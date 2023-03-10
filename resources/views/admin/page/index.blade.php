@extends('admin.layouts.default')
@section('title','Admin - Pages')
@section('content')
<div class="content container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title float-start">Pages</h5>
                            <a href="{{route('admin.page.create')}}" class="btn btn-success btn-sm float-end"><i class="fa fa-plus"></i> Add New</a>
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
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    {{-- <th>Author</th> --}}
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
@push('styles')
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endpush
@push('scripts')
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
$(function(){
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
            { "data": "post_title","name":"post_title",defaultContent:''},
            { "data": "post_status","name":"post_status"},

            // { "data": "post_author ","name":"post_author"},

            { "data": "post_date","name":"post_date"},
            { "data": "action",orderable: false, searchable: false,visible:true},
        ],
        "columnDefs": [
            {render: function (data, type, row, meta) {
                    return meta.row+1;
                },
                "targets":0,
            },
            {render: function (data, type, row, meta) {

                    return moment(data).format('LLLL');
                },
                "targets":3,
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
@stop
