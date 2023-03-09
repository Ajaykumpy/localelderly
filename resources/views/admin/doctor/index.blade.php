@extends('admin.layouts.default')
@section('title','Admin - Doctors')
@section('head')
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endsection
@section('content')
<!-- content -->
<div class="content container-fluid">
    <div class="page-header">
        
        <div class="row align-items-center">
            <div class="col-md-12 d-flex justify-content-end">
                <div class="doc-badge me-3">Doctor <span class="ms-1">{{$count}}</span></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title">Doctors</h5>
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
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile No</th>
                                    <th>Login Status</th>
                                    <th>Status</th>
                                    <th>Action</th>
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
                { "data": "name","name":"name"},
                { "data": "email","name":"email"},
                { "data": "mobile","name":"mobile"},
                { "data": "current_status.status","name":"current_status.status","defaultContent":"NA"},
                { "data": "ban","name":"ban","defaultContent":"NA"},
                { "data": "action",orderable: false, searchable: false,visible:true},
            ],
            "columnDefs": [
                {render: function (data, type, row, meta) {
                        return meta.row+1;
                    },
                    "targets":0,
                },
				{render: function (data, type, row, meta) {
                        return '<h2 class="table-avatar">'
                            +'<a href="{{url()->current()}}/'+row.id+'"><img class="avatar avatar-img" src="'+((row.profile && row.profile.image)?row.profile.image:'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y')+'" alt=""></a>'
                            +'<a href="{{url()->current()}}/'+row.id+'"><span class="user-name">'+data+'</span>'
                            '</h2>';
                    },
                    "targets":1,
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
						if(data == 1){
							data = '<span class="badge badge-danger">Disable</span>';
                        }else{
                            data = '<span class="badge badge-success">Enable</span>';
                        }
                        return data;
                    },
                    "targets":-2,
                },
            ],
            "aaSorting": [],
            // "order": [[0, 'desc']],
            initComplete: (settings, json) => {
                $('.dataTables_paginate').appendTo('#tablepagination');
                $('.dataTables_filter').appendTo('#tableSearch');
            },
        });
    });
    
</script>
@endpush