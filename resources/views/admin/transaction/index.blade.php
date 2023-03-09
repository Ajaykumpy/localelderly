@extends('admin.layouts.default')
@section('title','Admin - Transaction')
@section('content')
<div class="content container-fluid">

<div class="page-header mb-2">
<div class="row align-items-center">
<div class="col-md-12 d-flex justify-content-end">
<div class="doc-badge me-3">Total Transactions <span class="ms-1 recordsTotal">0</span></div>
<div class="SortBy d-none">
<div class="selectBoxes order-by">
<p class="mb-0"><img src="{{ asset('assets/img/icon/sort.png') }}" class="me-2" alt="icon"> Order by </p>
<span class="down-icon"><i class="feather-chevron-down"></i></span>
</div>
<div id="checkBox">
<form action="">
</form>
</div>
</div>
</div>
</div>
</div>


<div class="row">
<div class="col-sm-12">
<div class="card">
<div class="card-header border-bottom-0">
<div class="row align-items-center">
<div class="col">
<h5 class="card-title">Transaction</h5>
</div>
<div class="col-auto d-flex">
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
<th>Transaction ID</th>
<th>Doctor</th>
<th>Date</th>
<th>Type</th>
<th>Total Amount</th>
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
<div id="tablepagination" class="dataTables_wrapper"></div>
</div>
</div>

</div>



@stop
@push('styles')
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endpush
@push('scripts')
<div class="modal fade contentmodal" id="transaction" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content doctor-profile">
            <div class="modal-header border-bottom-0 justify-content-end pb-0">
                <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i class="feather-x-circle"></i></button>
            </div>
            <div class="modal-body pt-0">
                <div class="rating-wrapper">
                    <form action="#">
                        @csrf
                        <input type="hidden" name="transaction_id">
                        <input type="hidden" name="type" value="withdraw">
                        <h4 class="text-center mb-4">Transaction Details</h4>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="mem-info transaction-info">
                                    <h6>Transaction ID </h6>
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mem-info transaction-date">
                                    <h6>Request On </h6>
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mem-info transaction-amount">
                                    <h6>Amount</h6>
                                    <p>0</p>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="mem-info transaction-status">
                                    <h6>Status</h6>
                                    <select name="status" class="form-control">
                                        <option>--Status--</option>
                                        <option value="pending">Pending</option>
                                        <option value="completed">Completed</option>
                                        <option value="rejected">Rejected</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="mem-info">
                                    <h6>Comment</h6>
                                    <textarea class="form-control" placeholder="comment" rows="1"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary btn-download">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
$(function(){
    var table=$('#table').DataTable({
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
            { "data": "id","name":"id",defaultContent:''},
            { "data": "payable.name","name":"payable.name"},
            { "data": "created_at","name":"created_at"},
            { "data": "type","name":"type"},
            { "data": "amount","name":"amount"},
            { "data": "meta.status","name":"meta.status",defaultContent:'NA'},
            { "data": "action",orderable: false, searchable: false,visible:true},
        ],
        "columnDefs": [
            {render: function (data, type, row, meta) {
                    return meta.row+1;
                },
                "targets":0,
            },
            {render: function (data, type, row, meta) {
                    if(data){
						let image=(row.payable && row.payable.profile && row.payable.profile.image)?row.payable.profile.image:'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y';
						let gender=(row.payable && row.payable.profile && row.payable.profile.gender)?row.payable.profile.gender:'';
						let age=(row.payable && row.payable.profile && row.payable.profile.age)?row.payable.profile.age+' Year':'';
                        return '<h2 class="table-avatar">'
                        +'<a href="{{route("admin.doctor.index")}}/'+row.payable.id+'"><img class="avatar avatar-img" src="'+image+'" alt=""></a>'
                        +'<a href="{{route("admin.doctor.index")}}/'+row.payable.id+'"><span class="user-name">'+data+'</span> <span class="text-muted">'+gender+', '+age+'</span></a>'
                        +'</h2>';
                    }
                    return data;
                },
                "targets":2,
            },
            // {render: function (data, type, row, meta) {
            //         if(data){
			// 			let image=(row.doctor && row.doctor.profile && row.doctor.profile.image)?row.doctor.profile.image:'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y';
			// 			let gender=(row.doctor && row.doctor.profile && row.doctor.profile.gender)?row.doctor.profile.gender:'';
			// 			let age=(row.doctor && row.doctor.profile && row.doctor.profile.age)?row.doctor.profile.age+' Year':'';
            //             let profile='<span class="text-muted">';
            //             if(gender){
            //                 profile+=gender;
            //             }
            //             if(age){
            //                 profile+=', '+age;
            //             }
            //             profile+='</span>';
            //             return '<h2 class="table-avatar">'
            //             +'<a href="{{route("admin.appointments.index")}}/'+row.id+'"><img class="avatar avatar-img" src="'+image+'" alt=""></a>'
            //             +'<a href="{{route("admin.appointments.index")}}/'+row.id+'"><span class="user-name">'+data+'</span> '+profile+'</a>'
            //             +'</h2>';
            //         }
            //         return data;
            //     },
            //     "targets":2,
            // },
            {render: function (data, type, row, meta) {
                    return moment(data).format('LLLL');
                },
                "targets":3,
            },
            {render: function (data, type, row, meta) {
                    return (data=="completed")?'<span class="badge bg-badge-grey text-success text-capitalize"><i class="fas fa-circle me-1"></i> '+data+'</span>':'<span class="badge bg-badge-grey text-danger text-capitalize"><i class="fas fa-circle me-1"></i> '+data+'</span>';
                },
                "targets":-2,
            },

        ],
        "aaSorting": [],
        "order": [[0, 'desc']],
        initComplete: (settings, json) => {
            $('.dataTables_paginate').appendTo('#tablepagination');
            $('.dataTables_filter').appendTo('#tableSearch');
            $('.recordsTotal').empty().text(json.recordsTotal);
        },
    });
    $('#table').on('click','[data-bs-target="#transaction"]',function(e){
        var $row = $(this).closest('tr');
        var data = table.row($row).data();
        $('#transaction .transaction-info p').empty().text('#'+data.id);
        $('#transaction .transaction-date p').empty().text(moment(data.created_at).format('LLLL'));
        $('#transaction .transaction-amount p').empty().text(data.amount);
        //$('#transaction .transaction-status p').empty().text(data.meta.status);
        $("#transaction select option[value='"+data.meta.status+"']").attr('selected', 'selected');
        $('#transaction input[name="transaction_id"]').val(data.id);
    });
    $('#transaction form').on('submit',function(e){
        e.preventDefault();
        $.ajax({
            url:'',
            type:'post',
            data:$('#transaction form').serialize(),
            success:function(data){
                if(data.success){
                    $('#transaction form')[0].reset();
                    $('#transaction').modal('hide');
                    table.ajax.reload( null, false );
                    toastr.success(data.message, 'Notification');
                }
                else{
                    toastr.error(data.message, 'Notification');
                }
            }
        });
    });
});
</script>
@endpush
