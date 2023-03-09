@extends('admin.layouts.default')
@section('title')
Admin - Patient
@endsection
@section('content')
<!-- content -->


{{--<div class="content container-fluid">
    <div class="page-header mb-0">
        <div class="row align-items-center">
            <div class="col">
                <ul class="list-links">
                    <li class="active"><a class="py-1" href="#">Subscribed</a></li>
                    <li><a class="py-1" href="#">Unsubscribed</a></li>
                    <li><a class="py-1" href="#">Expired</a></li>
                </ul>
            </div>
            <div class="col d-flex justify-content-end">
                <div class="doc-badge me-3">Patient <span class="ms-1">{{$count}}</span></div>

                {{-- <div class="SortBy">
                    <div class="selectBoxes order-by">
                        <p class="mb-0"><img src="{{ asset('assets/img/icon/sort.png') }}" class="me-2" alt="icon"> Order by </p>
                        <span class="down-icon"><i class="feather-chevron-down"></i></span>
                    </div>
                </div> --}}

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title">Patient</h5>
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
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile No</th>
                                    <th>Package</th>
                                    <th>Status</th>
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
</div>--}}
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
    $(function() {
        let subscriber='Subscribed';
        let table=$('#table').DataTable({
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
                    data.subscriber=subscriber.toLowerCase();
                },
            },
            "columns": [
                { "data": 'id',"name":'id','orderable': false, 'searchable': false,'width':'5%'},
                { "data": "name","name":"name"},
                { "data": "email","name":"email"},
                { "data": "mobile","name":"mobile"},
                { "data": "subscriptions","name":"subscriptions"},
                { "data": "status","name":"status",visible:false},
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
                            +'<a href="{{url()->current()}}/'+row.id+'"><img class="avatar avatar-img" src="'+((row.image)?row.image:'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y')+'" alt=""></a>'
                            +'<a href="{{url()->current()}}/'+row.id+'"><span class="user-name">'+data+'</span>'
                            '</h2>';
                    },
                    "targets":1,
                },
                {render: function (data, type, row, meta) {
                        return (data==1)?'<span class="badge badge-success">Enable</span>':'<span class="badge badge-danger">Disable</span>';
                    },
                    "targets":-3,
                },
            ],
            "aaSorting": [],
            "order": [[0, 'desc']],
            initComplete: (settings, json) => {
                $('.dataTables_paginate').appendTo('#tablepagination');
                $('.dataTables_filter').appendTo('#tableSearch');
            },
        });
        $('.list-links').on('click','a',function(e){
            e.preventDefault();
            $('.list-links li').removeClass('active');
            $(this).parent().addClass('active');
            subscriber=$(this).text();
            table.ajax.reload();
        });
    });

</script>
@endpush
