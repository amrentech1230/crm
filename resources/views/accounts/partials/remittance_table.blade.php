
@foreach($customers as $key => $customer)
<tr>
    <td>
        {{ ($customers->currentPage() - 1) * $customers->perPage() + $key + 1 }}
    </td>
    <td>
	@if(in_array(Auth::user()->role_id, [1,2,3]))
		<a href="{{route('edit.customer',$customer->id)}}">{{ $customer->customer_name }}</a>
	@else
		@if($customer->status == 'Not Approved')
		<a href="{{route('customer.edit',$customer->id)}}">{{ $customer->customer_name }}</a>
		@else
			{{ $customer->customer_name }}
		@endif
	@endif
    </td>
	
    <td class="dynamic-data">
        {{ $customer->customer_address }} 
        {{ $customer->customer_country }} 
        {{ $customer->customer_state }} 
        {{ $customer->customer_city }} 
        {{ $customer->customer_zip }}
    </td>
	<td>
		<input type="file" name="remittance[]" id="remittance_{{ $customer->id }}" data-customer-id="{{ $customer->id }}" multiple class="remittance-upload">
	</td>

 
	<td>
		<button id="view-button-{{ $customer->id }}" onclick="showRemittanceFiles({{ $customer->id }})" class="btn btn-info btn-sm" style="background-color: unset;border: unset;">
			<i class="fa fa-eye" style="font-size: 17px;color: #000;"></i>
		</button>
	</td>
    <td class="dynamic-data">{{ $customer->customer_telephone }}</td>
    <td class="dynamic-data">{{ $customer->created_at->format('m-d-Y') }}</td>
    <td class="dynamic-data">{{ $customer->user?->name }}</td>
    <td class="dynamic-data">{{ $customer->user?->teamLeaderInfo?->tl }}</td>
    <td class="dynamic-data">{{ $customer->user?->managerInfo?->manager }}</td>
    <td class="dynamic-data">
        @if($customer->status == 'Approved')
            ${{ $customer->remaining_credit }}
        @else
        xxx
        @endif
    </td>
    <td class="dynamic-data">
            ${{ $customer->invoice_credit_limit }}
    </td>
    @php
                $lastdate = \App\Models\Load::where('customer_id', $customer->id)
                            ->where('user_id', $customer->user?->id)
                            ->latest('created_at')
                            ->value('created_at');
                $daysDifference = $lastdate ? \Carbon\Carbon::parse($lastdate)->diffInDays(\Carbon\Carbon::now()) : null;
    @endphp

    <td class="dynamic-data"> {{ $lastdate ?  $daysDifference.' Days'  : 'N/A' }} </td>
    
    <td class="dynamic-data">
        {{ $customer->status == 'Approved' ? 'Approved' : 'Pending For Approval' }}
    </td>
	
    <td class="dynamic-data">
        @if($customer->commenter_name)
            @php
                // Decode the JSON strings
                $commenterNames = json_decode($customer->commenter_name, true);
                $commentNotes = json_decode($customer->comment_notes, true);

                // Initialize an empty string for comments
                $comments = '';

                // Check if the decoding was successful and both are arrays
                if (is_array($commenterNames) && is_array($commentNotes)) {
                    for ($j = 0; $j < count($commenterNames); $j++) {
                        // Concatenate comments if indexes exist
                        if (isset($commenterNames[$j]) && isset($commentNotes[$j])) {
                            $comments .= $commenterNames[$j] . ': ' . $commentNotes[$j] . "\n";
                        }
                    }
                }
            @endphp
            <textarea disabled name="comment_text" id="comment_text" rows="1">{{ $comments }}</textarea>
        @else
            <textarea disabled name="comment_text" rows="1">No Comment Found</textarea>
        @endif
        

    </td>
     <td class="status-{{ $customer->id }}">
        <span data-bs-toggle="modal" style="color: #0c7ce6; cursor:pointer" data-bs-target="#view-documents-{{ $customer->id }}"> View Documents</span>
    </td>
    <div class="modal fade" id="view-documents-{{ $customer->id }}" tabindex="-1" aria-labelledby="view-documents" aria-hidden="true">
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
                        $alladoc = $customer->customer_file_upload;
                        $docs = json_decode($alladoc, true);
                        
                    @endphp

                    @if(empty($docs))
                        <p>No documents found.</p>
                    @else

                        <div class="accordion" id="accordionExample">
                            @foreach($docs as $key => $all)
                            
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$key}}" aria-expanded="false" aria-controls="collapse{{$key}}">
                                    view document #{{$key + 1}}
                                    </button>
                                </h2>
                                <div id="collapse{{$key}}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                       @php
                                            $file = $all; // Or $all['file'] depending on your data structure
                                            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                        @endphp

                                        <div style="margin-bottom: 20px;">
                                            @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']))
                                                <!-- Image Preview -->
                                                <img src="{{ asset('public/uploads/remittances'.$file) }}" alt="Image" style="max-width: 500px;">
                                            @elseif($extension === 'pdf')
                                                <!-- PDF Preview -->
                                                <embed src="{{ asset('public/uploads/remittances/'.$file) }}" type="application/pdf" width="600" height="400">
                                            @elseif(in_array($extension, ['doc', 'docx']))
                                                <!-- Word Preview with Google Docs Viewer -->
                                                <iframe src="https://docs.google.com/gview?url={{ urlencode(asset('public/'.$file)) }}&embedded=true" 
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

                    </div>
                </div>
        </div>
    </div>

</tr>
@endforeach

