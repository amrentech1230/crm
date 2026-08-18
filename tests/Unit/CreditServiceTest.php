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

    public function test_invoicing_limit_never_covers_a_shortfall_on_the_remaining_limit(): void
    {
        $service = new CreditService();
        $customer = new Customer();
        $customer->remaining_credit = 700.0;
        $customer->invoice_credit_limit = 4000.0;

        // 4700 against the remaining limit is refused even though the invoicing limit
        // would have covered the missing 4000.
        $result = $service->validateSplitLoadCredit($customer, 4700.0, 0.0);

        $this->assertFalse($result['allowed']);
        $this->assertStringContainsString('4000 more credits', $result['message']);
    }

    public function test_load_is_allowed_when_each_limit_covers_its_own_share(): void
    {
        $service = new CreditService();
        $customer = new Customer();
        $customer->remaining_credit = 700.0;
        $customer->invoice_credit_limit = 4000.0;

        // 700 of base/F.S.C/non-invoice charges plus 4000 of For Invoice=checked charges.
        $result = $service->validateSplitLoadCredit($customer, 700.0, 4000.0);

        $this->assertTrue($result['allowed']);
    }

    public function test_cancelling_returns_invoice_charges_to_the_invoicing_limit(): void
    {
        $service = new CreditService();

        $release = $service->splitCreditRelease(1000.0, 250.0);

        $this->assertSame(250.0, $release['to_invoice_limit']);
        $this->assertSame(750.0, $release['to_remaining']);
    }

    public function test_credit_release_never_returns_more_than_the_final_rate(): void
    {
        $service = new CreditService();

        // Invoice charges larger than the load (e.g. the load was later edited down).
        $release = $service->splitCreditRelease(500.0, 9000.0);

        $this->assertSame(500.0, $release['to_invoice_limit']);
        $this->assertSame(0.0, $release['to_remaining']);
    }

    public function test_credit_release_still_honours_a_legacy_recorded_overflow(): void
    {
        $service = new CreditService();

        // Load created while the invoicing limit could top up the remaining limit:
        // 300 came from the invoicing limit and has to go back there.
        $release = $service->splitCreditRelease(15400.0, 0.0, 300.0);

        $this->assertSame(300.0, $release['to_invoice_limit']);
        $this->assertSame(15100.0, $release['to_remaining']);
    }

    public function test_customer_credit_values_are_never_negative(): void
    {
        $this->assertSame(0.0, normalize_customer_credit_value(-25.50));
        $this->assertSame(420.0, normalize_customer_credit_value(420.0));
    }

    public function test_customer_display_remaining_credit_respects_explicit_zero(): void
    {
        $customer = new Customer();
        $customer->remaining_credit = 0;
        $customer->adv_customer_credit_limit = 7200;
        $customer->invoice_credit_limit = 7200;

        // When remaining_credit is explicitly 0, it means customer used all credit — return 0, don't fall back.
        $this->assertSame(0.0, get_customer_display_remaining_credit($customer));
    }

    public function test_customer_display_remaining_credit_falls_back_to_assigned_when_null(): void
    {
        $customer = new Customer();
        $customer->remaining_credit = null;
        $customer->adv_customer_credit_limit = 7200;
        $customer->invoice_credit_limit = 7200;

        // When remaining_credit is null (never been set), fall back to assigned limit.
        $this->assertSame(7200.0, get_customer_display_remaining_credit($customer));
    }
}
