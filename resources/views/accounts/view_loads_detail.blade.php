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
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">View Load Logs</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">CCI</a></li>
                            <li class="breadcrumb-item active">View Load Logs</li>
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

                        <!-- Title -->
                        <h4 class="card-title mb-4">Load Logs Details</h4>

                        <!-- Load Info Grid -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>Load #:</strong> {{ $load->load_number }}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>W/O #:</strong> {{ $load->load_workorder ?? '-' }}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Customer Reference #:</strong> {{ $load->customer_refrence_number ?? '-' }}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Customer #:</strong> {{ $load->load_bill_to ?? '-' }}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Load Create Date:</strong>
                                {{ $load->created_at ? $load->created_at->format('d-m-Y') : '-' }}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Carrier:</strong> {{ $load->load_carrier ?? '-' }}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Load Status:</strong> {{ $load->load_status ?? '-' }}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Customer Rate:</strong> {{ $load->shipper_load_final_rate ?? '-' }}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Carrier Rate:</strong> {{ $load->load_final_carrier_fee ?? '-' }}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>CPR Status:</strong> {{ $load->cpr_check ?? '-' }}
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Logs Section -->
                        <h4 class="card-title mb-3">Activity Logs</h4>

                        <div class="accordion accordion-flush" id="accordionLogs">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="logHeadingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#logCollapseOne" aria-expanded="false"
                                        aria-controls="logCollapseOne">
                                        All Logs
                                    </button>
                                </h2>
                                <div id="logCollapseOne" class="accordion-collapse collapse"
                                    aria-labelledby="logHeadingOne" data-bs-parent="#accordionLogs">
                                    <div class="accordion-body">
                                        @if($alllogs->isEmpty())
                                            <div class="alert alert-light mb-0">No activity has been recorded for this load yet.</div>
                                        @else
                                            <div class="d-flex flex-column gap-3 p-3">
                                                @foreach($alllogs as $log)
                                                    @php
                                                        $changes = getdiffrance($log->old_json, $log->new_json);
                                                    @endphp

                                                    <div class="activity-history border rounded p-3 bg-white shadow-sm">
                                                        <div class="d-flex flex-wrap justify-content-between align-items-start gap-2">
                                                            <div>
                                                                <div class="activity-title fw-bold mb-0">{{ $log->message ?: 'Activity was recorded' }}</div>
                                                                <div class="activity-label text-muted mt-1">Performed by: <strong class="activity-actor">{{ $log->user_name ?: 'System' }}</strong></div>
                                                            </div>
                                                            <span class="activity-time text-muted">{{ format_activity_timestamp($log->created_at ?: $log->updated_at) }}</span>
                                                        </div>

                                                        <div class="mt-3">
                                                            <div class="activity-label fw-semibold text-dark">What changed</div>
                                                            <div class="mt-2">{!! trim($changes) !== '' ? $changes : '<div class="text-muted">No details found.</div>' !!}</div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div> <!-- end card -->
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- container-fluid -->
</div> <!-- page-content -->

@endsection

<style>
.activity-history {
    font-size: 16px;
}

.activity-history .activity-title {
    font-size: 17px;
}

.activity-history .activity-label,
.activity-history .small {
    font-size: 15px !important;
}

.activity-actor {
    color: #a6ce3a;
}
</style>
