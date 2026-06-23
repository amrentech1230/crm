@extends('layout.compact.app')
<!-- This links to the app.blade.php layout -->

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
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">carrier</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">CCI</a></li>
                            <li class="breadcrumb-item active">carrier</li>
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

                        <h4 class="card-title">carrier</h4>

                        <div class="my-4">
                            <button type="button" class="btn btn-primary waves-effect waves-light"
                                data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl">+ Add carrier</button>
                        </div>

                        <table id="datatable"
                            class="table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Carrier Name</th>
                                    <th>MC No./FF No.</th>
                                    <th>DOT</th>
                                    <th>Address</th>
                                    <th>Phone No.</th>
                                    <th>Date Added</th>
                                    <th>Agent</th>
                                    <th>Team Leader</th>
                                    <th>Manager</th>
                                    <th>Carrier Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @include('broker.partials.carrier_table')
                            </tbody>
                        </table>
                        <div class="custom-pagination">
                            {{ $carriers->links() }}
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
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Add carrier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('carrier.create') }}" id="myForm"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card-body text-left">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Carrier Name <code>*</code></label>
                                        <input class="form-control select2" required="" name="carrier_name"
                                            style="width: 100%; ">

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label class="mr-2">M.C. #/F.F.#
                                            <code>*</code></label>
                                        <div class="d-flex" style="width: 100%;">
                                            <select class="form-control select2 mr-2" required="" name="carrier_mc_ff"
                                                style="width: 35% !important;height:35px ">
                                                <option selected="selected" value="FF">
                                                    FF
                                                </option>
                                                <option selected="MC">MC</option>
                                            </select>
                                            <input type="text" class="form-control select2" required=""
                                                name="carrier_mc_ff_input" id="carrier_mc_ff_input"
                                                style="width: 65%; ">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mb-3">
                                        <label>D.O.T</label>
                                        <input class="form-control" name="carrier_dot" style="width: 100%; ">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label>Address<code>*</code></label>
                                        <input class="form-control" required="" name="carrier_address_two"
                                            style="width: 100%;  ">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Country<code>*</code></label>
                                        <select required="" class="form-control select2" name="carrier_country"
                                            id="country">
                                            <option value="">Choose Country</option>
                                            <option value="233 United States">
                                                United States
                                            </option>
                                            <option value="39 Canada">
                                                Canada
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>State<code>*</code></label>
                                        <div>
                                            <select class="form-control select2" name="carrier_state" id="state"
                                                required="" disabled="">
                                                <option selected="selected">Please Select
                                                </option>
                                                <option>
                                                    Southern Nations, Nationalities, and Peoples' Region
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>City<code>*</code></label>
                                        <input class="form-control" name="carrier_city" required=""
                                            style="width: 100%;  ">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Zip<code>*</code></label>
                                        <input class="form-control" type="text" name="carrier_zip" required=""
                                            id="carrier_zip" style="width: 100%;  ">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>POC Name</label>
                                        <input class="form-control" name="carrier_contact_name" style="width: 100%; ">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Email</label>
                                        <input class="form-control" name="carrier_email" style="width: 100%; ">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Phone No<code>*</code></label>
                                        <input type="number" class="form-control" name="carrier_telephone" required=""
                                            id="carrier_telephone" style="width: 100%; ">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Extn. </label>
                                        <input class="form-control" name="carrier_extn" style="width: 100%; ">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Fax</label>
                                        <input class="form-control" name="carrier_fax" style="width: 100%; ">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Status <code>*</code></label>
                                        <div class="select2-purple">
                                            <select class="form-control select2" name="carrier_status"
                                                style="width: 100%;" required="">
                                                <option value="" selected="" disabled="">Select</option>
                                                <option value="Active" style="font-family: 'Poppins', sans-serif;">
                                                    Active</option>
                                                <option value="In-Active" style="font-family: 'Poppins', sans-serif;">
                                                    In-Active</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Payment Terms </label>
                                        <div class="select2-purple">
                                            <select class="form-control select2" name="carrier_payment_terms"
                                                style="width: 100%;  ">
                                                <option selected="selected">Select
                                                    Payment
                                                </option>
                                                <option style="font-family: 'Poppins', sans-serif;">
                                                    Prepaid
                                                </option>
                                                <option style="font-family: 'Poppins', sans-serif;">
                                                    Postpaid
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Factoring Company </label>
                                        <input class="form-control" name="carrier_factoring_company"
                                            style="width: 100%; ">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label style="margin-bottom: 0; font-weight: 600;color: #4a4a4a;">Notes</label>
                                        <textarea class="form-control" name="carrier_notes"
                                            style="width: 100%; height: 70px !important"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label style="margin-bottom: 0; font-weight: 600;color: #4a4a4a;">File
                                            Upload</label>
                                        <input type="file" class="form-control" name="carrier_file_upload[]"
                                            id="carrier_file_upload" multiple=""
                                            style="width: 100%; height: 70px !important">
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 mb-4 text-center">
                                <input type="submit" class="btn btn-info" value="Save" style="padding: 8px 40px;">
                                <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel"
                                    style="font-size: 15px;padding: 8px 40px;">
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <script>
        const modal = new bootstrap.Modal(document.getElementById('carrierModal'))

        // Open modal for edit
        document.querySelectorAll('.editCarrierBtn').forEach(btn => {
            btn.addEventListener('click', () => {
                let id = btn.dataset.id;

                fetch(`/carrier/${id}/edit`)
                    .then(res => res.json())
                    .then(json => {
                        document.getElementById('carrierForm').action = `/carrier/${id}`;
                        document.getElementById('carrierMethod').value = 'PUT';
                        document.getElementById('carrierModalTitle').textContent = 'Edit Carrier';
                        document.getElementById('carrierSubmit').textContent = 'Update Carrier';

                        document.getElementById('carrier_name').value = json.carrier_name;
                        document.getElementById('carrier_mc_ff').value = json.carrier_mc_ff;
                        document.getElementById('carrier_mc_ff_input').value = json
                            .carrier_mc_ff_input;
                        // populate other fields if present...

                        modal.show();
                    })
                    .catch(console.error);
            });
        });

    </script>


    @endsection
