@extends('admin.layouts.default')
@section('title')
Admin - Package
@endsection
@section('head')
<!-- <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}"> -->
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">  -->
<!-- <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet"> -->
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endsection
@section('content')
<!-- content -->
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-12 d-flex justify-content-end">
                <div class="doc-badge me-3">Packages <span class="ms-1">{{$count}}</span></div>
               {{--   <a href="{{route('admin.package.create')}}" data-bs-toggle="modal" data-bs-target="#addModal"
                    class="btn btn-primary btn-add"><i class="feather-plus-square me-1"></i> Add New</a> --}}
                <a href="{{route('admin.package.create')}}" class="btn btn-primary btn-add"><i class="feather-plus-square me-1"></i> Add New</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title">Packages</h5>
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
                                    <th>Sr.No</th>
                                    <th>Name</th>
                                    <th>Duration</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Subscribed</th>
                                    <th>Date</th>
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
<!-- script -->
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
                { "data": "invoice_period","name":"invoice_period"},
                { "data": "price","name":"price"},
                { "data": "status","name":"status"},
                { "data": "subcription_count","name":"subcription_count"},
                { "data": "created_at","name":"created_at"},
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
                            +'<img class="avatar avatar-img" src="'+((row.image)?row.image:'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y')+'" alt=""></a>'
                            +'<span class="user-name">'+data+'</span>'
                            '</h2>';
                    },
                    "targets":1,
                },
                {render: function (data, type, row, meta) {
                        return data+' '+row.invoice_interval;
                    },
                    "targets":2,
                },
                {render: function (data, type, row, meta) {
                        if(row.currency=='inr'){
                            return '<i class="fa fa-rupee-sign"></i> '+parseFloat(data).toFixed(2);
                        }
                        return parseFloat(data).toFixed(2);
                    },
                    "targets":3,
                },
                {render: function (data, type, row, meta) {
                        return (data==1)?'<span class="badge badge-success">Enable</span>':'<span class="badge badge-danger">Disable</span>';
                    },
                    "targets":4,
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

    function pack_del(id){
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
                type:'post',
                url:'{!! route("admin.package.destroy",'+id+') !!}',
                data:{_token:'{{csrf_token()}}',_method:'delete',id:id},
                success:function(data){
                    Swal.fire('Deleted!','Your file has been deleted.','success')
                    location.reload();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    var data=$.parseJSON(jqXHR.responseText);
                    Swal.fire('Error!','Failed','error')
                }
            });


          }
        })
  }

</script>
@endpush
