@extends('admin.layouts.default')
@section('title')
Admin - Category
@endsection
@section('content')
{{--<div class="row">
    <div class="float-right">
 
    <a class="btn btn-lg btn-primary" href="{{route('program.create')}}">ADD</a>
    </div>
 


</div>--}}
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-12 d-flex justify-content-end">
                <div class="doc-badge me-3">Category <span class="ms-1">{{$count}}</span></div>
               {{--   <a href="{{route('admin.package.create')}}" data-bs-toggle="modal" data-bs-target="#addModal"
                    class="btn btn-succes btn-add"><i class="feather-plus-square me-1"></i> Add New</a> --}}
                <a href="{{route('category.create')}}" class="btn btn-success btn-add"><i class="feather-plus-square me-1"></i> Add New</a>
            </div>
        </div>
    </div>
<div class="row rowmargin">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title">Category</h5>
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
                                    <th>Sr.no</th>
                               
                                    <th>Image</th>
                                    <th>Category Name</th>
                                    <th>Satus</th>
                                    <th>Action</th>
                                </tr>
                               
                            </thead>
                            <tbody>
                           {{-- @foreach ($program as $data)
                                <tr>
                               
                                <td>{{$data->id}}</td>
                                <td>{{$data->program_name}}</td>
                                <td>{{$data->description}}</td>
                                <td>{{$data->status}}</td>
                                <td>{{$data->price}}</td>
                                <td></td>
                              
                                </tr>
                       
                                @endforeach--}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="tablepagination" class="dataTables_wrapper"></div>
        </div>
    </div>
</div>
@stop
@push('styles')
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endpush
@push('scripts')
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
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
                { "data": 'id',"name":'id','orderable': false, 'searchable': false,'width':'6%'},
                { "data": "image","name":"image"},
                { "data": "category_name","name":"category_name"},

                { "data": "status","name":"status"},
                
                
        
                { "data": "action",orderable: false, searchable: false,visible:true},
            ],
            "columnDefs": [
                {render: function (data, type, row, meta) {
                        return meta.row+1;
                    },
                    "targets":0,
                },
                {render: function (data, type, row, meta) {

                   return '<img class=" avatar-img" src="'+data+'" alt="Image" width="200px" height="100px">';
                    },
                    "targets":1,
                },
                {render: function (data, type, row, meta) {
                        return (data==1)?'<span class="badge badge-success">Enable</span>':'<span class="badge badge-danger">Disable</span>';
                    },
                    "targets":3,
                }
	            // {render: function (data, type, row, meta) {
                //    return meta.row+1;
                //     },
                //     "targets":1,
                // },
                // {render: function (data, type, row, meta) {
                //         return meta.row+1;
                //     },
                //     "targets":2,
                // },
                // {render: function (data, type, row, meta) {
                //         // if(row.currency=='inr'){
                //             return meta.row+1;
                //         //     return '<i class="fa fa-rupee-sign"></i> '+parseFloat(data).toFixed(2);
                //         // }
                //         // return parseFloat(data).toFixed(2);
                //     },
                //     "targets":3,
                // },
                // {render: function (data, type, row, meta) {
                //         // return (data==1)?'<span class="badge badge-success">Enable</span>':'<span class="badge badge-danger">Disable</span>';
                //         return meta.row+1;
                //     },

                //     "targets":4,
                // },
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
          confirmButtonColor: 'green',
          cancelButtonColor: 'red',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
                type:'post',
                url:'{!! route("admin.category.destroy",'+id+') !!}',
                data:{_token:'{{csrf_token()}}',_method:'delete',id:id},
                success:function(data){
                    Swal.fire('Deleted!','Your Data has been deleted.','success')
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
