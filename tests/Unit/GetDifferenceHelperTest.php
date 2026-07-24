<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class GetDifferenceHelperTest extends TestCase
{
    public function test_getdiffrance_returns_fallback_message_when_no_changes_are_present(): void
    {
        require_once dirname(__DIR__, 2) . '/app/Helpers/helpers.php';

        $output = \getdiffrance(null, null);

        $this->assertStringContainsString('No details found', $output);
    }

    public function test_getdiffrance_formats_changes_into_readable_field_output(): void
    {
        require_once dirname(__DIR__, 2) . '/app/Helpers/helpers.php';

        $output = \getdiffrance(
            json_encode([
                'load_workorder' => '32511',
                'updated_at' => '2026-06-11T17:27:20.000000Z',
                'load_shipper_appointment' => [['appointment' => '2026-06-11T14:00']],
                'load_consignee_notes' => [['load_consignee_notes' => 'Please ensure the shipment is delivered on time and handled safely.']],
            ]),
            json_encode([
                'load_workorder' => '32752',
                'updated_at' => '2026-06-11T17:27:48.000000Z',
                'load_shipper_appointment' => [['appointment' => '2026-06-11T15:00']],
                'load_consignee_notes' => [
                    ['load_consignee_notes' => 'Please ensure the shipment is delivered on time and handled safely.'],
                    ['load_consignee_notes' => 'Please ensure the shipment is delivered on time and handled safely.'],
                ],
            ])
        );

        $this->assertStringContainsString('Load Workorder', $output);
        $this->assertStringContainsString('32511', $output);
        $this->assertStringContainsString('32752', $output);
        $this->assertStringContainsString('Load Shipper Appointment', $output);
        $this->assertStringContainsString('Load Consignee Notes', $output);
        $this->assertStringContainsString('From:', $output);
        $this->assertStringContainsString('To:', $output);
        $this->assertStringContainsString('Updated At', $output);
    }
}
