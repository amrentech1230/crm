 @php $i = 1; @endphp
                                        @foreach($get_customers as $index => $customer)
                                       
                                        @if(!empty($customer->customer_name))
                                        <tr>
                                            <td>{{ ($get_customers->currentPage() - 1) * $get_customers->perPage() + $index + 1 }}</td>
                                            <td>{{ \Carbon\Carbon::parse($customer->created_at)->format('m/d/Y') }}</td>
                                            <td>{{ $customer->customer_name }}</td>
                                            <td>{{ $customer->customer_address }} </td>
                                            <td>{{ $customer->customer_city }} </td>
                                            <td>{{ $customer->state?->name ?? $customer->customer_state }}</td>
                                            <td>{{ $customer->customer_zip }}</td>
                                            <td>{{ $customer->country?->name ?? $customer->country_name }}
                                                {{ $customer->customer_billing_city }}
                                                {{ $customer->customer_billing_state }}
                                                {{ $customer->customer_billing_zip }}
                                                {{ preg_replace('/^\d+\s*/', '',  isset($customer->customer_billing_country )) }}
                                            </td>
                                            <td>{{ $customer->customer_extn }}</td>
                                            <td>{{ $customer->customer_fax }}</td>
                                            <td>@if($customer->user) {{ $customer->user->name }} @endif</td>
                                            <td>{{ $customer->adv_customer_payment_terms}}</td>
                                            <td>{{ $customer->remaining_credit}}</td>
                                            <td>{{ $customer->approved_limit}}</td>
                                            <td>{{ $customer->customer_status}}</td>
                    
                                        </tr>
                                        @endif
                                        @endforeach