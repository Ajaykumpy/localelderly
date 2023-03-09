@extends('admin.layouts.default')
@section('title','Admin - User-Transaction')
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
                            <h5 class="card-title">User Transaction</h5>
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
                                    <th>User</th>
                                    <th>Packages</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
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
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
    $(function() {
        var table = $('#table').DataTable({
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
                "data": function(data) {
                    data._token = "{!! csrf_token() !!}";
                },
            },
            "columns": [
                { "data": 'id',"name":'id','orderable': false, 'searchable': false,'width':'5%'},
                { "data": "payment_id","name":"payment_id",defaultContent:'NA'},
                { "data": "user","name":"user"},
                { "data": "packages","name":"packages"},
                { "data": "amount","name":"amount"},
                { "data": "status","name":"status"},
                { "data": "date","name":"date"},
            ],
            "columnDefs": [{
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    },
                    "targets": 0,
                },
                {
                    render: function(data, type, row, meta){
                        return Number.parseFloat(data).toFixed(2);
                    },
                    "targets":-3,
                }
            ],
            "aaSorting": [],
            "order": [
                [0, 'desc']
            ],
            initComplete: (settings, json) => {
                $('.dataTables_paginate').appendTo('#tablepagination');
                $('.dataTables_filter').appendTo('#tableSearch');
                $('.recordsTotal').empty().text(json.recordsTotal);
            },
        });
        $('#table').on('click', '[data-bs-target="#transaction"]', function(e) {
            var $row = $(this).closest('tr');
            var data = table.row($row).data();
            $('#transaction .transaction-info p').empty().text('#' + data.id);
            $('#transaction .transaction-date p').empty().text(moment(data.created_at).format('LLLL'));
            $('#transaction .transaction-amount p').empty().text(data.amount);
            $("#transaction select option[value='" + data.meta.status + "']").attr('selected', 'selected');
            $('#transaction input[name="transaction_id"]').val(data.id);
        });
        $('#transaction form').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '',
                type: 'post',
                data: $('#transaction form').serialize(),
                success: function(data) {
                    if (data.success) {
                        $('#transaction form')[0].reset();
                        $('#transaction').modal('hide');
                        table.ajax.reload(null, false);
                        toastr.success(data.message, 'Notification');
                    } else {
                        toastr.error(data.message, 'Notification');
                    }
                }
            });
        });
    });
</script>
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

@endpush