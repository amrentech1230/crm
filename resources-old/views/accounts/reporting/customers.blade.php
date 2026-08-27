 @php $i = 1; @endphp
                                        @foreach($totalRevenueCustomer as $rc)
                                        @php
                                        $finalRate = $rc->total_revenue - $rc->revenue_difference;
                                        @endphp
                                        <tr>
                                            <td class="dynamic-data">{{ $i++ }}</td>
                                            <td class="dynamic-data">{{ $rc->load_bill_to }}</td>
                                            <td class="dynamic-data">{{ number_format($rc->total_revenue, 2) }}</td>
                                            <td class="dynamic-data">{{ number_format($rc->revenue_difference, 2) }}
                                            </td>
                                            <td class="dynamic-data">{{ number_format($finalRate, 2) }}</td>
                                            <td class="dynamic-data">{{ $rc->load_count }}</td>
                                            <td class="dynamic-data">{{ $rc->open_load_count }}</td>
                                            <td class="dynamic-data">{{ $rc->deliverd_load_count }}</td>
                                            <td class="dynamic-data">{{ $rc->completed_load_count }}</td>
                                            <td class="dynamic-data">
                                                {{ number_format($rc->adv_customer_credit_limit, 2) }}</td>
                                        </tr>
                                        @endforeach