@extends('layout.compact.app')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Customer</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">CCI</a></li>
                            <li class="breadcrumb-item active">Customer</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
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

        <!-- Country Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">State</h4>

                        <div class="my-4">
                            <button type="button" class="btn btn-primary waves-effect waves-light"
                                data-bs-toggle="modal" data-bs-target="#stateModal" id="addStateBtn">+ Add
                                State</button>
                        </div>

                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                            style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>State Name</th>
                                    <th>Country</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($states as $state)
                                <tr>
                                    <td>{{ $state->name }}</td>
                                    <td>{{ $state->country->name }}</td> <!-- Display associated country name -->
                                    <td>
                                        <button type="button"
                                            class="btn btn-primary waves-effect waves-light edit-state-btn"
                                            data-bs-toggle="modal" data-bs-target="#stateModal"
                                            data-id="{{ $state->id }}" data-name="{{ $state->name }}"
                                            data-country="{{ $state->country_id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <form action="{{ route('state.delete', $state->id) }}" method="POST"
                                            style="display:inline-block;"
                                            onsubmit="return confirm('Are you sure you want to delete this state?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
						<div class="custom-pagination"> 
							{{$states->links('pagination::bootstrap-5')}}
						</div>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- container-fluid -->
</div> <!-- End Page-content -->

<!-- Modal for Add/Edit State -->
<div id="stateModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="stateModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="stateForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="state-method" value="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="stateModalLabel">Add/Edit Country</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="state-name">State Name</label>
                        <input type="text" class="form-control" id="state-name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="state-country">Select Country</label>
                        <select class="form-control" name="country_id" id="state-country" required>
                            <option value="">-- Select Country --</option>
                            @foreach($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="state-submit-btn" class="btn btn-primary">Create Country</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script to Handle Modal Logic -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    // Handle "Add" Button
    const addBtn = document.getElementById('addStateBtn');
    if (addBtn) {
        addBtn.addEventListener('click', function () {
            const form = document.getElementById('stateForm');
            form.action = "{{ route('state.create') }}";
            document.getElementById('state-method').value = "POST";
            document.getElementById('state-name').value = '';
            document.getElementById('state-country').value = '';
            document.getElementById('state-submit-btn').textContent = 'Create State';
        });
    }

    // Handle "Edit" Buttons
    document.querySelectorAll('.edit-state-btn').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.dataset.id;
            const name = this.dataset.name;
            const country = this.dataset.country;

            const form = document.getElementById('stateForm');
            form.action = `/state-update/${id}`;
            document.getElementById('state-method').value = "PUT";
            document.getElementById('state-name').value = name;
            document.getElementById('state-country').value = country;
            document.getElementById('state-submit-btn').textContent = 'Update State';
        });
    });

});

</script>

@endsection
