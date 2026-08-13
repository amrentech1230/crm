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

        // If remaining_credit has been tracked (> 0 or explicitly set), use it directly.
        // Fall back to assigned limit only when remaining_credit has never been set.
        if ($remainingCredit > 0 || $customer->remaining_credit !== null) {
            return max(0.0, $remainingCredit);
        }

        return max(0.0, (float) ($customer->adv_customer_credit_limit ?? $customer->invoice_credit_limit ?? 0));
    }

    public function calculateCustomerCreditSummary($customer, float $assignedCreditLimit, float $loadCreateAmount, float $receivingAmount = 0.0): array
    {
        $customer = $this->resolveCustomer($customer);

        if (!$customer) {
            return [
                'assigned_credit_limit' => 0.0,
                'used_amount' => 0.0,
                'remaining_credit' => 0.0,
            ];
        }

        $assignedCreditLimit = max(0.0, $assignedCreditLimit);
        $loadCreateAmount = max(0.0, $loadCreateAmount);
        $receivingAmount = max(0.0, $receivingAmount);

        $usedAmount = max(0.0, $loadCreateAmount - $receivingAmount);
        $remainingCredit = max(0.0, $assignedCreditLimit - $loadCreateAmount);

        return [
            'assigned_credit_limit' => $assignedCreditLimit,
            'used_amount' => $usedAmount,
            'remaining_credit' => $remainingCredit,
        ];
    }

    protected function getAssignedCreditLimit($customer): float
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

    protected function getLoadCreationAmount($customer): float
    {
        $customer = $this->resolveCustomer($customer);

        if (!$customer) {
            return 0.0;
        }

        return (float) $customer->loads()->where('load_status', '!=', 'Cancelled')->where(function ($query) {
            $query->where('invoice_status', '!=', 'Paid Record')->orWhereNull('invoice_status');
        })->sum('shipper_load_final_rate');
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

        if ($loadAmount <= 0) {
            return [
                'allowed' => false,
                'message' => 'Load amount must be greater than zero.',
                'available_credit' => $availableCredit,
            ];
        }

        if ($availableCredit <= 0) {
            return [
                'allowed' => false,
                'message' => 'You do not have sufficient limit to create this load.',
                'available_credit' => $availableCredit,
            ];
        }

        if ($loadAmount > $availableCredit) {
            $shortage = round($loadAmount - $availableCredit, 2);

            return [
                'allowed' => false,
                'message' => "You do not have sufficient limit to create this load. Available limit is {$availableCredit}. Requested amount: {$loadAmount}. You need {$shortage} more credits to create this load.",
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

            if ($loadAmount <= 0) {
                return [
                    'allowed' => false,
                    'message' => 'Load amount must be greater than zero.',
                    'available_credit' => $availableCredit,
                ];
            }

            if ($availableCredit <= 0) {
                return [
                    'allowed' => false,
                    'message' => 'You do not have sufficient limit to create this load.',
                    'available_credit' => $availableCredit,
                ];
            }

            if ($loadAmount > $availableCredit) {
                $shortage = round($loadAmount - $availableCredit, 2);

                return [
                    'allowed' => false,
                    'message' => "You do not have sufficient limit to create this load. Available limit is {$availableCredit}. Requested amount: {$loadAmount}. You need {$shortage} more credits to create this load.",
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

    /**
     * Validate and apply credit delta for a load edit.
     * Wraps the check + update in a transaction with row locking.
     *
     * @param mixed $customer Customer model or ID
     * @param float $creditDelta Positive means credit is being freed; negative means more credit is being used.
     * @return array ['allowed' => bool, 'message' => string]
     */
    public function applyEditCreditDelta($customer, float $creditDelta): array
    {
        return DB::transaction(function () use ($customer, $creditDelta) {
            $customer = $this->resolveCustomer($customer);

            if (!$customer) {
                return [
                    'allowed' => false,
                    'message' => 'Customer not found.',
                ];
            }

            $customer = Customer::whereKey($customer->id)->lockForUpdate()->first();

            if (!$customer) {
                return [
                    'allowed' => false,
                    'message' => 'Customer not found.',
                ];
            }

            $currentRemaining = (float) ($customer->remaining_credit ?? 0);
            $newRemaining = round($currentRemaining + $creditDelta, 2);

            if ($newRemaining < 0) {
                return [
                    'allowed' => false,
                    'message' => "Insufficient credit. Available: {$currentRemaining}. Additional needed: " . abs($creditDelta) . ".",
                ];
            }

            $customer->remaining_credit = $newRemaining;
            $customer->remaining_credit_amount = $newRemaining;
            $customer->save();

            return [
                'allowed' => true,
                'message' => '',
                'remaining_credit' => $newRemaining,
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
