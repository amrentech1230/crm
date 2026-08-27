 @php $i = 1; @endphp
                                        @foreach($get_customers as $customer)
                                        @if(!empty($customer->customer_name))
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ \Carbon\Carbon::parse($customer->created_at)->format('m/d/Y') }}</td>
                                            <td>{{ $customer->customer_name }}</td>
                                            <td>{{ $customer->customer_address }} {{ $customer->customer_city }}
                                                {{ $customer->customer_state }} {{ $customer->customer_zip }}
                                                {{ preg_replace('/^\d+\s*/', '',  isset($customer->customer_country)) }}
                                            </td>
                                            <td>{{ $customer->customer_billing_address }}
                                                {{ $customer->customer_billing_city }}
                                                {{ $customer->customer_billing_state }}
                                                {{ $customer->customer_billing_zip }}
                                                {{ preg_replace('/^\d+\s*/', '',  isset($customer->customer_billing_country )) }}
                                            </td>
                                            <td>{{ $customer->customer_secondary_email }}</td>
                                            <td>{{ $customer->customer_billing_telephone }}</td>
                                            <td>{{ $customer->customer_telephone }}</td>
                                            <td>{{ $customer->customer_extn }}</td>
                                            <td>{{ $customer->customer_fax }}</td>
                                            <td>{{ $customer->customer_email }}</td>
                                            <td>@if($customer->user) {{ $customer->user->name }} @endif</td>
                                            <td>{{ $customer->adv_customer_payment_terms}}</td>
                                            <td>{{ $customer->remaining_credit}}</td>
                                            <td>{{ $customer->approved_limit}}</td>
                                            <td>{{ $customer->customer_status}}</td>
                                            <!-- <td>abs</td>
                                <td>abs</td>
                                <td>abs</td>
                                <td>abs</td> -->
                                        </tr>
                                        @endif
                                        @endforeach