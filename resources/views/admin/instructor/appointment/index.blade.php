@extends('doctor.layouts.default')
@section('title','Doctor Appointment')
@section('content')
<div class="content container-fluid">
    <div class="page-header mb-3">
        <div class="row align-items-center">
            <div class="col">
                <ul class="list-links">
                    <li class="active"><a class="py-1" href="#" data-date="today">Upcoming Appointments</a></li>
                    <li><a class="py-1" href="#" data-date="yesterday">Past Appointments</a></li>
                </ul>
            </div>
            <div class="col-auto">
                <div class="bookingrange btn btn-white btn-sm d-none">
                    <div class="cal-ico">
                        <i class="feather-calendar mr-1"></i>
                        <span>Select Date</span>
                    </div>
                    <div class="ico">
                        <i class="fas fa-chevron-left"></i>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title">Appointments</h5>
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
                                    <th>Patient</th>
                                    <th>Doctor</th>
                                    <th>Symptoms</th>
                                    <th>Consultation type</th>
                                    <th>Comment</th>
                                    <th>Date & Time</th>
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

    if($('.bookingrange').length>0){var start=moment().subtract(6,'days');var end=moment();function booking_range(start,end){$('.bookingrange span').html(start.format('M/D/YYYY')+' - '+end.format('M/D/YYYY'));}
        $('.bookingrange').daterangepicker({startDate:start,endDate:end,ranges:{'Today':[moment(),moment()],'Yesterday':[moment().subtract(1,'days'),moment().subtract(1,'days')],'Last 7 Days':[moment().subtract(6,'days'),moment()],'Last 30 Days':[moment().subtract(29,'days'),moment()],'This Month':[moment().startOf('month'),moment().endOf('month')],'Last Month':[moment().subtract(1,'month').startOf('month'),moment().subtract(1,'month').endOf('month')]}},booking_range);booking_range(start,end);
    }
    let date=$('.list-links li.active a').data('date');
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
                data.date=date;
            },
        },
        "columns": [
            { "data": 'id',"name":'id','orderable': false, 'searchable': false,'width':'5%'},
            { "data": "patient.name","name":"patient.name",defaultContent:''},
            { "data": "doctor.name","name":"doctor.name",defaultContent:'NA'},
            { "data": "symptom_id","name":"symptom_id",defaultContent:''},
            { "data": "symptom","name":"symptom"},
            { "data": "comment","name":"comment"},
            { "data": "date","name":"date"},
            { "data": "status","name":"status"},
            { "data": "id",orderable: false, searchable: false,visible:true},
        ],
        "columnDefs": [
            {render: function (data, type, row, meta) {
                    return meta.row+1;
                },
                "targets":0,
            },
            {render: function (data, type, row, meta) {
                    if(data){
						let image=(row.patient && row.patient.image)?row.patient.image:'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y';
						let gender=(row.patient && row.patient.gender)?row.patient.gender:'';
						let age=(row.patient && row.patient.age)?row.patient.age:'';
                        let profile='&nbsp;<span class="text-muted">';
                        if(gender){
                            profile+=gender;
                        }
                        if(age){
                            profile+=', '+age;
                        }
                        profile+='</span>';
                        return '<h2 class="table-avatar">'
                        +'<img class="avatar avatar-img" src="'+image+'" alt="">'
                        +'<span class="user-name">'+data+'</span> <br>'+profile
                        +'</h2>';
                    }
                    return data;
                },
                "targets":1,
            },
            {render: function (data, type, row, meta) {
                    if(data){
						let image=(row.doctor && row.doctor.profile && row.doctor.profile.image)?row.doctor.profile.image:'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y';
						// let gender=(row.doctor && row.doctor.profile && row.doctor.profile.gender)?row.doctor.profile.gender:'';
						// let age=(row.doctor && row.doctor.profile && row.doctor.profile.age)?row.doctor.profile.age+' Year':'';
                        let profile='<span class="text-muted">';
                        // if(gender){
                        //     profile+=gender;
                        // }
                        // if(age){
                        //     profile+=', '+age;
                        // }
                        profile+='</span>';
                        return '<h2 class="table-avatar">'
                        +'<img class="avatar avatar-img" src="'+image+'" alt="">'
                        +'<span class="user-name">'+data+'</span> ' 
                        +'</h2>';
                    }
                    // return data;
                },
                "targets":2,
            },
            {render: function (data, type, row, meta) {

                    return data;
                },
                "targets":-4,
                "className": "desc-info"
            },
            {render: function (data, type, row, meta) {
                    if(row.symptoms && row.symptoms.length>0){
                        let symptoms=row.symptoms.map(function(v,i){
                            return '<span class="badge badge-info mb-1">'+v.name+'</span>';
                        }).join(' ');
                        return symptoms;
                    }
                    return 'N/A';
                },
                "targets":3,
                "className":"desc-info"
               // "className":"mb-1"
            },
            {render: function (data, type, row, meta) {
                    if(row.patient){
                        if(row.status == 3){
                            return 'NA';
                        }else if(row.status == 2){
                            return '<span class="badge badge-success">Completed</span>'
                        }else{
                            return '<span>Scheduled Appointment</span>'
                               +'<a target="_blank" href="{{ url()->current() }}/'+row.id+'/voice-call" class="d-block text-primary mt-2 voice-call"><span class="d-flex align-items-center"><i class="feather-phone me-2"></i> Voice call</span></a>';
                        }

                    }else{
                        return 'NA';
                    }                              
                },
                "targets":-5,
            },
            {render: function (data, type, row, meta) {
                    return data+'/ '+row.start_time+' -  '+row.start_end;
                },
                "targets":-3,
            },
            {render: function (data, type, row, meta) {
                    //refer 0 = UPCOMMING,1=ONGOING, 2=COMPLETED, 3=CANCELLED
                    var status = "Pending";var color = "badge-info";
                    if(data == 0){
                        var color = "badge-info";
                        var status = "UPCOMMING";
                    }else if(data == 1){
                        var color = "badge-primary";
                        var status = "ONGOING";
                    }else if(data == 2){
                        var color = "badge-success";
                        var status = "COMPLETED";
                    }else if(data == 3){
                        var color = "badge-danger";
                        var status = "CANCELLED";
                    }else if(data == 4){
                        var color = "badge-danger";
                        var status = "Didn't Connect";
                    }
                    return '<span class="badge '+color+' text-capitalize"><i class="fas fa-circle me-1"></i> '+status+'</span>';
                },
                "targets":-2,
            },
            {render: function (data, type, row, meta) {
                if(row.status == 3){
                    return 'NA';
                }else{
                    return '<div class="actions">'
                            +'<a href="{{ route("doctor.appoinment.index") }}/'+data+'" class="text-black">'
                            +'<i class="feather-eye me-1"></i> View'
                            +'</a>'
                            +'</div>';
                }
                },
                "targets":-1,
            },
        ],
        "aaSorting": [],
        "order": [[0, 'desc']],
        "initComplete": (settings, json) => {
            $('.dataTables_paginate').appendTo('#tablepagination');
            $('.dataTables_filter').appendTo('#tableSearch');
        },
    });
    $('.list-links a').on('click',function(e){
        e.preventDefault();
        $('.list-links li').removeClass('active');
        $(this).parent().addClass('active');
        date=$(this).data('date');
        table.ajax.reload();
    });
});
</script>
@endpush
