@foreach($all_load as $loads)
<tr class="load-row {{ 
                                                 $loads->load_status == 'Open' ? 'row-open' : 
                                                ($loads->load_status == 'Delivered' && $loads->invoice_status == 'Paid' ? 'row-delivered-paid' : 
                                                ($loads->load_status == 'Delivered' && $loads->invoice_status == 'Paid Record' ? 'row-delivered-paid-record' : 
                                                ($loads->load_status == 'Delivered' ? 'row-delivered' : ''))) 
                                            }}" data-created-at="{{ $loads->created_at->format('Y-m-d') }}">
    <td class="dynamic-data">
        @if ($loads->load_status != 'Completed')
        <a style="font-weight: 700;" href="#">
            {{ $loads->load_number }}
        </a>
        @else
        {{ $loads->load_number }}
        @endif
    </td>
    <td>
        <a href="{{ route('load.editload', $loads->id) }}" class="btn btn-primary btn-sm">
            <i class="fas fa-edit"></i>
        </a>
    </td>



    <td class="dynamic-data">{{ $loads->user?->name }}</td>
    <td class="dynamic-data">{{ $loads->load_workorder }}</td>
    <td class="dynamic-data">{{ $loads->customer_refrence_number }}</td>
    <td class="dynamic-data">{{ $loads->load_bill_to }}</td>
    <td class="dynamic-data">{{ $loads->created_at->format('m-d-Y') }}</td>
    @php
    $shipper_appointment =
    json_decode($loads->load_shipper_appointment,true);
    @endphp
    <td class="dynamic-data">
        {{ isset($shipper_appointment[0]['appointment']) ? \Carbon\Carbon::parse($shipper_appointment[0]['appointment'])->format('m-d-Y') : '' }}
    </td>
    @php
    $consignee_appointment =
    json_decode($loads->load_consignee_appointment,true);
    @endphp
    <td class="dynamic-data">
        @if ($consignee_appointment && isset($consignee_appointment[0]['appointment']))
        @php
        $appointment = $consignee_appointment[0]['appointment'];
        // Attempt to parse only if it's in a recognizable date format
        try {
        $formattedDate = \Carbon\Carbon::parse($appointment)->format('m-d-Y');
        } catch (\Exception $e) {
        $formattedDate = '-'; // Set to '-' if parsing fails
        }
        @endphp
        {{ $formattedDate }}
        @else
        -
        @endif
    </td>


    <td class="dynamic-data">
        @if($loads->load_actual_delivery_date)
        {{ \Carbon\Carbon::parse($loads->load_actual_delivery_date)->format('m-d-Y') }}
        @else
        -
        @endif

    </td>
    <td class="dynamic-data">{{ $loads->load_carrier }}</td>


    @php
    $shipper_location = json_decode($loads->load_shipper_location, true);
    $first_shipper_location = is_array($shipper_location) ? reset($shipper_location) : null;
    @endphp





    <td class="dynamic-data tooltip-container" onclick="copyToClipboard(this)">
        {{ \Illuminate\Support\Str::words($first_shipper_location['location'] ?? '', 3, '...') }}
        <span class="tooltip-text">{{ $first_shipper_location['location'] ?? '' }}</span>
    </td>

    @php
    $consignee_location = json_decode($loads->load_consignee_location, true);
    $last_consignee_location = is_array($consignee_location) ? end($consignee_location) : null;
    @endphp


    <td class="dynamic-data tooltip-container" onclick="copyToClipboard(this)">
        {{ \Illuminate\Support\Str::words($last_consignee_location['location'] ?? '', 3, '...') }}
        <span class="tooltip-text">{{ $last_consignee_location['location'] ?? '' }}</span>
    </td>


    <td class="dynamic-data">


        @if($loads->cpr_check == 'Not Approved' || $loads->cpr_check == 'Not Verified' || $loads->cpr_check == 'Not
        Received')
        <select name="" id="" disabled>
            <option value="Open">Open</option>
        </select>
        <div>
            <span style="color:red;font-size: 9px;">CPR Not Approved Kindly Wait</span>
        </div>
        @else
        @php


        $statusOptions = [
        'Open' => '#74d1f0',
        'Covered' => 'rgb(69 7 172 / 72%)',
        'On Route' => 'green',
        'Delivered' => '#7C2B1A',
        'Unloading' => 'gray',
        'Completed' => '#3597dc',
        ];


        // Always disable dropdown if load_status is "Completed"
        $disableDropdown = ($loads->load_status == 'Completed');
        @endphp

        <select name="load_status" class="form-control" data-load-id="{{ $loads->id }}" @if($disableDropdown) disabled
            @endif>
            @foreach($statusOptions as $status => $color)
            <option value="{{ $status }}" @if($loads->load_status === $status) selected @endif>
                {{ $status }}
            </option>
            @endforeach
        </select>
        @endif
    </td>






    @if(!empty($loads->shipper_load_final_rate))
    <td class="dynamic-data">{{ $loads->shipper_load_final_rate }}</td>
    @else
    <td class="dynamic-data"> - </td>
    @endif

    @if(!empty($loads->load_final_carrier_fee))
    <td class="dynamic-data">{{ $loads->load_final_carrier_fee }}</td>
    @else
    <td class="dynamic-data"> - </td>
    @endif

    @php
    $shipperRate = floatval($loads->shipper_load_final_rate);
    $carrierFee = floatval($loads->load_final_carrier_fee);
    $getMargin = $shipperRate - $carrierFee;
    @endphp
    <td class="dynamic-data">
        ${{ number_format($getMargin, 2) }}
    </td>
    @php
    $shipperRate = floatval($loads->shipper_load_final_rate);
    $carrierFee = floatval($loads->load_final_carrier_fee);
    $getMargin = $shipperRate - $carrierFee;

    // Calculate margin percentage
    if ($shipperRate > 0) {
    $marginPercent = ($getMargin / $shipperRate) * 100;
    } else {
    $marginPercent = 0; // Handle division by zero case
    }
    @endphp

    <td class="dynamic-data">
        {{ number_format($marginPercent, 2) }}%
    </td>





    <td class="dynamic-data">
        @php
        // Initialize the differenceInDays variable
        $differenceInDays = null;

        // Check if the invoice date is set
        if (isset($loads->invoice_date)) {
        // Parse the invoice date
        $invoiceDate = \Carbon\Carbon::parse($loads->invoice_date);
        $currentDate = \Carbon\Carbon::now();

        // Calculate the difference in days based on the invoice status
        if ($loads->invoice_status == 'Paid') {
        // Calculate days since the invoice was paid
        $differenceInDays = $invoiceDate->diffInDays($currentDate);
        } elseif ($loads->invoice_status == 'Paid Record') {
        // If the invoice status is 'Paid Record', aging is complete
        $differenceInDays = 'Paid';
        }
        }

        // Check for empty or null invoice status
        $isInvoiceStatusEmpty = empty($loads->invoice_status);
        @endphp

        @if($isInvoiceStatusEmpty)
        <span>-</span>
        @elseif($differenceInDays !== null)
        @if($loads->invoice_status == 'Paid')
        <span style="color:red">{{ $differenceInDays }} days</span>
        @elseif($loads->invoice_status == 'Paid Record')
        <span style="color:green">{{ $differenceInDays }}</span>
        @endif
        @else
        <span>-</span>
        @endif
    </td>



    @if($loads->load_status == "Open" && $loads->cpr_check != 'Verified')
    <td class="dynamic-data">Not Verified</td>
    @else
    <td class="dynamic-data">{{ $loads->cpr_check }}</td>
    @endif

    @if($loads->load_status)
    <td class="dynamic-data" colspan="2">
               
                    <a href="{{route('clone.load', $loads->load_number)}}" target="_blank">
                        <i class="fas fa-clone dynamic-data" style="margin:0 10px; font-size: 20px;"></i> Clone
                    </a>
                
                    <a href="{{route('rc.download.pdf', $loads->load_number)}}" target="_blank">
                        <i class="fas fa-file-pdf dynamic-data" style="margin:0 10px; font-size: 20px;"></i>Carrier RC
                    </a>
               
                    <a href="{{route('shipper.download.pdf', $loads->load_number)}}" class="clone-link">
                        <i class="fas fa-file-pdf dynamic-data" style="margin:0 10px; font-size: 20px;"></i> Shipper RC
                    </a>
               
                @if ($loads->load_status != 'Open')
              
                    <a href="javascript:void(0);">
                        <i class="fa fa-upload dynamic-data" aria-hidden="true"
                            style="margin:0 10px; font-size: 20px;"></i>Upload
                    </a>
               

                @endif
               
                    <a class="view-files" data-toggle="modal" data-id="{{ $loads->id }}" data-target="#filesModal">
                        <i class="fa fa-file" style="margin:0 10px; font-size: 20px;"></i> AP Docs
                    </a>

    </td>
    @elseif($loads->invoice_status == 'Paid Record')
    <td class="dynamic-data"><span>Paid</span></td>
    @elseif($loads->invoice_status == 'Paid')
    <td class="dynamic-data"><span> Invoiced</span></td>
    @elseif($loads->invoice_status == 'Completed')
    <td class="dynamic-data"><span> Completed </span></td>
    @else
    <td class="dynamic-data"><span>Delivered</span></td>
    @endif
   

</tr>
@endforeach

