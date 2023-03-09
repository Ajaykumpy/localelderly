@extends('admin.layouts.default')
@section('title')
Admin - Instructor
@endsection
@section('content')
{{--<div class="content container-fluid pb-0">
    <h4 class="mb-3">Overview</h4>
    <div class="row">
        <div class="col-xl-6 col-sm-6 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon bg-success">
                            <i class="feather-user-plus"></i>
                        </span>
                        <div class="dash-count">
                            <h5 class="dash-title">Appointments</h5>
                            <div class="dash-counts">
                                <p>sg</p>
                            </div>
                        </div>
                    </div>

                    
                    
                </div>
                        
        </div>  
            </div>
            <div class="col-md-6">
              <div class="card">
                <div class="card-body">
                <div class="d-flex">
                    <div class="row" styele="margin-right:15px">
                   {{-- <label class="switch mt-2">
                                    <input type="checkbox" id="onlineoffine" {{$Status == 'Active' ? 'checked' : "" }} 
                                    class="statustoggle {{ $Status == 'Active' ? 'offline' : 'gonline' }} ">
                                    <span class="slider round"></span>
                                </label>   --}}
                    
                            </div>
                    <div class="text-center mx-5" styele="margin-left:15px"> 
                        Make yourself Online/Offline <span></span><br>
                        
                    </div>
                    </div>
                
            </div>
            </div>
  
        
        
        
    </div>
</div>
    

    
</div>--}}


@stop
@push('scripts')
<script>
$(document).ready(function() {
    localStorage.removeItem("latitude");
    localStorage.removeItem("longitude");

});

        $(".gonline").click(function(){
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
                Swal.fire({
                title: 'Go Online',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type:'post',
                        url:'{!! url("doctor/internal/status/online") !!}',
                        data:{_token:'{{csrf_token()}}',_method:'post',latitude:latitude,longitude:longitude},
                        success:function(data){
                            $(".statustoggle").addClass('offline');
                            $(".statustoggle").removeClass('gonline');
                            location.reload();

                            Swal.fire('Status','You are online.','success');
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            var data=$.parseJSON(jqXHR.responseText);
                            Swal.fire('Error!',data.message,'error')
                        }
                    });


                }else{
                    document.getElementById("onlineoffine").checked = false;   
                }
                })
            }, 700);//700ms            
        });
        $(".offline").click(function(){
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
                Swal.fire({
                title: 'Go offline',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type:'post',
                        url:'{!! url("doctor/internal/status/offline") !!}',
                        data:{_token:'{{csrf_token()}}',_method:'post',latitude:latitude,longitude:longitude},
                        success:function(data){
                            $(".statustoggle").addClass('gonline');
                            $(".statustoggle").removeClass('offline');
                            location.reload();
                            Swal.fire('Status','You are offline.','success');
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            var data=$.parseJSON(jqXHR.responseText);
                            Swal.fire('Error!',data.message,'error')
                        }
                    });


                }else{
                    document.getElementById("onlineoffine").checked = false;   
                }
                })
            }, 700);//700ms            
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