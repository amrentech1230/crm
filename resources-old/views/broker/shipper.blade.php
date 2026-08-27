@extends('layout.compact.app')
<!-- This links to the app.blade.php layout -->

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Shipper</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">CCI</a></li>
                            <li class="breadcrumb-item active">Shipper</li>
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

                        <h4 class="card-title">Shipper</h4>

                        <div class="my-4">
                            <button type="button" class="btn btn-primary waves-effect waves-light"
                                data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl">+ Add Shipper</button>
                        </div>

                        <table id="datatable"
                            class="table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Shipper Name</th>
                                    <th>Address</th>
                                    <th>Phone No.</th>
                                    <th>Added Date</th>
                                    <th>Agent</th>
                                    <th>Team Leader</th>
                                    <th>Manager</th>
                                </tr>
                            </thead>


                            <tbody>
                                @include('broker.partials.shipper_table')
                            </tbody>
                        </table>
                        <div class="custom-pagination">
                            {{ $shipper->links() }}
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>
    <!-- End Page-content -->



    <!--  Modal content for the above example -->
    <div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Add Shipper</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('shipper.insert') }}" id="myForm">
                        @csrf
                        <div class="card-body text-left">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Name <code>*</code></label>
                                        <input type="text" class="form-control" name="shipper_name" required="" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Address<code>*</code></label>
                                        <input type="text" class="form-control" required="" name="shipper_address" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Country <code>*</code></label>
                                        <div>
                                            <select class="form-control select2" required="" name="customer_country"
                                                id="country">
                                                <option value="">Choose Country</option>

                                                <option value="233 United States">United States </option>

                                                <option value="247 Zimbabwe">Zimbabwe </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>State <code>*</code></label>
                                        <div>
                                            <select class="form-control select2" required="" name="customer_state"
                                                id="state" disabled="">
                                                <option selected="selected" class="hiddenOption">Please Select </option>
                                                <option value="1|Southern Nations, Nationalities, and Peoples' Region">
                                                    Southern Nations, Nationalities, and Peoples' Region
                                                </option>
                                                <option value="2|Somali Region"> Somali Region</option>
                                                <option value="5227|Loyalty Islands Province"> Loyalty Islands Province
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>City <code>*</code></label>
                                        <input type="text" class="form-control select2" required="" name="customer_city"
                                            id="customer_city" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Zip <code>*</code></label>
                                        <input type="text" class="form-control select2" required="" name="customer_zip"
                                            id="customer_zip" />
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group mb-3">
                                        <label>POC Name</label>
                                        <input type="text" class="form-control" name="shipper_contact_name" />
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group mb-3">
                                        <label>Contact Email</label>
                                        <input type="email" class="form-control" name="shipper_contact_email" />
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group mb-3">
                                        <label>Telephone <code>*</code></label>
                                        <input type="number" class="form-control" required=""
                                            name="shipper_telephone" />
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group mb-3">
                                        <label>Ext. </label>
                                        <input type="text" class="form-control" name="shipper_extn" />
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group mb-3">
                                        <label>Fax</label>
                                        <input type="text" class="form-control" name="shipper_fax" />
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group mb-3">
                                        <label>Appointments</label>
                                        <select class="form-control select2" name="shipper_appointments">
                                            <option selected="selected">Select</option>
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group mb-3">
                                        <label>Status <code>*</code></label>
                                        <select class="form-control select2" name="shipper_status" required="">
                                            <option value="" selected="" disabled="">Select</option>
                                            <option value="Active">Active</option>
                                            <option value="In-Active">In-Active</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group mb-3 d-flex align-items-center">
                                        <label class="one-line-label mr-2">Add as consignee</label>

                                        <input class="form-check-input" type="checkbox" name="same_as_consignee"
                                            id="same_as_consignee" style="margin-top: 0;" value="1" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group mb-3">
                                        <label>Shipping Notes </label>
                                        <textarea class="form-control" name="shipper_shipping_notes"
                                            style="width: 100%; height: 100px !important;"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group mb-3">
                                        <label>Internal Notes </label>
                                        <textarea class="form-control" name="shipper_internal_notes"
                                            style="width: 100%; height: 100px !important;"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer mt-4">
                                <input type="submit" class="btn btn-info" value="Save" />
                                <input type="button" class="btn btn-warning" id="clearFormButton" value="Clear Form" />
                                <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel" />
                            </div>
                        </div>
                    </form>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    @endsection
