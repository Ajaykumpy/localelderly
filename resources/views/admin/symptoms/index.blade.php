@extends('admin.layouts.default')
@section('title', 'Admin - Symptoms')
@section('head')
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">  --}}
@stop
@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-12 d-flex justify-content-end">
                <a href="{{ route('admin.symptoms.create') }}" class="btn btn-primary btn-add"><i class="feather-plus-square me-1"></i> Add New</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header border-bottom-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title">Symptoms</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="datatables table table-borderless hover-table" id="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Symptoms</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
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
{{-- <script src="{{ asset('assets/plugins/DataTables/datatables.min.js') }}"></script> --}}
<script>
$(function() {
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
        ajax: {
            "url": "{{ url()->current() }}",
            "type": "GET",
            "data": function(data){
                data._token="{!! csrf_token() !!}";
            },
        },
        "columns":[
        {"data":'id', "name": 'id', "orderable": false, "searchable": false},
        {"data":'name', "name": 'name'},
        {"data":'status', "name": 'status'},
        //only those have manage_user permission will get access
        { "data": "action",orderable: false, searchable: false,visible:true},
        ],
        "columnDefs":[
            {render: function (data, type, row, meta) {
                    return meta.row+1;
                },
                "targets":0,
            },
            {render: function (data, type, row, meta) {
                return (data==1)?'<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">Disable</span>';
                },
                "targets":2,
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
