@php
    $i = 1;
@endphp
@foreach($sortedCustomers as $customer)
@if(!empty($customer->customer_name))
<tr class="load-row 
        {{ $customer->status == 'Approved' ? 'row-approved' : '' }} 
        {{ $customer->status == 'Not Approved' ? 'row-not-approved' : '' }} ">
    <td>{{ $i++ }}</td>
    <td>@if($customer->user){{ ucwords($customer->user->name) }}@endif</td>
    <td>
        <a href="{{route('edit.customer', $customer->id)}}" style="text-decoration:unset">
            {{ ucwords($customer->customer_name) }}</a>
    </td>
    <td>
        {{ $customer->customer_address }} {{ $customer->customer_country }} {{ $customer->customer_state }} {{ $customer->customer_city }} {{ $customer->customer_zip }}
    </td>
    <td>{{ $customer->customer_telephone }}</td>
    <td>{{ $customer->created_at->format('m-d-Y') }}</td>
    <td>@if($customer->user){{ ucwords($customer->user->team_lead)}}@endif</td>
    <td>@if($customer->user){{ ucwords($customer->user->manager) }}@endif</td>
    <td>@if($customer->user){{ ucwords($customer->user->office) }}@endif</td>
    <td>
        ${{ $customer->adv_customer_credit_limit }}
    </td>
    <td>
        ${{ number_format(floatval($customer->adv_customer_credit_limit), 2) }} - ${{ number_format(floatval($customer->adv_customer_credit_limit) - floatval($customer->remaining_credit), 2) }}
    </td>
    <td>
        ${{ number_format(floatval($customer->remaining_credit), 2) }}
    </td>
    <td>{{ $customer->status }}</td>
    @php

        // Calculate aging days
        $agingDays = $customer->invoice_date 
            ? Carbon::parse($customer->invoice_date)->diffInDays(Carbon::now()) 
            : null;
    @endphp
    <td>{{ $agingDays !== null ? $agingDays . ' days' : 'N/A' }}
    </td>
    <td>
        <div class="d-flex justify-content-center">
            @php
                $st = $customer->status;
            @endphp
            <a href="{{route('edit.customer', $customer->id)}}">
                <i class="fa fa-edit" style="font-size: 17px;color: #0dcaf0;"></i>
            </a>
            <a href="javascript:void(0);" class="delete-customer" data-id="{{ $customer->id }}">
                <i class="fa fa-trash" style="font-size: 17px;color: red;"></i>
            </a>
        </div>
    </td>
</tr>
@endif
@endforeach

