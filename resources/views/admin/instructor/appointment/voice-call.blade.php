@extends('doctor.layouts.default')
@section('title', 'Doctor - Voice Call')
@section('content')
<div class="content container-fluid">

    <div class="row">
        <div class="col-md-8">

            <div class="row">
                <div class="col-md-12">
                    <!-- Start prescription -->
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="card-title"><a data-bs-toggle="collapse" href="#collapsePrescription" role="button" aria-expanded="false" aria-controls="collapsePrescription"><i class="fa fa-plus"></i> Add Prescription</a></h5>
                                </div>

                            </div>
                        </div>
                        <div class="card-body collapse" id="collapsePrescription">
                            <form id="form-prescription">
                                @csrf
                                <input type="hidden" name="patient_id" value="{{$patientrequest->patient->id??''}}">
                                <input type="hidden" name="patient_call_request_id" value="{{$patientrequest->id??''}}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Weight</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" name="weight">
                                                <span class="input-group-text">KG</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Symptoms</label>
                                            <input type="text" readonly class="form-control" name="symptoms" value="{{$patientrequest->symptoms->pluck('name')->join(', ')}}">
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-12"><h6>Medicines</h6></div>
                                    <div class="col-md-12">
                                        <div class='repeater mb-4'>
                                            <div data-repeater-list="medicines" class="form-group">
                                                <div data-repeater-item class="mb-3 row">
                                                    <div class="col-md-2 col-2 mb-1">
                                                        <input type="text" name="medicine_name" class="form-control medicine"
                                                            placeholder="Medicine Name" />
                                                    </div>
                                                    <div class="col-md-2 col-2 mb-1">
                                                        <input type="text" name="quantity" class="form-control quantity" placeholder="Quantity" />
                                                    </div>
                                                    <div class="col-md-2 col-2 mb-1">
                                                        <input type="text" name="strength" class="form-control" placeholder="Strength" />
                                                    </div>
                                                    <div class="col-md-2 col-2 mb-1">
                                                        <input type="text" name="dosage" class="form-control dosage" placeholder="Dosage" />
                                                    </div>
                                                    <div class="col-md-2 col-2 mb-1">
                                                        <input type="text" name="duration" class="form-control duration" placeholder="Duration" />
                                                    </div>
                                                    <div class="col-md-2 col-2 mb-1">
                                                        <input type="text" name="preparation" class="form-control preparation" placeholder="Preparation" />
                                                    </div>
                                                    <div class="col-md-2 col-2 mb-1">
                                                        <input type="text" name="direction" class="form-control direction" placeholder="Direction" />
                                                    </div>
                                                    <div class="col-md-2 col-2 mb-1">
                                                        <textarea type="text" name="note" class="form-control" placeholder="Notes..." rows="1"></textarea>
                                                    </div>
                                                    <div class="col-md-1 col-1 mb-1">
                                                        <a data-repeater-delete href="javascript::void(0);" class="btn bg-danger-light trash"><i class="far fa-trash-alt"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <button data-repeater-create type="button" class="btn btn-outline-primary btn-sm"><i class="fas fa-plus-circle"></i> Add Medicine</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Diagnosis</label>
                                            <textarea class="form-control" name="diagnosis"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea class="form-control" name="description"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Submit <i class="fa fa-spinner fa-spin Aspinner d-none"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- ./end prescription -->
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="card-title">Prescription</h5>
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
                                            <th>Patient</th>
                                            <!-- <th>Diagnosis</th> -->
                                            <th>Symptom</th>
                                            <th>Date</th>
                                            <th>Doctor</th>
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
        <div class="col-md-4">
            <div class="call-wrapper">
                <div class="call-main-row">
                    <div class="call-main-wrapper">
                        <div class="call-view">
                            <div class="call-window">

                                <div class="fixed-header">
                                    <div class="navbar">
                                        <div class="user-details me-auto">
                                            <div class="float-start user-img">
                                                <a class="avatar avatar-sm me-2" href="#" title="{{$patientrequest->doctor->name}}">
                                                <img src="{{$patientrequest->doctor->profile->image??'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y'}}" alt="{{$patientrequest->doctor->name}}" class="rounded-circle">
                                                <span class="status online"></span>
                                                </a>
                                            </div>
                                            <div class="user-info float-start">
                                                <a href="#"><span>Dr. {{$patientrequest->doctor->name}}</span></a>
                                                <span class="last-seen">{{$Status}}</span>
                                            </div>
                                        </div>
                                        {{--<ul class="nav float-end custom-menu">
                                            <li class="nav-item dropdown dropdown-action">
                                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-cog"></i></a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                <a href="javascript:void(0)" class="dropdown-item">Settings</a>
                                                </div>
                                            </li>
                                        </ul>--}}
                                        @if($Status == 'Active') 
                                            @if($patientrequest->status == 0 || $patientrequest->status == 1 || $patientrequest->status == 4)
                                            
                                             <select name="call_status" class="form-control w-25">
        										<option value="">--Status--</option>
        										@forelse([2=>"COMPLETED", 4=>"Didn't Connect"] as $key=>$items)
        										<option value="{{$key}}">{{$items}}</option>
        										@empty
        										@endforelse
    										</select> 
                                            @elseif($patientrequest->status == 4)
                                                <span class="badge badge-danger">Didn't Connect</span>                                            
                                            @else
                                                <span class="badge badge-info">COMPLETED</span>
                                            @endif
                                        @endif
                                    </div>
                                </div>


                                <div class="call-contents">
                                    <div class="call-content-wrap">
                                        <div class="voice-call-avatar">
                                            <img src="{{$patientrequest->patient->image??'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y'}}" alt="{{$patientrequest->patient->name??'NA'}}" class="call-avatar">
                                            <span class="username">{{$patientrequest->patient->name??''}}</span>
                                            <span class="call-timing-count"></span>
                                            <div id="localVideo" class="d-none"></div>
                                            <div id="remoteVideo" class="d-none"></div>
                                            <div id="publishVideo" class="d-none"></div>
                                        </div>
                                        <div class="call-users">
                                            <ul>
                                                <li>
                                                    <a href="#">
                                                    <img src="{{$patientrequest->patient->image??'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y'}}" class="img-fluid" alt="{{$patientrequest->patient->name??''}}">
                                                    <span class="call-mute"><i class="fa fa-microphone-slash"></i></span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>


                                <div class="call-footer">
                                    <div class="call-icons">
                                        <ul class="call-items">
                                            <!-- <li class="call-item">
                                            <a href="#" title="Enable Video" data-placement="top" data-bs-toggle="tooltip">
                                            <i class="fas fa-video camera"></i>
                                            </a>
                                            </li>-->
@if($Status == 'Active')                                     
    <li class="call-item">
        <a href="#" class="add-call {{$patientrequest->status == 2 ? 'disabled':''}}" title="Enable Call" data-placement="top" data-bs-toggle="tooltip">
        <i class="fas fa-phone-alt camera" style="color: green"></i>
        </a>
    </li>
     {{-- <li class="call-item">
                                                <a href="#" class="audio-invite" title="invite" data-placement="top" data-bs-toggle="tooltip">
                                                    <i class="fa fa-microphone microphone"></i>
                                                    </a>
                                            </li> --}}
    <li class="call-item">
        <a href="#" class="audio-mute {{$patientrequest->status == 2 ? 'disabled':''}}" title="Mute" data-placement="top" data-bs-toggle="tooltip">
        <i class="fa fa-microphone microphone"></i>
        </a>
    </li>
    <li class="call-item d-none">
        <a href="#" title="Add User {{$patientrequest->status == 2 ? 'disabled':''}}" data-placement="top" data-bs-toggle="tooltip">
        <i class="fa fa-user-plus"></i>
        </a>
    </li>
    </ul>
    @if($patientrequest->status != 2)
    <div class="end-call">
        <a href="javascript:void(0);">
        <i class="material-icons">call_end</i>
        </a>
    </div>
    @endif

@else
<span class="badge badge-danger">Make Yourself Online</span>
@endif
                                 
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@stop
@push('styles')
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/toastr/css/toastr.min.css') }}">
@endpush
@push('scripts')
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js" integrity="sha512-foIijUdV0fR0Zew7vmw98E6mOWd9gkGWQBWaoA1EOFAx+pY+N8FmmtIYAVj64R98KeD2wzZh1aHK0JSpKmRH8w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script src="{{ asset('assets/toastr/js/toastr.min.js') }}" type="text/javascript"></script>
<script>
$(document).ready(function() {
    localStorage.removeItem("roomID");    
    localStorage.removeItem("token");
    localStorage.removeItem("latitude");
    localStorage.removeItem("longitude");
    var userLocation = navigator.geolocation;
    if(userLocation) {
        userLocation.getCurrentPosition(success);               
    } 
    setTimeout(function() {
        var latitude= localStorage.getItem("latitude");
        var longitude= localStorage.getItem("longitude");
        if(!latitude && !longitude){
            Swal.fire('Please allow location');
            return false;
        }
    }, 700);//700ms     
});



$(function(){
    $('.repeater').repeater({
        initEmpty: false,
        defaultValues: {
            'text-input': ''
        },
        show: function show() {
            $(this).slideDown();
        },
        hide: function hide(deleteElement) {
            $(this).slideUp(deleteElement);
        },
        ready: function ready(setIndexes) {},
        isFirstItemUndeletable: true
    });
    $.summernote.dom.emptyPara = "";
    $('textarea[name="diagnosis"], textarea[name="description"]').summernote({
        //placeholder: 'Advice',
        tabsize: 1,
        height: 50,
        toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        //['insert', ['link', 'picture', 'video']],
        //['view', ['fullscreen', 'codeview', 'help']]
        ]
    });
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
            "url": "{{ route('doctor.prescription.index') }}",
            "type": "GET",
            "data": function(data){
                data._token="{!! csrf_token() !!}";
                data.patient_id="{{ $patientrequest->patient->id??'' }}";
            },
        },
        "columns": [
            { "data": 'prescription_id',"name":'prescription_id','orderable': false, 'searchable': false,'width':'5%'},
            { "data": "patient.name","name":"patient.name",defaultContent:''},
            // { "data": "diagnosis","name":"diagnosis"},
            { "data": "symptom","name":"symptom"},
            { "data": "date","name":"date"},
            { "data": "doctor.name","name":"doctor.name",defaultContent:'NA'},
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
						let image=(row.patient && row.patient.image)?row.patient.image:'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y';
						let gender=(row.patient && row.patient.gender)?row.patient.gender:'';
						let age=(row.patient && row.patient.age)?row.patient.age:'';
                        let profile='<span class="text-muted">';
                        if(gender){
                            profile+=gender;
                        }
                        if(age){
                            profile+=', '+age;
                        }
                        profile+='</span>';
                        return '<h2 class="table-avatar">'
                        +'<a href="{{route("doctor.prescription.index")}}/'+row.prescription_id+'"><img class="avatar avatar-img" src="'+image+'" alt=""></a>'
                        +'<a href="{{route("doctor.prescription.index")}}/'+row.prescription_id+'"><span class="user-name">'+data+'</span> '+profile+'</a>'
                        +'</h2>';
                    }
                    return data;
                },
                "targets":1,
            },
            {render: function (data, type, row, meta) {
                    if(data.length>0){
                        return data.map(function(v,i){
                            return '<span class="badge bg-info text-light">'+v.symptom+'</span>';
                        }).join(' ');
                    }
                    return data;
                },
                "targets":2,
            },
			{render: function (data, type, row, meta) {
                    if(data){
						let image=(row.doctor && row.doctor.profile && row.doctor.profile.image)?row.doctor.profile.image:'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y';
						let gender=(row.doctor && row.doctor.profile && row.doctor.profile.gender)?row.doctor.profile.gender:'';
						let age=(row.doctor && row.doctor.profile && row.doctor.profile.age)?row.doctor.profile.age+' Year':'';
                        let profile='<span class="text-muted">';
                        if(gender){
                            profile+=gender;
                        }
                        if(age){
                            profile+=', '+age;
                        }
                        profile+='</span>';
                        return '<h2 class="table-avatar">'
                        +'<a href="{{route("doctor.prescription.index")}}/'+row.prescription_id+'"><img class="avatar avatar-img" src="'+image+'" alt=""></a>'
                        +'<a href="{{route("doctor.prescription.index")}}/'+row.prescription_id+'"><span class="user-name">'+data+'</span> '+profile+'</a>'
                        +'</h2>';
                    }
                    return data;
                },
                "targets":-2,
            },
        ],
        "aaSorting": [],
        "order": [[0, 'desc']],
        initComplete: (settings, json) => {
            $('.dataTables_paginate').appendTo('#tablepagination');
            $('.dataTables_filter').appendTo('#tableSearch');
        },
    });
    //add prescription
    $('.add-prescription').on('click',function(e){
        e.preventDefault();
    });

    $('#form-prescription').on('submit',function(e){
        e.preventDefault();
        $('.Aspinner').removeClass('d-none');       
        $.ajax({
            type:'post',
            url:'{{route("doctor.prescription.store")}}',
            data:$(this).serialize()+"&appointment_id="+"{{$patientrequest->id}}",
            success:function(data){
                if(data.success){
                    toastr.success("", data.message, {
                            timeOut: 5000,closeButton: !0,
                            debug: !1,newestOnTop: !0,
                            progressBar: !0,positionClass: "toast-top-right",
                            preventDuplicates: !0,onclick: null,
                            showDuration: "300",hideDuration: "1000",
                            extendedTimeOut: "1000",showEasing: "swing",
                            hideEasing: "linear",showMethod: "fadeIn",
                            hideMethod: "fadeOut",tapToDismiss: !1
                        })
                    $('#form-prescription')[0].reset();
                    $('textarea[name="diagnosis"]').summernote('reset');
                    $('textarea[name="description"]').summernote('reset');
                    $('.Aspinner').addClass('d-none');       
                    table.ajax.reload();
                    $('[data-repeater-item]').slice(1).remove();
                }
                else{
                    $('.Aspinner').addClass('d-none');       
                    
                    toastr.error("",  data.message, {
                            positionClass: "toast-top-right",timeOut: 5000,
                            closeButton: !0,debug: !1,newestOnTop: !0,
                            progressBar: !0,preventDuplicates: !0,onclick: null,
                            showDuration: "300",hideDuration: "1000",
                            extendedTimeOut: "1000",showEasing: "swing",
                            hideEasing: "linear",showMethod: "fadeIn",
                            hideMethod: "fadeOut",tapToDismiss: !1
                        })

                }
            }
        });
    });    
});
</script>
<script src="{{ asset('assets/plugins/zegocloud/dist_js/ZegoExpressWebRTC-2.22.0.js') }}"></script>
<script>
//sample from 
//https://github.com/zegoim/express-demo-web/blob/master/src/Examples/QuickStart/VideoTalk/index.js    
/**
 *https://www.zegocloud.com/blog/voice-call 
*/
$(function(){
    let appID = parseInt("{{$options['ZEGO_APP_ID']}}");
    let server = "{{$options['ZEGO_SERVER_KEY']}}";
let userID = localStorage.getItem("userID") ? localStorage.getItem("userID") : "{{\Str::slug($patientrequest->patient->name??'NA').'_'.$patientrequest->patient->mobile??'NA'}}";
    
    let roomID = localStorage.getItem("roomID") ? localStorage.getItem("roomID") : "{{ random_int(100000, 999999) }}";
    let token = parseInt(localStorage.getItem("token") ? localStorage.getItem("token") : '');
    let streamID = 'web_' + new Date().getTime();
    let remoteStreamID = null;
    let deviceID="{{$patientrequest->patient->device->device_id}}";
    let appointment_id = "{{$patientrequest->id}}";
    let zg = null;
    let isChecked = false;
    let isLogin = false;
    let localStream = null;
    let remoteStream = null;
    let published = false;
    let videoCodec = localStorage.getItem('VideoCodec') === 'H.264' ? 'H264' : 'VP8';

    function createZegoExpressEngine() {
        zg = new ZegoExpressEngine(appID, server);
        window.zg = zg;
    }
    // Step1 Check system requirements
    async function checkSystemRequirements() {
        //console.log('sdk version is', zg.getVersion());
        try {
            const result = await zg.checkSystemRequirements();

            // console.warn('checkSystemRequirements ', result);

            if (!result.webRTC) {
                // console.error('browser is not support webrtc!!');
                return false;
            } else if (!result.videoCodec.H264 && !result.videoCodec.VP8) {
                // console.error('browser is not support H264 and VP8');
                return false;
            } else if (!result.camera && !result.microphone) {
                // console.error('camera and microphones not allowed to use');
                return false;
            } else if (result.videoCodec.VP8) {
                if (!result.screenSharing){ 
                    // console.warn('browser is not support screenSharing');
                }
            } else {
                // console.log('VP8 is not supported, please go to the mixed stream transcoding test');
            }
            return true;
        } catch (err) {
            // console.error('checkSystemRequirements', err);
            return false;
        }
    }
    function initEvent() {
        zg.on('roomStateUpdate', (roomId, state) => {
            if (state === 'CONNECTED') {
                $('.call-timing-count').empty().text('CONNECTED');
            }
            if (state == 'CONNECTING') {
                $('.call-timing-count').empty().text('CONNECTING');
            }
            if (state === 'DISCONNECTED') {
                $('.call-timing-count').empty().text('DISCONNECTED');

            }
            //updateStatus(state);
            // console.log('****************************************');
            // console.log(state);
            // console.log('****************************************');
        })
        zg.on('publisherStateUpdate', (result) => {
            if (result.state === 'PUBLISHING') {
                //$('.call-timing-count').empty().text(result.streamID);
            } else if (result.state === 'NO_PUBLISH') {
                //$('.call-timing-count').empty().text(result.state);//.text('');
            }
        });
        zg.on('playerStateUpdate', (result) => {
            if (result.state === 'PLAYING') {
                //$('.call-timing-count').empty().text(result.streamID);
            } else if (result.state === 'NO_PLAY') {
                //$('.call-timing-count').empty().text(result.state);//.text('');
            }
        });
        zg.on('roomStreamUpdate', async (roomID, updateType, streamList, extendedData) => {
            // streams added
            if (updateType === 'ADD') {
                const addStream = streamList[streamList.length - 1]
                if (addStream && addStream.streamID) {
                    // play the last stream
                    if (remoteStreamID) {
                        zg.stopPlayingStream(remoteStreamID)
                    }
                    remoteStreamID = addStream.streamID
                    $('#PlayUserID').text(addStream.user.userID)
                    remoteStream = await zg.startPlayingStream(remoteStreamID)

                    if (zg.getVersion() < "2.17.0") {
                        $('#playVideo').srcObject = remoteStream;
                        //playVideoEl.show();
                        $('#playVideo').show()
                        $('#remoteVideo').hide()
                    } else {
                        const remoteView = zg.createRemoteStreamView(remoteStream);
                        remoteView.play("remoteVideo", {
                            objectFit: "cover",
                            enableAutoplayDialog: true,
                        })
                        //playVideoEl.show();
                        $('#playVideo').hide()
                        $('#remoteVideo').show()
                    }
                }
            } else if (updateType == 'DELETE') {
                //  del stream
                const delStream = streamList[streamList.length - 1]
                if (delStream && delStream.streamID) {
                    if (delStream.streamID === remoteStreamID) {
                        zg.stopPlayingStream(remoteStreamID)
                        remoteStreamID = null
                        //playVideoEl.hide();
                        logoutRoom(roomID);
                    }
                }
            }
            // console.log('****************************************');
            // console.log(updateType);
            // console.log('****************************************');
            
        });
    
    }
    async function getToken(){
        $.ajax({
            url: "",
            async: false, 
            dataType: "json",
            data:{userID:userID,roomID:roomID}
        })
        .done(function(data) {
            token=data;
            localStorage.setItem("token", token);
        });
    }
    async function sendNotification(){
        $.ajax({
            type:'get',
            url:'',
            data:{type:'notification','meeting_id':roomID,appointment_id:appointment_id,
                            'latitude':localStorage.getItem("latitude"),
                            'longitude':localStorage.getItem("longitude")},
            success:function(data){
                // console.log(data);
            }
        });
    }


    function setLogConfig() {
        let config = localStorage.getItem('logConfig');
        const DebugVerbose =false;// localStorage.getItem('DebugVerbose') === 'true' ? true : false;
        if (config) {
            config = JSON.parse(config);
            zg.setLogConfig({
                logLevel: 'disable',//config.logLevel,
                remoteLogLevel: 'disable',//config.remoteLogLevel,
                logURL: ''
            });
        }
        zg.setDebugVerbose(DebugVerbose);
    }

    //  Login room
    async function loginRoom(roomId, userId, userName) {
        return new Promise(async (resolve, reject) => {
            // Need to get the token before logging in to the room
            localStorage.setItem('roomID', roomID);
            localStorage.setItem("userID", userID);
            localStorage.setItem("token", token);
            try {
                await zg.loginRoom(roomId, token, {
                    userID: userId,
                    userName
                });
                resolve();
            } catch (err) {
                reject();
            }
        });
    }
    // Logout room
    function logoutRoom(roomId) {
        zg.logoutRoom(roomId);
    }
    //update status
    function updateStatus(status){
        $.ajax({
            type:'get',
            url:'',
            data:{type:'call_log','meeting_id':roomID,'status':status},
            success:function(data){
                // console.log(data);
            }
        });
    }
    //  Start Publishing Stream
    async function startPublishingStream(streamId, config) {
        try {
            localStream = await zg.createStream(config);
            zg.startPublishingStream(streamId, localStream, { videoCodec });
            if (zg.getVersion() < "2.17.0") {
                $('#publishVideo')[0].srcObject = localStream;
                $('#publishVideo').show()
                $('#localVideo').hide()
            } else {
                const localView = zg.createLocalStreamView(localStream);
                localView.play("localVideo", {
                    mirror: true,
                    objectFit: "cover",
                    enableAutoplayDialog: true,
                })
                $('#publishVideo').hide()
                $('#localVideo').show()
            }
            return true;
        } catch (err) {
            return false;
        }
    }
    function stopPublishingStream(streamId) {
        zg.stopPublishingStream(streamId);
        zg.destroyStream(localStream)
        localStream = null
    }

    async function render() {
        createZegoExpressEngine();
        await checkSystemRequirements();
        if(!token){
            await getToken();
        }
        initEvent();
        setLogConfig();
    }
    render();
    //send call
    $('.add-call').on('click',async function(e){
        e.preventDefault();
        $(this).addClass('btn-success text-light');
        $('.call-timing-count').text('Connecting...');
        if (!isLogin) {
            try{
                isLogin = true;
                await loginRoom(roomID, userID, userID);
                await sendNotification();
                const flag = await startPublishingStream(streamID, { camera: {audio:true,video:false} });
                //const localStream = await zg.createStream({camera :{audio:true,video:false}});
                published = true;                
                $('.add-call').addClass('disabled');
            }
            catch(err){
                isLogin = false;
                throw err;
            }
        }
        else{
            isLogin = false;
            logoutRoom(roomID);
        }       
    });

    //end call 
    $('.end-call').on('click',function(e){
        if(isLogin){
            e.preventDefault();
            logoutRoom(roomID);
            isLogin=false;
            $('.add-call').removeClass('btn-success text-light disabled');
            $('.call-timing-count').text('Disconnected');
            // $.ajax({
            //     type:'post',
            //     url:'{{url("doctor/appointment/end/call")}}',
            //     data:{_token:"{!! csrf_token() !!}",'meeting_id':roomID,appointment_id:appointment_id,
            //                     'latitude':localStorage.getItem("latitude"),
            //                     'longitude':localStorage.getItem("longitude")},
            //     success:function(data){
            //        Swal.fire('Successful!','Appointment Call Completed.','success')
            //          location.reload();
            //     },
            //     error: function (jqXHR, textStatus, errorThrown) {
            //         var data=$.parseJSON(jqXHR.responseText);
            //         Swal.fire('Error!','Failed','error')
            //     }
            // });
        }        
    });

    $('select[name="call_status"]').on('change',function(e){
        if(this.value == 4){//if 4 then call other url
            var url= '{{url("doctor/appointment/not/pickup")}}';
            var status = "Status";
            var text = "Call didn't connect!";
        }else if(this.value == 2){
            var url = '{{url("doctor/appointment/status/complete")}}'
            var status = "Status";
            var text = "Do you want to complete this call!";
        }else{
            return false;
        }
        e.preventDefault();
        Swal.fire({
        title: status,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type:'post',
                    url:url,
                    data:{type:'status',status:$(this).val(),_method:'post',_token:'{{csrf_token(),}}','appointment_id':"{{$patientrequest->id}}",
                            'latitude':localStorage.getItem("latitude"),
                            'longitude':localStorage.getItem("longitude"),
                            "meeting_id":localStorage.getItem("roomID")},
                    success:function(data){
                         Swal.fire('Successful!',data.message,'success')
                         location.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        var data=$.parseJSON(jqXHR.responseText);
                        console.log(data);
                        Swal.fire('Error!','Failed','error')
                    }
                });
            }else{
                 
            }
        })//end of swal
    });

    $('.audio-mute').on('click',function(e){
        e.preventDefault();
        if( $("video").prop('muted') ) {
            $("video").prop('muted', false);
        } else {
            $("video").prop('muted', true);
        }        
    });
});


function success(data) {
            let lat = data.coords.latitude;
            let long = data.coords.longitude;
            localStorage.setItem("latitude", lat);
            localStorage.setItem("longitude", long);
            return true;
        }
</script>
@endpush
