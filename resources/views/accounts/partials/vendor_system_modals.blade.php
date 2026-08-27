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
