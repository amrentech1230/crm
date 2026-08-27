@extends('layout.compact.app')
@section('content')
@if(session('success'))
<div class="alert alert-success" id="successMessage">
   {{ session('success') }}
</div>
@endif
<style>
   .modal-dialog {
      max-width: 500px;
   }

   .modal-title {
      font-size: 17px;
      text-align: left;
      font-weight: 700;
   }

   .form-group .form-group {
      margin-bottom: 1rem;
   }

   .modal-body label {
      font-weight: 600;
      text-align: left;
      font-size: 13px;
      color: #4a4a4a;
      font-family: 'Poppins';
   }

   .modal-body .form-group {
      margin-bottom: 23px;
   }
</style>

 
<section class="page-content">
   <div class="body_scroll">
      <div class="block-header">
         <h2>Edit Customer</h2>
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
                  <form method="POST" action="{{ route('update.customer', $customer->id) }}">
                     @csrf
                     @method('PUT')
                     <div class="body">
                        <div class="row clearfix">
                           <div class="col-md-3">
                              <div class="form-group">
                                 <label for="customer_name">Customer Name<code>*</code></label>
                                 <input type="text" class="form-control" id="customer_name"
                                    name="customer_name" value="{{ $customer->customer_name }}" >
                                    @if ($errors->has('customer_name'))
                                        <span class="text-danger">{{ $errors->first('customer_name') }}</span>
                                    @endif
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="form-group">
                                 <label for="customer_address">MC# /FF#</label>
                                 <input type="text" class="form-control" id="customer_address"
                                    name="customer_mc_ff_input"
                                    value="{{ $customer->customer_mc_ff }} {{ $customer->customer_mc_ff_input }}"
                                    >
                                
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="form-group">
                                 <label for="customer_address">Customer Address <code>*</code></label>
                                 <input type="text" class="form-control" id="customer_address"
                                    name="customer_address" value="{{ $customer->customer_address }}"
                                    >
                                     @if ($errors->has('customer_address'))
                                        <span class="text-danger">{{ $errors->first('customer_address') }}</span>
                                    @endif
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="form-group">
                                 <label for="customer_city">City <code>*</code></label>
                                 <input type="text" class="form-control" id="customer_city"
                                    name="customer_city" value="{{ $customer->customer_city }}">
                                    @if ($errors->has('customer_city'))
                                        <span class="text-danger">{{ $errors->first('customer_city') }}</span>
                                    @endif
                              </div>
                           </div>
                           <div class="col-md-3 mt-2">
                              <div class="form-group">
                                 <label for="customer_state">State <code>*</code></label>
                                 <input type="text" class="form-control" id="customer_state"
                                    name="customer_state" value="{{ $customer->customer_state }}">
                                      @if ($errors->has('customer_state'))
                                        <span class="text-danger">{{ $errors->first('customer_state') }}</span>
                                    @endif
                              </div>
                           </div>
                           <div class="col-md-3 mt-2">
                              <div class="form-group">
                                 <label for="customer_country">Country <code>*</code></label>
                                 <input type="text" class="form-control" id="customer_country"
                                    name="customer_country" value="{{ preg_replace('/^\d+\s*/', '', $customer->customer_country) }}"
                                    >
                                     @if ($errors->has('customer_country'))
                                        <span class="text-danger">{{ $errors->first('customer_country') }}</span>
                                    @endif
                              </div>
                           </div>
                           
                          
                           <div class="col-md-3 mt-2">
                              <div class="form-group">
                                 <label for="customer_zip">Zip <code>*</code></label>
                                 <input type="text" class="form-control" id="customer_zip"
                                    name="customer_zip" value="{{ $customer->customer_zip }}">
                                    @if ($errors->has('customer_zip'))
                                        <span class="text-danger">{{ $errors->first('customer_zip') }}</span>
                                    @endif
                              </div>
                           </div>
                           
                           <div class="col-md-3 mt-2">
                              <div class="form-group">
                                 <label for="customer_telephone">Customer Telephone <code>*</code></label>
                                 <input type="text" class="form-control" id="customer_telephone"
                                    name="customer_telephone" value="{{ $customer->customer_telephone }}"
                                    >
                                     @if ($errors->has('customer_telephone'))
                                        <span class="text-danger">{{ $errors->first('customer_telephone') }}</span>
                                    @endif
                              </div>
                           </div>
                           <div class="col-md-3 mt-2">
                              <div class="form-group">
                              
                                 <label>
                                    <a href="javascript:void(0)" data-customer-id="{{ $customer['id'] }}" data-bs-toggle="modal" data-bs-target="#customerDetailsModal">Amt Customer Aging (Invoice Date)</a>
                                 </label>
                              

                                 <input class="form-control" type="number" value="{{ $customerAging }}" name="approved_limit" readonly style="width: 100%; height: 30px !important; padding: 0px 0 0 10px;">
                              </div>
                           </div>


                           <div class="col-md-3 mt-2">
                              <div class="form-group">
                                 <label><a href="javascript:void(0)" data-customer-id="{{ $customer['id'] }}" data-bs-toggle="modal" data-bs-target="#thirtydaysaging">Amt Invoices Over 30 Days</a></label>
                                 <input class="form-control" type="number" value="{{ $last30Days }}" readonly name="approved_limit" style="width: 100%;height:30px !important;padding: 0px 0 0 10px;">
                              </div>
                           </div>
                           <div class="col-md-3 mt-2">
                              <div class="form-group">
                                 <label>Approved Credit Limits (OTR)</label>
                                 <input class="form-control" type="number" value="{{ $customer->approved_limit }}" name="approved_limit" style="width: 100%;height:30px !important;padding: 0px 0 0 10px;">
                                   
                                </div>
                           </div>
                           
                           <div class="col-md-3 mt-2">
                              <div class="form-group">
                                 <label for="adv_customer_credit_limit">Assigned Credit Limit
                                    <i class="fa fa-plus" data-bs-toggle="modal" style="color: #0c7ce6; cursor:pointer" data-bs-target="#assigned-credit"></i>
                                 </label>
                                 <input type="text" class="form-control" id="adv_customer_credit_limit" name="adv_customer_credit_limit"  value="{{ $totalCreditLimit }}"  readonly>
                               
                                </div>
                           </div>
                           <div class="col-md-3 mt-2">
                              <div class="form-group">
                                 <label for="used_amount">Pending Payment
                                 
                              </label>
                                 <input type="text" class="form-control" id="used_amount" name="used_amount" value="{{ $pendingpayment }}" required readonly>
                              </div>
                           </div>
                           <div class="col-md-3 mt-2">
                              <div class="form-group">
                                 <label for="remaining_credit">Remaing Credit Limit
                                 <i class="fa fa-plus" data-bs-toggle="modal" style="color: #0c7ce6; cursor:pointer" data-bs-target="#assigned-credit-remaing"></i>
                              </label>
                                 <input type="text" class="form-control" id="remaining_credit" name="remaining_credit" value="{{ $customer->remaining_credit }}" required readonly>
                                 <input type="hidden" class="form-control" id="remaining_credit_new" name="remaining_credit_new" value="{{ $customer->remaining_credit }}" required readonly>
                             
                             </div>
                           </div>
                           <div class="col-md-3 mt-2">
                              <div class="form-group">
                                 <label for="status">Status</label>
                                 <select type="text" class="form-control" id="statuses" name="status" required>
                                    <option value="">Please Select Status</option>
                                    <option value="Approved" {{ $customer->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="Not Approved" {{ $customer->status == 'Not Approved' ? 'selected' : '' }}>Not Approved</option>
                                 </select>
                              </div>
                           </div>
                          
                           <div class="col-md-3 mt-2">
                              <div class="form-group">
                                 <label>Assigned Broker</label>
                                 <select class="form-control" required name="user_id" id="user_id">
                                    <option class="hiddenOption" disabled>Select Broker</option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}"
                                       {{ $user->id == $customer->user_id ? 'selected' : '' }}>
                                       {{ ucwords($user->name) }}
                                    </option>
                                    @endforeach
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-3 mt-2">
                              <div class="form-group">
                                 <label>Commenter's Name<code>*</code></label>
                                 <input type="text" class="form-control" readonly name="commenter_name[]" id="commenter_name" value="Adam Smith">
                              </div>
                           </div>
                           <div class="col-md-3 mt-2">
                              <div class="form-group">
                                 <label>Total load Creation Amount<code>*</code></label>
                                 <input type="text" class="form-control" readonly id="total_load_create_amount" value="{{ $loadcreateamount }}">
                              </div>
                           </div>
                           <div class="col-md-3 mt-2">
                              <div class="form-group">
                                 <label>Total Payment Received<code>*</code>
                                 <i class="fa fa-plus" data-bs-toggle="modal" style="color: #0c7ce6; cursor:pointer" data-bs-target="#paymentmarkedlist"></i>
                              </label>
                                 <input type="text" class="form-control" readonly id="total_load_create_amount" value="{{ $receiving_amount }}">
                              </div>
                           </div>

                           <div class="col-md-3 mt-2">
                              <div class="form-group">
                                 <label for="invoice_credit_limit">Assigned Invoice Credit Limit</label>
                                 <input type="text" class="form-control" id="invoice_credit_limit" name="invoice_credit_limit"  value="{{ $customer->invoice_credit_limit }}">
                              </div>
                           </div>

                           <div class="col-md-12 mt-2">
                              <div class="form-group">
                                 <label>Comment</label>
                                 <textarea name="comment_notes[]" class="form-control" cols="60" rows="5">{{ is_array($customer->comment_notes) ? implode("\n", json_decode($customer->comment_notes, true)) : $customer->comment_notes }}</textarea>
                              </div>
                           </div>
                           <div id="commentFields">
                           <!-- Initial comment fields here -->
                           </div>

                           <div class="col-md-12 mt-2">
                              <div class="form-group">
                                 <label>Private Comment</label>
                                 <textarea name="private_comment_notes[]" class="form-control" cols="60" rows="5">{{ is_array($customer->private_comment_notes) ? implode("\n", json_decode($customer->private_comment_notes, true)) : $customer->private_comment_notes }}</textarea>
                              </div>
                           </div>
                           

                        <div class="text-center mt-4">
                           <button type="submit" class="btn btn-info">Update</button>
                           <a class="btn btn-danger" href="javascript:history.back()">Cancel</a>
                        </div>
                     </div>


                     
<div class="modal" id="customerDetailsModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customerDetailsModalLabel">Customer Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered js-data-table">
                        <thead>
                            <tr>
                                <th>Load Number</th>
                                <th>Customer Name</th>
                                <th>Invoice No.</th>
                                <th>Invoice Date</th>
                                <th>Agent</th>
                                <th>Customer Payment</th>
                                <th>Aging Days</th>
                            </tr>
                        </thead>
                        <tbody>
                              @foreach($loadDatacustomeraging as $data)
                              
                                 <tr>
                                    <td>{{$data['load_number']}}</td>
                              <td>{{$data['load_bill_to']}}</td>
                              <td>{{$data['invoice_number']}}</td>
                              <td>{{$data['invoice_date']}}</td>
                              <td>{{$data['agent']}}</td>
                              <td>{{$data['customer_payment']}}</td>
                              <td>{{$data['aging_days']}}</td>
                                 </tr>
                              
                              @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="thirtydaysaging" tabindex="-1" aria-labelledby="thirtydaysagingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">30 Days Aging</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-bs-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered js-data-table">
                        <thead>
                            <tr>
                                <th>Load Number</th>
                                <th>Customer Name</th>
                                <th>Invoice No.</th>
                                <th>Invoice Date</th>
                                <th>Agent</th>
                                <th>Customer Payment</th>
                                <th>Aging Days</th>
                            </tr>
                        </thead>
                        <tbody id="thirtydaysaging-body">
                            @foreach($loadDataabove30days as $data)
                                 <tr>
                                    <td>{{$data['load_number']}}</td>
                                    <td>{{$data['load_bill_to']}}</td>
                                    <td>{{$data['invoice_number']}}</td>
                                    <td>{{$data['invoice_date']}}</td>
                                    <td>{{$data['agent']}}</td>
                                    <td>{{$data['customer_payment']}}</td>
                                    <td>{{$data['aging_days']}}</td>
                                 </tr>
                              @endforeach
							
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="paymentmarkedlist" tabindex="-1" aria-labelledby="paymentmarkedlistModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 800px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Payment Mark List</h5>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                   
                    <table class="table table-bordered js-data-table-data">
                        <thead>
                            <tr>
                                <th>Amount</th>
                                <th>payment Mark Date</th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach($dailyInvoiceTotals->sortByDesc('date') as $amounts)
                              <tr>
                                <td>{{$amounts->total_amount}}</td>
                                <td>{{$amounts->date}}</td>
                              </tr>
                           @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
               <span>Total Payment Received : <strong>${{$receiving_amount}}</strong></span> <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="assigned-credit" tabindex="-1" aria-labelledby="assignedcreditModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 800px;">
            <div class="modal-content">
                                 <!-- Modal Header -->
                                 <div class="modal-header" style="padding-left: 14px;">
                                    <h4 class="modal-title">Add Credit Limit</h4>
                                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                                 </div>

                                 <!-- Modal Body -->
                                 @php
                                    // Decode the credit limit log from the customer
                                    $credit_log = json_decode($customer->credit_limit_log, true) ?? [];
                                    $adv_customer_credit_limit = $customer->adv_customer_credit_limit ?? null;
                                 @endphp

                                 <div class="modal-body">
                                    <!-- Existing Credit Logs -->
                                    <div class="row form-row credit-log-entry">
                                          <div class="col-md-6">
                                             <div class="form-group">
                                                <label class="mb-0">Credit Limit</label>
                                             </div>
                                          </div>
                                          <div class="col-md-5">
                                             <div class="form-group">
                                                <label class="mb-0">Time & Date</label>
                                             </div>
                                          </div>
                                          <div class="col-md-1">
                                             <div class="form-group">
                                             </div>
                                          </div>
                                       </div>
                                       @if (!empty($credit_log))
                                          @foreach ($credit_log as $key => $credit)
                                             <div class="row form-row credit-log-entry" data-index="{{ $key }}">
                                                   <div class="col-md-6">
                                                      <div class="form-group">
                                                         <input type="number" 
                                                                  class="form-control credit-limit" 
                                                                  readonly 
                                                                  value="{{ !empty($credit['credit_limit']) ? $credit['credit_limit'] : $customer->adv_customer_credit_limit }}" 
                                                                  placeholder="Enter credit limit">
                                                      </div>
                                                   </div>
                                                   <div class="col-md-5">
                                                      <div class="form-group">
                                                         <input type="datetime-local" 
                                                                  class="form-control credit-time" 
                                                                  readonly 
                                                                  value="{{ $credit['credit_time'] }}">
                                                      </div>
                                                   </div>
                                                   <div class="col-md-1">
                                                      <div class="form-group">
                                                         <a href="javascript:void(0);" class="edit-field" data-index="{{ $key }}">
                                                               <i class="fa fa-edit" style="margin-top: 11px;"></i>
                                                         </a>
                                                      </div>
                                                   </div>
                                             </div>
                                          @endforeach
                                       @endif


                                    <!-- Add New Credit Limit -->
                                    <div class="row form-row new-credit-log-entry">
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <input type="number" class="form-control credit-limit" placeholder="Enter credit limit" name="new_credit_limit[]">
                                          </div>
                                       </div>
                                       <div class="col-md-5">
                                          <div class="form-group">
                                             <input type="datetime-local" class="form-control" name="new_credit_time[]" readonly value="{{ now()->format('Y-m-d\TH:i') }}">
                                          </div>
                                       </div>
                                       <div class="col-md-1">
                                          <div class="form-group">
                                             <i class="fa fa-edit" style="margin-top: 11px;"></i>
                                          </div>
                                       </div>
                                    </div>

                                    <!-- Add More Button -->
                                 </div>
                                 <div class="text-center mt-1">
                                    <button type="button" class="btn btn-success" id="addMoreLimit" style="font-size: 14px; padding: 8px 20px;">Add more limit</button>
                                 </div>
                </div>
    </div>
</div>


<div class="modal fade" id="assigned-credit-remaing" tabindex="-1" aria-labelledby="assignedcreditremaingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 800px;">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header" style="padding-left: 14px;">
            <h4 class="modal-title">Add Remaing Credit Limit</h4>
            <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
            </div>

            <!-- Modal Body -->
            @php
            // Decode the credit limit log from the customer
            $credit_log = json_decode($customer->remaining_credit_logs, true) ?? [];
            @endphp

            <div class="modal-body modal-assigned-credit-remaing">
            <!-- Existing Credit Logs -->
            <div class="row form-row credit-log-entry">
                    <div class="col-md-6">
                        <div class="form-group">
                        <label class="mb-0">Remaing Credit Limit</label>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                        <label class="mb-0">Time & Date</label>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                        </div>
                    </div>
                </div>
                @if (!empty($credit_log))
                    @foreach ($credit_log as $key => $credit)
                        <div class="row form-row credit-log-entry" data-index="{{ $key }}">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="number" name=""
                                            class="form-control remaining-credit-limit" 
                                            readonly 
                                            value="{{ !empty($credit['credit_limit']) ? $credit['credit_limit'] : '' }}" 
                                            placeholder="Enter Remaing credit limit">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <input type="datetime-local" 
                                            class="form-control remaining-credit-time" 
                                            readonly 
                                            value="{{ $credit['credit_time'] }}">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <a href="javascript:void(0);" class="edit-field" data-index="{{ $key }}">
                                        <i class="fa fa-edit" style="margin-top: 11px;"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @else
                    <div class="row form-row credit-log-entry">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="number" 
                                            class="form-control remaining-credit-limit" 
                                            readonly name="new_remaing_credit_limit[]" step="any" 
                                            value="{{ $customer->remaining_credit }}" 
                                            placeholder="Enter Remaing credit limit">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <input type="datetime-local" 
                                            class="form-control remaining-credit-time" 
                                            name="new_remaing_credit_time[]"
                                            readonly 
                                            value="{{ now()->format('Y-m-d\TH:i') }}">
                                </div>
                            </div>
                            
                        </div>

                @endif 


            <!-- Add New Credit Limit -->
            <div class="row form-row new-remaning-credit-log-entry">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="number" class="form-control remaining-credit-limit" step="any" placeholder="Enter Remaing credit limit" name="new_remaing_credit_limit[]">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <input type="datetime-local" class="form-control" name="new_remaing_credit_time[]" readonly value="{{ now()->format('Y-m-d\TH:i') }}">
                    </div>
                </div>
            </div>

            <!-- Add More Button -->
            </div>
            <div class="text-center mt-1">
            <button type="button" class="btn btn-success" id="addMoreremaingLimit" style="font-size: 14px; padding: 8px 20px;">Add more limit</button>
            </div>
        </div>
    </div>
</div>


                  </form>

               </div>
            </div>
         </div>
      </div>
   </div>
</section>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>


<script>
        // $(document).ready(function () {
        // $('.js-data-table-data').DataTable({
        //     pageLength: 100,
        //     order: [[1, "desc"]],
        //     lengthMenu: [100, 50, 25, 10],
        //     dom: 'Bfrtip',
        //     buttons: [
        //         'copy', 'csv', 'excel', 'pdf', 'print'
        //     ]
        // });
           
        // });
</script>

<script>
   $(document).ready(function() {
      $('#addComment').click(function() {
         var html = '<div class="col-md-12">';
         html += '<div class="form-group">';
         html += '<label>Commenter\'s Name</label>';
         html += '<select style="font-family: \'Poppins\', sans-serif;font-weight: 400;font-size: 9px;line-height: 0.2em;color: #666;width: 100%;height:30px;padding: 0px 0 0 10px;" class="form-control" required name="commenter_name[]" id="commenter_name">';
         html += '<option value="Please Select">Please Select</option>';
         html += '<option value="Adam Smith">Adam Smith</option>';
         html += '<option value="Amren">Amren</option>';
         html += '</select>';
         html += '</div>';
         html += '</div>';
         html += '<div class="col-md-12">';
         html += '<div class="form-group">';
         html += '<label>Comment</label>';
         html +=
            '<textarea name="comment_notes[]" class="form-control" cols="60" rows="5"></textarea>';
         html += '</div>';
         html += '</div>';

         $('#commentFields').append(html);
      });
   });
</script>



<script>
document.addEventListener('DOMContentLoaded', function () {
    const editIcons = document.querySelectorAll('.edit-field');

    editIcons.forEach(icon => {
        icon.addEventListener('click', function (e) {
            e.preventDefault();
            
            // Find the parent row
            const parentRow = this.closest('.form-row');
            const index = this.getAttribute('data-index');
            
            // Find inputs in the same row
            const creditLimitInput = parentRow.querySelector('.credit-limit');
            const creditTimeInput = parentRow.querySelector('.credit-time');
            
            // Remove readonly attributes
            creditLimitInput.removeAttribute('readonly');
            creditTimeInput.removeAttribute('readonly');

            // Focus on the first input field
            creditLimitInput.focus();

            // Save changes on blur or pressing Enter
            creditLimitInput.addEventListener('blur', function () {
                saveChanges(index, creditLimitInput.value, creditTimeInput.value);
            });

            creditTimeInput.addEventListener('blur', function () {
                saveChanges(index, creditLimitInput.value, creditTimeInput.value);
            });
        });
    });

    function saveChanges(index, creditLimit, creditTime) {
    fetch('/save-credit-log', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            index: index,
            credit_limit: creditLimit,
            credit_time: creditTime
        })
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => { throw err; });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('Changes saved successfully!');
            // Make fields readonly again
            document.querySelector(`.form-row[data-index="${index}"] .credit-limit`).setAttribute('readonly', true);
            document.querySelector(`.form-row[data-index="${index}"] .credit-time`).setAttribute('readonly', true);
        } else {
            alert(data.message || 'Failed to save changes.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert(error.errors ? JSON.stringify(error.errors) : 'An unexpected error occurred.');
    });
}
});

</script>


<script>
   $(document).ready(function () {
      let originalUsedAmount = parseFloat($('#used_amount').val()) || 0;

      // Function to get the current date and time
      function getCurrentDateTime() {
         const now = new Date();
         return now.toISOString().slice(0, 16);
      }

      // Function to update calculations
      function updateCreditCalculations() {
         let totalCreditLimit = 0;

         // Sum all credit limits
         $('.credit-limit').each(function () {
            const value = parseFloat($(this).val());
            if (!isNaN(value)) {
                  totalCreditLimit += value;
            }
         });

         // Update Assigned Credit Limit
         $('#adv_customer_credit_limit').val(totalCreditLimit.toFixed(2));

         // Get the last entered credit value from the last .credit-limit input
         let lastEntered = parseFloat($('.credit-limit').last().val());

         // Get remaining credit from server-side variable (make sure this renders correctly)
         let existingRemainingCredit = parseFloat('{{ $customer->remaining_credit ?? 0 }}') || 0;

         // Calculate remaining credit
         let remainingCredit = !isNaN(lastEntered) ? lastEntered + existingRemainingCredit : existingRemainingCredit;

         // Update remaining credit field
         $('#remaining_credit').val(remainingCredit.toFixed(2));
         $('#remaining_credit_new').val(remainingCredit.toFixed(2));
         
      }

     
      
         // Function to update calculations
         function updateremaingCreditCalculations() {
            const currentValue = parseFloat($(this).val());
            //const existingRemainingCredit = parseFloat('{{ $customer->remaining_credit ?? 0 }}') || 0;
            const existingRemainingCredit = parseFloat($('#remaining_credit_new').val());
			
            let totalCreditLimit = 0;

            if (!isNaN(currentValue)) {
               totalCreditLimit = existingRemainingCredit + currentValue;
            } else {
               totalCreditLimit = existingRemainingCredit;
            }

            // Update the remaining credit field
            $('#remaining_credit').val(totalCreditLimit.toFixed(2));
         }
      // Add more credit limit rows dynamically
      $('#addMoreLimit').click(function () {
         const newRow = `
            <div class="row form-row">
               <div class="col-md-6">
                  <div class="form-group">
                     <input type="number" name="new_credit_limit[]" class="form-control credit-limit" placeholder="Enter credit limit">
                  </div>
               </div>
               <div class="col-md-5">
                  <div class="form-group">
                     <input type="datetime-local" name="new_credit_time[]" class="form-control" readonly value="${getCurrentDateTime()}">
                  </div>
               </div>
               <div class="col-md-1">
                  <div class="form-group">
                     <i class="fa fa-trash text-danger delete-row" style="cursor:pointer; margin-top: 8px;"></i>
                  </div>
               </div>
            </div>`;
         $('#assigned-credit .modal-body').append(newRow);
      });

      // Update calculations when a credit-limit field is changed
      $(document).on('input', '.credit-limit', updateCreditCalculations);

      

      // Delete dynamically added rows
      $(document).on('click', '.delete-row', function () {
         $(this).closest('.form-row').remove();
         updateCreditCalculations();
      });


      
      // Add more remaing credit limit rows dynamically
      $('#addMoreremaingLimit').click(function () {
         const newRow = `
            <div class="row form-row">
               <div class="col-md-6">
                  <div class="form-group">
                     <input type="number" name="new_remaing_credit_limit[]" class="form-control remaining-credit-limit" step="any" placeholder="Enter Remaing credit limit">
                  </div>
               </div>
               <div class="col-md-5">
                  <div class="form-group">
                     <input type="datetime-local" name="new_remaing_credit_time[]" class="form-control" readonly value="${getCurrentDateTime()}">
                  </div>
               </div>
            </div>`;
         $('.modal-assigned-credit-remaing').append(newRow);
      });

      $(document).on('input', '.remaining-credit-limit', updateremaingCreditCalculations);


   });
</script>


@endsection