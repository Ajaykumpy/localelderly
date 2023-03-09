@extends('admin.layouts.default')
@section('title', 'Admin - Video Call')
@section('content')
<div class="content container-fluid">

<div class="call-wrapper">
<div class="call-main-row">
<div class="call-main-wrapper">
<div class="call-view">
<div class="call-window">

<div class="fixed-header">
<div class="navbar">
<div class="user-details me-auto">
<div class="float-start user-img">
<a class="avatar avatar-sm me-2" href="patient-profile.html" title="{{$patientrequest->patient->name}}">
<img src="{{$patientrequest->patient->image}}" alt="{{$patientrequest->patient->name}}" class="rounded-circle">
<span class="status online"></span>
</a>
</div>
<div class="user-info float-start">
<a href="patient-profile.html"><span>{{$patientrequest->patient->name}}</span></a>
<span class="last-seen">Online</span>
</div>
</div>
<ul class="nav float-end custom-menu">
<li class="nav-item dropdown dropdown-action">
<a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-cog"></i></a>
<div class="dropdown-menu dropdown-menu-end">
<a href="javascript:void(0)" class="dropdown-item">Settings</a>
</div>
</li>
</ul>
</div>
</div>


<div class="call-contents">
<div class="call-content-wrap">
<div class="voice-call-avatar">
<img src="{{$patientrequest->doctor->profile->image??'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y'}}" alt="{{$patientrequest->doctor->name}}" class="call-avatar">
<span class="username">Dr. {{$patientrequest->doctor->name}}</span>
<span class="call-timing-count"></span>
</div>
<div class="call-users">
<ul>
<li>
<a href="#">
<img src="{{$patientrequest->patient->image}}" class="img-fluid" alt="{{$patientrequest->patient->name}}">
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
<li class="call-item">
<a href="#" class="add-call" title="Enable Call" data-placement="top" data-bs-toggle="tooltip">
<i class="fas fa-phone-alt camera"></i>
</a>
</li>
<li class="call-item">
<a href="#" title="Mute" data-placement="top" data-bs-toggle="tooltip">
<i class="fa fa-microphone microphone"></i>
</a>
</li>
<li class="call-item d-none">
<a href="#" title="Add User" data-placement="top" data-bs-toggle="tooltip">
<i class="fa fa-user-plus"></i>
</a>
</li>
</ul>
<div class="end-call">
<a href="javascript:void(0);">
<i class="material-icons">call_end</i>
</a>
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
@push('scripts')
<script src="{{ asset('assets/plugins/zegocloud/dist_js/ZegoExpressWebRTC-2.22.0.js') }}"></script>
<script>
//sample from
//https://github.com/zegoim/express-demo-web/blob/master/src/Examples/QuickStart/VideoTalk/index.js
//$(function(){
    let appID = {{env('ZEGO_APP_ID')}};
    let server = "{{env('ZEGO_SERVER_KEY')}}";

    let userID = localStorage.getItem("userID") ? localStorage.getItem("userID") : {{$patientrequest->patient->mobile}};//Util.getBrow() + '_' + new Date().getTime();
    let roomID = localStorage.getItem("roomID") ? localStorage.getItem("roomID") : new Date().getTime();
    let token = localStorage.getItem("token") ? localStorage.getItem("token") : '';
    let streamID = 'web_' + new Date().getTime();
    let remoteStreamID = null;
    let deviceID="{{$patientrequest->patient->device->device_id}}";

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
        console.log('sdk version is', zg.getVersion());
        try {
            const result = await zg.checkSystemRequirements();

            console.warn('checkSystemRequirements ', result);

            if (!result.webRTC) {
                console.error('browser is not support webrtc!!');
                return false;
            } else if (!result.videoCodec.H264 && !result.videoCodec.VP8) {
                console.error('browser is not support H264 and VP8');
                return false;
            } else if (!result.camera && !result.microphone) {
                console.error('camera and microphones not allowed to use');
                return false;
            } else if (result.videoCodec.VP8) {
                if (!result.screenSharing) console.warn('browser is not support screenSharing');
            } else {
                console.log('system check passed');
            }
            return true;
        } catch (err) {
            console.error('checkSystemRequirements', err);
            return false;
        }
    }

    function initEvent() {
        zg.on('roomStateUpdate', (roomId, state) => {

        });


    }
    function setLogConfig() {
        let config = localStorage.getItem('logConfig');
        const DebugVerbose = localStorage.getItem('DebugVerbose') === 'true' ? true : false;
        if (config) {
            config = JSON.parse(config);
            zg.setLogConfig({
                logLevel: config.logLevel,
                remoteLogLevel: config.remoteLogLevel,
                logURL: ''
            });
        }
        zg.setDebugVerbose(DebugVerbose);
    }

    //  Login room
    async function loginRoom(roomId, userId, userName) {

        return new Promise(async (resolve, reject) => {
            // Need to get the token before logging in to the room
            let token = $("#Token").val()
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
        })
    }

    // Logout room
    function logoutRoom(roomId) {
        localStream && stopPublishingStream($('#PublishID').val());
        zg.logoutRoom(roomId);
    }
    //send call
    $('.add-call').on('click',function(e){
        e.preventDefault();
        $(this).addClass('btn-success text-light');
        $('.call-timing-count').text('Connecting...');
        $.ajax({
            type:'get',
            url:'',
            data:{type:'notification'},
            success:function(data){
                console.log(data);
            }
        });
    });


    function updateButton(button, preText, afterText) {

    }

    async function render() {
        createZegoExpressEngine();
        await checkSystemRequirements();
        initEvent();
    }
    render();

//});
</script>
@endpush
