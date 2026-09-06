<?php

namespace Tests\Unit;

use App\Http\Controllers\AccountController;
use App\Models\Load;
use ReflectionMethod;
use Tests\TestCase;

class AccountControllerInvoiceCreditTest extends TestCase
{
    public function testInvoiceCreditAmountForExcelSumsOnlyChargesMarkedForInvoice(): void
    {
        $controller = new AccountController();
        $load = new Load();
        $load->shipper_load_other_charge = json_encode([
            ['amount' => '$100.00', 'for_invoice' => 'on'],
            ['amount' => '$50.00', 'for_invoice' => 'off'],
            ['amount' => '25', 'for_invoice' => 'on'],
            ['amount' => 'abc', 'for_invoice' => 'on'],
        ]);

        $method = new ReflectionMethod($controller, 'invoiceCreditAmountForExcel');
        $method->setAccessible(true);

        $this->assertSame(125.0, $method->invoke($controller, $load));
    }
}
