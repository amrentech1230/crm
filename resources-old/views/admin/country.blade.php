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
                            <li class="breadcrumb-item active">Customer </li>
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

                        <h4 class="card-title">Country</h4>

                        <div class="my-4">
                            <button type="button" class="btn btn-primary waves-effect waves-light"
                                data-bs-toggle="modal" data-bs-target="#myModal">+ Add Country</button>
                        </div>

                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Country Name</th>
                                    <th>Flag</th>
                                    <th>Action</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach($country as $c)
                                <tr>
                                    <td>{{ $c->name }}</td>
                                    @php
                                    if (!function_exists('renderEmojiFlag')) {
                                    function renderEmojiFlag($unicodeString) {
                                    $hexCodes = explode(' ', str_replace('U+', '', $unicodeString));
                                    $emoji = '';
                                    foreach ($hexCodes as $hex) {
                                    $emoji .= mb_convert_encoding('&#x' . $hex . ';', 'UTF-8', 'HTML-ENTITIES');
                                    }
                                    return $emoji;
                                    }
                                    }
                                    @endphp



                                    <td>{{ renderEmojiFlag($c->flag) }}</td>


                                    <td>
                                        <span type="button" class="btn btn-primary waves-effect waves-light"
                                            data-bs-toggle="modal" data-bs-target="#myModal" data-id="{{ $c->id }}"
                                            data-name="{{ $c->name }}" data-flag="{{ $c->flag }}">
                                            <i class="fas fa-edit"></i>
                                        </span>

                                        <!-- Delete Button -->
                                        <form action="{{ route('country.delete', $c->id) }}" method="POST"
                                            style="display:inline-block;"
                                            onsubmit="return confirm('Are you sure you want to delete this country?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>


                                </tr>
                                @endforeach

                                <!-- sample modal content -->
                                <div id="" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="myModalLabel">Edit Country</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                            </div>

                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->

                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->



    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

<!-- sample modal content -->
<!-- Modal for Create or Update Country -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Country</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="countryForm" class="row" method="POST">
                    @csrf
                    <input type="hidden" id="method-field" name="_method" value="POST">

                    <div class="col-12 mb-4">
                        <label class="form-label" for="country_name">Country Name <code>*</code></label>
                        <input type="text" id="country_name" name="country_name" class="form-control"
                            placeholder="Country Name" required>
                    </div>

                    <div class="col-12 mb-4">
                        <label class="form-label" for="flag">Flag <code>*</code></label>
                        <input type="text" id="flag" name="flag" class="form-control" placeholder="Emoji Code"
                            required>
                    </div>

                    <div class="col-12 text-center">
                        <button type="submit" id="submit-button" class="btn btn-primary">Create Country</button>
                    </div>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- /.modal -->
<script>
    // When "Add Country" is clicked
    document.querySelector('[data-bs-target="#myModal"]').addEventListener('click', function () {
        const form = document.getElementById('countryForm');
        form.action = "{{ route('country.create') }}";
        document.getElementById('method-field').value = 'POST';
        form.reset();
        document.getElementById('submit-button').textContent = 'Create Country';
    });

    // When "Edit" button is clicked
    document.querySelectorAll('[data-bs-target="#myModal"][data-id]').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const flag = this.getAttribute('data-flag');

            const form = document.getElementById('countryForm');
            form.action = `/country-update/${id}`; // Use URL directly
            document.getElementById('method-field').value = 'PUT';

            document.getElementById('country_name').value = name;
            document.getElementById('flag').value = flag;
            document.getElementById('submit-button').textContent = 'Update Country';
        });
    });
</script>




@endsection
