@extends('layout.compact.app')

@section('content')

<div class="page-content">
    <div class="container-fluid">
        @if(session('error'))
        <div class="alert alert-danger" id="error-alert">
            {{ session('error') }}
        </div>
        @endif

        @if(session('success'))
        <div class="alert alert-success" id="success-alert">
            {{ session('success') }}
        </div>
        @endif
        <!-- Page Title -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-0">User Profile</h4>
                    <!-- <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="#">CCI</a></li>
                            <li class="breadcrumb-item active">Broker Users</li>
                        </ol>
                    </div> -->
                </div>
            </div>
        </div>

        <!-- Profile Card -->
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow border-0">
                    <div class="card-header bg-primary text-white text-center py-4">
                        <h4 class="mb-0">User Profile Details</h4>
                    </div>
                    <div class="card-body p-4">

                        <div class="row align-items-center">
                            <!-- Profile Image -->
                            <div class="col-md-4 text-center mb-4">
                                <form id="profilePicForm" enctype="multipart/form-data">
                                    @csrf
                                    <label for="profile_picture">
                                        <img id="previewImage"
                                            src="{{ asset('public/'.Auth::user()->profile_picture ?? 'default.jpg') }}"
                                            alt="Profile Picture"
                                            class="rounded-circle img-thumbnail"
                                            style="width: 150px; height: 150px; object-fit: cover; cursor: pointer;">
                                        <div class="mt-2 text-primary">Change Picture</div>
                                    </label>
                                    <input type="file" name="profile_picture" id="profile_picture" class="d-none">
                                </form>




                                <h5 class="mt-3">{{ Auth::user()->name }}</h5>
                                <p class="text-muted">Employee Code: <strong>{{ Auth::user()->emp_code }}</strong></p>
                                <span class="badge {{ Auth::user()->status ? 'bg-success' : 'bg-secondary' }}">
                                    {{ Auth::user()->status ? 'Active' : 'Inactive' }}
                                </span>

                                <div class="text-center mt-4">
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                        Change Password
                                    </button>
                                </div>
                            </div>


                            <!-- Profile Info -->
                            <div class="col-md-8">
                                <div class="row mb-2">
                                    <div class="col-sm-6">
                                        <p><strong>Email:</strong> {{ $user->email }}
                                            @if($user->email_verified_at)
                                            <span class="badge bg-success ms-1">Verified</span>
                                            @else
                                            <span class="badge bg-danger ms-1">Unverified</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-sm-6">
                                    <p><strong>Role:</strong> {{ $profile->role_name ?? 'N/A' }}</p>

                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-sm-6">
                                        <p><strong>Department:</strong> {{ $profile->department_name ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p><strong>Office:</strong> {{ $profile->office_name ?? 'N/A' }}</p>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-sm-6">
                                        <p><strong>Address:</strong> {{ $user->address }}</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p><strong>Manager:</strong> {{ $profile->manager_name ?? 'N/A' }}</p>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-sm-6">
                                        <p><strong>Team Lead:</strong> {{ $profile->leader_name ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p><strong>Emergency Contact:</strong> {{ $user->emergency_contact }}</p>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-sm-6">
                                        <p><strong>Logged In:</strong>
                                            <span class="badge {{ $user->is_logged_in ? 'bg-success' : 'bg-warning' }}">
                                                {{ $user->is_logged_in ? 'Yes' : 'No' }}
                                            </span>
                                        </p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p><strong>Created At:</strong> {{ optional($user->created_at)->format('d M Y, h:i A') }}</p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-6">
                                        <p><strong>Bio:</strong> {{ $user->bio }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- end profile info -->
                        </div> <!-- end row -->

                    </div>
                </div>
            </div>
        </div>

    </div> <!-- container-fluid -->
</div>
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('change_password.auth') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Current Password -->
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>

                    <!-- New Password -->
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Change Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('profile_picture').addEventListener('change', function() {
        const form = document.getElementById('profilePicForm');
        const formData = new FormData(form);

        // Preview image instantly
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImage').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }

        // Send AJAX request
        fetch("{{ route('update_profile') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // Reload the page to reflect changes
                } else {
                    alert("Failed to update profile picture.");
                }
            })
            .catch(error => {
                alert("Something went wrong!");
                console.error(error);
            });
    });
</script>
@endsection