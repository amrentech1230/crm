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

                @php
                    $difference = floatval($record->shipper_load_final_rate) - floatval($record->receiving_amount);
                @endphp
                <td style="min-width:120px;" id="payment-status-{{ $record->id }}">
                    <div id="payment-status-label-{{ $record->id }}" style="font-weight:700; margin-bottom:5px; display: {{ $difference > 0 ? 'none' : 'block' }}; color: {{ $difference > 0 ? 'green' : 'green' }};">
                        Paid
                    </div>
                    @if($difference > 0)
                        <a href="javascript:void(0);" id="short-btn-{{ $record->id }}" class="btn btn-warning btn-sm" onclick="markAsShortPayment({{ $record->id }}, {{ $record->receiving_amount ?? 0 }}, {{ $record->shipper_load_final_rate ?? 0 }})">Short</a>
                    @endif
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
        $difference = floatval($record->shipper_load_final_rate) - floatval($record->receiving_amount);
    @endphp

    @if($difference > 0)
        <div style="display:flex; align-items:center; gap:8px;">
            <span style="color: red; font-weight: 600;">{{ number_format($difference, 2) }}</span>
            <label style="margin:0; font-weight:600; cursor:pointer;">
                <input type="checkbox" class="mark-paid-checkbox" data-id="{{ $record->id }}" data-shipper="{{ $record->shipper_load_final_rate }}"> Mark Paid
            </label>
        </div>
    @elseif($difference < 0)
        <span style="background-color:#d4edda; color:#28a745; padding:3px 10px; border-radius:4px; font-weight:600; display:inline-block;">
            Excess: ${{ number_format(abs($difference), 2) }}
        </span>
    @else
        <span style="background-color:#d4edda; color:#28a745; padding:3px 10px; border-radius:4px; font-weight:600; display:inline-block;">
            $0.00
        </span>
    @endif
</td>

            <td class="dynamic-data" id="payment-receiving-date-{{ $record->id }}">{{ !empty($record->payment_receiving_date) ? \Carbon\Carbon::parse($record->payment_receiving_date)->format('m-d-Y H:i:s') : '' }}</td>
            <td class="dynamic-data">{{ !empty($record->invoice_status_date) ? \Carbon\Carbon::parse($record->invoice_status_date)->format('m-d-Y') : '' }}</td>
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
    $(document).off('change.markPaid', '.mark-paid-checkbox').on('change.markPaid', '.mark-paid-checkbox', function(event) {
        event.stopImmediatePropagation();

        var $cb = $(this);
        if (!$cb.is(':checked')) return;
        if ($cb.data('processing')) return;
        $cb.data('processing', true);

        var id = $cb.data('id');
        var shipper = parseFloat($cb.data('shipper')) || 0;

        var now = new Date();
        // Format as YYYY-MM-DD HH:MM:SS
        var yyyy = now.getFullYear();
        var mm = String(now.getMonth() + 1).padStart(2, '0');
        var dd = String(now.getDate()).padStart(2, '0');
        var hh = String(now.getHours()).padStart(2, '0');
        var min = String(now.getMinutes()).padStart(2, '0');
        var ss = String(now.getSeconds()).padStart(2, '0');
        var formatted = yyyy + '-' + mm + '-' + dd + ' ' + hh + ':' + min + ':' + ss;

        // show global loader
        $('.loader-container').removeClass('hide');

        $.ajax({
            url: '/account/update-invoice-status-as-paid-record/' + id,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                payment_receiving_date: formatted,
                receiving_amount: shipper,
                status: 'Paid'
            },
            success: function(res) {
                $('.loader-container').addClass('hide');
                $('#payment-status-label-' + id).text('Paid').css('display', 'block');
                $('#short-btn-' + id).remove();
                $('#payment-receiving-date-' + id).text(formatted);
                $cb.prop('disabled', true);
                $cb.removeData('processing');
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                $cb.prop('checked', false);
                $cb.removeData('processing');
                $('.loader-container').addClass('hide');
            }
        });
    });
</script>
<script>
    function printInvoice(recordId) {
        var printWindow = window.open('/account/invoices/' + recordId + '/print/paid', '_blank', 'width=800,height=600');
        printWindow.addEventListener('load', function () {
            printWindow.print();
        }, true);
    }

    function markAsBackInvoiceRecord(loadId) {
        // show loader and perform back-invoice silently
        $('.loader-container').removeClass('hide');
        $.ajax({
            url: `/account/update-invoice-status-as-back-invoice/${loadId}`,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Laravel CSRF protection
            },
            success: function(response) {
                console.log('AJAX request successful:', response);
                $('.loader-container').addClass('hide');
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error('Error marking as Back to Invoice:', error);
                $('.loader-container').addClass('hide');
            }
        });
    }


</script>

    <script>
        function markAsShortPayment(loadId, currentReceiving, shipperFinal) {
            var defaultVal = (currentReceiving && Number(currentReceiving) > 0) ? Number(currentReceiving) : Number(shipperFinal);
            var received = prompt('Enter received amount for short payment:', defaultVal);
            if (received === null) return; // cancelled

            received = parseFloat(received);
            if (isNaN(received) || received < 0) {
                console.error('Invalid receiving amount');
                return;
            }

            $('.loader-container').removeClass('hide');

            $.ajax({
                url: "/account/update-invoice-status-as-short/" + loadId,
                method: 'POST',
                data: {
                    receiving_amount: received,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                        console.log(res.message || 'Marked as Short Payment');
                        $('.loader-container').addClass('hide');
                        var $tab = $('a[data-bs-toggle="tab"][href="#invoiced_paid"]');
                        if ($tab.length) {
                            $tab.trigger('click');
                            location.reload();
                        } else {
                            location.reload();
                        }
                },
                error: function(xhr) {
                    $('.loader-container').addClass('hide');
                    console.error('Failed to mark short payment', xhr.responseText);
                }
            });
        }
    </script>