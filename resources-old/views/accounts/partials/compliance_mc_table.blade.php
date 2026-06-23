@foreach($carriers as $carrier)
<tr>
    <td>{{$carrier->carrier_mc_ff_input}}</td>
    <td>{{$carrier->carrier_dot}}</td>
    <td>{{$carrier->carrier_name}}</td>
    <td>{{$carrier->user->name}}</td>
    <td>{{$carrier->created_at}}</td>
     <td>
        <select name="mc_check" id="mc_check-{{ $carrier->id }}" class="form-control mc_check" data-carrier-id="{{ $carrier->id }}" width="100%">
            <option value="">Please Select MC</option>
            <option value="Approved" {{ $carrier->mc_check == 'Approved' ? 'selected' : '' }}>Approved</option>
            <option value="Not Approved" {{ $carrier->mc_check == 'Not Approved' ? 'selected' : '' }}>Not Approved</option>
        </select>
    </td>
    <td class="status-{{ $carrier->id }}">{{$carrier->mc_check}}</td>
</tr>
@endforeach 

<script>
$('.mc_check').on('change', function(){
    var carrier_id = $(this).data('carrier-id');
    var mc_check = $(this).val();

    $.ajax({
        url: '/mc-chcek', // Change this to your actual endpoint
        method: 'POST',
        data: {
            carrier_id: carrier_id,
            mc_check: mc_check
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // If using Laravel or CSRF
        },
        success: function (response) {
            console.log('Success:', response);
            $('.status-'+carrier_id).text(mc_check);
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
</script>




