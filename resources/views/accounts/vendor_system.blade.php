@extends('layout.compact.app') <!-- This links to the app.blade.php layout -->

@section('content')

<style>
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
    background-color: rgb(237, 212, 214);
    color: rgb(206, 10, 27);
    margin-bottom: 10px;
    border: 1px solid rgb(230, 195, 201);
    border-radius: 4px;
    position: fixed;
    width: 20%;
    right: 10px;
    z-index: 9999;
    top: 10px;
}
.row-open {
    background-color: #f9e79f !important;
}
.row-delivered-paid {
   background-color: #ffcccb !important;
} 
.row-delivered-paid-record {
   background-color: #82e0aa !important;
} 
ul.pagination {
    display: none;
}
 .load-row {
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    /* Open – Red */
    .table-striped>tbody>tr.row-open td {
        background-color: #fff8dc !important;
        color: #000 !important;
    }

    /* Delivered – Yellow */
    .table-striped>tbody>tr.row-delivered td {
        background-color: #f7f7f7 !important;
        color: #8a6d3b !important;
    }

    /* Covered – Light Purple */
    .table-striped>tbody>tr.row-covered td {
        background-color: #f3e8ff !important;
        color: #6b21a8 !important;
    }

    /* On Route – Light Blue */
    .table-striped>tbody>tr.row-onroute td {
        background-color: #e0f2fe !important;
        color: #075985 !important;
    }

    /* Unloading – Light Orange */
    .table-striped>tbody>tr.row-unloading td {
        background-color: #ffedd5 !important;
        color: #9a3412 !important;
    }

    /* Completed – Gray */
    .table-striped>tbody>tr.row-completed td {
        background-color: #fff !important;
        color: #374151 !important;
    }

    /* Completed & Paid – Green */
    .table-striped>tbody>tr.row-completed-paid td {
        background-color: #e6ffed !important;
        color: #2d6a4f !important;
    }

    /* Completed & Paid Record – Teal */
    .table-striped>tbody>tr.row-completed-paidrecord td {
        background-color: #e6ffed !important;
        color: #115e59 !important;
    }

    /* Hover */
    .load-row:hover td {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.08);
        transform: scale(1.01);
    }
    .status-box {
    display: inline-block;
    width: 18px;
    height: 18px;
    border-radius: 4px;
    margin-right: 6px;
    border: 1px solid #ccc;
}
 div[style*="overflow-x"]::-webkit-scrollbar {
        height: 8px;
        width: 8px;
    }
    div[style*="overflow-x"]::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }
    div[style*="overflow-x"]::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
    .note-box {
    background: #f8f9fa;
    padding: 12px 15px;
    border-radius: 10px;
    border-left: 4px solid #0d6efd;
}

.note-user {
    font-size: 14px;
    margin-bottom: 5px;
}

.note-text {
    font-size: 15px;
    color: #333;
}
.form-control {
    display: block;
    width: unset;
    padding: .47rem .75rem;
    font-size: .9rem;
    font-weight: 400;
    line-height: 1.5;
    color: var(--bs-body-color);
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background-color: var(--bs-secondary-bg);
    background-clip: padding-box;
    border: var(--bs-border-width) solid var(--bs-border-color);
    border-radius: var(--bs-border-radius);
    -webkit-transition: border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
    transition: border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
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
                                    <h4 class="mb-sm-0">Vendor System</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">CCI</a></li>
                                            <li class="breadcrumb-item active">Vendor System</li>
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
                                <div class="my-4 d-flex justify-content-between align-items-center">
                                        <h4 class="card-title">Vendor System</h4>
                                                                       <!-- Status Legend -->
                                <!-- <ul class="list-inline m-0" style="display: flex;">
                                    <li class="list-inline-item d-flex align-items-center me-3">
                                        <span class="status-box" style="background:#ffe5e5;"></span> Open
                                    </li>
                                    <li class="list-inline-item d-flex align-items-center me-3">
                                        <span class="status-box" style="background:#fff8dc;"></span> Delivered
                                    </li>
                                    <li class="list-inline-item d-flex align-items-center me-3">
                                        <span class="status-box" style="background:#e6f0ff;"></span> Invoiced
                                    </li>
                                    <li class="list-inline-item d-flex align-items-center me-3">
                                        <span class="status-box" style="background:#e6ffed;"></span> Paid
                                    </li>
                                </ul> -->
</div>
        
<div style="overflow-x: auto; overflow-y: auto; max-height: 600px; border: 1px solid #ddd; border-radius: 8px;">
    <table class="table table-striped table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <th>Sr No.</th>
                <th>Load#</th>
                <th>W/O #</th>
                <th>Carrier</th>
                <th>Carrier Invoice Date</th>
                <th>Carrier Due Date</th>
                <th>Ready to Pay</th>
                <th>Proccessed By</th>
                <th>Documents</th>
                <th>Quick Pay %</th>
                <th>Carrier Files Upload</th>
                <th>Carrier Files View</th>
                <th>Payment Method</th>
                <th>Carrier Payment Status</th>
                <th>Carrier Payment Date</th></th>
                <th>Customer Invoice Date</th>
                <!-- <th>Agent Files</th> -->
                <th>Logs Check</th>
                <th>Vendor Internal Notes</th>
            </tr>
        </thead>

        <tbody id="vendor-search">
            @include('accounts.partials.vendor_system_table')
        </tbody>
    </table>
</div>

<div class="custom-pagination mt-3">
    {{ $vendormanagement->links('pagination::bootstrap-5') }}
</div>

        <div id="modals-container">
            @foreach($vendormanagement as $i => $vendor)

            <!-- Blade Table -->
            @if($vendor->carrierDoc)
            
            <!-- Move this outside of the table -->
					<div class="modal fade" id="filesModal{{ $vendor->id }}" tabindex="-1" aria-labelledby="filesModalLabel{{ $vendor->id }}" aria-hidden="true">
					  <div class="modal-dialog modal-lg" style="max-width: 800px;">

                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header" style="padding-left: 14px;">
                                <h4 class="modal-title">View Documents</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                @php
                                    $alladoc = $vendor->carrierDoc;
                                    $docs = json_decode($alladoc, true);
                                @endphp

                                @if(empty($docs))
                                    <p>No documents found.</p>
                                @else
                                    <div class="accordion" id="accordionExample">
                                        @foreach($docs as $key => $all)
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="heading{{$key}}">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$key}}" aria-expanded="false" aria-controls="collapse{{$key}}"> 
                                                        View document #{{$key + 1}} ({{ basename($all) }})
                                                    </button>
                                                     <button
                                                            type="button"
                                                            class="remove-file"
                                                            data-load-id="{{ $vendor->load_id ?? $vendor->id }}"
                                                            data-file-name="{{ basename($all) }}"
                                                            onclick="deleteCarrierFile(this)"
                                                            style="background: unset; border: none;"
                                                        >
                                                            <i class="fa fa-trash" style="margin-top: 15px; color: red;"></i>
                                                        </button>
                                                    
                                                </h2>
                                                <div id="collapse{{$key}}" class="accordion-collapse collapse" aria-labelledby="heading{{$key}}" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        @php
                                                            $file = $all;
                                                            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                                        @endphp

                                                        <div style="margin-bottom: 20px;">
                                                            @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']))
                                                                <!-- Image Preview -->
                                                                <a href="{{ asset('public/'.$file) }}" target="_blank">
                                                                    <img src="{{ asset('public/'.$file) }}" alt="Image" style="max-width: 500px;">
                                                                </a>
                                                            @elseif($extension === 'pdf')
                                                                <!-- PDF Preview -->
                                                                <a href="{{ asset('public/'.$file) }}" target="_blank">
                                                                    <embed src="{{ asset('public/'.$file) }}" type="application/pdf" width="600" height="400" />
                                                                 </a>
                                                            @elseif(in_array($extension, ['doc', 'docx']))
                                                                <!-- Word Preview with Google Docs Viewer -->
                                                                <iframe src="https://docs.google.com/gview?url={{ urlencode(asset('public/'.$file)) }}&embedded=true" 
                                                                        style="width:600px; height:500px;" frameborder="0"></iframe>
                                                                <br>
                                                                <a href="{{ asset('public/'.$file) }}" target="_blank">Download Word Document</a>
                                                            @else
                                                                <p>Unsupported file type.</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            
            @endif
        </div>
		
		
    


    <div class="modal fade" id="view-documents-{{ $vendor->id }}" tabindex="-1" aria-labelledby="view-documents" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="max-width: 800px;">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header" style="padding-left: 14px;">
                    <h4 class="modal-title">View Documents</h4>
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                            <!-- Existing Credit Logs -->

                            @php
							$alladoc = $vendor->public_file;
                            $docs = json_decode($alladoc, true);
                            @endphp
							
                            @if(empty($docs))
                                <p>No documents found.</p>
                            @else
								@if(!empty($docs['carrer_rate_cnfrm_doc']))
                                <div class="accordion" id="accordionExample">
                                    @foreach($docs['carrer_rate_cnfrm_doc'] as $key => $all)
                                    
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#carrer_rate{{$key}}" aria-expanded="false" aria-controls="collapse{{$key}}">
                                            Carrier Rate document #{{$key + 1}} ({{basename($all)}})
                                            </button>
                                        </h2>
                                        <div id="carrer_rate{{$key}}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                            @php
                                                    $file = 'public/'.$all; // Or $all['file'] depending on your data structure
                                                    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                                @endphp

                                                <div style="margin-bottom: 20px;">
                                                    @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']))
                                                        <!-- Image Preview -->
                                                        <a href="{{ asset($file) }}" target="_blank"><img src="{{ asset($file) }}" alt="Image" style="max-width: 500px;"></a>
                                                    @elseif($extension === 'pdf')
                                                        <!-- PDF Preview -->
                                                        <a href="{{ asset($file) }}" target="_blank"><embed src="{{ asset($file) }}" type="application/pdf" width="600" height="400"></a>
                                                    @elseif(in_array($extension, ['doc', 'docx']))
                                                        <!-- Word Preview with Google Docs Viewer -->
                                                        <iframe src="https://docs.google.com/gview?url={{ urlencode(asset($file)) }}&embedded=true" 
                                                                style="width:600px; height:500px;" frameborder="0"></iframe>
                                                        <!-- Optional download link -->
                                                        <br><a href="{{ asset($file) }}" target="_blank">Download Word Document</a>
                                                    @else
                                                        <!-- Unsupported file -->
                                                        <p>Unsupported file type.</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
								@endif
								
								@if(!empty($docs['pod_doc']))
                                <div class="accordion" id="accordionExample">
                                    @foreach($docs['pod_doc'] as $key => $all)
                                    
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#pod_doc{{$key}}" aria-expanded="false" aria-controls="collapse{{$key}}">
                                            POD document #{{$key + 1}} ({{basename($all)}})
                                            </button>
                                        </h2>
                                        <div id="pod_doc{{$key}}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                            @php
                                                    $file = 'public/'.$all; // Or $all['file'] depending on your data structure
                                                    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                                @endphp

                                                <div style="margin-bottom: 20px;">
                                                    @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']))
                                                        <!-- Image Preview -->
                                                        <a href="{{ asset($file) }}" target="_blank"><img src="{{ asset($file) }}" alt="Image" style="max-width: 500px;"></a>
                                                    @elseif($extension === 'pdf')
                                                        <!-- PDF Preview -->
                                                        <a href="{{ asset($file) }}" target="_blank"><embed src="{{ asset($file) }}" type="application/pdf" width="600" height="400"></a>
                                                    @elseif(in_array($extension, ['doc', 'docx']))
                                                        <!-- Word Preview with Google Docs Viewer -->
                                                        <iframe src="https://docs.google.com/gview?url={{ urlencode(asset($file)) }}&embedded=true" 
                                                                style="width:600px; height:500px;" frameborder="0"></iframe>
                                                        <!-- Optional download link -->
                                                        <br><a href="{{ asset($file) }}" target="_blank">Download Word Document</a>
                                                    @else
                                                        <!-- Unsupported file -->
                                                        <p>Unsupported file type.</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
								@endif
								
								@if(!empty($docs['shipper_rate_approval_doc']))
                                <div class="accordion" id="accordionExample">
                                    @foreach($docs['shipper_rate_approval_doc'] as $key => $all)
                                    
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#shipper_rate{{$key}}" aria-expanded="false" aria-controls="collapse{{$key}}">
                                            Shipper Rate document #{{$key + 1}} ({{basename($all)}})
                                            </button>
                                        </h2>
                                        <div id="shipper_rate{{$key}}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                            @php
                                                    $file = 'public/'.$all; // Or $all['file'] depending on your data structure
                                                    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                                @endphp

                                                <div style="margin-bottom: 20px;">
                                                    @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']))
                                                        <!-- Image Preview -->
                                                        <a href="{{ asset($file) }}" target="_blank"><img src="{{ asset($file) }}" alt="Image" style="max-width: 500px;"></a>
                                                    @elseif($extension === 'pdf')
                                                        <!-- PDF Preview -->
                                                        <a href="{{ asset($file) }}" target="_blank"><embed src="{{ asset($file) }}" type="application/pdf" width="600" height="400"></a>
                                                    @elseif(in_array($extension, ['doc', 'docx']))
                                                        <!-- Word Preview with Google Docs Viewer -->
                                                        <iframe src="https://docs.google.com/gview?url={{ urlencode(asset($file)) }}&embedded=true" 
                                                                style="width:600px; height:500px;" frameborder="0"></iframe>
                                                        <!-- Optional download link -->
                                                        <br><a href="{{ asset($file) }}" target="_blank">Download Word Document</a>
                                                    @else
                                                        <!-- Unsupported file -->
                                                        <p>Unsupported file type.</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
								@endif
								
								
								@if(!empty($docs['carrier_invoice_doc']))
                                <div class="accordion" id="accordionExample">
                                    @foreach($docs['carrier_invoice_doc'] as $key => $all)
                                    
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#carrier_invoice{{$key}}" aria-expanded="false" aria-controls="collapse{{$key}}">
                                            Carrier Invoice document #{{$key + 1}} ({{basename($all)}})
                                            </button>
                                        </h2>
                                        <div id="carrier_invoice{{$key}}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                            @php
                                                    $file = 'public/'.$all; // Or $all['file'] depending on your data structure
                                                    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                                @endphp

                                                <div style="margin-bottom: 20px;">
                                                    @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']))
                                                        <!-- Image Preview -->
                                                        <a href="{{ asset($file) }}" target="_blank"><img src="{{ asset($file) }}" alt="Image" style="max-width: 500px;"></a>
                                                    @elseif($extension === 'pdf')
                                                        <!-- PDF Preview -->
                                                        <a href="{{ asset($file) }}" target="_blank"><embed src="{{ asset($file) }}" type="application/pdf" width="600" height="400"></a>
                                                    @elseif(in_array($extension, ['doc', 'docx']))
                                                        <!-- Word Preview with Google Docs Viewer -->
                                                        <iframe src="https://docs.google.com/gview?url={{ urlencode(asset($file)) }}&embedded=true" 
                                                                style="width:600px; height:500px;" frameborder="0"></iframe>
                                                        <!-- Optional download link -->
                                                        <br><a href="{{ asset($file) }}" target="_blank">Download Word Document</a>
                                                    @else
                                                        <!-- Unsupported file -->
                                                        <p>Unsupported file type.</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
								@endif
								
								@if(!empty($docs['do']))
                                <div class="accordion" id="accordionExample">
                                    @foreach($docs['do'] as $key => $all)
                                    
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#do{{$key}}" aria-expanded="false" aria-controls="collapse{{$key}}">
                                            DO document #{{$key + 1}} ({{basename($all)}})
                                            </button>
                                        </h2>
                                        <div id="do{{$key}}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                            @php
                                                    $file = 'public/'.$all; // Or $all['file'] depending on your data structure
                                                    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                                @endphp

                                                <div style="margin-bottom: 20px;">
                                                    @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']))
                                                        <!-- Image Preview -->
                                                        <a href="{{ asset($file) }}" target="_blank"><img src="{{ asset($file) }}" alt="Image" style="max-width: 500px;"></a>
                                                    @elseif($extension === 'pdf')
                                                        <!-- PDF Preview -->
                                                        <a href="{{ asset($file) }}" target="_blank"><embed src="{{ asset($file) }}" type="application/pdf" width="600" height="400"></a>
                                                    @elseif(in_array($extension, ['doc', 'docx']))
                                                        <!-- Word Preview with Google Docs Viewer -->
                                                        <iframe src="https://docs.google.com/gview?url={{ urlencode(asset($file)) }}&embedded=true" 
                                                                style="width:600px; height:500px;" frameborder="0"></iframe>
                                                        <!-- Optional download link -->
                                                        <br><a href="{{ asset($file) }}" target="_blank">Download Word Document</a>
                                                    @else
                                                        <!-- Unsupported file -->
                                                        <p>Unsupported file type.</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
								@endif
								
								@if(!empty($docs['optional_docs']))
                                <div class="accordion" id="accordionExample">
                                    @foreach($docs['optional_docs'] as $key => $all)
                                    
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#optional_docs{{$key}}" aria-expanded="false" aria-controls="collapse{{$key}}">
                                            Optional document #{{$key + 1}} ({{basename($all)}})
                                            </button>
                                        </h2>
                                        <div id="optional_docs{{$key}}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                            @php
                                                    $file = 'public/'.$all; // Or $all['file'] depending on your data structure
                                                    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                                @endphp

                                                <div style="margin-bottom: 20px;">
                                                    @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']))
                                                        <!-- Image Preview -->
                                                        <a href="{{ asset($file) }}" target="_blank"><img src="{{ asset($file) }}" alt="Image" style="max-width: 500px;"></a>
                                                    @elseif($extension === 'pdf')
                                                        <!-- PDF Preview -->
                                                        <a href="{{ asset($file) }}" target="_blank"><embed src="{{ asset($file) }}" type="application/pdf" width="600" height="400"></a>
                                                    @elseif(in_array($extension, ['doc', 'docx']))
                                                        <!-- Word Preview with Google Docs Viewer -->
                                                        <iframe src="https://docs.google.com/gview?url={{ urlencode(asset($file)) }}&embedded=true" 
                                                                style="width:600px; height:500px;" frameborder="0"></iframe>
                                                        <!-- Optional download link -->
                                                        <br><a href="{{ asset($file) }}" target="_blank">Download Word Document</a>
                                                    @else
                                                        <!-- Unsupported file -->
                                                        <p>Unsupported file type.</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
								@endif

                            @endif
                            </div>
                        </div>

                <div>
        </div>
    </div>
</div>

@endforeach 

</div>										
										
                                  
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->



                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

<script>
    function deleteCarrierFile(button) {
            var loadId = button.getAttribute('data-load-id');
            var fileName = button.getAttribute('data-file-name');

            if (confirm('Are you sure you want to delete this file?')) {
                $.ajax({
                    url: '/account/delete-carrier-file', // Replace with your actual endpoint
                    method: 'POST',
                    data: {
                        load_id: loadId,
                        file_name: fileName
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        console.log('Success:', response);
                        button.closest('.accordion-item').remove(); // Remove the file entry from the UI
                       // alert(response.message);
                        //location.reload(); // Reload the page to reflect changes
                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', error);
                        alert('An error occurred while deleting the file.');
                    }
                });
            }
        }
     // $(document).on('click', '.custom-pagination a', function(e) {
		initDataTable();
        // e.preventDefault();
        // let url = $(this).attr('href');

        // $.ajax({
            // url: url,
            // type: 'GET',
            // success: function(data) {
			 // if ($.fn.DataTable.isDataTable('#datatable-buttons-vendor')) {
					// $('#datatable-buttons-vendor').DataTable().destroy();
				// }
				// $('#vendor-search').html(data.rows);
				// $('#modals-container').html(data.modals);
				// $('#datatable-buttons-vendor').DataTable({
                    // responsive: true,
                    // dom: 'rtip',  // added "B" so buttons show properly
                    // buttons: ['copy', 'excel', 'pdf', 'colvis'],
                    // searching: false,
                    // paging: true,                     // ✅ enable pagination
                    // pageLength: 10,                   // ✅ default 50 rows
				// });
                
                // window.history.pushState("", "", url); // optional: update URL
            // }
        // });
    // });
</script>
<script>
$(document).ready(function() {
    $('input[name="query"]').on('keyup', function() {
        let query = $(this).val().trim();

        // Debounce logic
        clearTimeout($.data(this, 'timer'));
        let wait = setTimeout(() => {

            if (query.length > 0) {
                $('.loader-container').removeClass('hide');
                // Perform AJAX search
                $.ajax({
                    url: "{{ route('vendor_search') }}",
                    type: 'GET',
                    data: { query: query },
                    success: function(response) {
                        if ($.fn.DataTable.isDataTable('#datatable-buttons-vendor')) {
                            $('#datatable-buttons-vendor').DataTable().destroy();
                        }
                        $('#vendor-search').html(response.rows); // Inject result HTML
						$('#modals-container').html(response.modals);
                       
                            $('#datatable-buttons-vendor').DataTable({
                                responsive: true,
                                dom: 'rtip',  // added "B" so buttons show properly
                                buttons: ['copy', 'excel', 'pdf', 'colvis'],
                                searching: false,
                                paging: true,                     // ✅ enable pagination
                                pageLength: 10,
                            });


                        $('.loader-container').addClass('hide');
                        
                    },
                    error: function(xhr) {
                        console.error("AJAX error:", xhr.responseText);
                    }
                });

            } else {
               
                // Optionally clear the results or reload original data
                $('#vendor-search').html('');
            }

        }, 300);

        $(this).data('timer', wait);
    });
});

</script>


@endsection