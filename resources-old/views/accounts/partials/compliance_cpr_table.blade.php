 @foreach($loads as $delivered)
    <tr>
        
        <td>
            <a>
                {{ $delivered->load_number }}
            </a>
        </td>
        <td>{{ $delivered->load_workorder }}</td>
        <td>@if($delivered->user) {{ $delivered->user->name }} @endif</td>
        <td>{{ $delivered->load_bill_to }}</td>
        <td>{{ $delivered->shipper_load_final_rate }}</td>
        <td>@if($delivered->user) {{ $delivered->user->office }}@endif</td>
        <td>@if($delivered->user) {{ $delivered->user->team_lead }}@endif</td>
        <td>@if($delivered->user) {{ $delivered->user->manager }}@endif</td>
        <td>{{ $delivered->created_at->format('m-d-Y') }}</td>
        @php
        $shipper_appointment =
        json_decode($delivered->load_shipper_appointment,true);
        @endphp
        <td>{{ isset($shipper_appointment[0]['appointment']) ? \Carbon\Carbon::parse($shipper_appointment[0]['appointment'])->format('m-d-Y') : '' }}
        </td>
        @php
        $consignee_appointment =
        json_decode($delivered->load_consignee_appointment,true);
        @endphp
        <td>
            {{ 
                isset($consignee_appointment[0]['appointment']) && 
                \Carbon\Carbon::hasFormat($consignee_appointment[0]['appointment'], 'm-d-Y\TH:i:s') 
                    ? \Carbon\Carbon::parse($consignee_appointment[0]['appointment'])->format('m-d-Y') 
                    : '' 
            }}
        </td>

        <td>{{ $delivered->load_equipment_type }}</td>
        <td>{{$delivered->load_carrier}}</td>
        <td>{{$delivered->load_final_carrier_fee}}</td>
        @php
        $shipper_location = json_decode($delivered->load_shipper_location, true);
        @endphp

            <td >
                {{ $shipper_location[0]['location'] ?? '' }}
            </td>
        @php
        $consignee_location = json_decode($delivered->load_consignee_location, true);
        $last_consignee_location = is_array($consignee_location) && !empty($consignee_location) ? end($consignee_location) : null;
        @endphp

        
        @if (!empty($last_consignee_location) && is_array($last_consignee_location))
            <td>
                {{ $last_consignee_location['location'] ?? '' }}
            </td>
        @else
            <td>
                Not Found Any Drop Location
            </td>
        @endif
        
        
        <td>
            {{ $delivered->load_status }}
        </td>
        <td >
            <select name="cpr_check" class="form-control cpr_check" data-load-id="{{ $delivered->id }}">
                <option value=""> Select CPR</option>
                <option value="Verified" {{ $delivered->cpr_check == 'Verified' ? 'selected' : '' }}>Verified</option>
                <option value="Not Verified" {{ $delivered->cpr_check == 'Not Verified' ? 'selected' : '' }}>Not Verified</option>
                <option value="Not Received" {{ $delivered->cpr_check == 'Not Received' ? 'selected' : '' }}>Not Received</option>
            </select>
        </td>
        <td class="cpr_status-{{ $delivered->id }}">
            @if($delivered->cpr_check == 'Not Received' || $delivered->cpr_check == '')
                blank data
            @else
                {{ $delivered->cpr_check }}
            @endif
        </td>
        <td >
            <select name="macro" class="form-control macro" id="macro-{{ $delivered->id }}" data-load-id="{{ $delivered->id }}">
                <option value="">Select Macro</option>
                <option value="Sent" {{ $delivered->macro == 'Sent' ? 'selected' : '' }}>Sent</option>
                <option value="Not Sent" {{ $delivered->macro == 'Not Sent' ? 'selected' : '' }}>Not Sent</option>
            </select>
        </td>
        <td >
            <select name="no_of_macro" class="form-control no_of_macro" id="no_of_macro-{{ $delivered->id }}" data-load-id="{{ $delivered->id }}">
                <option value="">Select No Of Macro</option>
                @for ($i = 1; $i <= 10; $i++)
                    <option value="{{ $i }}" {{ $delivered->no_of_macro == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </td>

        @if($delivered->cpr_check == 'Verified')
        <td style="padding: 7px 10px !important; vertical-align: middle !important;color: green;">
        Verified
        </td>
        @elseif($delivered->cpr_check == 'Not Verified')
        <td >
            Not Verified
        </td>
        @elseif($delivered->cpr_check == 'Not Received')
        <td >
            Not Received
        </td>
        @elseif($delivered->cpr_check != 'Verified')
        <td >
                Check CPR
        </td>
        @endif
        
        <td>
        
        @if (!empty($delivered->load_delivery_do_file))
                @php
                    $fileUrl = asset('storage/' . $delivered->load_delivery_do_file);
                @endphp
                <a href="{{ $fileUrl }}" target="_blank"><i class="fa fa-eye" style="font-size: 15px;color: #000; margin-right: 6px;"></i></a> | 
                <a href="{{ $fileUrl }}" download><i class="fa fa-download" style="font-size: 15px;color: #000; margin-left: 6px;"></i></a>
            @else
                No File Available
            @endif
        </td>
    </tr>
@endforeach



<script>
 $(document).ready(function() {
    $(document).on('change', '.cpr_check', function(e){
        var load_id = $(this).data('load-id');
        var cpr_check = $(this).val();

        $.ajax({
            url: '/cpr-check',
            method: 'POST',
            data: {
                load_id: load_id,
                cpr_check: cpr_check
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log('Success:', response);
                
                $('.cpr_status-'+load_id).text(cpr_check);
                $('#mc-success-message').text(response.message).fadeIn();

                // Hide after 10 seconds
                setTimeout(function() {
                    $('#mc-success-message').text('').fadeOut();
                }, 1000); // 10000ms = 10s
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                $('#mc-error-message').text(error).fadeIn();

                // Hide after 10 seconds
                setTimeout(function() {
                    $('#mc-error-message').text('').fadeOut();
                }, 1000); 
            }
        });
    });
});


 $(document).ready(function() {
    $(document).on('change', '.macro', function(e){
        var load_id = $(this).data('load-id');
        var macro = $(this).val();

        $.ajax({
            url: '/macro',
            method: 'POST',
            data: {
                load_id: load_id,
                macro: macro
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log('Success:', response);

                $('#mc-success-message').text(response.message).fadeIn();

                // Hide after 10 seconds
                setTimeout(function() {
                    $('#mc-success-message').text('').fadeOut();
                }, 1000); // 10000ms = 10s
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                $('#mc-error-message').text(error).fadeIn();

                // Hide after 10 seconds
                setTimeout(function() {
                    $('#mc-error-message').text('').fadeOut();
                }, 1000); 
            }
        });
    });
});


$(document).ready(function() {
    $(document).on('change', '.no_of_macro', function(e){
        var load_id = $(this).data('load-id');
        var no_of_macro = $(this).val();

        $.ajax({
            url: '/no_of_macro',
            method: 'POST',
            data: {
                load_id: load_id,
                no_of_macro: no_of_macro
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log('Success:', response);

                $('#mc-success-message').text(response.message).fadeIn();

                // Hide after 10 seconds
                setTimeout(function() {
                    $('#mc-success-message').text('').fadeOut();
                }, 1000); // 10000ms = 10s
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                $('#mc-error-message').text(error).fadeIn();

                // Hide after 10 seconds
                setTimeout(function() {
                    $('#mc-error-message').text('').fadeOut();
                }, 1000); 
            }
        });
    });
});



</script>