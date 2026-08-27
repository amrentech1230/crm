@extends('layout.compact.app') <!-- This links to the app.blade.php layout -->

@section('content')
   
<div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Shipment Type</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">CCI</a></li>
                                            <li class="breadcrumb-item active">Shipment Type</li>
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
        
                                        <h4 class="card-title">Shipment Type</h4>
                                       
                                        <div class="my-4">
                                        <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#myModal">+ Add Shipment Type</button>
                                        </div>
        
                                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Value</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
        
        
                                            <tbody>
                                            @foreach($allShipment as $shipment)
                                            <tr>
                                                <td>{{ $shipment->name}}</td>
                                                <td>{{ $shipment->value}}</td>
                                                <td><span type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#editshipment_{{$shipment->id}}"><i class="fas fa-edit"></i></span></td>
                                                
                                            </tr>

                                            <!-- sample modal content -->
                                            <div id="editshipment_{{$shipment->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="myModalLabel">Edit Shipment Type</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            
                                                            <form id="addStatusForm" class="row" action="{{route('update_shipmenttype', $shipment->id)}}" method="post" novalidate="novalidate">
                                                            @csrf   
                                                            <div class="col-12 form-control-validation mb-4 fv-plugins-icon-container">
                                                                    <label class="form-label" for="name">Shipment Name</label>
                                                                    <input type="text" id="name" name="name" class="form-control" placeholder="Shipment Name" value="{{ $shipment->name}}">
                                                                </div>
                                                                
                                                                <div class="col-12 text-center">
                                                                    <button type="submit" class="btn btn-primary me-sm-4 me-1">Update Shipment</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
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

                <!-- sample modal content -->
                <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="myModalLabel">Shipment Type</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                
                                <form id="addStatusForm" class="row" action="{{route('store_shipmenttype')}}" method="post"  novalidate="novalidate">
                                    @csrf 
                                    <div class="col-12 form-control-validation mb-4 fv-plugins-icon-container">
                                        <label class="form-label" for="name">Shipment Name</label>
                                        <input type="text" id="name" name="name" class="form-control" placeholder="Shipment Name" autofocus="">
                                    </div>
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-primary me-sm-4 me-1">Create Shipment</button>
                                    </div>
                                </form>
                            </div>
                            
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
@endsection