@php
$i = 1;
@endphp
@foreach($admins as $getadmin)
<tr>
    <td class="dynamic-data">{{ $i++ }}</td>
    <td>
        <label class="switch">
            <input class="switch-input statusCheckbox" type="checkbox" data-id="{{$getadmin->id}}" @if($getadmin->status
            == 'active') checked @endif>
            <span class="switch-button"></span>
        </label>
    </td>
    <td class="dynamic-data">{{ $getadmin->name }}</td>
    <td class="dynamic-data">{{ $getadmin->email }}</td>
    <td class="dynamic-data">{{ $getadmin->role?->name }}</td>
    <td class="dynamic-data" style="text-align: center;">
        <button class="btn update-password-btn" data-bs-toggle="modal"
            data-bs-target="#updatePasswordModal{{ $getadmin->id }}" title="Change Password"
            data-id="{{ $getadmin->id }}" data-name="{{ $getadmin->name }}"><i class="fa fa-lock"
                style="color: #ff9d20;"></i></button>
        <a href="{{route('delete_user',$getadmin->id)}}" class="deleteAccount" data-id="{{ $getadmin->id }}"><i
                class="fa fa-trash" style="color:red;font-size: 17px;cursor: pointer;"></i></a>
    </td>
</tr>
<div class="modal fade" id="updatePasswordModal{{ $getadmin->id }}" tabindex="-1"
    aria-labelledby="updatePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="updatePasswordForm" method="POST" action="{{route('admin_update_password', $getadmin->id)}}">

                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="updatePasswordModalLabel">Update Password</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="accountName" class="form-label">Name</label>
                        <input type="text" class="form-control accountName" value="{{ $getadmin->name }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" name="password" class="form-control password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control password_confirmation"
                            required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info">Update Password</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach


<script>
    $(document).ready(function () {
        // Attach change event to the checkbox
        $('.statusCheckbox').on('change', function () {
            var status = $(this).prop('checked') ? 'active' : 'inactive'; // Get the new status
            var adminId = $(this).data(
            'id'); // Assuming $getadmin->id is available in the JavaScript context

            // Make the AJAX request to update the status
            $.ajax({
                url: '/admin/update-status', // Replace with your actual route
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // CSRF token for security
                    id: adminId,
                    status: status
                },
                success: function (response) {
                    if (response.success) {
                        $('#mc-success-message').text('user status changed').fadeIn();
                        setTimeout(function () {
                            $('#mc-success-message').text('').fadeOut();
                        }, 1000); // 10000ms = 10s
                    } else {
                        $('#mc-error-message').text('user status not changed').fadeIn();
                        setTimeout(function () {
                            $('#mc-error-message').text('').fadeOut();
                        }, 1000); // 10000ms = 10s
                        // Optionally, revert the checkbox state if something goes wrong
                        $('.statusCheckbox').prop('checked', !$('#statusCheckbox').prop(
                            'checked'));
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX error: ' + error);
                    // Optionally, revert the checkbox state if something goes wrong
                    $('.statusCheckbox').prop('checked', !$('#statusCheckbox').prop(
                        'checked'));
                }
            });
        });
    });
</script>