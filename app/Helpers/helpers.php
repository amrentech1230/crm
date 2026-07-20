<?php

use Illuminate\Support\Facades\Request;
use App\Models\Log;
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

if (!function_exists('format_report_date')) {
    function format_report_date($value, $default = '-')
    {
        if ($value === null || $value === '' || $value === '0000-00-00' || $value === '0000-00-00 00:00:00') {
            return $default;
        }

        try {
            $date = $value instanceof \Carbon\Carbon ? $value : \Carbon\Carbon::parse((string) $value);

            if ($date->year === 0 || $date->month === 0 || $date->day === 0) {
                return $default;
            }

            return $date->format('m/d/Y');
        } catch (\Throwable $e) {
            return $default;
        }
    }
}

if (!function_exists('format_report_value')) {
    function format_report_value($value, $isCancelled = false, $default = '-')
    {
        if ($isCancelled) {
            return 0;
        }

        return $value;
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

if (!function_exists('format_log_field_label')) {
    function format_log_field_label($key)
    {
        $label = str_replace(['_', '-'], ' ', (string) $key);
        $label = ucwords($label);

        $map = [
            'Load Status' => 'Load Status',
            'Invoice Status' => 'Invoice Status',
            'Receiving Amount' => 'Receiving Amount',
            'Remaining Amount' => 'Remaining Amount',
            'Payment Receiving Date' => 'Payment Receiving Date',
            'Invoice Status Date' => 'Invoice Status Date',
            'Shipper Load Final Rate' => 'Customer Rate',
            'Load Final Carrier Fee' => 'Carrier Rate',
            'Load Advance Rec Amount' => 'Advance Received Amount',
        ];

        return $map[$label] ?? $label;
    }
}

if (!function_exists('format_log_change_value')) {
    function format_log_change_value($value)
    {
        if ($value === null || $value === '') {
            return '—';
        }

        if (is_array($value)) {
            return json_encode($value, JSON_UNESCAPED_SLASHES);
        }

        return (string) $value;
    }
}

if (!function_exists('getdiffrance')) {
    function getdiffrance($old_data, $new_data)
    {
        $array1 = json_decode($old_data, true);
        $array2 = json_decode($new_data, true);

        if (!is_array($array1)) {
            $array1 = [];
        }

        if (!is_array($array2)) {
            $array2 = [];
        }

        $diff = [];
        $allKeys = array_unique(array_merge(array_keys($array1), array_keys($array2)));

        foreach ($allKeys as $key) {
            $val1 = $array1[$key] ?? null;
            $val2 = $array2[$key] ?? null;

            if (in_array($key, ['_token', '_method'])) {
                continue;
            }
            if (!array_key_exists($key, $array1)) {
                $diff[$key] = ['olddata' => null, 'newdata' => $val2];
            } elseif (!array_key_exists($key, $array2)) {
                $diff[$key] = ['olddata' => $val1, 'newdata' => null];
            } elseif ($val1 !== $val2) {
                $diff[$key] = ['olddata' => $val1, 'newdata' => $val2];
            }
        }

        if (empty($diff)) {
            return '<div class="text-muted small">No detailed field changes were recorded for this action.</div>';
        }

        $output = '<ul class="list-unstyled mb-0">';

        foreach ($diff as $key => $diffdata) {
            $rawOld = $diffdata['olddata'];
            $rawNew = $diffdata['newdata'];
            $oldNormalized = is_array($rawOld) ? json_encode($rawOld, JSON_UNESCAPED_SLASHES) : (string) $rawOld;
            $newNormalized = is_array($rawNew) ? json_encode($rawNew, JSON_UNESCAPED_SLASHES) : (string) $rawNew;

            if ($oldNormalized === $newNormalized || $newNormalized === '[]' || $newNormalized === '[null]') {
                continue;
            }

            $output .= '<li class="mb-2"><div class="fw-semibold">' . e(format_log_field_label($key)) . '</div>';
            $output .= '<div class="small text-muted">From: ' . e(format_log_change_value($rawOld)) . '</div>';
            $output .= '<div class="small text-success">To: ' . e(format_log_change_value($rawNew)) . '</div></li>';
        }

        $output .= '</ul>';

        return $output;
    }
}