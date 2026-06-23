@extends('layout.compact.app')
<!-- This links to the app.blade.php layout -->

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Customer</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">CCI</a></li>
                            <li class="breadcrumb-item active">Customer</li>
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

                        <h4 class="card-title">Customer</h4>

                        <div class="my-4">
                            <button type="button" class="btn btn-primary waves-effect waves-light"
                                data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl">+ Add Customer</button>
                        </div>

                        <table id="datatable"
                            class="table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Actions</th>
                                    <th>Customer Name</th>
                                    <th>Address</th>
                                    <th>Phone No</th>
                                    <th>Added Date</th>
                                    <th>Agent</th>
                                    <th>Team Leader</th>
                                    <th>Mnager</th>
                                    <th>Remaing Credit</th>
                                    <th>Last Load</th>
                                    <th>Approved Status</th>
                                    <th>Comment/Notes</th>
                                </tr>
                            </thead>
                            <tbody id="customer-table-body">
                                @include('broker.partials.customer_table')
                            </tbody>
                        </table>
                        <div class="custom-pagination">
                            {{ $customers->links() }}
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
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Add Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('create.customer') }}" id="myForm" enctype="multipart/form-data">
                        @csrf

                        <div class="card-body text-left">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Customer Name <code>*</code></label>
                                        <input class="form-control select2" type="text" required="" name="customer_name" id="customer_name" />
                                    </div>
                                </div>
                                <input type="text" name="user_id" hidden="" />
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label class="mr-2">
                                            MC# /FF#
                                        </label>
                                        <div class="d-flex" style="width: 100%;">
                                            <select class="form-control select2 mr-2" name="customer_mc_ff"
                                                id="customer_mc_ff">
                                                <option selected="selected" id="mc_ff_code_na">NA</option>
                                                <option>MC</option>
                                                <option>FF</option>
                                            </select>
                                            <input class="form-control select2" name="customer_mc_ff_input"
                                                id="customer_mc_ff_input" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Address <code>*</code></label>
                                        <input type="text" class="form-control select2" required=""
                                            name="customer_address" id="customer_address" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Country <code>*</code></label>
                                        <div>
                                            <select class="form-control select2" required="" name="customer_country"
                                                id="country">
                                                <option value="">Choose Country</option>
                                                <option value="246 Zambia" data-id="Zambia">Zambia</option>
                                                <option value="247 Zimbabwe" data-id="Zimbabwe">Zimbabwe</option>
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
                                                <option value="Please Select" selected="">Please Select</option>

                                                <option value="1242|'Adan"> 'Adan</option>

                                                <option value="1250|'Amran"> 'Amran</option>

                                                <option value="4307|Žužemberk Municipality"> Žužemberk Municipality
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
                                <div class="col-sm-3">
                                    <div class="form-group mb-3 d-flex align-items-center">
                                        <label class="one-line-label">Same as Physical Address</label>
                                        <input class="form-control select2" type="checkbox" name="same_as_physical"
                                            id="same_as_physical" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Billing Address <code>*</code></label>
                                        <input type="text" class="form-control select2" required=""
                                            name="customer_billing_address" id="customer_billing_address" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Billing Country <code>*</code></label>
                                        <input type="text" class="form-control select2" required=""
                                            name="customer_billing_country" id="customer_billing_country" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Billing State <code>*</code></label>
                                        <input type="text" class="form-control select2" required=""
                                            name="customer_billing_state" id="customer_billing_state" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Billing City <code>*</code></label>
                                        <input type="text" class="form-control select2" required=""
                                            name="customer_billing_city" id="customer_billing_city" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Billing Zip <code>*</code></label>
                                        <input type="text" class="form-control select2" required=""
                                            name="customer_billing_zip" id="customer_billing_zip" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>POC Name</label>
                                        <input type="text" class="form-control select2"
                                            name="customer_primary_contact" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Phone No <code>*</code></label>
                                        <input type="number" class="form-control select2" required=""
                                            name="customer_telephone" id="customer_telephone" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Extn. </label>
                                        <input type="text" class="form-control select2" name="customer_extn" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Email <code>*</code></label>
                                        <input type="email" class="form-control select2" required=""
                                            name="customer_email" />
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group mb-3">
                                        <label>Website URL </label>
                                        <input class="form-control select2" name="adv_customer_webiste_url"
                                            id="adv_customer_webiste_url" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Fax</label>
                                        <input type="text" class="form-control select2" name="customer_fax" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Acc Pay Email</label>
                                        <input type="email" class="form-control select2"
                                            name="customer_secondary_email" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>AP Contact</label>
                                        <input type="number" class="form-control select2"
                                            name="customer_billing_telephone" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>AP Extn.</label>
                                        <input type="text" class="form-control select2" name="customer_billing_extn" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3 align-items-center">
                                        <label class="mr-2">Status <code>*</code></label>
                                        <div>
                                            <select class="form-control select2" required="" name="customer_status">
                                                <option value="">
                                                    Please Select
                                                </option>
                                                <option> Active</option>
                                                <option> In-Active</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-header mt-3">
                            <h3 class="card-title head">ADVANCED</h3>
                        </div>
                        <div class="card-body text-left">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Currency Setting </label>
                                        <div class="d-flex">
                                            <select class="form-control select2 mr-2"
                                                name="adv_customer_currency_Setting">
                                                <option value="">Please Select </option>
                                                <option>
                                                    American Dollars
                                                </option>
                                                <option>
                                                    Canadian Dollars
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Payment Terms</label>
                                        <div class="d-flex" style="width: 100%;">
                                            <div class="d-flex" style="width: 100%;">
                                                <select class="form-control select2" name="adv_customer_payment_terms"
                                                    onchange="showInput()">
                                                    <option value="">Please Select</option>
                                                    <option value="Net 30">Net30 </option>
                                                    <option value="Quick Pay 6% 1 Day"> Quick Pay 6% 1 Day</option>
                                                    <option value="Quick Pay 4% 5 Days"> Quick Pay 4% 5 Days</option>
                                                    <option value="Prepay">Prepay </option>
                                                    <option value="Custom" id="custome">
                                                        Custom
                                                    </option>
                                                </select>
                                                <input class="form-control select2"
                                                    name="adv_customer_payment_terms_custome" id="custome_input" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Sales Rep. <code>*</code></label>
                                        <input type="text" class="form-control select2" name="adv_customer_sales_rep"
                                            value="{{ Auth::user()->name }}" readonly="" />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mb-3">
                                        <label class="control-label mb-1 el_min100">Duplicate</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="AddAsShipper"
                                                name="AddAsShipper" />
                                            <label class="form-check-label" for="AddAsShipper"
                                                style="font-size: 10px;">Add as Shipper</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="AddAsConsignee"
                                                name="AddAsConsignee" />
                                            <label class="form-check-label" for="AddAsConsignee"
                                                style="font-size: 10px;">Add as Consignee</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group mb-3 align-items-center">
                                        <label style="line-height: 1.2em;">Internal Notes </label>
                                        <textarea class="select2" type="text" name="adv_customer_internal_notes"
                                            id="adv_customer_internal_notes"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group mb-3">
                                        <label style="line-height: 1.2em;">Upload files</label>
                                        <label for="upload" class="upload-button" style="height: 47px;">
                                            <input type="file" id="upload" multiple="" />
                                            <p class="choose-file" style="font-size: 12px;">Choose the file</p>
                                        </label>
                                        <p>Please upload the file you want to share</p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-info" value="Save" />
                                <input type="button" style="font-size: 14px !important;" class="btn btn-warning"
                                    id="clearFormButton" value="Clear Form" />
                                <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel" />
                            </div>
                        </div>
                    </form>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
<script>
    $(document).ready(function () {
        $('#same_as_physical').on('change', function () {
            if ($(this).is(':checked')) {
                $('#customer_billing_address').val($('#customer_address').val());
                $('#customer_billing_country').val($('#country option:selected').text());
                $('#customer_billing_state').val($('#state option:selected').text());
                $('#customer_billing_city').val($('#customer_city').val());
                $('#customer_billing_zip').val($('#customer_zip').val());
            } else {
                $('#customer_billing_address').val('');
                $('#customer_billing_country').val('');
                $('#customer_billing_state').val('');
                $('#customer_billing_city').val('');
                $('#customer_billing_zip').val('');
            }
        });
    });
</script>


    @endsection
