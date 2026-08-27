@php
    $i = 1;
@endphp
@foreach($sortedCustomers as $customer)
@if(!empty($customer->customer_name))
<tr class="load-row 
        {{ $customer->status == 'Approved' ? 'row-approved' : '' }} 
        {{ $customer->status == 'Not Approved' ? 'row-not-approved' : '' }} ">
    <td class="hide_blur_privacy">{{ $i++ }}</td>
    <td class="hide_blur_privacy">@if($customer->user){{ ucwords($customer->user->name) }}@endif</td>
    <td class="hide_blur_privacy">@if($customer->user){{ ucwords($customer->user->officedata?->office_name) }}@endif</td>
    <td class="hide_blur_privacy">
        <a href="{{route('edit.customer', $customer->id)}}" style="text-decoration:unset">
            {{ ucwords($customer->customer_name) }}</a>
    </td>
    <td class="hide_blur_privacy">
        {{ $customer->customer_address }} {{ $customer->customer_country }} {{ $customer->customer_state }} {{ $customer->customer_city }} {{ $customer->customer_zip }}
    </td>
    <td class="hide_blur_privacy">{{ $customer->customer_telephone }}</td>
    <td class="hide_blur_privacy">{{ $customer->customer_email }}</td>
    <td class="hide_blur_privacy">{{ $customer->customer_secondary_email }}</td>
    <td class="hide_blur_privacy">{{ $customer->created_at->format('m-d-Y') }}</td>
    <td class="hide_blur_privacy">@if($customer->user){{ ucwords($customer->user->teamLeaderInfo?->tl)}}@endif</td>
    <td class="hide_blur_privacy">@if($customer->user){{ ucwords($customer->user->managerInfo?->manager) }}@endif</td>
    <td class="hide_blur_privacy">
        ${{ $customer->adv_customer_credit_limit }}
    </td>
    <td class="hide_blur_privacy">
        ${{ number_format(floatval($customer->adv_customer_credit_limit), 2) }} - ${{ number_format(floatval($customer->adv_customer_credit_limit) - floatval($customer->remaining_credit), 2) }}
    </td>
    <td class="hide_blur_privacy">
        ${{ number_format(round(floatval($customer->remaining_credit), 2), 2) }}

    </td>
    <td class="hide_blur_privacy">{{ $customer->status }}</td>
    @php

        // Calculate aging days
        $agingDays = $customer->invoice_date 
            ? Carbon::parse($customer->invoice_date)->diffInDays(Carbon::now()) 
            : null;
    @endphp
    <td class="hide_blur_privacy">{{ $agingDays !== null ? $agingDays . ' days' : 'N/A' }}
    </td>
    <td class="hide_blur_privacy">
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

