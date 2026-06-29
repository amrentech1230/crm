
        @foreach($paid as $i => $record)
        
        <tr>
            
            <td class="dynamic-data" id="load_number3">

            <a style="color: #000; font-weight: 700; cursor: pointer;" onclick="#">
                {{ $record->load_number }}
            </a>
            </td>
            <td class="dynamic-data">
                <a class="btn btn-primary btn-sm" onclick="openUploadWindow('{{route('load.edit', $record->id)}}')"><i class=" fas fa-edit"></i></a>
                <a  href="javascript:void(0);" title="Back"
                    onclick="markAsBackInvoiceRecord({{ $record->id }})" class="btn btn-primary btn-sm"><i class=" fas fa-reply"></i></a>
                <a href="javascript:void(0);" title="Print invoice"
                   onclick="printInvoice({{ $record->id }})" class="btn btn-primary btn-sm"><i class=" fas fa-print"></i></a>
				
				<a href="{{route('CompletedPublicDoc',$record->id)}}" class="btn btn-primary btn-sm" target="_blank" rel="noopener noreferrer"> <i class="fas fa-file"></i></a>
                <a href="{{ route('accounts.view_loads_detail', $record->id) }}" class="btn btn-primary btn-sm" title="logs"> <i class="fas fa-eye"></i></a>
            </td>
                        <td class="dynamic-data">{{ $record->load_workorder }}</td>
                         <td class="dynamic-data">{{ $record->invoice_number }}</td>
                         @php
            $consignee_appointment =
            json_decode($record->load_consignee_appointment,true);
            @endphp
            <td class="dynamic-data">
                {{ isset($consignee_appointment[0]['appointment']) ? \Carbon\Carbon::parse($consignee_appointment[0]['appointment'])->format('m-d-Y') : '' }}
            </td>

            @php
                $difference = floatval($record->shipper_load_final_rate) - floatval($record->receiving_amount);
                $paymentIsComplete = abs($difference) < 0.005;
            @endphp
            <td class="dynamic-data">
                {{ $record->load_bill_to }}
                @if($paymentIsComplete)
                    <span class="text-success ms-1" style="font-weight: 700;">&#10004;</span>
                @endif
            </td>
           
            <td class="dynamic-data">
            {{ $record->invoice_date 
    ? \Carbon\Carbon::parse($record->invoice_date)->format('m-d-Y') 
    : ($record->invoice_status_date 
        ? \Carbon\Carbon::parse($record->invoice_status_date)->format('m-d-Y') 
        : '') }}

            </td>
            <td class="dynamic-data">{{ $record->shipper_load_final_rate }}</td>
            <td class="dynamic-data">{{ $record->receiving_amount }}</td>

<td class="dynamic-data">
    @php
        $difference = $record->shipper_load_final_rate - $record->receiving_amount;
    @endphp

    @if($difference > 0)
        {{-- Short Payment --}}
        <span style="color: red; font-weight: 600;">
            {{ number_format($difference, 2) }}
        </span>
    @elseif($difference < 0)
        {{-- Excess Payment --}}
        <span style="color: green; font-weight: 600;">
            +{{ number_format(abs($difference), 2) }}
        </span>
    @else
        {{-- Exact Payment --}}
        <span style="color: green; font-weight: 600;">
            0.00
        </span>
    @endif
</td>

            <td class="dynamic-data">{{ !empty($record->payment_receiving_date) ? \Carbon\Carbon::parse($record->payment_receiving_date)->format('m-d-Y') : '' }}</td>
            <td class="dynamic-data">{{ \Carbon\Carbon::parse($record->invoice_status_date)->format('m-d-Y') }}</td>
            <td class="dynamic-data">{{ !empty($record->paper_work_date) ? \Carbon\Carbon::parse($record->paper_work_date)->format('m-d-Y') : '' }}</td>
            <td class="dynamic-data">@if($record->user) {{ $record->user->name }} @endif</td>
            <td class="dynamic-data">{{ $record->created_at->format('m-d-Y') }}</td>
            @php
            $shipper_appointment =
            json_decode($record->load_shipper_appointment,true);
            @endphp
            <td class="dynamic-data">
                {{ isset($shipper_appointment[0]['appointment']) ? \Carbon\Carbon::parse($shipper_appointment[0]['appointment'])->format('m-d-Y') : '' }}
            </td>
            
                        @php
                        $shipper_location =
                        json_decode($record->load_shipper_location,true);
                        @endphp
                        <td class="dynamic-data tooltip-container" onclick="copyToClipboard(this)">
                            {{ \Illuminate\Support\Str::words($shipper_location[0]['location'] ?? '', 3, '...') }}
                            <span class="tooltip-text">{{ $shipper_location[0]['location'] ?? '' }}</span>
                        </td> 
            <!-- <td class="dynamic-data">
            {{ \Carbon\Carbon::parse($record->invoice_status_date)->format('m-d-Y') }}
            </td> -->
            

            


             @php
            $consignee_loaction =
            json_decode($record->load_consignee_location,true);
            @endphp


             <td class="dynamic-data tooltip-container" onclick="copyToClipboard(this)">
                {{ \Illuminate\Support\Str::words($consignee_loaction[0]['location'] ?? '', 3, '...') }}
                <span class="tooltip-text">{{ $consignee_loaction[0]['location'] ?? '' }}</span>
            </td> 
            
            <!-- @php
            $shipperLoadFinalRate = floatval($record->shipper_load_final_rate);
            $receivingAmount = floatval($record->remaining_amount);
            $remaining = max($shipperLoadFinalRate - $receivingAmount, 0);
            @endphp
            <td class="dynamic-data">{{ $record->shipper_load_final_rate }}</td>
			<td class="dynamic-data">{{ $record->invoice_internal_value }}</td> -->
			<!-- <td class="dynamic-data">{{ $record->load_advance_rec_amount }}</td> -->



            <!-- @php
                $receivingAmount = floatval($record->receiving_amount);
                $shipperRate = floatval($shipperLoadFinalRate);
                $advpayment = $receivingAmount - $shipperRate;

                if ($advpayment > 0) {
                    echo $advpayment;
                } else {
                    $advpayment = 0;
                }
            @endphp -->
            <!-- <td class="dynamic-data">{{ $advpayment}}</td> -->

            
            <!-- @if($record->invoice_status == 'Paid Record')
                <td class="dynamic-data"> Paid</td>
            @endif -->
                            <td class="dynamic-data">
                  
                       <textarea name="invoice_internal_value" onkeyup="RemainingAmount(this)" row="10" col="5" style="width: 450px !important;height: 50px;"   data-invoice-id="{{ $record->id }}" class="invoice_internal_value" placeholder="Enter additional notes...">{{ $record->invoice_internal_value }}</textarea>

                </td>
        </tr>
		
@endforeach

 
<script>
    function openUploadWindow(url) {
        // Define the size of the new window
        var width = 1500;   // Width of the new window
        var height = 800;  // Height of the new window

        // Calculate the position to center the window
        var left = screen.width / 2 - width / 2;   // Center horizontally
        var top = screen.height / 2 - height / 2;  // Center vertically

        // Open the new window with the specified URL and properties
        var newWindow = window.open(url, 'UploadWindow', 'width=' + width + ',height=' + height + ',top=' + top + ',left=' + left + ',resizable=yes,scrollbars=yes');
        
        // Focus on the new window, if it was successfully opened
        if (newWindow) {
            newWindow.focus();
        }
    }
</script>
<script>
    function printInvoice(recordId) {
        var printWindow = window.open('/account/invoices/' + recordId + '/print/paid', '_blank', 'width=800,height=600');
        printWindow.addEventListener('load', function () {
            printWindow.print();
        }, true);
    }

    function markAsBackInvoiceRecord(loadId) {
    if (confirm('Are you sure you want to back this record in Invoice?')) {
        $.ajax({
            url: `/account/update-invoice-status-as-back-invoice/${loadId}`,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Laravel CSRF protection
            },
            success: function(response) {
                console.log('AJAX request successful:', response);
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error('Error marking as Back to Invoice:', error);
                alert('Failed back in Invoice.');
            }
        });
    }
}


</script>