@extends('layout.compact.app')

@section('content')

<div id="mc-success-message" style="display:none;"></div>
<div id="mc-error-message" style="display:none;"></div>

<div class="page-content">
    <div class="container-fluid">

        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Raise Ticket</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">CCI</li>
                        <li class="breadcrumb-item active">Ticket</li>
                    </ol>
                </div>
            </div>
        </div>

        @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body">

                <h4 class="card-title mb-3">Ticket Dashboard</h4>

                <!-- Tabs -->
                <ul class="nav nav-tabs nav-tabs-custom nav-justified">

                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#open">Open</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#delivered">Hold</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#complete">Completed</a>
                    </li>
                </ul>

                <div class="tab-content pt-3">

                    <!-- ALL TAB -->


                    <!-- OPEN TAB -->
                    <div class="tab-pane fade show active" id="open">
                        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addLoadModal">
                            + Add Ticket
                        </button>

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>

                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Issue</th>
                                    <th>Description</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody id="open_search">
                                @foreach($tickets_open as $ticket)
                                <tr>

                                    <td>{{ $ticket->name }}</td>
                                    <td>{{ $ticket->email }}</td>
                                    <td>{{ $ticket->issues }}</td>
                                    <td>{{ $ticket->description }}</td>
                                    <td><textarea cols="50" rows="3" readonly>{{ $ticket->remark }}</textarea></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- HOLD TAB -->
                    <div class="tab-pane fade" id="delivered">
                        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addLoadModal">
                            + Add Ticket
                        </button>

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Issue</th>
                                    <th>Description</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody id="delivered_search">
                                @foreach($tickets_hold as $ticket)
                                <tr>

                                    <td>{{ $ticket->name }}</td>
                                    <td>{{ $ticket->email }}</td>
                                    <td>{{ $ticket->issues }}</td>
                                    <td>{{ $ticket->description }}</td>
                                    <td><textarea cols="50" rows="3" readonly>{{ $ticket->remark }}</textarea></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- COMPLETE TAB -->
                    <div class="tab-pane fade" id="complete">
                        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addLoadModal">
                            + Add Ticket
                        </button>

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Issue</th>
                                    <th>Description</th>
                                    <th>Remarks</th>

                                </tr>
                            </thead>
                            <tbody id="complete_search">
                                @foreach($tickets_completed as $ticket)
                                <tr>

                                    <td>{{ $ticket->name }}</td>
                                    <td>{{ $ticket->email }}</td>
                                    <td>{{ $ticket->issues }}</td>
                                    <td>{{ $ticket->description }}</td>
                                    <td><textarea cols="50" rows="3" readonly>{{ $ticket->remark }}</textarea></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<!-- COMPACT Add Ticket MODAL -->
<div class="modal fade" id="addLoadModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <form method="POST" action="{{ route('broker.raise.ticket') }}">
                @csrf

                <div class="modal-header py-2">
                    <h5 class="modal-title">Add Issue / Hardware Ticket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body py-3">
                    <div class="row">

                        <div class="col-md-6 mb-2">
                            <label>Agent Name</label>
                            <input type="text" name="name" class="form-control form-control-sm"
                                value="{{ Auth::user()->name }}" readonly>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Agent Email</label>
                            <input type="email" name="email" class="form-control form-control-sm"
                                value="{{ Auth::user()->email }}" readonly>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Issue</label>
                            <input type="text" name="issues" class="form-control form-control-sm"
                                placeholder="Enter issue title" required>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Status</label>
                            <input type="text" name="status" class="form-control form-control-sm" value="Open" readonly>
                        </div>

                        <div class="col-12 mt-2">
                            <label>Description</label>
                            <textarea name="description" rows="3" class="form-control form-control-sm"
                                placeholder="Write issue description..." required></textarea>
                        </div>

                    </div>
                </div>

                <div class="modal-footer py-2">
                    <button type="submit" class="btn btn-success btn-sm">Save</button>
                    <button type="reset" class="btn btn-warning btn-sm">Clear</button>
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Cancel</button>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var modal = document.getElementById('addLoadModal');
        modal.addEventListener('shown.bs.modal', function () {
            document.querySelector('input[name="issues"]').focus();
        });
    });
</script>

@endsection