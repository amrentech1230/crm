 @php $i = 1; @endphp
                                    @foreach($totalRevenueCarrier as $revenue)
                                    @php
                                    $finalRate = $revenue->total_revenue - $revenue->revenue_difference;
                                    @endphp

                                    <tr>
                                        <td class="dynamic-data">{{ $i++ }}</td>
                                        <td class="dynamic-data">{{ $revenue->name }}</td>
                                        <td class="dynamic-data">{{ $revenue->load_count }}</td>
                                        <td class="dynamic-data">{{ $revenue->total_revenue }}</td>
                                        <td class="dynamic-data">${{ number_format($revenue->sum_load_final_carrier_fee, 2) }}</td>
                                        <td class="dynamic-data">{{ $revenue->revenue_difference }}</td>
                                        <td class="dynamic-data">{{ $revenue->open_load_count }}</td>
                                        <td class="dynamic-data">{{ $revenue->delivered_load_count }}</td>
                                        <td class="dynamic-data">{{ $revenue->invoiced_load_count }}</td>
                                    </tr>
                                    @endforeach