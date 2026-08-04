<?php

use Illuminate\Support\Facades\Request;
use App\Models\Log;
use App\Models\Customer;
use Symfony\Component\Process\Process;

if (!function_exists('getmacaddress')) {

	function getmacaddress()
	{
		$os = PHP_OS_FAMILY;

		if ($os === 'Windows') {
			$command = ['getmac'];
		} elseif ($os === 'Linux' || $os === 'Darwin') {
			// Use 'ip link' for Linux/macOS
			$command = ['sh', '-c', "ip link show | grep ether | awk '{print \$2}'"];
		} else {
			return 'Unsupported OS';
		}

		$process = new Process($command);
		$process->run();

		if ($process->isSuccessful()) {
			return trim($process->getOutput());
		}

		return 'MAC address not found';
	}
}

/*
|--------------------------------------------------------------------------
| Customer Credit Summary
|--------------------------------------------------------------------------
|
| This is the single source of truth for calculating a customer's used
| amount and remaining credit. Both AccountController@editCustomer and
| AccountController@accountupdateCustomer rely on this function so the
| numbers shown on the view page and the numbers saved after an update
| always match.
|
| - usedAmount      = max(0, loadCreateAmount - receivingAmount)
| - remainingCredit = max(0, assignedCreditLimit - loadCreateAmount)
|
| NOTE: this function does not touch the database, it is pure calculation.
| The caller is responsible for deciding which loads to include (e.g.
| excluding Cancelled loads) and which credit-limit source to use.
|
*/
if (!function_exists('calculate_customer_credit_summary')) {

	function calculate_customer_credit_summary($customer, $assignedCreditLimit = null, $loadCreateAmount = null, $receivingAmount = null)
	{
		$assignedCreditLimit = $assignedCreditLimit !== null ? (float) $assignedCreditLimit : 0.0;
		$assignedCreditLimit = max(0.0, $assignedCreditLimit);

		$loadCreateAmount = $loadCreateAmount !== null ? (float) $loadCreateAmount : 0.0;
		$receivingAmount  = $receivingAmount !== null ? (float) $receivingAmount : 0.0;

		$usedAmount      = max(0.0, $loadCreateAmount - $receivingAmount);
		$remainingCredit = max(0.0, $assignedCreditLimit - $loadCreateAmount);

		return [
			'assigned_credit_limit' => $assignedCreditLimit,
			'used_amount'           => $usedAmount,
			'remaining_credit'      => $remainingCredit,
		];
	}
}

if (!function_exists('get_customer_available_credit_limit')) {
	function get_customer_available_credit_limit($customer)
	{
		if ($customer === null) {
			return 0.0;
		}

		if (is_numeric($customer)) {
			$customer = Customer::find($customer);
		}

		$remainingCredit = (float) data_get($customer, 'remaining_credit', 0);
		$invoiceCreditLimit = (float) data_get($customer, 'invoice_credit_limit', 0);
		$assignedCreditLimit = (float) data_get($customer, 'adv_customer_credit_limit', 0);

		if ($remainingCredit > 0) {
			return $remainingCredit;
		}

		if ($assignedCreditLimit > 0) {
			return $assignedCreditLimit;
		}

		return $invoiceCreditLimit;
	}
}

if (!function_exists('addToLog')) {

	function addToLog($customer_id = '', $load_id = '', $subject = '', $old_data = '', $new_data = '')
	{
		// Get the authenticated user
		$user = auth()->user();

		$log = [
			'load_id'     => $load_id,
			'customer_id' => $customer_id,
			'message'     => $subject,
			'user_name'   => $user ? $user->name : null,
			'user_id'     => $user ? $user->id : null,
			'user_email'  => $user ? $user->email : null,
			'old_json'    => $old_data,
			'new_json'    => $new_data,
			'ip'          => Request::ip(),
			'url'         => Request::fullUrl(),
		];

		Log::create($log);
	}
}

if (!function_exists('getdiffrance')) {

	function getdiffrance($old_data, $new_data)
	{
		$array1 = json_decode($old_data, true);
		$array2 = json_decode($new_data, true);
		$diff = [];

		$array1 = is_array($array1) ? $array1 : [];
		$array2 = is_array($array2) ? $array2 : [];

		$isListPayload = (function_exists('array_is_list') && array_is_list($array1)) || (function_exists('array_is_list') && array_is_list($array2));
		if ($isListPayload) {
			$oldDisplay = format_log_value($array1);
			$newDisplay = format_log_value($array2);
			if ($oldDisplay === $newDisplay) {
				return '<div class="text-muted">No details found.</div>';
			}

			return '<div class="mb-3 border-bottom pb-2">'
				. '<div class="small text-muted mt-1"><span class="fw-semibold">From:</span> ' . e($oldDisplay) . '</div>'
				. '<div class="small text-muted mt-1"><span class="fw-semibold">To:</span> ' . e($newDisplay) . '</div>'
				. '</div>';
		}

		if (!empty($array1) || !empty($array2)) {
			$allKeys = array_unique(array_merge(array_keys($array1), array_keys($array2)));
			foreach ($allKeys as $key) {
				if (in_array($key, ['_token', '_method'])) {
					continue;
				}

				$val1 = $array1[$key] ?? null;
				$val2 = $array2[$key] ?? null;
				if (!array_key_exists($key, $array1)) {
					$diff[$key] = ['olddata' => null, 'newdata' => $val2];
				} elseif (!array_key_exists($key, $array2)) {
					$diff[$key] = ['olddata' => $val1, 'newdata' => null];
				} elseif ($val1 !== $val2) {
					$diff[$key] = ['olddata' => $val1, 'newdata' => $val2];
				}
			}
		}

		$output = '';
		foreach ($diff as $key => $diffdata) {
			$rawOld = $diffdata['olddata'];
			$rawNew = $diffdata['newdata'];

			$oldDisplay = format_log_value($rawOld);
			$newDisplay = format_log_value($rawNew);
			if ($oldDisplay === $newDisplay) {
				continue;
			}

			$label = format_log_label($key);
			$output .= '<div class="mb-3 border-bottom pb-2">';
			$output .= '<div class="fw-semibold text-dark">' . e($label) . '</div>';
			$output .= '<div class="small text-muted mt-1"><span class="fw-semibold">From:</span> ' . e($oldDisplay) . '</div>';
			$output .= '<div class="small text-muted mt-1"><span class="fw-semibold">To:</span> ' . e($newDisplay) . '</div>';
			$output .= '</div>';
		}

		if (trim($output) === '') {
			return '<div class="text-muted">No details found.</div>';
		}

		return $output;
	}
}

if (!function_exists('format_log_label')) {

	function format_log_label($key)
	{
		$labelMap = [
			'carrier_load_other_charge' => 'Carrier other charge',
			'shipper_load_other_charge' => 'Shipper other charge',
			'load_final_rate' => 'Final rate',
			'load_billing_fsc_rate' => 'Billing FSC rate',
			'load_other_charge' => 'Other charge',
			'load_shipper_discription' => 'Shipper description',
			'load_shipper_commodity_type' => 'Commodity type',
			'load_shipper_qty' => 'Quantity',
			'load_shipper_weight' => 'Weight',
			'load_shipper_commodity' => 'Commodity',
			'load_shipper_value' => 'Value',
			'load_shipper_shipping_notes' => 'Shipping notes',
			'load_shipper_commodity_name' => 'Commodity',
			'load_shipper_qty_qty' => 'Quantity',
			'load_shipper_weight_weight' => 'Weight',
			'load_shipper_value_value' => 'Value',
			'load_shipper_shipping_notes_shipping_notes' => 'Shipping notes',
			'description' => 'Description',
			'commodity_type' => 'Commodity type',
			'shipper_qty' => 'Quantity',
			'qty' => 'Quantity',
			'shipper_weight' => 'Weight',
			'weight' => 'Weight',
			'commodity_name' => 'Commodity',
			'commodity' => 'Commodity',
			'shipper_value' => 'Value',
			'value' => 'Value',
			'shipping_notes' => 'Shipping notes',
			'type' => 'Type',
			'amount' => 'Amount',
		];

		if (isset($labelMap[$key])) {
			return $labelMap[$key];
		}

		$key = str_replace(['_', '-'], ' ', $key);
		$key = preg_replace('/\s+/', ' ', trim($key));
		$key = ucwords(strtolower($key));
		$key = preg_replace('/\bLoad\b/i', '', $key);
		$key = preg_replace('/\s+/', ' ', trim($key));
		$key = preg_replace('/\bShipper\b/i', 'Shipper', $key);

		return $key;
	}
}

if (!function_exists('format_log_array_entry')) {

	function format_log_array_entry($item)
	{
		if (is_array($item) && isset($item['appointment'])) {
			return \Carbon\Carbon::parse($item['appointment'])->format('d-m-Y h:i A');
		}

		if (is_array($item)) {
			$parts = [];
			foreach ($item as $key => $subValue) {
				$label = format_log_label($key);
				if ($subValue === null || $subValue === '') {
					$parts[] = $label . ': No value';
					continue;
				}

				if (is_array($subValue)) {
					$parts[] = $label . ': ' . format_log_value($subValue);
					continue;
				}

				if (is_string($subValue) && preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}/', $subValue)) {
					try {
						$parts[] = $label . ': ' . \Carbon\Carbon::parse($subValue)->format('d-m-Y h:i:s A');
					} catch (\Exception $e) {
						$parts[] = $label . ': ' . $subValue;
					}
					continue;
				}

				$parts[] = $label . ': ' . $subValue;
			}

			return implode('; ', $parts);
		}

		return format_log_value($item);
	}
}

if (!function_exists('format_log_value')) {

	function format_log_value($value)
	{
		if ($value === null || $value === '') {
			return 'No value';
		}

		if (is_array($value)) {
			if (empty($value)) {
				return 'No value';
			}

			$hasSequentialKeys = array_keys($value) === range(0, count($value) - 1);
			if ($hasSequentialKeys) {
				$items = [];
				foreach ($value as $item) {
					$formatted = format_log_array_entry($item);
					if ($formatted !== 'No value' && $formatted !== '') {
						$items[] = $formatted;
					}
				}

				if (!empty($items)) {
					return implode(' | ', $items);
				}

				return 'No value';
			}

			return format_log_array_entry($value);
		}

		if (is_string($value)) {
			if (preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}/', $value)) {
				try {
					return \Carbon\Carbon::parse($value)->format('d-m-Y h:i:s A');
				} catch (\Exception $e) {
					return $value;
				}
			}

			return $value;
		}

		return (string) $value;
	}
}
if (!function_exists('render_pagination_links')) {

    function render_pagination_links($paginator)
    {
        if (!$paginator || !method_exists($paginator, 'hasPages') || !$paginator->hasPages()) {
            return '';
        }

        $html = '<nav class="d-flex justify-content-center"><ul class="pagination">';

        if ($paginator->onFirstPage()) {
            $html .= '<li class="page-item disabled" aria-disabled="true"><span class="page-link">«</span></li>';
        } else {
            $html .= '<li class="page-item"><a class="page-link" href="' . e($paginator->previousPageUrl()) . '" rel="prev">«</a></li>';
        }

        $currentPage = (int) $paginator->currentPage();
        $lastPage = (int) $paginator->lastPage();
        $window = 2;
        $start = max(1, $currentPage - $window);
        $end = min($lastPage, $currentPage + $window);

        if ($start > 1) {
            $html .= '<li class="page-item"><a class="page-link" href="' . e($paginator->url(1)) . '">1</a></li>';
            if ($start > 2) {
                $html .= '<li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>';
            }
        }

        for ($page = $start; $page <= $end; $page++) {
            if ($page === $currentPage) {
                $html .= '<li class="page-item active" aria-current="page"><span class="page-link">' . $page . '</span></li>';
            } else {
                $html .= '<li class="page-item"><a class="page-link" href="' . e($paginator->url($page)) . '">' . $page . '</a></li>';
            }
        }

        if ($end < $lastPage) {
            if ($end < $lastPage - 1) {
                $html .= '<li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>';
            }
            $html .= '<li class="page-item"><a class="page-link" href="' . e($paginator->url($lastPage)) . '">' . $lastPage . '</a></li>';
        }

        if ($paginator->hasMorePages()) {
            $html .= '<li class="page-item"><a class="page-link" href="' . e($paginator->nextPageUrl()) . '" rel="next">»</a></li>';
        } else {
            $html .= '<li class="page-item disabled" aria-disabled="true"><span class="page-link">»</span></li>';
        }

        $html .= '</ul></nav>';

        return $html;
    }
}

if (!function_exists('format_report_date')) {

	function format_report_date($date, $format = 'm/d/Y')
	{
		if (empty($date) || $date === '0000-00-00' || $date === '0000-00-00 00:00:00') {
			return '';
		}

		try {
			return \Carbon\Carbon::parse($date)->format($format);
		} catch (\Exception $e) {
			return '';
		}
	}
}

if (!function_exists('format_report_value')) {

	function format_report_value($value, $isCancelled = false)
	{
		if ($isCancelled) {
			return '-';
		}

		if ($value === null || $value === '') {
			return '';
		}

		return is_numeric($value) ? number_format((float) $value, 2) : $value;
	}
}
