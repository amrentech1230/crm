@extends('layout.compact.app')
@section('content')
 <style>
 span#switchtoprivate {
    right: 4rem;
    position: absolute;
}
 </style>
<section class="page-content">
   <div class="body_scroll">
      <div class="block-header">
         <h2>Load Public Documents</h2>
      </div>
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
      <div class="container-fluid">
        
         <!-- Multi Column -->
         <div class="row clearfix">
            <div class="card">
               <div class="card-body">
                  @php
				  
							$alladoc = $complete->public_file;
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
                                            Carrier Rate document #{{$key + 1}} <span id="switchtoprivate" class="switchtoprivate text-left danger btn btn-primary btn-sm" data-file="{{$all}}" data-load_id="{{$complete->id}}"> Move To Private Folder</span>
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
                                                        <img src="{{ asset($file) }}" alt="Image" style="max-width: 500px;">
                                                    @elseif($extension === 'pdf')
                                                        <!-- PDF Preview -->
                                                        <embed src="{{ asset($file) }}" type="application/pdf" width="600" height="400">
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
                                            POD document #{{$key + 1}}  <span id="switchtoprivate" class="switchtoprivate text-left danger btn btn-primary btn-sm" data-file="{{$all}}" data-load_id="{{$complete->id}}"> Move To Private Folder</span>
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
                                                        <img src="{{ asset($file) }}" alt="Image" style="max-width: 500px;">
                                                    @elseif($extension === 'pdf')
                                                        <!-- PDF Preview -->
                                                        <embed src="{{ asset($file) }}" type="application/pdf" width="600" height="400">
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
                                            Shipper Rate document #{{$key + 1}} <span id="switchtoprivate" class="switchtoprivate text-left danger btn btn-primary btn-sm" data-file="{{$all}}" data-load_id="{{$complete->id}}"> Move To Private Folder</span>
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
                                                        <img src="{{ asset($file) }}" alt="Image" style="max-width: 500px;">
                                                    @elseif($extension === 'pdf')
                                                        <!-- PDF Preview -->
                                                        <embed src="{{ asset($file) }}" type="application/pdf" width="600" height="400">
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
                                            Carrier Invoice document #{{$key + 1}} <span id="switchtoprivate" class="switchtoprivate text-left danger btn btn-primary btn-sm" data-file="{{$all}}" data-load_id="{{$complete->id}}"> Move To Private Folder</span>
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
                                                        <img src="{{ asset($file) }}" alt="Image" style="max-width: 500px;">
                                                    @elseif($extension === 'pdf')
                                                        <!-- PDF Preview -->
                                                        <embed src="{{ asset($file) }}" type="application/pdf" width="600" height="400">
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
                                            DO document #{{$key + 1}} <span id="switchtoprivate" class="switchtoprivate text-left danger btn btn-primary btn-sm" data-file="{{$all}}" data-load_id="{{$complete->id}}"> Move To Private Folder</span>
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
                                                        <img src="{{ asset($file) }}" alt="Image" style="max-width: 500px;">
                                                    @elseif($extension === 'pdf')
                                                        <!-- PDF Preview -->
                                                        <embed src="{{ asset($file) }}" type="application/pdf" width="600" height="400">
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
                                            Optional document #{{$key + 1}} <span id="switchtoprivate" class="switchtoprivate text-left danger btn btn-primary btn-sm" data-file="{{$all}}" data-load_id="{{$complete->id}}"> Move To Private Folder</span>
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
                                                        <img src="{{ asset($file) }}" alt="Image" style="max-width: 500px;">
                                                    @elseif($extension === 'pdf')
                                                        <!-- PDF Preview -->
                                                        <embed src="{{ asset($file) }}" type="application/pdf" width="600" height="400">
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
         </div>
      </div>
   </div>
</section>
<script>
$(document).ready(function() {
	$('.switchtoprivate').on('click', function () {
		const filePath = $(this).data('file');
		const load_id = $(this).data('load_id');

		$.ajax({
			url: "{{ route('move.to.private') }}",
			type: "POST",
			contentType: "application/json",
			data: JSON.stringify({ file: filePath, load_id:load_id }),
			headers: {
				'X-CSRF-TOKEN': '{{ csrf_token() }}'
			},
			success: function (data) {
				if (data.success) {
					alert("File moved successfully!");
				} else {
					alert("Failed to move file: " + data.message);
				}
			},
			error: function (xhr, status, error) {
				console.error("Error:", error);
				alert("An error occurred while moving the file.");
			}
		});
	});
});
</script>



@endsection
