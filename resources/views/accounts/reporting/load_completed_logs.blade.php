@php $i = 1; @endphp
                                @foreach($dashboard_logs as $index => $log)
                                @php
                                    $shipper = json_decode($log->load_shipperr, true);
                                    $consignee = json_decode($log->load_consignee, true);
                                    $shipper_appointment = json_decode($log->load_shipper_appointment,true);
                                    $shipper_location = json_decode($log->load_shipper_location,true);
                                    $appointment = isset($shipper_location[0]['appointment']) ? $shipper_location[0]['appointment'] : '';
                                    $consignee_location = json_decode($log->load_consignee_location,true);
                                    $consignee_appointment = json_decode($log->load_consignee_appointment,true);

                                    // Account receiving status, parsed the same way as the AR "Invoiced / Paid" tab.
                                    $shipperRate = (float) preg_replace('/[^0-9.\-]/', '', (string)($log->shipper_load_final_rate ?? ''));
                                    $receivingAmount = (float) preg_replace('/[^0-9.\-]/', '', (string)($log->receiving_amount ?? ''));
                                    $difference = $shipperRate - $receivingAmount;
                                    $remainingAmount = $difference > 0 ? $difference : 0.0;
                                    $excessAmount = $difference < 0 ? abs($difference) : 0.0;

                                    $isCancelled = strcasecmp((string) $log->load_status, 'Cancelled') === 0;

                                    // Cancelled loads owe nothing and hold no excess — reads "Cancelled" or 0.
                                    if ($isCancelled) {
                                        $remainingAmount = 0.0;
                                        $excessAmount = 0.0;
                                    }

                                    if ($isCancelled) {
                                        $paymentStatus = 'Cancelled';
                                    } elseif (empty($log->invoice_status)) {
                                        // Not invoiced yet — show a hyphen instead of "Pending".
                                        $paymentStatus = '-';
                                    } elseif ($receivingAmount <= 0) {
                                        $paymentStatus = 'Pending';
                                    } elseif (abs($difference) < 0.005) {
                                        $paymentStatus = 'Full Payment';
                                    } elseif ($difference < 0) {
                                        $paymentStatus = 'Excess Payment';
                                    } else {
                                        $paymentStatus = 'Short Payment';
                                    }

                                    // Invoice Status follows the real money received: a "Paid Record" with
                                    // nothing received maps back to "Invoiced", not a false "Paid Record".
                                    if ($isCancelled) {
                                        $displayInvoiceStatus = 'Cancelled';
                                    } elseif (empty($log->invoice_status)) {
                                        $displayInvoiceStatus = '-';
                                    } elseif ($log->invoice_status == 'Paid') {
                                        $displayInvoiceStatus = 'Invoiced';
                                    } elseif ($log->invoice_status == 'Paid Record') {
                                        $displayInvoiceStatus = [
                                            'Full Payment'   => 'Paid Record',
                                            'Short Payment'  => 'Short Pay',
                                            'Excess Payment' => 'Excess',
                                        ][$paymentStatus] ?? 'Invoiced';
                                    } else {
                                        $displayInvoiceStatus = $log->invoice_status;
                                    }
                                @endphp
                                <tr>
                                    <td class="dynamic-data">{{ ($dashboard_logs->currentPage() - 1) * $dashboard_logs->perPage() + $index + 1 }}</td>
                                    <td class="dynamic-data">{{ $log->load_number }}</td>
                                    <td class="dynamic-data"><a href="{{ route('accounts.view_loads_detail', $log->id) }}" class="btn btn-primary btn-sm"> <i class="fas fa-eye"></i></a></td>
                                    <td class="dynamic-data">@if($log->user)  {{ $log->user->name }} @endif</td>
                                    <td class="dynamic-data">{{ $log->cmt_agent ?? '' }}</td>
                                    <td class="dynamic-data">
                                        @php
                                            $statusOptions = [
                                                'Open' => '#74d1f0',
                                                'Covered' => 'rgb(69 7 172 / 72%)',
                                                'On Route' => 'green',
                                                'Delivered' => '#7C2B1A',
                                                'Unloading' => 'gray',
                                                'Completed' => '#3597dc',
                                            ];

                                            $statusColor = $statusOptions[$log->load_status] ?? '#000'; // Default color if status is not found
                                        @endphp

                                        @if($log->load_status == 'Completed')
                                            <span style="background-color: {{ $statusColor }}; color: #fff; padding: 2px 5px; border-radius: 3px;">
                                                Completed
                                            </span>
                                        @elseif($log->load_status == 'Open')
                                            <span style="background-color: {{ $statusColor }}; color: #fff; padding: 2px 5px; border-radius: 3px;">
                                                Open
                                            </span>
                                        @elseif($log->load_status == 'Unloading')
                                            <span style="background-color: {{ $statusColor }}; color: #fff; padding: 2px 5px; border-radius: 3px;">
                                                Unloading
                                            </span>
                                        @else
                                            <span style="background-color: {{ $statusColor }}; color: #fff; padding: 2px 5px; border-radius: 3px;">
                                                {{ $log->load_status }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="dynamic-data">{{ $displayInvoiceStatus }}</td>

                                    <td class="dynamic-data">{{ $log->customer_refrence_number }}</td>
                                    <td class="dynamic-data">
                                        {{ format_report_date($log->created_at ? $log->created_at->setTimezone('America/New_York') : null) }}
                                    </td>
                                    <td class="dynamic-data">{{ $log->load_bill_to }}</td>
                                    <td class="dynamic-data">{{ $log->load_carrier }}</td>
                                    <td class="dynamic-data">{{ $shipper_location[0]['location'] ?? '' }}</td>
                                    <td class="dynamic-data">{{ $consignee_location[0]['location'] ?? '' }}</td>
                                    <td class="dynamic-data">{{ $log->load_type_two }}</td>
                                    <td class="dynamic-data">{{ $log->load_advance_payment }}</td>
                                    @php
                                        $formattedDate = '';

                                        // Ensure $consignee_appointment is a valid array
                                        if (is_array($consignee_appointment) && !empty($consignee_appointment)) {
                                            // Get the last key of the consignee appointment array
                                            $lastKey = array_key_last($consignee_appointment);

                                            // Check if the appointment date is not empty
                                            $appointmentDate = !empty($consignee_appointment[$lastKey]['appointment']) ? $consignee_appointment[$lastKey]['appointment'] : null;

                                            // Format the date if it exists
                                            $formattedDate = format_report_date($appointmentDate);
                                        }
                                    @endphp

                                    <td class="dynamic-data">
                                        {{ $formattedDate }}
                                    </td>

                                    <td class="dynamic-data">{{ format_report_date($log->load_actual_delivery_date) }}</td>
                                    <td class="dynamic-data">{{ format_report_date($log->load_carrier_due_date) }}</td>
@php
$date = trim($log->load_carrier_due_date_on);
$formatted = '';

try {
    $formatted = format_report_date($date);
} catch (\Exception $e) {
    $formatted = '';
}

@endphp

<td class="dynamic-data">{{ format_report_date($log->load_carrier_due_date_on) }}</td>
                                    <td class="dynamic-data">{{ $log->load_carrier_fee }}</td>
                                    <td class="dynamic-data">{{ format_report_value($log->load_billing_fsc_rate, $isCancelled) }}</td>
                                    <td class="dynamic-data">
                                        @php
                                            $charges = json_decode($log->carrier_load_other_charge, true);
                                            $total = 0;
                                        @endphp

                                        @if(is_array($charges) && count($charges) > 0)
                                        <table style="width:100%; border-collapse: collapse; border:1px solid #000;" class="bordered-table">
                                            <tr>
                                                <th style="text-align:left; border:1px solid #000;">Type</th>
                                                <th style="text-align:right; border:1px solid #000;">Amount</th>
                                            </tr>

                                            @foreach($charges as $c)
                                                @php
                                                    $amount = floatval(str_replace(',', '', $c['amount']));
                                                    $total += $amount;
                                                @endphp

                                                <tr>
                                                    <td style="border:1px solid #000;">{{ $c['type'] }}</td>
                                                    <td style="text-align:right; border:1px solid #000;">{{ number_format($amount, 2) }}</td>
                                                </tr>
                                            @endforeach

                                            <tr>
                                                <td style="border:1px solid #000;"><strong>Total</strong></td>
                                                <td style="text-align:right; border:1px solid #000;"><strong>{{ number_format($total, 2) }}</strong></td>
                                            </tr>
                                        </table>
                                        @else
                                            N/A
                                        @endif
                                    </td>

                                    <td class="dynamic-data">{{ format_report_value($log->load_final_carrier_fee, $isCancelled) }}</td>
                                    <td class="dynamic-data">{{ format_report_value($log->load_shipper_rate, $isCancelled) }}</td>
                                    <td class="dynamic-data">{{ format_report_value($log->load_fsc_rate, $isCancelled) }}</td>
                                    <td class="dynamic-data">{{ format_report_value($log->shipper_load_other_charge, $isCancelled) }}</td>
                                    <td class="dynamic-data">{{ format_report_value($log->shipper_load_final_rate, $isCancelled) }}</td>
                                    <td class="dynamic-data">{{ $isCancelled ? '-' : $log->invoice_number }}</td>
                                    <td class="dynamic-data">
                                        @if($isCancelled)
                                            -
                                        @elseif(!empty($log->invoice_date) && $log->invoice_date !== '0000-00-00')
                                            {{ format_report_date($log->invoice_date) }}
                                        @elseif(!empty($log->invoice_status_date) && $log->invoice_status_date !== '0000-00-00')
                                            {{ format_report_date($log->invoice_status_date) }}
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td class="dynamic-data">{{ $isCancelled ? '-' : format_report_date($log->paper_work_date) }}</td>
                                    <td class="dynamic-data">{{ $isCancelled ? '-' : format_report_date($log->payment_receiving_date) }}</td>
                                    <td class="dynamic-data">{{ $isCancelled ? 'Cancelled' : $paymentStatus }}</td>
                                    <td class="dynamic-data">
                                        @if($isCancelled)
                                            0
                                        @elseif(in_array($log->invoice_status, ['Paid Record', 'Paid']))
                                            {{ $log->receiving_amount }}
                                        @endif
                                    </td>
                                    <td class="dynamic-data">{{ $isCancelled ? 0 : number_format($remainingAmount, 2) }}</td>
                                    <td class="dynamic-data">{{ $isCancelled ? 0 : number_format($excessAmount, 2) }}</td>
                                    <td class="dynamic-data">{{ $isCancelled ? '-' : format_report_date($log->invoice_status_date) }}</td>
                                    @php
                                        
                                        $shipperLoadFinalRate = $log->shipper_load_final_rate ?? 0;
                                        $loadFinalCarrierFee = $log->load_final_carrier_fee ?? 0;
                                        // Calculate margin
                                        $margin = $shipperLoadFinalRate - abs($loadFinalCarrierFee);

                                    @endphp
                                    <td class="dynamic-data">{{ format_report_value($log->shipper_load_final_rate, $isCancelled) }}</td>
                                    <td class="dynamic-data">{{ format_report_value($log->load_final_carrier_fee, $isCancelled) }}</td>
                                    <td class="dynamic-data">{{ $isCancelled ? 0 : $margin }}</td>
                                    <td class="dynamic-data">{{ $log->load_workorder }}</td>
                                    <td class="dynamic-data">{{ $log->cpr_check }}</td>
                                    <td class="dynamic-data">{{ $log->no_of_macro }}</td>
                                    <td class="dynamic-data">{{ $log->load_advance_rec_amount }}</td>
                                    <td class="dynamic-data">{{ $log->macro }}</td>
                                    <td class="dynamic-data">{{ $log->no_of_macro }}</td>
                                </tr>
                                @endforeach