@foreach ($customersData as $key => $customer)
                                    <tr>
                                        <td class="dynamic-data" style="vertical-align: middle !important;">{{ $customer['id'] }}</td>
                                        <td class="dynamic-data" style="vertical-align: middle !important;">
                                            <a href="javascript:void(0)" data-customer-id="{{ $customer['id'] }}" data-bs-toggle="modal" data-bs-target="#customerDetailsModal">
                                                {{ $customer['name'] }}
                                            </a>
                                        </td>
                                        <td class="dynamic-data" style="vertical-align: middle !important;">{{ $customer['teamlead'] }}</td>
                                        <td class="dynamic-data" style="vertical-align: middle !important;">{{ $customer['manager'] }}</td>
                                        <td class="dynamic-data" style="vertical-align: middle !important;">{{ $customer['office'] }}</td>
                                        <td class="dynamic-data" style="vertical-align: middle !important;">{{ $customer['agent'] }}</td>
                                        <td class="dynamic-data" style="vertical-align: middle !important;"><a href="javascript:void(0)" data-customer-id="{{ $customer['id'] }}" data-toggle="modal" data-target="#customerDetailsModal">{{ number_format($customer['customerAging'], 2) }}</a></td>
                                        <td class="dynamic-data" style="vertical-align: middle !important;"><a href="javascript:void(0)" data-customer-id="{{ $customer['id'] }}" data-toggle="modal" data-target="#thirtydaysaging">{{ number_format($customer['last30Days'], 2) }}</a></td>
                                    </tr>
                                    @endforeach