jQuery(document).ready(function($){
   var map = new google.maps.Map(document.getElementById('map-canvas'), {
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
						 title: 'You are here',
						 icon: mapsData.my_location_icon,
						 zIndex: 999999999
					 });
					 map.setCenter(geolocate);

			});

		} else {

			alert('No Geolocation Support.');

		}
    
	}

	function closeSearcher() {
		// hideSearcher(true);
	}

	function nextAds(){

		currentMarker++;
		closeSearcher();

		if (currentMarker>totalMarkers){
			currentMarker=1;
		}

		while(markers[currentMarker-1].visible===false){
			currentMarker++; 
			if (currentMarker>totalMarkers){
				currentMarker=1;
			}
		}

		map.panTo(markers[currentMarker-1].getPosition());
		google.maps.event.trigger(markers[currentMarker-1], 'click');

	}

	function prevAds(){

		currentMarker--;
		closeSearcher();

		if (currentMarker<1){
			currentMarker=totalMarkers;
		}

		while(markers[currentMarker-1].visible===false){
			currentMarker--; 
			if (currentMarker>totalMarkers){
				currentMarker=1;
			}
		}

		map.panTo(markers[currentMarker-1].getPosition());
		google.maps.event.trigger(markers[currentMarker-1], 'click');

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
			closeSearcher();
		});

		// SETUP THE CLICK EVENT LISTENER - ZOOMOUT
		google.maps.event.addDomListener(zoomOutButton, 'click', function() {
			map.getZoom() >= 4 ? map.setZoom(map.getZoom() - 1) : null ;
			closeSearcher();
		});

		// SETUP THE CLICK EVENT LISTENER - POSITION
		google.maps.event.addDomListener(positionButton, 'click', function() {
			return setMyPosition();
			closeSearcher();
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
    var markers = [];
	var markerCluster = null;

    // $.ajaxSetup({ cache: false });
	var result = jQuery('.find-result');

	function totalSearch(numResult){
		result.text(numResult + ' '+mapsData.found_text).addClass('active');
	}
    // $.getJSON("./ajax/marker.json", function(data){
    	// console.log(mapsData.properties);
         $.each(mapsData.properties, function(index, locations){

			/* ===================================================================== */

			 $typeTarget = $('#property-type a[data-type="'+locations.propertyType+'"] strong');
			 $valueProperty = parseInt($typeTarget.text(), 10);
			 $typeTarget.text($valueProperty+1);
			 // console.log(mapsData);

			 marker = new google.maps.Marker({
				 position: new google.maps.LatLng(locations.lat, locations.lon),
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
			  markers.push(marker);
			  google.maps.event.addListener(marker, 'click', (function(marker, i) {

					return function() {

						$('.infoBox').fadeOut(300);
						box = locations.property_box;
						console.log(locations);

						infobox = new InfoBox({
							content: box,
							disableAutoPan: false,
							maxWidth: 150,
							pixelOffset: new google.maps.Size(-160, -382),
							zIndex: null,
							position: new google.maps.LatLng(locations.lat, locations.lon),
							boxStyle: {
								width: "330px"
							},
							closeBoxMargin: "0",
							closeBoxURL: mapsData.theme_path+"/images/maps/close.png",
							infoBoxClearance: new google.maps.Size(1, 1)
						});
						infobox.open(map, marker);
						
						map.panTo(marker.getPosition());
						closeSearcher();
					}

			  })(marker, i));

        });

		totalMarkers = markers.length;

		function autoCenter() {

			// CREATE A NEW VIEWPOINT BOUND
			var bounds = new google.maps.LatLngBounds();

			// GO THROUGH EACH...
			for(x=0; x<totalMarkers; x++) {
				bounds.extend(markers[x].position);
			}

			// FIT THESE BOUNDS TO THE MAP
			map.fitBounds(bounds);
		}

		autoCenter();

		var markerCluster = new MarkerClusterer(map, markers, {
			gridSize: 40,
			minimumClusterSize: 2,
			calculator: function(markers_list, numStyles) {
				return {
					text: markers_list.length,
					index: numStyles
				};
			}
		});

		// FILTER MARKER
		filter = [];

		$('.type-filtering .item-type').on('click touchstart', function(){

			$(this).toggleClass('active');

			closeSearcher();

			properyClick = this.dataset.type;

			var newBounds = new google.maps.LatLngBounds();
			propertyFound = 0;

			$.inArray(properyClick, filter) == -1 ? filter.push(properyClick) 
				                                  : filter.splice(filter.indexOf(properyClick), 1) ;

			markerCluster.removeMarkers(markers, false);
			
			for(x=0; x<totalMarkers; x++) {

				if($.inArray(markers[x].propertyType, filter)>= 0){

					markers[x].setVisible(true);
					markerCluster.addMarker(markers[x], false);
					propertyFound++;

					// SET NEW POSITION MAPS
					newBounds.extend(markers[x].position);

				}else{

					markers[x].setVisible(false);
					markerCluster.removeMarker(markers[x]);

					// SET NEW POSITION MAPS
					newBounds.extend(markers[x].position);

				}
				
				totalSearch(propertyFound);

			}

			if(filter.length === 0) {

				totalSearch(totalMarkers);
				for(x=0; x<totalMarkers; x++) {

					markers[x].setVisible(true);
					markerCluster.addMarker(markers[x], false);

					// SET NEW POSITION MAPS
					newBounds.extend(markers[x].position);

				}
			}

			// SET NEW POSITION MAPS
			map.fitBounds(newBounds);

			autoCenter();
			return false;

		});

		google.maps.event.addListenerOnce(map, 'idle', function(){
			$(".loading-container").delay(3000).fadeOut();
		});

    // }).error(function(jqXHR, textStatus, errorThrown){
    //         alert(textStatus);
    // });

});