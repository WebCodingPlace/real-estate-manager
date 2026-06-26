jQuery(document).ready(function($){
$('.map-home').each(function(){

function add_marker_in_map(locations, lat, lng){
	/* ===================================================================== */

	$typeTarget = $('#property-type a[data-type="'+locations.propertyType+'"] strong');
	$valueProperty = parseInt($typeTarget.text(), 10);
	$typeTarget.text($valueProperty+1);

	marker = new google.maps.Marker({
	 position: new google.maps.LatLng(lat, lng),
	 map: map,
	 animation: google.maps.Animation.DROP,
	 icon: locations.icon_url,
	 propertyType: locations.propertyType
	});

	/* ===================================================================== */

	google.maps.event.addListener(marker, 'mouseover', function() {
		this.setIcon(locations.icon_url_hover);
	});
	google.maps.event.addListener(marker, 'mouseout', function() {
		this.setIcon(locations.icon_url);
	});

	// ADD MARKER TO MAPS
	window['markers_'+map_id].push(marker);
	google.maps.event.addListener(marker, 'click', (function(marker, i) {

		return function() {

			$('.infoBox').fadeOut(300);
			box = locations.property_box;
			// console.log(locations);

			infobox = new InfoBox({
				content: box,
				disableAutoPan: false,
				maxWidth: 150,
				pixelOffset: new google.maps.Size(-160, -382),
				zIndex: null,
				position: new google.maps.LatLng(lat, lng),
				boxStyle: {
					width: "330px"
				},
				closeBoxMargin: "0",
				closeBoxURL: mapsData.theme_path+"/images/maps/close.png",
				infoBoxClearance: new google.maps.Size(1, 1)
			});
			infobox.open(map, marker);
			
			map.panTo(marker.getPosition());
		}

	})(marker, i));
}	
	// CFD Note: ID is now on the <SECTION> tag, upward in the DOM list.
	//var map_id = $(this).attr("id");
	var map_id = $(this).closest("section").attr("id");

	// Because of multiple maps on one page, each one SHOULD have a unique ID. We'll base our data on that unique ID
	var mapsData = window['mapsData_' + map_id];
	
   	//var map = new google.maps.Map(document.getElementById(map_id), {
	var map = new google.maps.Map($('#'+map_id).find(".map.map-home")[0], {
	   scrollwheel: false,
	   disableDefaultUI: true,
       mapTypeId: google.maps.MapTypeId.ROADMAP,
		styles: (mapsData.maps_styles != '') ? JSON.parse(mapsData.maps_styles) : [
					{
						"featureType": "landscape.natural",
						"elementType": "geometry.fill",
						"stylers": [
							{
								"visibility": "on"
							},
							{
								"color": mapsData.fill_color
							}
						]
					},
					{
						"featureType": "poi",
						"elementType": "all",
						"stylers": [
							{
								"visibility": "off"
							}
						]
					},
					{
						"featureType": "poi",
						"elementType": "geometry.fill",
						"stylers": [
							{
								"visibility": "on"
							},
							{
								"hue": mapsData.poi_color_hue
							},
							{
								"color": mapsData.poi_color
							}
						]
					},
					{
						"featureType": "road",
						"elementType": "geometry",
						"stylers": [
							{
								"lightness": mapsData.roads_lightness
							},
							{
								"visibility": "simplified"
							}
						]
					},
					{
						"featureType": "road",
						"elementType": "labels",
						"stylers": [
							{
								"visibility": "on"
							}
						]
					},
					{
						"featureType": "transit",
						"elementType": "labels",
						"stylers": [
							{
								"visibility": "off"
							}
						]
					},
					{
						"featureType": "transit.line",
						"elementType": "geometry",
						"stylers": [
							{
								"visibility": "on"
							},
							{
								"lightness": mapsData.lines_lightness
							}
						]
					},
					{
						"featureType": "water",
						"elementType": "all",
						"stylers": [
							{
								"color": mapsData.water_color
							}
						]
					}
				]

    });

	currentMarker = 0;

	function setMyPosition(){
		if(!!navigator.geolocation) {
		
			navigator.geolocation.getCurrentPosition(function(position) {
			
				var geolocate = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
			    var marker = new google.maps.Marker({
						 position: geolocate,
						 animation: google.maps.Animation.DROP,
						 map: map,
						 title: mapsData.my_pos_text,
						 icon: mapsData.my_location_icon,
						 zIndex: 999999999
					 });
					 map.setCenter(geolocate);

			});

		} else {
			alert('No Geolocation Support.');
		}
    
	}

	function nextAds(){

		currentMarker++;
		

		if (currentMarker>totalMarkers){
			currentMarker=1;
		}

		while(window['markers_'+map_id][currentMarker-1].visible===false){
			currentMarker++; 
			if (currentMarker>totalMarkers){
				currentMarker=1;
			}
		}

		map.panTo(window['markers_'+map_id][currentMarker-1].getPosition());
		google.maps.event.trigger(window['markers_'+map_id][currentMarker-1], 'click');

	}

	function prevAds(){

		currentMarker--;
		

		if (currentMarker<1){
			currentMarker=totalMarkers;
		}

		while(window['markers_'+map_id][currentMarker-1].visible===false){
			currentMarker--; 
			if (currentMarker>totalMarkers){
				currentMarker=1;
			}
		}

		map.panTo(window['markers_'+map_id][currentMarker-1].getPosition());
		google.maps.event.trigger(window['markers_'+map_id][currentMarker-1], 'click');

	}

	function ControlSet(leftControlSet, rightControlSet, map) {

		// SET CSS FOR THE ZOOMIN
		var zoomInButton = document.createElement('div');
		zoomInElement = document.createAttribute("class");
		zoomInElement.value = "zoom-in";
		zoomInButton.setAttributeNode(zoomInElement);

		// SET CSS FOR THE ZOOMOUT
		var zoomOutButton = document.createElement('div');
		zoomOutElement = document.createAttribute("class");
		zoomOutElement.value = "zoom-out";
		zoomOutButton.setAttributeNode(zoomOutElement);

		// SET CSS FOR THE CONTROLL POSITION
		var positionButton = document.createElement('div');
		controlPositionWrapper = document.createAttribute("class");
		controlPositionWrapper.value = "set-position";
		positionButton.setAttributeNode(controlPositionWrapper);

		// SET CSS FOR THE CONTROLL POSITION
		var nextButton = document.createElement('div');
		controlPositionWrapper = document.createAttribute("class");
		controlPositionWrapper.value = "next-ads";
		nextButton.setAttributeNode(controlPositionWrapper);

		// SET CSS FOR THE CONTROLL POSITION
		var prevButton = document.createElement('div');
		controlPositionWrapper = document.createAttribute("class");
		controlPositionWrapper.value = "prev-ads";
		prevButton.setAttributeNode(controlPositionWrapper);

		// APPEND ELEMENTS
		leftControlSet.appendChild(zoomInButton);
		leftControlSet.appendChild(zoomOutButton);
		leftControlSet.appendChild(positionButton);
		rightControlSet.appendChild(prevButton);
		rightControlSet.appendChild(nextButton);

		// SETUP THE CLICK EVENT LISTENER - ZOOMIN
		google.maps.event.addDomListener(zoomInButton, 'click', function() {
			map.getZoom() <= 16 ? map.setZoom(map.getZoom() + 1) : null ;
			
		});

		// SETUP THE CLICK EVENT LISTENER - ZOOMOUT
		google.maps.event.addDomListener(zoomOutButton, 'click', function() {
			map.getZoom() >= 4 ? map.setZoom(map.getZoom() - 1) : null ;
			
		});

		// SETUP THE CLICK EVENT LISTENER - POSITION
		google.maps.event.addDomListener(positionButton, 'click', function() {
			return setMyPosition();
			
		});

		// SETUP THE CLICK EVENT LISTENER - PREVIOUS ADS
		google.maps.event.addDomListener(prevButton, 'click', function() {
			return prevAds();
		});

		// SETUP THE CLICK EVENT LISTENER - NEXT ADS
		google.maps.event.addDomListener(nextButton, 'click', function() {
			return nextAds();
		});

	}

  // CREATE THE DIV TO HOLD THE CONTROL AND CALL THE CONTROLSET() CONSTRUCTOR
  // PASSING IN THIS DIV.

	var leftControlSet = document.createElement('div');
	leftWrapperClass = document.createAttribute("class");
	leftWrapperClass.value = "control-left-wrapper";
	leftControlSet.setAttributeNode(leftWrapperClass);

	var rightControlSet = document.createElement('div');
	rightWrapperClass = document.createAttribute("class");
	rightWrapperClass.value = "control-right-wrapper";
	rightControlSet.setAttributeNode(rightWrapperClass);

    map.controls[google.maps.ControlPosition.TOP_LEFT].push(leftControlSet);
    map.controls[google.maps.ControlPosition.TOP_RIGHT].push(rightControlSet);
    var ControlSet = new ControlSet(leftControlSet, rightControlSet, map);

    var marker, i;
    window['markers_'+map_id] = [];
	var markerCluster = null;

    // $.ajaxSetup({ cache: false });
	var result = jQuery('#'+map_id+' .find-result');

	function totalSearch(numResult){
		result.text(numResult + ' '+mapsData.found_text).addClass('active');
	}

	geocoder = new google.maps.Geocoder();

    $.each(mapsData.properties, function(index, locations){
    	if (locations.lat != '' && locations.lon != '') {
			add_marker_in_map(locations, locations.lat, locations.lon);
    	} else {
	    	geocoder.geocode( { 'address': locations.address }, function(results, status) {
	    	if (status == google.maps.GeocoderStatus.OK) {
	    	    var latitude = results[0].geometry.location.lat();
	    	    var longitude = results[0].geometry.location.lng();
					add_marker_in_map(locations, latitude, longitude);
					autoCenter();
	    	    }
	    	});
    	}
    });

	totalMarkers = window['markers_'+map_id].length;

	function autoCenter() {
		var totalMarkers = window['markers_'+map_id].length;

		// CREATE A NEW VIEWPOINT BOUND
		var bounds = new google.maps.LatLngBounds();

		// GO THROUGH EACH...
		for(x=0; x<totalMarkers; x++) {
			bounds.extend(window['markers_'+map_id][x].position);
		}

		// Fix too much zoom in
		google.maps.event.addListener(map, 'zoom_changed', function() {
		    zoomChangeBoundsListener = 
		        google.maps.event.addListener(map, 'bounds_changed', function(event) {
		            if (this.getZoom() > 15 && this.initialZoom == true) {
		                this.setZoom(parseInt(mapsData.zoom_level));
		                this.initialZoom = false;
		            }
		        google.maps.event.removeListener(zoomChangeBoundsListener);
		    });
		});
		map.initialZoom = true;

		// FIT THESE BOUNDS TO THE MAP
		map.fitBounds(bounds);
	}

	autoCenter();

	var markerCluster = new MarkerClusterer(map, window['markers_'+map_id], {
		gridSize: 40,
		maxZoom: 18,
		minimumClusterSize: 2,
		calculator: function( markers_list, numStyles) {
			return {
				text: markers_list.length,
				index: numStyles
			};
		}
	});

		// FILTER MARKER
		filter = [];

		$('#filtering-'+map_id).on('change', 'input[type=checkbox]', function(){

			if ($(this).prop('checked') == false) {
				$(this).prop('checked', false);
			} else {
				$(this).prop('checked', true);
			}

			

			properyClick = this.dataset.type;

			// console.log(properyClick);

			var newBounds = new google.maps.LatLngBounds();
			propertyFound = 0;

			$.inArray(properyClick, filter) == -1 ? filter.push(properyClick) 
				                                  : filter.splice(filter.indexOf(properyClick), 1) ;

			markerCluster.removeMarkers(window['markers_'+map_id], false);
			
			for(x=0; x<totalMarkers; x++) {

				if($.inArray(window['markers_'+map_id][x].propertyType, filter)>= 0){

					window['markers_'+map_id][x].setVisible(true);
					markerCluster.addMarker(window['markers_'+map_id][x], false);
					propertyFound++;

					// SET NEW POSITION MAPS
					newBounds.extend(window['markers_'+map_id][x].position);

				}else{

					window['markers_'+map_id][x].setVisible(false);
					markerCluster.removeMarker(window['markers_'+map_id][x]);

					// SET NEW POSITION MAPS
					newBounds.extend(window['markers_'+map_id][x].position);

				}
				
				totalSearch(propertyFound);

			}

			if(filter.length === 0) {

				totalSearch(totalMarkers);
				for(x=0; x<totalMarkers; x++) {

					window['markers_'+map_id][x].setVisible(true);
					markerCluster.addMarker(window['markers_'+map_id][x], false);

					// SET NEW POSITION MAPS
					newBounds.extend(window['markers_'+map_id][x].position);

				}
			}

			// SET NEW POSITION MAPS
			map.fitBounds(newBounds);
			autoCenter();
			return false;

		});

		google.maps.event.addListenerOnce(map, 'idle', function(){
			$(".loading-container").delay(3000).fadeOut();
			if (mapsData.auto_center == 'disable') {
				map.setCenter(new google.maps.LatLng( parseFloat(mapsData.def_lat), parseFloat(mapsData.def_long) ));
				map.setZoom(parseInt(mapsData.zoom_level));
			}
		});

});

});