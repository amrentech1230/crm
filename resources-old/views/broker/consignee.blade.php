@extends('layout.compact.app') <!-- This links to the app.blade.php layout -->

@section('content')
   
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Consignee</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">CCI</a></li>
                            <li class="breadcrumb-item active">Consignee</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
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

        <div class="row">
            <div class="col-12">
                <div class="card">
                    
                    <div class="card-body">

                        <h4 class="card-title">Consignee</h4>
                        
                        <div class="my-4">
                            <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl">+ Add Consignee</button>
                        </div>

                        <table id="datatable" class="table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th>Action</th>
                                <th>Consignee Name</th>
                                <th>Address</th>
                                <th>Phone No.</th>
                                <th>Added At</th>
                                <th>Agent</th>
                                <th>Team Leader</th>
                                <th>Manager</th>
                            </tr>
                            </thead>


                            <tbody>
                                @include('broker.partials.consignee_table')                           
                            </tbody>
                        </table>
                        <div class="custom-pagination">
                            {{ $consignees->links() }}
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
</div>
                <!-- End Page-content -->



    <!--  Modal content for the above example -->
    <div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Add Consignee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form method="POST" action="{{ route('consignee.store') }}" id="myForm">
                    @csrf
                    <div class="card-body text-left">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label>Name <code>*</code></label>
                                    <input class="form-control" name="consignee_name" required="" style="width: 100%;" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label>Address <code>*</code></label>
                                    <input class="form-control" name="consignee_address" required="" style="width: 100%;" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label>Country <code>*</code></label>
                                    <div>
                                        <select class="form-control select2" required="" name="consignee_country" id="country">
                                            <option value="">Choose Country</option>
                                            <option value="233 United States" data-name="United States"> United States</option>
                                            <option value="39 Canada" data-name="Canada"> Canada</option>
                                            <option value="1 Afghanistan" data-name="Afghanistan"> Afghanistan</option>
                                            
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label>State <code>*</code></label>
                                    <div>
                                        <select class="form-control select2" required="" name="consignee_state" id="state" disabled="">
                                            <option selected="selected">Please Select </option>
                                            <option>'Adan</option>
                                            <option>'Amran</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label>City <code>*</code></label>
                                    <input class="form-control" required="" name="consignee_city" style="width: 100%;" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label>Zip <code>*</code></label>
                                    <input type="text" class="form-control" required="" name="consignee_zip" style="width: 100%;" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label>Major Intersections</label>
                                    <input class="form-control" name="consignee_major_intersections" style="width: 100%;" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label>Status <code>*</code></label>
                                    <select class="form-control" required="" name="consignee_status" style="width: 100%; height: 35px; padding: 1px;">
                                        <option value="" selected="" disabled="">Select Status</option>
                                        <option value="Active">Active</option>
                                        <option value="In-Active">In-Active</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group mb-3">
                                    <label>POC Name</label>
                                    <input class="form-control" name="consignee_contact_name" style="width: 100%;" />
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group mb-3">
                                    <label>Contact Email</label>
                                    <input class="form-control" name="consignee_contact_email" style="width: 100%;" />
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group mb-3">
                                    <label>Telephone<code>*</code></label>
                                    <input type="number" class="form-control" required="" name="consignee_telephone" style="width: 100%;" />
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group mb-3">
                                    <label>Ext. </label>
                                    <input class="form-control" name="consignee_ext" style="width: 100%;" />
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group mb-3">
                                    <label>Toll Free</label>
                                    <input class="form-control" name="consignee_toll_free" style="width: 100%;" />
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group mb-3">
                                    <label>Fax</label>
                                    <input class="form-control" name="consignee_fax" style="width: 100%;" />
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group mb-3">
                                    <label>Consignee Hours</label>
                                    <input type="time" class="form-control" name="consignee_hours" style="width: 100%;" />
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group mb-3">
                                    <label>Appointments</label>
                                    <select class="form-control select2" name="consignee_appointments" style="width: 100%;">
                                        <option selected="selected">Please Select </option>
                                        <option>No</option>
                                        <option>Yes</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                            <div class="col-md-4 col-sm-6">
                                <div class="col-12 col-sm-3">
                                    <div class="form-group mb-3 d-flex align-items-center">
                                        <label class="one-line-label mr-2" style="white-space: nowrap;">Add as Shipper</label>
                                        <input class="form-check-input" type="checkbox" name="consignee_add_shippper" id="consignee_add_shippper" style="margin-left: -15px; width: 15%; height: 30px; margin-top: 0;" value="1" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group mb-31">
                                    <label>Internal Notes </label>
                                    <textarea class="form-control" name="consignee_internal_notes" style="width: 100%; height: 61px;"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group mb-31">
                                    <label>Shipping Notes </label>
                                    <textarea class="form-control" name="consignee_shipping_notes" style="width: 100%; height: 61px;"></textarea>
                                </div>
                            </div>
                        </div>
                        <input type="text" name="added_by_user" value="Noah Weiss" readonly="" hidden="" />
                    </div>
                    <div class="modal-footer mt-4">
                        <input type="submit" class="btn btn-info" value="Save" onclick="saveFormData()" />
                        <input type="button" style="font-size: 14px !important;" class="btn btn-warning" id="clearFormButton" value="Clear Form" />
                        <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel" />
                    </div>
                    </form>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


@endsection