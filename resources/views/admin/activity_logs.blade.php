@extends('layout.compact.app') <!-- This links to the app.blade.php layout -->

@section('content')
   
<div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Activity logs</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">CCI</a></li>
                                            <li class="breadcrumb-item active">Activity logs</li>
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
        
                                        <h4 class="card-title">Activity logs</h4>
                                       
        
                                        <table id="datatable-buttons-log" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
												<tr>
													<th>Date</th>
													<th>Load Id</th>
													<th>Customer Id</th>
													<th>Subject</th>
													<th>Changes</th>
													<th>Name</th>
													<th>Ip Address</th>
													<th>Url</th>
												</tr>
                                            </thead>
        
        
                                            <tbody>
												@foreach($alllogs as $log)
												@php 
													$diffrent = getdiffrance($log->old_json, $log->new_json);
												@endphp
												
												<tr>
													<th>{{$log->updated_at}}</th>
													<th>{{$log->load_id}}</th>
													<th>{{$log->customer_id}}</th>
													<th>{{$log->message}}</th>
													<th>{!! $diffrent !!}</th>
													<th>{{$log->user_name}}</th>
													<th>{{$log->ip}}</th>
													<th>{{$log->url}}</th>
												</tr>
												@endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->



                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
<!-- Required datatable js -->
<script src="https://ccicrm.in/public/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="https://ccicrm.in/public/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script>
$('#datatable-buttons-log').DataTable({
	responsive: true,
	dom: 'Bfrtip',
	buttons: ['copy', 'excel', 'pdf', 'colvis'],
	order: [
        [0, 'desc']
    ]
});

</script>
@endsection