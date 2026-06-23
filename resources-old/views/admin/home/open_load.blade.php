
@php
                                $i = 1;
                                @endphp
                                @foreach($open as $s)
                                @if($s->load_status == 'Open')

                                <tr>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">{{ $i++ }}
                                    </td>
                                    <td class="dynamic-data" id="load_number1" style="vertical-align: middle !important;">
                                    <a style="color: rgb(10 185 90) !important; font-weight: 700; cursor: pointer;">{{ $s->load_number }}</a>
                                    </td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                    @if($s->user)  {{ $s->user->name }} @endif</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                    {{ $s->load_workorder }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                    {{ $s->load_bill_to }}</td>
                                    
                                    
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                       @if($s->user)  {{ $s->user->office }} @endif</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                       @if($s->user)  {{ $s->user->team_lead }} @endif</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                       @if($s->user)  {{ $s->user->manager }} @endif</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->created_at->format('m-d-Y') }}</td>
                                        @php
                                        $shipper_appointment = json_decode($s->load_shipper_appointment,true);
                                        @endphp
                                    <td class="dynamic-data" style="vertical-align: middle !important;">{{ isset($shipper_appointment[0]['appointment']) ? \Carbon\Carbon::parse($shipper_appointment[0]['appointment'])->format('m-d-Y') : '' }}</td>
                                        @php
                                            $consignee_appointment = json_decode($s->load_consignee_appointment,true);
                                        @endphp
                                        <td class="dynamic-data" style="vertical-align: middle !important;">
                                            {{ 
                                                isset($consignee_appointment[0]['appointment']) && 
                                                preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/', $consignee_appointment[0]['appointment']) 
                                                    ? \Carbon\Carbon::parse($consignee_appointment[0]['appointment'])->format('m-d-Y') 
                                                    : '' 
                                            }}
                                        </td>

                                        <!-- <td class="dynamic-data" style="vertical-align: middle !important;">
                                            {{ \Carbon\Carbon::parse($s->load_actual_delivery_date)->format('m-d-Y') }}
                                        </td> -->
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

                                    <td class="dynamic-data" style= "vertical-align: middle !important;">
                                        {{ $consignee_loaction[0]['location'] ?? '' }}</td>
                                    <td class="dynamic-data" style="vertical-align: middle !important;">
                                        {{ $s->load_status }}</td>

                                </tr>
                                @endif
                                @endforeach
