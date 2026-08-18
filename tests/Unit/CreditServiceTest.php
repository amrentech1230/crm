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

    public function test_validate_split_load_credit_uses_remaining_and_invoicing_limits_separately(): void
    {
        $service = new CreditService();
        $customer = new Customer();
        $customer->remaining_credit = 500.0;
        $customer->invoice_credit_limit = 300.0;

        $result = $service->validateSplitLoadCredit($customer, 400.0, 50.0);

        $this->assertTrue($result['allowed']);
        $this->assertSame(500.0, $result['remaining_limit']);
        $this->assertSame(300.0, $result['invoice_limit']);
    }

    public function test_validate_split_load_credit_deducts_invoice_charges_from_invoice_limit(): void
    {
        $service = new CreditService();
        $customer = new Customer();
        $customer->remaining_credit = 69.0;
        $customer->invoice_credit_limit = 5.0;

        $allowed = $service->validateSplitLoadCredit($customer, 69.0, 4.0);
        $this->assertTrue($allowed['allowed']);

        $blocked = $service->validateSplitLoadCredit($customer, 69.0, 6.0);
        $this->assertFalse($blocked['allowed']);
        $this->assertStringContainsString('invoicing limit', $blocked['message']);
    }

    public function test_customer_credit_values_are_never_negative(): void
    {
        $this->assertSame(0.0, normalize_customer_credit_value(-25.50));
        $this->assertSame(420.0, normalize_customer_credit_value(420.0));
    }

    public function test_customer_display_remaining_credit_falls_back_to_assigned_credit_limit_when_remaining_is_zero(): void
    {
        $customer = new Customer();
        $customer->remaining_credit = 0;
        $customer->adv_customer_credit_limit = 7200;
        $customer->invoice_credit_limit = 7200;

        $this->assertSame(7200.0, get_customer_display_remaining_credit($customer));
    }
}
