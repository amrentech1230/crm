@php
$i = 1;
@endphp
@foreach($brokers as $getbroker)
<tr>
    <td class="dynamic-data">{{ $i++ }}</td>
    <td>
        <label class="switch">
            <input class="switch-input statusCheckbox" type="checkbox" data-id="{{$getbroker->id}}"
                @if($getbroker->status == 'active') checked @endif>
            <span class="switch-button"></span>
        </label>
    </td>
    <td class="dynamic-data">{{ $getbroker->name }}</td>
    <td class="dynamic-data">
        <span onclick="copyEmail(this)" style="cursor:pointer;">
            {{ $getbroker->email }}
            <i class="fa fa-copy" style="margin-left:5px;"></i>
        </span>
    </td>
    <td class="dynamic-data">{{ $getbroker->managers?->manager }}</td>
    <td class="dynamic-data">{{ $getbroker->teamleader?->tl }}</td>
    <td class="dynamic-data">{{ $getbroker->role?->name }}</td>
    <td class="dynamic-data" style="text-align: center;">
        <!-- <a data-toggle="modal" style="margin-right:7px;" data-target="#editAccountModal" data-id="{{ $getbroker->id }}" class="editAccount"><i class="fa fa-edit" style="color:#0DCAF0;font-size: 17px;margin-left: 13px;cursor: pointer;"></i></a> -->
        <button class="btn update-password-btn" data-bs-toggle="modal"
            data-bs-target="#updatePasswordModal{{ $getbroker->id }}" title="Change Password"
            data-id="{{ $getbroker->id }}" data-name="{{ $getbroker->name }}"><i class="fa fa-lock"
                style="color: #ff9d20;"></i></button>
        <a href="{{route('delete_user',$getbroker->id)}}" class="deleteAccount" data-id="{{ $getbroker->id }}"><i
                class="fa fa-trash" style="color:red;font-size: 17px;cursor: pointer;"></i></a>
        <button class="btn editAccountBtn" data-bs-toggle="modal" data-bs-target="#editAccountModal{{ $getbroker->id }}"
            data-id="{{ $getbroker->id }}" data-name="{{ $getbroker->name }}" data-email="{{ $getbroker->email }}"
            data-role="{{ $getbroker->role }}">
            <i class="fa fa-edit" style="color:#0DCAF0;font-size: 17px;cursor: pointer;"></i>
        </button>
    </td>
</tr>

<div class="modal fade" id="updatePasswordModal{{ $getbroker->id }}" tabindex="-1"
    aria-labelledby="updatePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="updatePasswordForm" method="POST" action="{{route('admin_update_password', $getbroker->id)}}">

                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="updatePasswordModalLabel">Update Password</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="accountName" class="form-label">Name</label>
                        <input type="text" class="form-control accountName" value="{{ $getbroker->name }}" readonly>
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
<div class="modal fade" id="editAccountModal{{ $getbroker->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit User: {{ $getbroker->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="{{ route('admin_update_user', $getbroker->id) }}">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <div class="row">
                        <!-- Name -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $getbroker->name }}">
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $getbroker->email }}">
                        </div>

                        <!-- Role -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Role</label>
                            <select name="role_id" class="form-control">
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}"
                                    {{ $getbroker->role_id == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Department -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Department</label>
                            <select name="department" class="form-control">
                                @foreach($departments as $department)
                                <option value="{{ $department->id }}"
                                    {{ old('department', $getbroker->department) == $department->id ? 'selected' : '' }}>
                                    {{ $department->department_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>


                        <!-- Office -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Office</label>
                            <select name="office_id" class="form-control">
                                @foreach($offices as $office)
                                <option value="{{ $office->id }}"
                                    {{ (int) $getbroker->office === (int) $office->id ? 'selected' : '' }}>
                                    {{ $office->office_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>



                        <!-- Manager -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Manager</label>
                            <select name="manager_id" class="form-control">
                                <option value="">Select Manager</option>
                                @foreach($managers as $manager)
                                <option value="{{ $manager->id }}"
                                    {{ $getbroker->manager == $manager->id ? 'selected' : '' }}>
                                    {{ $manager->manager }}
                                </option>
                                @endforeach
                            </select>
                        </div>


                        <!-- Team Leader -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Team Leader</label>
                            <select name="team_lead" class="form-control">
                                @foreach($teamleaders as $teamleader)
                                <option value="{{ $teamleader->id }}"
                                    {{ $getbroker->team_lead == $teamleader->id ? 'selected' : '' }}>
                                    {{ $teamleader->tl }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Login</label>
                            <select name="login_status" class="form-control">
                                <option value="">Please Select</option>
                                <option value="1" {{ $getbroker->is_logged_in == 1 ? 'selected' : '' }}>Login</option>
                                <option value="0" {{ $getbroker->is_logged_in == 0 ? 'selected' : '' }}>Log Out</option>
                            </select>
                        </div>

                        <!-- Address -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" class="form-control" value="{{ $getbroker->address }}">
                        </div>

                        <!-- Emergency Contact -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Emergency Contact</label>
                            <input type="text" name="emergency_contact" class="form-control"
                                value="{{ $getbroker->emergency_contact }}">
                        </div>

                        <!-- Employee Code -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Employee Code</label>
                            <input type="text" name="emp_code" class="form-control" value="{{ $getbroker->emp_code }}">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update User</button>
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
<script>
    function copyEmail(el) {
        var email = el.textContent.trim();
        // Copy to clipboard
        navigator.clipboard.writeText(email);

        // Change icon to check
        var icon = el.querySelector('i');
        icon.classList.remove('fa-copy');
        icon.classList.add('fa-check');

        // Revert back after 1.5 seconds
        setTimeout(function () {
            icon.classList.remove('fa-check');
            icon.classList.add('fa-copy');
        }, 1500);
    }
</script>