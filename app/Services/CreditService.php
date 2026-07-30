<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class CreditService
{
    public function getAvailableCreditLimit($customer): float
    {
        $customer = $this->resolveCustomer($customer);

        if (!$customer) {
            return 0.0;
        }

        $remainingCredit = (float) ($customer->remaining_credit ?? 0);
        $invoiceCreditLimit = (float) ($customer->invoice_credit_limit ?? 0);
        $assignedCreditLimit = (float) ($customer->adv_customer_credit_limit ?? 0);

        if ($remainingCredit > 0) {
            return $remainingCredit;
        }

        if ($assignedCreditLimit > 0) {
            return $assignedCreditLimit;
        }

        return $invoiceCreditLimit;
    }

    public function validateCreditForLoad($customer, float $loadAmount): array
    {
        $customer = $this->resolveCustomer($customer);

        if (!$customer) {
            return [
                'allowed' => false,
                'message' => 'Selected customer is not approved or not found.',
                'available_credit' => 0.0,
            ];
        }

        $availableCredit = $this->getAvailableCreditLimit($customer);

        if ($availableCredit <= 0) {
            return [
                'allowed' => false,
                'message' => 'You do not have sufficient limit to create this load.',
                'available_credit' => $availableCredit,
            ];
        }

        if ($loadAmount > $availableCredit) {
            return [
                'allowed' => false,
                'message' => "You do not have sufficient limit to create this load. Available limit is ${$availableCredit}. Requested amount: ${$loadAmount}.",
                'available_credit' => $availableCredit,
            ];
        }

        return [
            'allowed' => true,
            'message' => '',
            'available_credit' => $availableCredit,
        ];
    }

    public function reserveCreditForLoad($customer, float $loadAmount): array
    {
        return DB::transaction(function () use ($customer, $loadAmount) {
            $customer = $this->resolveCustomer($customer);

            if (!$customer) {
                return [
                    'allowed' => false,
                    'message' => 'Selected customer is not approved or not found.',
                    'available_credit' => 0.0,
                ];
            }

            $customer = Customer::whereKey($customer->id)->lockForUpdate()->first();

            if (!$customer) {
                return [
                    'allowed' => false,
                    'message' => 'Selected customer is not approved or not found.',
                    'available_credit' => 0.0,
                ];
            }

            $availableCredit = $this->getAvailableCreditLimit($customer);

            if ($availableCredit <= 0) {
                return [
                    'allowed' => false,
                    'message' => 'You do not have sufficient limit to create this load.',
                    'available_credit' => $availableCredit,
                ];
            }

            if ($loadAmount > $availableCredit) {
                return [
                    'allowed' => false,
                    'message' => "You do not have sufficient limit to create this load. Available limit is ${$availableCredit}. Requested amount: ${$loadAmount}.",
                    'available_credit' => $availableCredit,
                ];
            }
            

            $newRemainingCredit = round(max(0.0, $availableCredit - $loadAmount), 2);
            $customer->remaining_credit = $newRemainingCredit;
            $customer->remaining_credit_amount = $newRemainingCredit;
            $customer->save();

            return [
                'allowed' => true,
                'message' => '',
                'available_credit' => $availableCredit,
                'remaining_credit' => $newRemainingCredit,
            ];
        });
    }

    protected function resolveCustomer($customer): ?Customer
    {
        if ($customer instanceof Customer) {
            return $customer;
        }

        if (is_numeric($customer)) {
            return Customer::find($customer);
        }

        if (is_string($customer)) {
            return Customer::where('customer_name', $customer)->first() ?? Customer::find($customer);
        }

        return null;
    }
}
