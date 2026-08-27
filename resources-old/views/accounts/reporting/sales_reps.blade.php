 @php $i = 1; @endphp
                            @foreach($totalRevenueBroker as $r)
                            @php
                            $finalRate = $r->total_revenue - $r->revenue_difference;
                            @endphp

                            <tr>
                                <td class="dynamic-data">{{ $i++ }}</td>
                                <td class="dynamic-data">{{ $r->name }}</td>
                                <td class="dynamic-data">{{ $r->load_count }}</td>
                                <td class="dynamic-data">{{ $r->total_revenue }}</td>
                                <td class="dynamic-data">{{ $finalRate }}</td>
                                <td class="dynamic-data">{{ $r->revenue_difference }}</td>
                                <td class="dynamic-data">{{ $r->open_load_count }}</td>
                            </tr>
                            @endforeach