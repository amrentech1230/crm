@php
$i = 1;
@endphp
@foreach($loads as $load)
<tr class="load-row {{ 
        $load->load_status == 'Open' ? 'row-open' : 
        ($load->load_status == 'Delivered' && $load->invoice_status == 'Paid' ? 'row-delivered-paid' : 
        ($load->load_status == 'Delivered' && $load->invoice_status == 'Paid Record' ? 'row-delivered-paid-record' : 
        ($load->load_status == 'Delivered' ? 'row-delivered' : ''))) 
    }}" data-created-at="{{ $load->created_at->format('m-d-Y') }}">
    <td>{{ $i++ }}</td>
    <td><a href="{{ route('load.edit', $load->id) }}">{{ $load->load_number }}</a></td>
    <td>
        <a href="{{ route('load.edit', $load->id) }}" class="btn btn-primary btn-sm">
            <i class="fas fa-edit"></i>
        </a>
    </td>

    <td>@if($load->user){{ $load->user->name }}@endif</td>
    <td>
    @if(!empty($load->invoice_number))
    {{ $load->invoice_number }}
    @else
    -
    @endif
    </td>
    <td>
    @if(!empty($load->invoice_date) && $load->invoice_date !== '0000-00-00')
        {{ \Carbon\Carbon::parse($load->invoice_date)->format('m-d-Y') }}
    @else
        -
    @endif
    </td>
    <td>{{ $load->load_workorder }}</td>
    <td>{{ $load->load_bill_to }}</td>
    <td>@if($load->user){{ $load->user->office }}@endif</td>
    <td>@if($load->user){{ $load->user->team_lead }}@endif</td>
    <td>@if($load->user){{ $load->user->manager }}@endif</td>
    <td>{{ $load->created_at->format('m-d-Y') }}</td>
        @php
        $shipper_appointment = json_decode($load->load_shipper_appointment,true);
        @endphp
    <td>{{ isset($shipper_appointment[0]['appointment']) ? \Carbon\Carbon::parse($shipper_appointment[0]['appointment'])->format('m-d-Y') : '' }}</td>
        @php
            $consignee_appointment = json_decode($load->load_consignee_appointment,true);
        @endphp
        <td>
            {{ isset($consignee_appointment[0]['appointment']) && strtotime($consignee_appointment[0]['appointment']) 
                ? \Carbon\Carbon::parse($consignee_appointment[0]['appointment'])->format('m-d-Y') 
                : '' }}
        </td>
        <td>
            {{ \Carbon\Carbon::parse($load->load_actual_delivery_date)->format('m-d-Y') }}
        </td>
    <td>{{ $load->load_mc_no }}</td>
    <td>
        {{ $load->load_carrier }}</td>
    @php
        $shipper_location = json_decode($load->load_shipper_location,true);
    @endphp
    <td>
        {{ $shipper_location[0]['location'] ?? '' }}
    </td>
    @php
        $consignee_loaction = json_decode($load->load_consignee_location,
    true);
    @endphp

    <td>
        {{ $consignee_loaction[0]['location'] ?? '' }}
    </td>
    <td>
        @if($load->load_status == 'Open')
            Open
        @elseif($load->load_status == 'Delivered' && $load->invoice_status == 'Paid')
            Invoiced
        @elseif($load->load_status == 'Delivered' && $load->invoice_status != 'Paid' && $load->invoice_status != 'Paid Record')
            Delivered
        @elseif($load->load_status == 'Delivered' && $load->invoice_status == 'Paid Record')
            Paid
        @endif
    </td>

    @php
        $shipperRate = floatval($load->shipper_load_final_rate);
        $carrierFee = floatval($load->load_final_carrier_fee);
        $getMargin = $shipperRate - $carrierFee;
    @endphp
    <td>${{ number_format($getMargin, 2) }}</td>
    @php
            $shipperRate = floatval($load->shipper_load_final_rate);
            $carrierFee = floatval($load->load_final_carrier_fee);
            $getMargin = $shipperRate - $carrierFee;

            // Calculate margin percentage
            if ($shipperRate > 0) {
                $marginPercent = ($getMargin / $shipperRate) * 100;
            } else {
                $marginPercent = 0; // Handle division by zero case
            }
        @endphp

    <td>
        {{ number_format($marginPercent, 2) }}%
    </td>

    <td>
        @php
            $differenceInDays = null;
            if (isset($load->invoice_date)) {
                $invoiceDate = \Carbon\Carbon::parse($load->invoice_date);
                $currentDate = \Carbon\Carbon::now();
                if ($load->invoice_status == 'Paid') {
                    $differenceInDays = $invoiceDate->diffInDays($currentDate);
                } elseif ($load->invoice_status == 'Paid Record') {
                    // If the invoice status is 'Paid Record', aging is complete
                    $differenceInDays = 'Paid';
                }
            }
            $isInvoiceStatusEmpty = empty($load->invoice_status);
        @endphp

        @if($isInvoiceStatusEmpty)
            <span>-</span>
        @elseif($differenceInDays !== null)
            @if($load->invoice_status == 'Paid')
            <span style="color:red">{{ $differenceInDays }} days</span>
            @elseif($load->invoice_status == 'Paid Record')
                <span style="color:green">{{ $differenceInDays }}</span>
            @endif
        @else
            <span>-</span>
        @endif
    </td>
    <td>
        @php
            $differenceInDays = null;

            // Check if the load has a delivery date and the status is Delivered
            if ($load->load_status == 'Delivered' && !empty($load->load_actual_delivery_date)) {
                $deliveryDate = \Carbon\Carbon::parse($load->load_actual_delivery_date);
                $currentDate = \Carbon\Carbon::now();

                // If the invoice status is 'Paid', aging is complete
                if ($load->invoice_status == 'Paid') {
                    $differenceInDays = 'Received to accounting';
                } 
                // Otherwise, calculate aging days from delivery date
                else {
                    $differenceInDays = $deliveryDate->diffInDays($currentDate);
                }
            }
        @endphp

        @if(empty($load->load_actual_delivery_date))
            <span>-</span>
        @elseif($differenceInDays === 'Received to accounting')
            <span style="color:green">{{ $differenceInDays }}</span>
        @elseif($differenceInDays !== null)
            <span style="color:red">{{ $differenceInDays }} days</span>
        @else
            <span>-</span>
        @endif
    </td>
    <td>
        <a href="{{route('admin.rc.download.pdf', $load->load_number)}}" target="_blank">
            <i class="fas fa-file-pdf text-danger" aria-hidden="true" style="font-size: 24px;"></i>
        </a>
    </td>
    <td>
        <a href="{{route('admin.shipper.rc.download.pdf', $load->load_number)}}" target="_blank">
            <i class="fas fa-file-pdf text-danger" aria-hidden="true" style="font-size: 24px;"></i>
        </a>
    </td>
</tr>
@endforeach

