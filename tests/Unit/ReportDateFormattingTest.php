<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ReportDateFormattingTest extends TestCase
{
    public function test_format_report_date_uses_consistent_slash_format(): void
    {
        require_once dirname(__DIR__, 2) . '/app/Helpers/helpers.php';

        $this->assertSame('07/08/2026', \format_report_date('2026-07-08'));
        $this->assertSame('07/08/2026', \format_report_date('2026-07-08 10:15:00'));
        $this->assertSame('-', \format_report_date(null));
        $this->assertSame('-', \format_report_date(null, '-'));
    }
}
