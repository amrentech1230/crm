@php
        $i=1;
        @endphp
        @foreach($paid as $record)
        <tr>
            <td class="dynamic-data">
                {{ $i++ }}</td>
            <td class="dynamic-data" id="load_number3">

            <a style="color: #0c7ce6; font-weight: 700; cursor: pointer;" 
                onclick="#">
                {{ $record->load_number }}
            </a>
            </td>
            <td class="dynamic-data">
                <a href="{{ route('load.edit', $record->id) }}" class="btn btn-primary btn-sm"><i class=" fas fa-edit"></i></a>
                <a href="{{ route('accounts.view_loads_detail', $record->id) }}" class="btn btn-primary btn-sm"><i class=" fas fa-eye"></i></a>
                <a  href="javascript:void(0);" title="Back"
                    onclick="markAsBackInvoiceRecord({{ $record->id }})" class="btn btn-primary btn-sm"><i class=" fas fa-reply"></i></a>
                <a href="javascript:void(0);" title="Print invoice"
                   onclick="printInvoice({{ $record->id }})" class="btn btn-primary btn-sm"><i class=" fas fa-print"></i></a>
            </td>
            <td class="dynamic-data">
                {{ $record->load_workorder }}</td>
            <td class="dynamic-data">
                {{ $record->load_bill_to }}
            </td>
            <td class="dynamic-data">
                {{ $record->invoice_number }}</td>
            <td class="dynamic-data">
            {{ \Carbon\Carbon::parse($record->invoice_date)->format('m-d-Y') }}
            </td>
            <td class="dynamic-data">
            {{ \Carbon\Carbon::parse($record->invoice_status_date)->format('m-d-Y') }}
            </td>
            <td class="dynamic-data">{{ !empty($record->payment_receiving_date) ? \Carbon\Carbon::parse($record->payment_receiving_date)->format('m-d-Y') : '' }}</td>
            <td class="dynamic-data">{{ !empty($record->paper_work_date) ? \Carbon\Carbon::parse($record->paper_work_date)->format('m-d-Y') : '' }}</td>
            <td class="dynamic-data">
            @if($record->user) {{ $record->user->name }} @endif
            </td>
            <td class="dynamic-data">
            @if($record->user)  {{ $record->user->office }}  @endif</td>
            <td class="dynamic-data">
            @if($record->user)  {{ $record-> user->team_lead }}  @endif</td>
            <td class="dynamic-data">
            @if($record->user) {{ $record->user->manager }}  @endif</td>

            <td class="dynamic-data">
            {{ $record->created_at->format('m-d-Y') }}
            </td>
            @php
            $shipper_appointment =
            json_decode($record->load_shipper_appointment,true);
            @endphp
            <td class="dynamic-data">
                {{ isset($shipper_appointment[0]['appointment']) ? \Carbon\Carbon::parse($shipper_appointment[0]['appointment'])->format('m-d-Y') : '' }}
            </td>
            @php
            $consignee_appointment =
            json_decode($record->load_consignee_appointment,true);
            @endphp
            <td class="dynamic-data">
                {{ isset($consignee_appointment[0]['appointment']) ? \Carbon\Carbon::parse($consignee_appointment[0]['appointment'])->format('m-d-Y') : '' }}
            </td>
            <td class="dynamic-data">
                {{ $record->load_carrier }}</td>
            @php
            $shipper_location =
            json_decode($record->load_shipper_location,true);
            @endphp
            <td class="dynamic-data tooltip-container" onclick="copyToClipboard(this)">
                {{ \Illuminate\Support\Str::words($shipper_location[0]['location'] ?? '', 3, '...') }}
                <span class="tooltip-text">{{ $shipper_location[0]['location'] ?? '' }}</span>
            </td>
            @php
            $consignee_loaction =
            json_decode($record->load_consignee_location,true);
            @endphp


            <td class="dynamic-data tooltip-container" onclick="copyToClipboard(this)">
                {{ \Illuminate\Support\Str::words($consignee_loaction[0]['location'] ?? '', 3, '...') }}
                <span class="tooltip-text">{{ $consignee_loaction[0]['location'] ?? '' }}</span>
            </td>
            <td class="dynamic-data">{{ $record->shipper_load_final_rate }}</td>
            @php
            $shipperLoadFinalRate = floatval($record->shipper_load_final_rate);
            $receivingAmount = floatval($record->remaining_amount);
            $remaining = max($shipperLoadFinalRate - $receivingAmount, 0);
            @endphp
            <td class="dynamic-data">{{ $record->receiving_amount }}</td>
            <td class="dynamic-data">{{ $record->remaining_amount }}</td>

            @php
                $receivingAmount = floatval($record->receiving_amount);
                $shipperRate = floatval($shipperLoadFinalRate);
                $advpayment = $receivingAmount - $shipperRate;

                if ($advpayment > 0) {
                    echo $advpayment;
                } else {
                    $advpayment = 0;
                }
            @endphp
            <td class="dynamic-data">{{ $advpayment}}</td>

            @if($record->invoice_status == 'Paid Record')
                <td class="dynamic-data"> Invoiced / Paid</td>
            @endif
            
        </tr>
@endforeach


<script>
    function printInvoice(recordId) {
        var printWindow = window.open('/invoices/' + recordId + '/print/paid', '_blank', 'width=800,height=600');
        printWindow.addEventListener('load', function () {
            printWindow.print();
        }, true);
    }

    function markAsBackInvoiceRecord(loadId) {
    if (confirm('Are you sure you want to back this record in Invoice?')) {
        $.ajax({
            url: `/update-invoice-status-as-back-invoice/${loadId}`,
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