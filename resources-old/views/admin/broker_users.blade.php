@extends('layout.compact.app') <!-- This links to the app.blade.php layout -->

@section('content')
  <style>
/* Light switch
   ========================================================================== */

.switch {
    display: inline-block;
    margin-bottom: .5rem;
}

.switch-button {
    /* background color when "off" */
    background: #FFFFFF;

    /* size of switch */
    width: 43px;
    height: 25px;
    border: 2px solid #E6E6E6;
    border-radius: 100px;
    display: block;

    cursor: pointer;
    -webkit-user-select: none;
       -moz-user-select: none;
        -ms-user-select: none;
            user-select: none;
    outline: 0;
    -webkit-transition: all .4s ease;
    -o-transition: all .4s ease;
    transition: all .4s ease;
}

/* Style of the "bubble" that toggles */
.switch-button::after {
    /* size of bubble */
    width: 21px;
    height: 21px;
    border-radius: 50%;
    background-color: #FFFFFF;
    position: relative;
    display: block;
    content: "";
    -webkit-transition: tranform .4s cubic-bezier(0.175, 0.885, 0.320, 1.275), 
                padding .3s ease, margin .3s ease;
    -o-transition: tranform .4s cubic-bezier(0.175, 0.885, 0.320, 1.275), 
                padding .3s ease, margin .3s ease;
    transition: tranform .4s cubic-bezier(0.175, 0.885, 0.320, 1.275), 
                padding .3s ease, margin .3s ease;
    -webkit-transform: translateX(0);
        -ms-transform: translateX(0);
            transform: translateX(0);
    -webkit-box-shadow: 0 1px 3px rgba(0,0,0,.4);
            box-shadow: 0 1px 3px rgba(0,0,0,.4);
}

.switch-input {
    display: none;
}

.switch-button:hover::after {
    will-change: padding;
}

.switch-button:active::after {
    padding-right: .4rem;
}

/* "On" state
   ========================== */

.switch-input:checked + .switch-button {
    /* border and background color when the button is "on" */
    border-color: #a6ce3a; 
    background: #a6ce3a;
}

.switch-input:checked + .switch-button::after {
    /* bubble position when "on" */
    -webkit-transform: translateX(18px);
        -ms-transform: translateX(18px);
            transform: translateX(18px);
}

.switch-input:checked + .switch-button:active::after {
    margin-left: -.4rem;
}

/* Checkbox in disabled state
   ========================== */

.switch-input[type="checkbox"]:disabled + .switch-button {
    opacity: .6;
    cursor: not-allowed;
    -webkit-box-shadow: 0 0 0 transparent;
            box-shadow: 0 0 0 transparent;
}

.switch-input[type="checkbox"]:checked:disabled + .switch-button {
    /* border and background color when button is disabled */
    border-color: #cccccc;
    background: #cccccc;
}


#mc-success-message{
    padding: 10px;
    background-color: rgb(212, 237, 218);
    color: rgb(21, 87, 36);
    margin-bottom: 10px;
    border: 1px solid rgb(195, 230, 203);
    border-radius: 4px;
    position: fixed;
    width: 20%;
    right: 10px;
    z-index: 9999;
    top: 10px;
}

#mc-error-message{
    padding: 10px;
    background-color: rgb(212, 237, 218);
    color: rgb(87, 21, 26);
    margin-bottom: 10px;
    border: 1px solid rgb(195, 230, 203);
    border-radius: 4px;
    position: fixed;
    width: 20%;
    right: 10px;
    z-index: 9999;
    top: 10px;
}
</style>

<div id="mc-success-message" style="display: none;"></div>
<div id="mc-error-message" style="display: none;"></div>
  
<div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Broker Users</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">CCI</a></li>
                                            <li class="breadcrumb-item active">Broker Users</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                       
        
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
        
                                        <h4 class="card-title">Broker Users</h4>
                                        
                                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Sr No.</th>
                                                <th>Status</th>
                                                <th>EMP code</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Address</th>
                                                <th>Password</th>
                                                <th>Manager</th>
                                                <th>Team Lead</th>
                                                <th>Role</th>
                                                <th>Emergency Number</th>
                                                <th>Created at</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
         
        
                                            <tbody>
                                            @php
                                                $i = 1;
                                            @endphp
                                                @foreach($brokers as $getbroker)
                                                <tr>
                                                    <td class="dynamic-data">{{ $i++ }}</td>
                                                    <td>
                                                        <label class="switch">
                                                            <input class="switch-input statusCheckbox" type="checkbox" data-id="{{$getbroker->id}}" @if($getbroker->status == 'active') checked @endif>
                                                            <span class="switch-button"></span>
                                                        </label>
                                                    </td>
                                                    <td class="dynamic-data">{{ $getbroker->emp_code }}</td>
                                                    <td class="dynamic-data">{{ $getbroker->name }}</td>
                                                    <td class="dynamic-data">{{ $getbroker->email }}</td>
                                                    <td class="dynamic-data">**********</td> <!-- Hide password -->
                                                    <td class="dynamic-data">{{ $getbroker->address }}</td>
                                                    <td class="dynamic-data">{{ $getbroker->managers?->manager }}</td>
                                                    <td class="dynamic-data">{{ $getbroker->teamleader?->tl }}</td>
                                                    <td class="dynamic-data">{{ $getbroker->role?->name }}</td>
                                                    <td class="dynamic-data">{{ $getbroker->emergency_contact }}</td>
                                                <td class="dynamic-data">{{ $getbroker->created_at ? \Carbon\Carbon::parse($getbroker->created_at)->format('m-d-y') : '' }}</td>
                                                    <td class="dynamic-data" style="text-align: center;">
                                                        <!-- <a data-toggle="modal" style="margin-right:7px;" data-target="#editAccountModal" data-id="{{ $getbroker->id }}" class="editAccount"><i class="fa fa-edit" style="color:#0DCAF0;font-size: 17px;margin-left: 13px;cursor: pointer;"></i></a> -->
                                                        <button class="btn update-password-btn" data-bs-toggle="modal" data-bs-target="#updatePasswordModal" title="Change Password" data-id="{{ $getbroker->id }}" data-name="{{ $getbroker->name }}"><i class="fa fa-lock" style="color: #ff9d20;"></i></button>
                                                        <a href="javascript:void(0);" class="deleteAccount" data-id="{{ $getbroker->id }}"><i class="fa fa-trash" style="color:red;font-size: 17px;cursor: pointer;"></i></a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->



                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->


  
<script>
$(document).ready(function() {
    // Attach change event to the checkbox
    $('.statusCheckbox').on('change', function() {
        var status = $(this).prop('checked') ? 'active' : 'inactive'; // Get the new status
        var adminId = $(this).data('id'); // Assuming $getadmin->id is available in the JavaScript context

        // Make the AJAX request to update the status
        $.ajax({
            url: '/update-status', // Replace with your actual route
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}', // CSRF token for security
                id: adminId,
                status: status
            },
            success: function(response) {
                if(response.success) {
                    $('#mc-success-message').text('user status changed').fadeIn();
                    setTimeout(function() {
                    $('#mc-success-message').text('').fadeOut();
                }, 1000); // 10000ms = 10s
                } else {
                     $('#mc-error-message').text('user status not changed').fadeIn();
                     setTimeout(function() {
                    $('#mc-error-message').text('').fadeOut();
                }, 1000); // 10000ms = 10s
                    // Optionally, revert the checkbox state if something goes wrong
                    $('.statusCheckbox').prop('checked', !$('#statusCheckbox').prop('checked'));
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error: ' + error);
                // Optionally, revert the checkbox state if something goes wrong
                $('.statusCheckbox').prop('checked', !$('#statusCheckbox').prop('checked'));
            }
        });
    });
});
</script>                    
@endsection