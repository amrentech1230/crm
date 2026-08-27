 @php $i = 1; @endphp
                            @foreach($totalRevenueBroker as $index => $r)
                            @php
                            $finalRate = $r->total_revenue - $r->revenue_difference;
                            @endphp

                            <tr>
                                <td class="dynamic-data">{{ ($totalRevenueBroker->currentPage() - 1) * $totalRevenueBroker->perPage() + $index + 1 }}</td>
                                <td class="dynamic-data">{{ $r->name }}</td>
                                <td class="dynamic-data">{{ $r->load_count }}</td>
                                <td class="dynamic-data">{{ $r->total_revenue }}</td>
                                <td class="dynamic-data">{{ $finalRate }}</td>
                                <td class="dynamic-data">{{ $r->revenue_difference }}</td>
                                <td class="dynamic-data">{{ $r->open_load_count }}</td>
                            </tr>
                            @endforeach