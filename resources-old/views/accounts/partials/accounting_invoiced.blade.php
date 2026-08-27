
    @php $i = 1; @endphp
        @foreach($invoiced as $invoice)
            @php
                $shipperAppointment = json_decode($invoice->load_shipper_appointment, true);
                $firstAppointment = '';

                if (is_array($shipperAppointment) && !empty($shipperAppointment)) {
                reset($shipperAppointment);
                $firstItem = current($shipperAppointment);

                if (is_array($firstItem)) {
                // If first item is an array, get the first string value or a key like 'date'
                if (isset($firstItem['date'])) {
                $firstAppointment = $firstItem['date'];
                } else {
                // fallback: get first value of the array
                $firstAppointment = reset($firstItem);
                }
                } elseif (is_string($firstItem)) {
                // If first item is a string directly
                $firstAppointment = $firstItem;
                }
                }
            @endphp

            @php
                $consigneeAppointment = json_decode($invoice->load_consignee_appointment, true);
                $lastAppointment = '';

                if (is_array($consigneeAppointment) && !empty($consigneeAppointment)) {
                    $lastItem = end($consigneeAppointment);

                    if (is_array($lastItem)) {
                        // If last item is an array, try to get 'date' key or first value
                        if (isset($lastItem['date'])) {
                            $lastAppointment = $lastItem['date'];
                        } else {
                            $lastAppointment = reset($lastItem);
                        }
                    } elseif (is_string($lastItem)) {
                        $lastAppointment = $lastItem;
                    }
                }
            @endphp
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $invoice->load_number }}</td>
                <td>
                    <a id="markAsPaidRecordBtn_{{ $invoice->id }}" title="Approved"
                        class="{{ $invoice->invoice_status === 'Paid Record' ? 'success' : 'danger' }} btn btn-primary btn-sm"
                        onclick="markAsPaidRecord({{ $invoice->id }})" ><i class=" fas fa-check"></i></a>

                    <a href="{{ route('load.edit', $invoice->id) }}" class="btn btn-primary btn-sm"><i class=" fas fa-edit"></i></a>

                    <a href="{{ route('accounts.view_loads_detail', $invoice->id) }}" class="btn btn-primary btn-sm"><i class=" fas fa-eye"></i></a>

                    <a href="#" onclick="markAsBackDeliveredRecord({{ $invoice->id }})" title="Back" class="btn btn-primary btn-sm"><i class=" fas fa-reply"></i></a>

                    <a href="#" class="btn btn-primary btn-sm"><i class=" fas fa-envelope-open"></i></a>

                    <a href="javascript:void(0);" onclick="printPreInvoice({{ $invoice->id }})" title="Print invoice" class="btn btn-primary btn-sm"><i class=" fas fa-print"></i></a>
                </td>
                <td class="dynamic-data">
                    {{ $invoice->load_workorder }}</td>
                <td class="dynamic-data">
                    {{ $invoice->load_bill_to }}</td>
                
                <td>{{ !empty($invoice->paper_work_date) ? \Carbon\Carbon::parse($invoice->paper_work_date)->format('m-d-Y') : '' }}</td>
                <td>
                    <input type="date"
                        class="form-control paymentreceivingdate_{{$invoice->id}}"
                        name="payment_receiving_date"
                        value="{{ !empty($load->payment_receiving_date) ? \Carbon\Carbon::parse($load->payment_receiving_date)->format('m-d-Y') : '' }}">
                </td>

                <td class="dynamic-data">{{ $invoice->shipper_load_final_rate }}</td>
                <td class="dynamic-data">
                    <input type="number" class="form-control receiving_amount"
                        name="receiving_amount" data-invoice-id="{{ $invoice->id }}"
                        data-shipper-load-final-rate="{{ $invoice->shipper_load_final_rate }}"
                        id="receiving_amount_{{ $invoice->id }}"
                        value="{{ $invoice->receiving_amount }}">
                </td>
                @php
                $shipperLoadFinalRate = floatval($invoice->shipper_load_final_rate);
                $receivingAmount = floatval($invoice->receiving_amount);
                $remaining = max($shipperLoadFinalRate - $receivingAmount, 0);
                @endphp
                <td class="dynamic-data">
                    <input type="text" readonly
                        class="form-control remaining_amount"
                        name="remaining_amount"
                        id="remaining_amount_{{ $invoice->id }}"
                        value="{{ number_format($remaining, 2) }}">
                </td>
                <td class="dynamic-data">
                    {{ $invoice->invoice_number }}</td>
                <td class="dynamic-data">
                    @if(!empty($invoice->invoice_date))
                    {{ date('m-d-Y', strtotime($invoice->invoice_date)) }}
                    @else
                    -
                    @endif
                </td>
                
                <td class="dynamic-data">
                @if($invoice->user) {{ $invoice->user->name }} @endif
                </td>


                <td class="dynamic-data">
                @if($invoice->user)  {{ $invoice->user->office }} @endif</td>
                <td class="dynamic-data">
                @if($invoice->user) {{ $invoice->user->team_lead }} @endif</td>
                <td class="dynamic-data">
                @if($invoice->user)  {{ $invoice->user->manager }} @endif</td>
                <td class="dynamic-data">
                {{ $invoice->created_at->format('m-d-Y') }}
                </td>
                @php
                $shipper_appointment =
                json_decode($invoice->load_shipper_appointment,true);
                @endphp
                <td class="dynamic-data">
                    {{ isset($shipper_appointment[0]['appointment']) ? \Carbon\Carbon::parse($shipper_appointment[0]['appointment'])->format('m-d-Y') : '' }}
                </td>
                @php
                $consignee_appointment =
                json_decode($invoice->load_consignee_appointment,true);
                @endphp
                <td class="dynamic-data">
                    {{ isset($consignee_appointment[0]['appointment']) ? \Carbon\Carbon::parse($consignee_appointment[0]['appointment'])->format('m-d-Y') : '' }}
                </td>
                <td class="dynamic-data">
                {{ \Carbon\Carbon::parse($invoice->load_actual_delivery_date)->format('m-d-Y') }}
                </td>
                <td class="dynamic-data">
                    {{ $invoice->load_carrier }}</td>
                @php
                $shipper_location = json_decode($invoice->load_shipper_location,
                true);
                @endphp
                <td class="dynamic-data tooltip-container" onclick="copyToClipboard(this)">
                    {{ \Illuminate\Support\Str::words($shipper_location[0]['location'] ?? '', 3, '...') }}
                    <span class="tooltip-text">{{ $shipper_location[0]['location'] ?? '' }}</span>
                </td>

                @php
                $consignee_loaction = json_decode($invoice->load_consignee_location,
                true);
                @endphp
                <td class="dynamic-data tooltip-container" onclick="copyToClipboard(this)">
                    {{ \Illuminate\Support\Str::words($consignee_loaction[0]['location'] ?? '', 3, '...') }}
                    <span class="tooltip-text">{{ $consignee_loaction[0]['location'] ?? '' }}</span>
                </td>
                <td class="dynamic-data">
                    @if($invoice->invoice_status == 'Paid')
                    Invoiced / Paid
                    @endif

                </td>

                <td class="dynamic-data">
                    @if($invoice->load_status == 'Delivered' ||
                    $invoice->invoice_status == 'Completed' )
                    @php
                    $deliveredDate = \Carbon\Carbon::parse($invoice->created_at);
                    $currentDate = \Carbon\Carbon::now();
                    $differenceInDays = $deliveredDate->diffInDays($currentDate);
                    @endphp
                    {{ $differenceInDays }} days
                    @elseif($invoice->invoice_status == 'Completed' ||
                    $invoice->load_status == 'Delivered')
                    Aging Complete
                    @endif
                </td>
                
                
            </tr>
        @endforeach

<script>
function printPreInvoice(id) {
        var printWindow = window.open('/print-invoice/' + id, '_blank', 'width=800,height=600');
        printWindow.focus();
        printWindow.onload = function () {
            printWindow.print();
        };
    }
    
function markAsPaidRecord(loadId) {
    const $paymentDateInput = $(`.paymentreceivingdate_${loadId}`).first();
    const paymentReceivingDate = $paymentDateInput.length ? $paymentDateInput.val() : '';

    if (paymentReceivingDate === '') {
         $('#mc-error-message').text('Please select the payment receiving date').fadeIn();
         setTimeout(function() {
                    $('#mc-error-message').text('').fadeOut();
                }, 2000);
        return;
    }

    // Send AJAX request with CSRF token (Laravel compatible)
    $.ajax({
        url: `/update-invoice-status-as-paid-record/${loadId}`,
        method: 'POST',
        data: {
            payment_receiving_date: paymentReceivingDate
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token from meta tag
        },
        success: function(response) {
            const $row = $(`#markAsPaidRecordBtn_${loadId}`).closest('tr');
            if ($row.length) {
                $row.remove(); // remove the row or update as needed
            }
            $('#mc-success-message').text(response.message).fadeIn();
            setTimeout(function() {
                    $('#mc-success-message').text('').fadeOut();
                }, 2000);
        },
        error: function(xhr, status, error) {
             $('#mc-error-message').text('Failed to mark as Paid Record').fadeIn();
             setTimeout(function() {
                    $('#mc-error-message').text('').fadeOut();
                }, 2000);
        }
    });
}

function markAsBackDeliveredRecord(loadId) {
    if (confirm('Are you sure you want to back this record in Completed?')) {
        $.ajax({
            url: `/update-invoice-status-as-back-complete/${loadId}`,
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Laravel CSRF token
            },
            success: function(response) {
                console.log('AJAX request successful:', response);
                location.reload(); // Reload the page after successful update
            },
            error: function(xhr, status, error) {
                console.error('Error marking as Back to Deliver:', error);
                alert('Failed to back in deliver.');
            }
        });
    }
}


        function updateRemainingAmount(invoiceId) {
            var shipperLoadFinalRate = parseFloat($('#receiving_amount_' + invoiceId).data(
                'shipper-load-final-rate'));
            var receivingAmount = parseFloat($('#receiving_amount_' + invoiceId).val()) || 0;

            if(receivingAmount > shipperLoadFinalRate){
                
                $('#mc-error-message').text('Receiving amount should not be greater than the shipper final rate.').fadeIn();
                setTimeout(function() {
                        $('#mc-error-message').text('').fadeOut();
                    }, 2000);
                    $('#receiving_amount_' + invoiceId).val('');
            }else{
                var remainingAmount = shipperLoadFinalRate - receivingAmount;

                // Ensure remaining amount is not negative
                remainingAmount = Math.max(remainingAmount, 0);

                // Display remaining amount, limiting to 2 decimal places
                $('#remaining_amount_' + invoiceId).val(remainingAmount.toFixed(2));
            }
            
        }

    function saveReceivingAmount(invoiceId) {
        var receivingAmount = parseFloat($('#receiving_amount_' + invoiceId).val()) || 0;
        var remainingAmount = parseFloat($('#remaining_amount_' + invoiceId).val()) || 0;

        $.ajax({
            url: '{{ route("load.updateReceivingAmount") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                load_id: invoiceId,
                receiving_amount: receivingAmount,
                remaining_amount: remainingAmount
            },
            success: function (response) {
                if (response.success) {
                    $('#remaining_amount_' + invoiceId).val(response.remaining_amount);
                } else {
                    $('#mc-error-message').text('Failed to update receiving amount').fadeIn();
             setTimeout(function() {
                    $('#mc-error-message').text('').fadeOut();
                }, 2000);
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
                
                $('#mc-error-message').text('An error occurred while updating the receiving amount').fadeIn();
             setTimeout(function() {
                    $('#mc-error-message').text('').fadeOut();
                }, 2000);
            }
        });
    }

    $(document).on('input', '.receiving_amount', function () {
        var invoiceId = $(this).data('invoice-id');
        updateRemainingAmount(invoiceId);
    });

    $(document).on('change', '.receiving_amount', function () {
        var invoiceId = $(this).data('invoice-id');
        updateRemainingAmount(invoiceId);
        saveReceivingAmount(invoiceId);
    });


</script>