@php $i = 1; @endphp
                                @foreach($dashboard as $log)
                                @php
                                    $shipper = json_decode($log->load_shipperr, true);
                                    $consignee = json_decode($log->load_consignee, true);
                                    $shipper_appointment = json_decode($log->load_shipper_appointment,true);
                                    $shipper_location = json_decode($log->load_shipper_location,true);
                                    $appointment = isset($shipper_location[0]['appointment']) ? $shipper_location[0]['appointment'] : '';
                                    $consignee_location = json_decode($log->load_consignee_location,true); 
                                    $consignee_appointment = json_decode($log->load_consignee_appointment,true);
                                @endphp
                                <tr>
                                    <td class="dynamic-data">{{ $i++ }}</td>
                                    <td class="dynamic-data">{{ $log->load_number }}</td>
                                    <td class="dynamic-data">@if($log->user)  {{ $log->user->name }} @endif</td>
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
                                    <td class="dynamic-data">
                                        @if(empty($log->invoice_status))
                                            -
                                        @elseif($log->invoice_status == "Paid")
                                            Invoiced
                                        @else
                                            {{ $log->invoice_status }}
                                        @endif
                                    </td>

                                    <td class="dynamic-data">{{ $log->customer_refrence_number }}</td>
                                    <td class="dynamic-data">
                                        {{ $log->created_at->setTimezone('America/New_York')->format('m/d/Y') }}
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
                                            $formattedDate = $appointmentDate ? (new DateTime($appointmentDate))->format('m/d/Y') : '';
                                        }
                                    @endphp

                                    <td class="dynamic-data">
                                        {{ $formattedDate }}
                                    </td>

                                    <td class="dynamic-data">{{ $log->load_actual_delivery_date ? \Carbon\Carbon::parse($log->load_actual_delivery_date)->format('m/d/Y') : '' }}</td>
                                    <td class="dynamic-data">{{ $log->load_carrier_due_date ? \Carbon\Carbon::parse($log->load_carrier_due_date)->format('m/d/Y') : '' }}</td>
                                    <td class="dynamic-data">{{ $log->load_carrier_due_date_on ? \Carbon\Carbon::parse($log->load_carrier_due_date_on)->format('m/d/Y') : '' }}</td>
                                    <td class="dynamic-data">{{ $log->load_final_carrier_fee }}</td>
                                    <td class="dynamic-data">{{ $log->shipper_load_final_rate }}</td>
                                    <td class="dynamic-data">{{ $log->invoice_number }}</td>
                                    <td class="dynamic-data">{{ $log->invoice_date ? \Carbon\Carbon::parse($log->invoice_date)->format('m/d/Y') : '' }}</td>
                                    <td class="dynamic-data">{{ $log->paper_work_date ? \Carbon\Carbon::parse($log->paper_work_date)->format('m/d/Y') : '' }}</td>
                                    <td class="dynamic-data">{{ $log->payment_receiving_date ? \Carbon\Carbon::parse($log->payment_receiving_date)->format('m/d/Y') : '' }}</td>
                                    
                                    <td class="dynamic-data">
                                        @if($log->invoice_status == "Paid Record") 
                                            {{ $log->receiving_amount }} 
                                        @endif
                                    </td>
                                    <td class="dynamic-data">{{ $log->invoice_status_date ? \Carbon\Carbon::parse($log->invoice_status_date)->format('m/d/Y') : '' }}</td>
                                    @php
                                        // Assign default values if null
                                        $shipperLoadFinalRate = $log->shipper_load_final_rate ?? 0;
                                        $loadFinalCarrierFee = $log->load_final_carrier_fee ?? 0;

                                        // Ensure values are numeric
                                        $shipperLoadFinalRate = is_numeric($shipperLoadFinalRate) ? $shipperLoadFinalRate : 0;
                                        $loadFinalCarrierFee = is_numeric($loadFinalCarrierFee) ? $loadFinalCarrierFee : 0;

                                        // Calculate margin
                                        $margin = $shipperLoadFinalRate - $loadFinalCarrierFee;
                                    @endphp
                                    <td class="dynamic-data">{{ $log->shipper_load_final_rate }}</td>
                                    <td class="dynamic-data">{{ $log->load_final_carrier_fee }}</td>
                                    <td class="dynamic-data">{{ number_format($margin, 2) }}</td>
                                    <td class="dynamic-data">{{ $log->load_workorder }}</td>
                                    <td class="dynamic-data">{{ $log->cpr_check }}</td>
                                    <td class="dynamic-data">{{ $log->no_of_macro }}</td>
                                </tr>
                                @endforeach