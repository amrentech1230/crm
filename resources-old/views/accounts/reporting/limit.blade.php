

                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach($sortedCustomers as $customer)
                                    <tr class="load-row 
                                            {{ $customer->status == 'Approved' ? 'row-approved' : '' }} 
                                            {{ $customer->status == 'Not Approved' ? 'row-not-approved' : '' }} ">
                                        <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $i++ }}</td>
                                        <td class="dynamic-data" style=" vertical-align: middle !important;">@if($customer->user) {{ $customer->user->name }} @endif</td>
                                        <td class="dynamic-data" style=" vertical-align: middle !important;">
                                            {{ $customer->customer_name }}
                                        </td>
                                        <td class="dynamic-data" style=" vertical-align: middle !important;">
                                            {{ $customer->customer_address }} {{ $customer->customer_country }} {{ $customer->customer_state }} {{ $customer->customer_city }} {{ $customer->customer_zip }}
                                        </td>
                                        <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $customer->customer_telephone }}</td>
                                        <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $customer->created_at->format('m/d/Y') }}</td>
                                        <td class="dynamic-data" style=" vertical-align: middle !important;">@if($customer->user) {{ $customer->user->team_lead }} @endif</td>
                                        <td class="dynamic-data" style=" vertical-align: middle !important;">@if($customer->user) {{ $customer->user->manager }} @endif</td>
                                        <td class="dynamic-data" style=" vertical-align: middle !important;">@if($customer->user) {{ $customer->user->office }} @endif</td>
                                         <td class="dynamic-data" style=" vertical-align: middle !important;">
                                            
                                            @php
                                            $credits = json_decode($customer->credit_limit_log, true);

                                            if (is_array($credits)) {
                                                $totalCreditLimit = array_sum(array_column($credits, 'credit_limit'));
                                            } else {
                                                $totalCreditLimit = 0;
                                            }
                                            @endphp
                                            ${{ $totalCreditLimit }}
                                        </td>
                                        <td class="dynamic-data" style=" vertical-align: middle !important;">
                                        ${{ $totalCreditLimit - $customer->remaining_credit }}
                                        </td>
                                        <td class="dynamic-data" style=" vertical-align: middle !important;">
                                            ${{ number_format(floatval($customer->remaining_credit), 2) }}
                                        </td>
                                        <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $customer->status }}</td>
                                        <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $customer->aging_days !== null ? $customer->aging_days . ' days' : 'N/A' }}</td>
                                        <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $customer->created_at->format('m-d-Y') }}</td>
                                        <td class="dynamic-data">
                                            <div class="d-flex justify-content-center">
                                                @php
                                                    $st = $customer->status;
                                                @endphp
                                                <a href="{{ route('edit.customer', ['id' => $customer->id]) }}">
                                                    <i class="fa fa-edit" style="font-size: 17px;color: #0dcaf0;"></i>
                                                </a>
                                                <a href="javascript:void(0);" class="delete-customer" data-id="{{ $customer->id }}">
                                                    <i class="fa fa-trash" style="font-size: 17px;color: red;"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach