 @php
                                $i = 1;
                                @endphp
                                @foreach($broker_status as $s)


                                <tr>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">{{ $i++ }}
                                    </td>
                                    <td class="dynamic-data" id="load_number" style="vertical-align: middle !important;">
                                        <a style="color: rgb(10 185 90) !important; font-weight: 700; cursor: pointer;" >
                                            {{ $s->load_number }}
                                        </a>
                                    </td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                    @if($s->user) {{ $s->user->name }} @endif</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        @if(!empty($s->invoice_number))
                                        {{ $s->invoice_number }}
                                    @else
                                    -
                                    @endif
                                    </td> 
                                        
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        @if(!empty($s->invoice_date) && $s->invoice_date !== '0000-00-00')
                                            {{ \Carbon\Carbon::parse($s->invoice_date)->format('m-d-Y') }}
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                    {{ $s->load_workorder }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                    {{ $s->load_bill_to }}</td>
                                    
                                    
                                   
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                      @if($s->user)   {{ $s->user->office }} @endif</td>
                                        <td class="dynamic-data" style="vertical-align: middle !important;">
                                       @if($s->user)  {{ $s->user->team_lead }} @endif</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                      @if($s->user)   {{ $s->user->manager }} @endif</td>
                                    
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->created_at->format('m-d-Y') }}</td>
                                        @php
                                        $shipper_appointment = json_decode($s->load_shipper_appointment,true);
                                        @endphp
                                        <td class="dynamic-data" style="vertical-align: middle !important;">
                                            {{ isset($shipper_appointment[0]['appointment']) ? \Carbon\Carbon::parse($shipper_appointment[0]['appointment'])->format('m-d-Y') : '' }}
                                        </td>

                                        @php
                                            $consignee_appointment = json_decode($s->load_consignee_appointment, true);
                                        @endphp

                                        <td class="dynamic-data" style="vertical-align: middle !important;">
                                            @if(!empty($s->load_consignee_appointment) && isset($consignee_appointment[0]['appointment']))
                                                {{ \Carbon\Carbon::parse($consignee_appointment[0]['appointment'])->format('m-d-Y') }}
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td class="dynamic-data" style="vertical-align: middle !important;">
                                            @if(!empty($s->load_actual_delivery_date))
                                            {{ \Carbon\Carbon::parse($s->load_actual_delivery_date)->format('m-d-Y') }}
                                            @else
                                            -
                                            @endif
                                        </td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->load_carrier }}</td>
                                    @php
                                        $shipper_location = json_decode($s->load_shipper_location,true);
                                    @endphp
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $shipper_location[0]['location'] ?? '' }}
                                    </td>
                                    @php
                                        $consignee_loaction = json_decode($s->load_consignee_location,
                                    true);
                                    @endphp

                                    <td class="dynamic-data" style=" vertical-align: middle !important;">
                                        {{ $consignee_loaction[0]['location'] ?? '' }}

                                    </td>

                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        @if($s->load_status == 'Open')
                                            Open
                                        @elseif($s->load_status == 'Delivered' && $s->invoice_status == 'Paid')
                                            Invoiced
                                        @elseif($s->load_status == 'Delivered' && $s->invoice_status != 'Paid' && $s->invoice_status != 'Paid Record')
                                            Delivered
                                        @elseif($s->load_status == 'Delivered' && $s->invoice_status == 'Paid Record')
                                            <span style="color:green">Paid</span>
                                        @endif    
                                    </td>
                                    @php
                                        $shipperRate = floatval($s->shipper_load_final_rate);
                                        $carrierFee = floatval($s->load_final_carrier_fee);
                                        $getMargin = $shipperRate - $carrierFee;
                                    @endphp
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        ${{ number_format($getMargin, 2) }}
                                    </td>

                                    <td class="dynamic-data">
                                                        @php
                                                            $differenceInDays = null;
                                                            if (isset($s->invoice_date)) {
                                                                $invoiceDate = \Carbon\Carbon::parse($s->invoice_date);
                                                                $currentDate = \Carbon\Carbon::now();
                                                                if ($s->invoice_status == 'Paid') {
                                                                    $differenceInDays = $invoiceDate->diffInDays($currentDate);
                                                                } elseif ($s->invoice_status == 'Paid Record') {
                                                                    // If the invoice status is 'Paid Record', aging is complete
                                                                    $differenceInDays = 'Paid';
                                                                }
                                                            }
                                                            $isInvoiceStatusEmpty = empty($s->invoice_status);
                                                        @endphp

                                                        @if($isInvoiceStatusEmpty)
                                                            <span>-</span>
                                                        @elseif($differenceInDays !== null)
                                                            @if($s->invoice_status == 'Paid')
                                                            <span style="color:red">{{ $differenceInDays }} days</span>
                                                            @elseif($s->invoice_status == 'Paid Record')
                                                                <span style="color:green">{{ $differenceInDays }}</span>
                                                            @endif
                                                        @else
                                                            <span>-</span>
                                                        @endif
                                                    </td>
                                    @if($s->load_status == "Open")
                                <td class="dynamic-data">{{ $s->cpr_check }}</td>
                                @elseif($s->load_status == "Delivered")
                                <td class="dynamic-data">Verified</td>
                                @elseif($s->load_status !== "Delivered")
                                <td class="dynamic-data">Not Verified</td>
                                @endif
                                   
                                </tr>
                                @endforeach