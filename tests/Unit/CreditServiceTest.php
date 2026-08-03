<?php

namespace Tests\Unit;

use App\Models\Customer;
use App\Services\CreditService;
use Tests\TestCase;

class CreditServiceTest extends TestCase
{
    public function test_calculate_customer_credit_summary_uses_the_provided_load_and_receipt_totals(): void
    {
        $service = new CreditService();
        $customer = new Customer();
        $customer->adv_customer_credit_limit = 1000;

        $summary = $service->calculateCustomerCreditSummary($customer, 800.0, 250.0);

        $this->assertSame(800.0, $summary['assigned_credit_limit']);
        $this->assertSame(250.0, $summary['used_amount']);
        $this->assertSame(550.0, $summary['remaining_credit']);
    }

    public function test_validate_credit_for_load_rejects_negative_amounts(): void
    {
        $service = new CreditService();
        $customer = new Customer();
        $customer->adv_customer_credit_limit = 1000;
        $customer->remaining_credit = 1000;

        $result = $service->validateCreditForLoad($customer, -100.0);

        $this->assertFalse($result['allowed']);
        $this->assertSame('Load amount must be greater than zero.', $result['message']);
    }
}
