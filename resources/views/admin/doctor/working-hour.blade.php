@extends('admin.layouts.default')
@section('title','Admin - Doctors')
@section('head')
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endsection
@section('content')
<!-- content -->
<div class="content container-fluid">
    <div class="page-header">
    <button class="float-left d-flex badge badge-success" onclick="history.back()">Back</button>
        <div class="row align-items-center">          
            <div class="col-md-12 d-flex justify-content-end">                
                <div class="doc-badge me-3">Total login <span class="ms-1">{{$count}}</span></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title">Doctors Working Hours</h5>
                        </div>
                        <div class="col-auto custom-list d-flex">
                            <div class="form-custom me-2">
                                <div id="tableSearch" class="dataTables_wrapper"></div>
                            </div>
                        
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="datatables table table-borderless hover-table" id="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Date</th>
                                    <th>Online Time</th>
                                    <th>Offline Time</th>
                                    <th>Working in hours</th>
                                    <th>Working in minutes</th>                                    
                                    <th>Status</th>
                                    <th>Online Location</th>
                                    <th>Offline Location</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div id="tablepagination" class="dataTables_wrapper"></div>
        </div>
    </div>  

        
</div>
@stop
@push('scripts')
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#table').DataTable({
            "language": {
                search: ' ',
                searchPlaceholder: "Search...",
                paginate: {
                    next: 'Next <i class="fas fa-chevron-right ms-2"></i>',
                    previous: '<i class="fas fa-chevron-left me-2"></i> Previous'
                }
            },
            "bFilter": true,
            "bInfo": false,
            "bLengthChange": false,
            "bAutoWidth": false,
            "ajax": {
                "url": "{{ url()->current() }}",
                "type": "GET",
                "data": function(data){
                    data._token="{!! csrf_token() !!}";
                },
            },
            "columns": [
                { "data": 'id',"name":'id','orderable': false, 'searchable': false,'width':'5%'},
                { "data": "date","name":"date"},
                { "data": "from_time","name":"from_time"},
                { "data": "to_time","name":"to_time","defaultContent":"-"},                
                { "data": "total_hrs","name":"total_hrs","defaultContent":"-"},
                { "data": "total_min","name":"total_min","defaultContent":"-"},
                { "data": "status","name":"status","defaultContent":"NA"},
                { "data": "latitude","name":"latitude","defaultContent":"-"},//for doctor online location
                { "data": "latitude","name":"latitude","defaultContent":"-"},//for doctor offline location
            ],
            "columnDefs": [
                {render: function (data, type, row, meta) {
                        return meta.row+1;
                    },
                    "targets":0,
                },
                {render: function (data, type, row, meta) {
						if(data){
							data = '<span class="badge bg-badge-grey '+((data=="Active")?"text-success":"text-danger")+'"> <i class="fas fa-circle me-1"></i> '+data+'</span>';
                        }
                        return data;
                    },
                    "targets":-3,
                },
                {render: function (data, type, row, meta) { 
                    if(row.login_location){
                        var online_location = row.login_location.split(',');
                        return '<a href="http://www.google.com/maps/place/'+online_location[0]+','+online_location[1]+'" target="_blank"><i class="fas fa-map"></i></a>';                    
                    }
                    },
                    "targets":-2,
                },
                {render: function (data, type, row, meta) { 
                    if(row.logout_location){
                        var offline_location = row.logout_location.split(',');
                        return '<a href="http://www.google.com/maps/place/'+offline_location[0]+','+offline_location[1]+'" target="_blank"><i class="fas fa-map"></i></a>';                    
                    }
                    },
                    "targets":-1,
                },            
            ],
            "aaSorting": [],
            "order": [[0, 'desc']],
            initComplete: (settings, json) => {
                $('.dataTables_paginate').appendTo('#tablepagination');
                $('.dataTables_filter').appendTo('#tableSearch');
            },
        });
    });
    
</script>
@endpush