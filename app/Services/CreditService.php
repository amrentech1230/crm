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

    /**
     * Allocate a load across the two limits.
     *
     * Invoice-flagged charges always come out of the invoicing limit. The rest of the load
     * (base rate, F.S.C and non-invoice charges) comes out of the remaining limit first; any
     * shortfall may spill over into whatever is left of the invoicing limit, but only while
     * the customer still has some remaining limit to draw on.
     *
     * @return array{allowed: bool, message: string, remaining_limit: float, invoice_limit: float,
     *               from_remaining: float, invoice_overflow: float, invoice_total: float}
     */
    protected function allocateCreditUsage(float $remainingLimit, float $invoiceLimit, float $remainingUsed, float $invoiceUsed): array
    {
        $remainingLimit = max(0.0, $remainingLimit);
        $invoiceLimit = max(0.0, $invoiceLimit);
        $remainingUsed = max(0.0, $remainingUsed);
        $invoiceUsed = max(0.0, $invoiceUsed);

        $fromRemaining = min($remainingUsed, $remainingLimit);
        $overflow = round($remainingUsed - $fromRemaining, 2);

        $allocation = [
            'allowed' => true,
            'message' => '',
            'remaining_limit' => $remainingLimit,
            'invoice_limit' => $invoiceLimit,
            'from_remaining' => round($fromRemaining, 2),
            'invoice_overflow' => $overflow,
            'invoice_total' => round($invoiceUsed + $overflow, 2),
        ];

        // Invoice-flagged charges have first claim on the invoicing limit.
        if ($invoiceUsed > 0 && $invoiceLimit <= 0) {
            return array_merge($allocation, [
                'allowed' => false,
                'message' => 'You do not have sufficient invoicing limit to create the load.',
            ]);
        }

        if ($invoiceUsed > $invoiceLimit) {
            $shortage = round($invoiceUsed - $invoiceLimit, 2);

            return array_merge($allocation, [
                'allowed' => false,
                'message' => "You do not have sufficient invoicing limit to create the load. Your invoicing limit is {$invoiceLimit}. You need {$shortage} more credits to create this load.",
            ]);
        }

        if ($overflow > 0) {
            // The invoicing limit can only cover the overflow once there is some remaining limit.
            if ($remainingLimit <= 0) {
                return array_merge($allocation, [
                    'allowed' => false,
                    'message' => 'You do not have any remaining credit limit. Your invoicing limit can only be used once you have some remaining credit available.',
                ]);
            }

            $invoiceLimitLeft = round($invoiceLimit - $invoiceUsed, 2);

            if ($overflow > $invoiceLimitLeft) {
                $shortage = round($overflow - $invoiceLimitLeft, 2);
                $combined = round($remainingLimit + $invoiceLimitLeft, 2);

                return array_merge($allocation, [
                    'allowed' => false,
                    'message' => "You do not have sufficient limit to create the load. Your remaining credit is {$remainingLimit} and {$invoiceLimitLeft} is available from your invoicing limit ({$combined} in total). You need {$shortage} more credits to create this load.",
                ]);
            }
        }

        return $allocation;
    }

    /**
     * Split a cancelled load's final rate back into the two limits it was taken from.
     *
     * Mirrors allocateCreditUsage(): invoice-flagged charges plus whatever spilled over into
     * the invoicing limit go back there, and the rest returns to the remaining limit.
     *
     * @return array{to_invoice_limit: float, to_remaining: float}
     */
    public function splitCreditRelease(float $finalRate, float $invoiceCharges, float $invoiceOverflow = 0.0): array
    {
        $finalRate = max(0.0, $finalRate);
        $invoiceCharges = min(max(0.0, $invoiceCharges), $finalRate);
        $overflow = min(max(0.0, $invoiceOverflow), max(0.0, $finalRate - $invoiceCharges));

        return [
            'to_invoice_limit' => round($invoiceCharges + $overflow, 2),
            'to_remaining' => round(max(0.0, $finalRate - $invoiceCharges - $overflow), 2),
        ];
    }

    public function validateCreditForLoad($customer, float $loadAmount, float $invoiceAmount = 0.0): array
    {
        $customer = $this->resolveCustomer($customer);

        if (!$customer) {
            return [
                'allowed' => false,
                'message' => 'Selected customer is not approved or not found.',
                'available_credit' => 0.0,
            ];
        }

        $invoiceAmount = max(0.0, $invoiceAmount);
        $remainingAmount = max(0.0, $loadAmount - $invoiceAmount);
        $availableCredit = $this->getAvailableCreditLimit($customer);
        $invoiceLimit = max(0.0, (float) ($customer->invoice_credit_limit ?? 0));

        if ($loadAmount <= 0) {
            return [
                'allowed' => false,
                'message' => 'Load amount must be greater than zero.',
                'available_credit' => $availableCredit,
            ];
        }

        $allocation = $this->allocateCreditUsage($availableCredit, $invoiceLimit, $remainingAmount, $invoiceAmount);

        if (!$allocation['allowed']) {
            return [
                'allowed' => false,
                'message' => $allocation['message'],
                'available_credit' => $availableCredit,
            ];
        }

        return [
            'allowed' => true,
            'message' => '',
            'available_credit' => $availableCredit,
        ];
    }

    public function validateSplitLoadCredit($customer, float $remainingUsed, float $invoiceUsed = 0.0): array
    {
        $customer = $this->resolveCustomer($customer);

        if (!$customer) {
            return [
                'allowed' => false,
                'message' => 'Selected customer is not approved or not found.',
                'remaining_limit' => 0.0,
                'invoice_limit' => 0.0,
                'remaining_used' => $remainingUsed,
                'invoice_used' => $invoiceUsed,
            ];
        }

        $remainingLimit = max(0.0, $this->getAvailableCreditLimit($customer));
        $invoiceLimit = max(0.0, (float) ($customer->invoice_credit_limit ?? 0));

        $remainingUsed = max(0.0, $remainingUsed);
        $invoiceUsed = max(0.0, $invoiceUsed);

        $allocation = $this->allocateCreditUsage($remainingLimit, $invoiceLimit, $remainingUsed, $invoiceUsed);

        return [
            'allowed' => $allocation['allowed'],
            'message' => $allocation['message'],
            'remaining_limit' => $remainingLimit,
            'invoice_limit' => $invoiceLimit,
            'remaining_used' => $remainingUsed,
            'invoice_used' => $invoiceUsed,
            'from_remaining' => $allocation['from_remaining'],
            'invoice_overflow' => $allocation['invoice_overflow'],
        ];
    }

    public function reserveCreditForLoad($customer, float $loadAmount, float $invoiceAmount = 0.0): array
    {
        return DB::transaction(function () use ($customer, $loadAmount, $invoiceAmount) {
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

            $invoiceAmount = max(0.0, $invoiceAmount);
            $remainingAmount = max(0.0, $loadAmount - $invoiceAmount);
            $availableCredit = $this->getAvailableCreditLimit($customer);
            $invoiceLimit = max(0.0, (float) ($customer->invoice_credit_limit ?? 0));

            if ($loadAmount <= 0) {
                return [
                    'allowed' => false,
                    'message' => 'Load amount must be greater than zero.',
                    'available_credit' => $availableCredit,
                ];
            }

            $allocation = $this->allocateCreditUsage($availableCredit, $invoiceLimit, $remainingAmount, $invoiceAmount);

            if (!$allocation['allowed']) {
                return [
                    'allowed' => false,
                    'message' => $allocation['message'],
                    'available_credit' => $availableCredit,
                ];
            }

            $newRemainingCredit = round(max(0.0, $availableCredit - $allocation['from_remaining']), 2);
            $newInvoiceCreditLimit = round(max(0.0, $invoiceLimit - $allocation['invoice_total']), 2);

            $customer->remaining_credit = $newRemainingCredit;
            $customer->remaining_credit_amount = $newRemainingCredit;
            $customer->invoice_credit_limit = $newInvoiceCreditLimit;
            $customer->save();

            return [
                'allowed' => true,
                'message' => '',
                'available_credit' => $availableCredit,
                'remaining_credit' => $newRemainingCredit,
                'invoice_credit_limit' => $newInvoiceCreditLimit,
                'from_remaining' => $allocation['from_remaining'],
                'invoice_overflow' => $allocation['invoice_overflow'],
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
