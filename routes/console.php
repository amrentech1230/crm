<?php

use App\Models\Customer;
use App\Models\Load;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('customer:normalize-credit', function () {
    $this->info('Normalizing customer credit limits...');

    $customers = Customer::cursor();
    $updated = 0;

    foreach ($customers as $customer) {
        $credits = json_decode($customer->credit_limit_log, true);
        $remainingCreditLogs = json_decode($customer->remaining_credit_logs, true);

        $totalCreditLimit = 0;

        if (is_array($credits)) {
            $totalCreditLimit = array_sum(array_column($credits, 'credit_limit'));
        }

        if ($totalCreditLimit <= 0 && is_array($remainingCreditLogs)) {
            $totalCreditLimit = array_sum(array_column($remainingCreditLogs, 'credit_limit'));
        }

        if ($totalCreditLimit <= 0) {
            continue;
        }

        $loads = Load::where('customer_id', $customer->id)->get();
        $usedAmount = 0;

        foreach ($loads as $load) {
            $rate = (float) ($load->shipper_load_final_rate ?? 0);

            if ($load->invoice_status === 'Paid') {
                $usedAmount += $rate;
            } elseif ($load->invoice_status === 'Paid Record') {
                if (is_numeric($load->receiving_amount)) {
                    $usedAmount += (float) $load->receiving_amount;
                } elseif (is_numeric($load->remaining_amount)) {
                    $usedAmount += max(0, $rate - (float) $load->remaining_amount);
                } else {
                    $usedAmount += $rate;
                }
            }
        }

        $remainingCredit = max(0, $totalCreditLimit - $usedAmount);

        $customer->adv_customer_credit_limit = $totalCreditLimit;
        $customer->remaining_credit = $remainingCredit;
        $customer->save();

        $updated++;
    }

    $this->info("Completed normalization for {$updated} customers.");
})->purpose('Normalize customer assigned and remaining credit using remaining_credit_logs if credit_limit_log is empty.');
