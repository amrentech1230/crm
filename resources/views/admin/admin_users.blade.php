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
                                    <h4 class="mb-sm-0">Admin Users</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">CCI</a></li>
                                            <li class="breadcrumb-item active">Admin Users</li>
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
        
                                        <h4 class="card-title">Admin Users</h4>
                                        
                                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Sr No.</th>
                                               <th>Status</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Role</th> 
                                                <th>Action</th>
                                            </tr>
                                            </thead>
        
        
                                            <tbody id="admins-data">
                                            @include('admin.users.admins')
                                            </tbody>
                                        </table>
										<div class="custom-pagination"> 
											{{$admins->links('pagination::bootstrap-5')}}
										</div> 
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->



                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

 
<script>
	
$(document).ready(function () {
    // Set ID for the search form wrapper
    $('form.app-search .position-relative').attr('id', 'admins');

    function initializeTab() {
        const inputSelector = 'input[name="query"]';
        const ajaxUrl = "{{route('admins_users_search')}}";
        const resultContainer = '#admins-data';
        const tableSelector = '#datatable-buttons';

        // Set up keyup listener with debounce
        $(inputSelector).on('keyup', function () {
            const query = $(this).val().trim();
            clearTimeout($.data(this, 'timer'));

            const wait = setTimeout(() => {
                if (query.length > 0) {
                   // $('.loader-container').removeClass('hide');

                    $.ajax({
                        url: ajaxUrl,
                        type: 'GET',
                        data: { query: query },
                        success: function (response) {
                            // Destroy existing DataTable if it exists
                            if ($.fn.DataTable.isDataTable(tableSelector)) {
                                $(tableSelector).DataTable().destroy();
                            }

                            // Inject new table rows
                            $(resultContainer).html(response);

                            // Re-initialize DataTable
                            $(tableSelector).DataTable({
                                responsive: true,
                                dom: 'rtip',
                                buttons: [],            // Set to empty array instead of false
                                pageLength: 10,         // Show 50 rows per page
                                lengthMenu: [10, 25, 50, 100] // Dropdown options
                            });

                            $('.loader-container').addClass('hide');
                        },
                        error: function (xhr) {
                            console.error("AJAX error:", xhr.responseText);
                           // $('.loader-container').addClass('hide');
                        }
                    });
                } else {
                    // Clear results if query is empty
                    $(resultContainer).html('');
                }
            }, 300); // 300ms debounce

            $(this).data('timer', wait);
        });
    }

    initializeTab();
});
</script>            
@endsection