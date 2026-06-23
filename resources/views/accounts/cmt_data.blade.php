@extends('layout.compact.app')
@section('content')

<section class="page-content">
    <div class="container-fluid">

        <div class="block-header">
            <h2>CMT</h2>
        </div>

        @if(session('success'))
            <div class="alert alert-success" id="successAlert">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body">

                <div style="overflow-x:auto;">
                    <table id="datatable-buttons"
                        class="table table-striped table-bordered dt-responsive nowrap w-100">

                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Timestamp</th>
                                <th>Agent Name</th>
                                <th>Agent Email</th>
                                <th>Agent Ext.</th>
                                <th>Pickup City</th>
                                <th>Pickup State</th>
                                <th>Pickup Zip Code</th>
                                <th>Pickup Date</th>
                                <th>Delivery City</th>
                                <th>Delivery State</th>
                                <th>Delivery Zip Code</th>
                                <th>Delivery Date</th>
                                <th>Equipment</th>
                                <th>Load Type</th>
                                <th>Commodity</th>
                                <th>Weight</th>
                                <th>Special Instructions</th>
                                <th>Rate</th>
                            </tr>
                        </thead>

                        <tbody>
                        
                            @foreach($cmt as $index => $cmts)
                            <tr>
                                <td>{{ $index+1 }}</td>
                                <td>{{ $cmts->created_at }}</td>
                                <td>{{ $cmts->agent_name }}</td>
                                <td>{{ $cmts->agent_email }}</td>
                                <td>{{ $cmts->agent_ext }}</td>
                                <td>{{ $cmts->pickup_city }}</td>
                                <td>{{ $cmts->pickup_state }}</td>
                                <td>{{ $cmts->pickup_zip_code }}</td>
                                <td>{{ $cmts->pickup_date }}</td>
                                <td>{{ $cmts->delivery_city }}</td>
                                <td>{{ $cmts->delivery_state }}</td>
                                <td>{{ $cmts->delivery_zip_code }}</td>
                                <td>{{ $cmts->delivery_date }}</td>
                                <td>{{ $cmts->equipment }}</td>
                                <td>{{ $cmts->load_type }}</td>
                                <td>{{ $cmts->commodity }}</td>
                                <td>{{ $cmts->weight }}</td>
                                <td>{{ $cmts->special_instructions }}</td>
                                <td>${{ $cmts->rate }}</td>
                           
                            </tr>
                            @endforeach
                        
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection
