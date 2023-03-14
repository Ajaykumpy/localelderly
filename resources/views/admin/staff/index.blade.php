@extends('admin.layouts.default')
@section('title')
Admin - Staff
@endsection
@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-12 d-flex justify-content-end">
             <div class="doc-badge me-3">Staff <span class="ms-1">1</span></div>
               {{--   <a href="{{route('admin.package.create')}}" data-bs-toggle="modal" data-bs-target="#addModal"
                    class="btn btn-succes btn-add"><i class="feather-plus-square me-1"></i> Add New</a> --}}
                <a href="{{route('admin.staff.create')}}" class="btn btn-success btn-add"><i class="feather-plus-square me-1"></i> Add New</a>
            </div>
        </div>
    </div>
    <div class="row rowmargin">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title">Staff</h5>
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
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>

                            </thead>
                            <tbody>
          {{--   @foreach ($banner as $data)
                                <tr>

                                <td>{{$data->id}}</td>
                                <td> <img src="{{asset('public/images/banner/image/'.$data->image)}}" alt="image" width="200px" height="150px"></td>
                                <td>{{$data->status}}</td>
                                <td><div class="actions">
                        <a class="text-black" href="{{route('admin.banner.edit',$data->id)}}">
                            <i class="feather-edit-3 me-1"></i> Edit
                        </a>
                        <a class="text-danger delete-speciality pointer-link" onclick="pack_del('{{$data->id}}')" data-id="'{{$data->id}}'">
                            <i class="feather-trash-2 me-1"></i> Delete
                        </a>
                    </div></td>
                                </tr>

                                @endforeach
--}}                            </tbody>
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
                { "data": "image","name":"image"},
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
                    "targets":2,
                }
                // {render: function (data, type, row, meta) {
                //         return meta.row+1;
                //     },
                //     "targets":,
                // },
                // {render: function (data, type, row, meta) {
                //         return (data==1)?'<span class="badge badge-success">Enable</span>':'<span class="badge badge-danger">Disable</span>';
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
        console.log(id);
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
                url:'{!! route("admin.banner.destroy",'+id+') !!}',
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
