

@php
                                $i = 1;
                                @endphp
                                @foreach($broker_status as $s)


                                @php
                                    $rowClass = '';
                                    if ($s->load_status == 'Open') {
                                        $rowClass = 'row-open';
                                    } elseif ($s->load_status == 'Delivered') {
                                        $rowClass = 'row-delivered';
                                    } elseif ($s->load_status == 'Covered') {
                                        $rowClass = 'row-covered';
                                    } elseif ($s->load_status == 'On Route') {
                                        $rowClass = 'row-onroute';
                                    } elseif ($s->load_status == 'Unloading') {
                                        $rowClass = 'row-unloading';
                                    } elseif ($s->load_status == 'Completed' && $s->invoice_status == 'Paid') {
                                        $rowClass = 'row-completed-paid';
                                    } elseif ($s->load_status == 'Completed' && $s->invoice_status == 'Paid Record') {
                                        $rowClass = 'row-completed-paidrecord';
                                    } elseif ($s->load_status == 'Completed') {
                                        $rowClass = 'row-completed';
                                    } elseif ($s->load_status == 'Cancelled') {
                                        $rowClass = 'row-cancelled';
                                    }
                                @endphp

                                <tr class="load-row {{ $rowClass }}" data-created-at="{{ $s->created_at->format('Y-m-d') }}">

                                    <td class="dynamic-data hide_blur_privacy" style="vertical-align: middle !important;">{{ $i++ }}</td>
                                    <td class="dynamic-data hide_blur_privacy"><a href="{{ route('accounts.view_loads_detail', $s->id) }}" class="btn btn-primary btn-sm"> <i class="fas fa-eye"></i></a></td>
                                    <td class="dynamic-data hide_blur_privacy" id="load_number" style="vertical-align: middle !important;">
                                        <a href="{{ route('load.edit', $s->id) }}" style="color: rgb(10 185 90) !important; font-weight: 700; cursor: pointer;" >
                                            {{ $s->load_number }}
                                        </a>
                                    </td>
                                    <td class="dynamic-data hide_blur_privacy" style="vertical-align: middle !important;">
                                    @if($s->user) {{ $s->user->name }} @endif</td>
                                    <td class="dynamic-data hide_blur_privacy" style="vertical-align: middle !important;">
                                        @if(!empty($s->invoice_number))
                                        {{ $s->invoice_number }}
                                    @else
                                    -
                                    @endif
                                    </td> 
                                        
                                    <td class="dynamic-data hide_blur_privacy" style="vertical-align: middle !important;">
                                        @if(!empty($s->invoice_date) && $s->invoice_date !== '0000-00-00')
                                        {{ \Carbon\Carbon::parse($s->invoice_date)->format('m-d-Y') }}
                                        @elseif(!empty($s->invoice_status_date))
                                            {{ \Carbon\Carbon::parse($s->invoice_status_date)->format('m-d-Y') }}
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td class="dynamic-data hide_blur_privacy" style="vertical-align: middle !important;">
                                    {{ $s->load_workorder }}</td>
                                    <td class="dynamic-data hide_blur_privacy" style="vertical-align: middle !important;">
                                    {{ $s->load_bill_to }}</td>
                                    
                                    
                                   
                                    <td class="dynamic-data hide_blur_privacy" style="vertical-align: middle !important;">
                                      @if($s->user)   {{ $s->user->officedata?->office_name }} @endif</td>
                                        <td class="dynamic-data hide_blur_privacy" style="vertical-align: middle !important;">
                                       @if($s->user)  {{ $s->user->teamLeaderInfo?->tl }} @endif</td>
                                    <td class="dynamic-data hide_blur_privacy" style="vertical-align: middle !important;">
                                      @if($s->user)   {{ $s->user->managerInfo?->manager }} @endif</td>
                                    
                                    <td class="dynamic-data hide_blur_privacy" style="vertical-align: middle !important;">
                                        {{ $s->created_at->format('m-d-Y') }}</td>
                                        @php
                                        $shipper_appointment = json_decode($s->load_shipper_appointment,true);
                                        @endphp
                                        <td class="dynamic-data hide_blur_privacy" style="vertical-align: middle !important;">
                                            {{ isset($shipper_appointment[0]['appointment']) ? \Carbon\Carbon::parse($shipper_appointment[0]['appointment'])->format('m-d-Y') : '' }}
                                        </td>

                                        @php
                                            $consignee_appointment = json_decode($s->load_consignee_appointment, true);
                                        @endphp

                                        <td class="dynamic-data hide_blur_privacy" style="vertical-align: middle !important;">
                                            @if(!empty($s->load_consignee_appointment) && isset($consignee_appointment[0]['appointment']))
                                                {{ \Carbon\Carbon::parse($consignee_appointment[0]['appointment'])->format('m-d-Y') }}
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td class="dynamic-data hide_blur_privacy" style="vertical-align: middle !important;">
                                            @if(!empty($s->load_actual_delivery_date))
                                            {{ \Carbon\Carbon::parse($s->load_actual_delivery_date)->format('m-d-Y') }}
                                            @else
                                            -
                                            @endif
                                        </td>
                                    <td class="dynamic-data hide_blur_privacy" style="vertical-align: middle !important;">
                                        {{ $s->load_carrier }}</td>
                                    @php
                                        $shipper_location = json_decode($s->load_shipper_location,true);
                                    @endphp
                                    <td class="dynamic-data hide_blur_privacy" style="vertical-align: middle !important;">
                                        {{ $shipper_location[0]['location'] ?? '' }}
                                    </td>
                                    @php
                                        $consignee_loaction = json_decode($s->load_consignee_location,
                                    true);
                                    @endphp

                                    <td class="dynamic-data hide_blur_privacy" style=" vertical-align: middle !important;">
                                        {{ $consignee_loaction[0]['location'] ?? '' }}

                                    </td>

                                    <td class="dynamic-data hide_blur_privacy" style="vertical-align: middle !important;">
                                        {{ $s->load_status }}
                                    </td>

                                    <td class="dynamic-data hide_blur_privacy" style="vertical-align: middle !important;">
                                        @if($s->invoice_status == 'Paid')
                                            <span style="color:red">Invoiced</span>
                                        @elseif($s->invoice_status == 'Paid Record')
                                            <span style="color:green">Mark Paid</span>
                                        @endif
                                    </td>
                                    <td class="dynamic-data hide_blur_privacy" style="vertical-align: middle !important;">${{ $s->shipper_load_final_rate }}</td>
                                    <td class="dynamic-data hide_blur_privacy" style="vertical-align: middle !important;">${{ $s->load_final_carrier_fee }}</td>
                                    @php
                                        $shipperRate = floatval($s->shipper_load_final_rate);
                                        $carrierFee = floatval($s->load_final_carrier_fee);
                                        $getMargin = $shipperRate - $carrierFee;
                                    @endphp
                                    <td class="dynamic-data hide_blur_privacy" style="vertical-align: middle !important;">
                                        ${{ number_format($getMargin, 2) }}
                                    </td>
                                    @php
                                        $shipperRate = floatval($s->shipper_load_final_rate);
                                        $carrierFee  = floatval($s->load_final_carrier_fee);
                                        $getMargin   = $shipperRate - $carrierFee;

                                        // avoid division by zero
                                        $marginPercent = $shipperRate > 0 ? ($getMargin / $shipperRate) * 100 : 0;
                                    @endphp
                                    <td class="dynamic-data hide_blur_privacy" style="vertical-align: middle !important;">{{ number_format($marginPercent, 2) }}%</td>

                                    <td class="dynamic-data hide_blur_privacy">
                                        @php
                                            $differenceInDays = null;
                                            $isInvoiceStatusEmpty = empty($s->invoice_status);

                                            // Pick the correct date: prefer invoice_date, else invoice_status_date
                                            $invoiceDate = null;
                                            if (!empty($s->invoice_date) && $s->invoice_date !== '0000-00-00') {
                                                $invoiceDate = \Carbon\Carbon::parse($s->invoice_date);
                                            } elseif (!empty($s->invoice_status_date) && $s->invoice_status_date !== '0000-00-00') {
                                                $invoiceDate = \Carbon\Carbon::parse($s->invoice_status_date);
                                            }

                                            if ($invoiceDate) {
                                                $currentDate = \Carbon\Carbon::now();

                                                if ($s->invoice_status == 'Paid') {
                                                    $differenceInDays = $invoiceDate->diffInDays($currentDate);
                                                } elseif ($s->invoice_status == 'Paid Record') {
                                                    // For 'Paid Record' status, no difference needed
                                                    $differenceInDays = 'Paid';
                                                }
                                            }
                                        @endphp

                                        @if($isInvoiceStatusEmpty)
                                            <span>-</span>
                                        @elseif($differenceInDays !== null)
                                            @if($s->invoice_status == 'Paid')
                                                <span style="color:red">{{ round($differenceInDays) }} days</span>
                                            @elseif($s->invoice_status == 'Paid Record')
                                                <span style="color:green">{{ $differenceInDays }}</span>
                                            @endif
                                        @else
                                            <span>-</span>
                                        @endif
                                    </td>



                                 <td>{{ $s->cpr_check }}</td>
                                   
                                </tr>
                                @endforeach

                                