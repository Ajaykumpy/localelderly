@extends('admin.layouts.default')
@section('title')
    Admin - Dashboard
@endsection
@section('content')
    <!-- content -->
    <div class="content container-fluid pb-0">
        <h4 class="mb-3">Overview</h4>
        <div class="row">
            <div class="col-xl-4 col-sm-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon bg-success">
                                <i class="feather-user-plus"></i>
                            </span>
                            <div class="dash-count">                                
                                <h5 class="dash-title">Customers</h5>                              
                                <h2 class="mb-4s text-center text-success" id="Doctors">NA</h2>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon bg-blue">
                                <i class="feather-users"></i>
                            </span>
                            <div class="dash-count">                                
                                <h5 class="dash-title">Instructors</h5>
                                <h2 class="mb-4s text-center text-success" id="Patients">NA</h2>
                               
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon bg-warning">
                                <img src="assets/img/icon/calendar.png" alt="User Image">
                            </span>
                            <div class="dash-count">                                
                                <h5 class="dash-title">Course</h5>
                                <h2 class="mb-4s text-center text-success" id="Appointment" >NA</h2>
                                
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
            
        </div>

      {{-- <div class="row">
            <div class="col-md-12">
                <div class="section-heading">
                    <h5 class="mb-0">Map Info</h5>
                </div>
            </div>
            <div class="col-md-12">
                <div id="map" class="w-100 vh-100"></div>
            </div>
        </div>--}}



    </div>
    </div>
@stop

@push('scripts')
<script type="text/javascript"src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=geometry,places&amp;ext=.js" ></script>
<script type="text/javascript" src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>

    <!-- script -->
<script>
    {{--let doctors={!! $doctors??[] !!};
	let patient_locations={!!$patient_locations??[]!!}; 
	
	function initMap() {
	   window.map = new google.maps.Map(document.getElementById('map'), {
			zoom: 10,
			center: { lat: 19.215382199425786, lng: 72.8681240973765 },
			mapTypeId: "hybrid",
			scrollwheel: true,
		});

		var infowindow = new google.maps.InfoWindow();

		var bounds = new google.maps.LatLngBounds();

		for(let i=0;i<doctors.length;i++){
			if(doctors[i].current_status){
				marker = new google.maps.Marker({
					position: new google.maps.LatLng(parseFloat(doctors[i].current_status.latitude), parseFloat(doctors[i].current_status.longitude)),
					map: map,
					icon: (doctors[i].current_status.status=="Active")?'{{asset('/uploads/icons/doctor-online.png')}}':'{{asset('/uploads/icons/doctor.png')}}',
				});

				bounds.extend(marker.position);

				google.maps.event.addListener(marker, 'click', (function (marker, i) {
					return function () {
						infowindow.setContent('Dr. '+doctors[i].name);
						infowindow.open(map, marker);
					}
				})(marker, i));
			}
		}
		//patient map
		if(patient_locations.length>0){
			for(let i=0;i<patient_locations.length;i++){
				if(patient_locations[i].properties.latitude && patient_locations[i].properties.longitude && patient_locations[i].patient){
					marker = new google.maps.Marker({
						position: new google.maps.LatLng(parseFloat(patient_locations[i].properties.latitude), parseFloat(patient_locations[i].properties.longitude)),
						map: map,
						icon: '{{asset('/uploads/icons/patient-map-marker.png')}}',
					});

					bounds.extend(marker.position);

					google.maps.event.addListener(marker, 'click', (function (marker, i) {
						return function () {
							infowindow.setContent(patient_locations[i].patient.name??'');
							infowindow.open(map, marker);
						}
					})(marker, i));
					
				}
			}
		}

		map.fitBounds(bounds);

		var listener = google.maps.event.addListener(map, "idle", function () {
			map.setZoom(25);
			google.maps.event.removeListener(listener);
		});
     
}

const locations = [
  @if($doctorlocation->count()>0)
      @foreach($doctorlocation as $latlng)
        @if($latlng['latitude']  && $latlng['longitude'])
            { lat: {!! $latlng['latitude'] !!}, lng: {!! $latlng['longitude'] !!} },
        @endif      
      @endforeach
  @endif
];

initMap();
--}}
</script>

@endpush
