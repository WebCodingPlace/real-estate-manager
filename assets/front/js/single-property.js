jQuery(document).ready(function($) {
	// Contact Agent frontend
	$('#contact-agent').submit(function(event) {
		event.preventDefault();
		$('.sending-email').show();
		var ajaxurl = $(this).data('ajaxurl');
		var data = $(this).serialize();
		// console.log(data);

		$.post(ajaxurl, data, function(resp) {
			// console.log(resp);
			if (resp.status == 'sent') {
				$('.sending-email').removeClass('alert-info').addClass('alert-success');
				$('.sending-email .msg').html(resp.msg);
			} else {
				$('.sending-email').removeClass('alert-info').addClass('alert-danger');
				$('.sending-email .msg').html(resp.msg);
			}
		}, 'json');
	});

	// Apply ImageFill	
	jQuery('.ich-settings-main-wrap .image-fill').each(function(index, el) {
		jQuery(this).imagefill();
	});

	$('.fotorama-custom').on('fotorama:fullscreenenter fotorama:fullscreenexit', function (e, fotorama) {
		if (e.type === 'fotorama:fullscreenenter') {
		    // Options for the fullscreen
		    fotorama.setOptions({
		        fit: 'contain'
		    });
		} else {
		    // Back to normal settings
		    fotorama.setOptions({
		        fit: 'cover'
		    });
		}
	}).fotorama();

	// Maps Related
    function initializeSinglePropertyMap() {
        var lat = rem_property_map.latitude;
        var lon = rem_property_map.longitude;
        var zoom = parseInt(rem_property_map.zoom);
        var map_type = rem_property_map.map_type;
        var load_map_from = rem_property_map.load_map_from;
        var myLatLng = new google.maps.LatLng(lat, lon);
        var mapProp = {
            center:myLatLng,
            zoom: zoom,
            mapTypeId: map_type,
            styles: (rem_property_map.maps_styles != '') ? JSON.parse(rem_property_map.maps_styles) : '',
        };

        var map=new google.maps.Map(document.getElementById("map-canvas"),mapProp);
        var image = rem_property_map.maps_icon_url;
        var beachMarker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            icon: image
        });
        
        if (load_map_from == 'address') {
            var geocoder = new google.maps.Geocoder();
            var address = rem_property_map.address;
            geocoder.geocode({'address': address}, function(results, status) {
                if (status === 'OK') {
                    map.setCenter(results[0].geometry.location);
                    var marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location,
                        icon: image
                    });
                } else {
                    alert('Unable to load map because : ' + status);
                }
            });
        }
    }
    if (rem_property_map.latitude != 'disable' && rem_property_map.use_map_from == 'google_maps') {
        google.maps.event.addDomListener(window, 'load', initializeSinglePropertyMap);
    }
    if (rem_property_map.use_map_from == 'leaflet') {
    	var property_map = L.map('map-canvas', {scrollWheelZoom: false}).setView([rem_property_map.latitude, rem_property_map.longitude], parseInt(rem_property_map.zoom));
        
        L.tileLayer('https://{s}.tile.openstreetmap.de/tiles/osmde/{z}/{x}/{y}.png', {
                maxZoom: 21,
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Points &copy 2012 LINZ'
            }).addTo(property_map);
        var propertyIcon = L.icon({
            iconUrl: rem_property_map.maps_icon_url,
            iconSize: [43, 47],
            iconAnchor: [18, 47],
        });
        var marker = L.marker([rem_property_map.latitude, rem_property_map.longitude], {icon: propertyIcon}).addTo(property_map);
        // marker.bindPopup("<b>Hello world!</b><br>I am a popup.");
        if (rem_property_map.maps_styles != '') {
            // console.log(rem_property_map.maps_styles);
            // L.geoJSON(JSON.parse(rem_property_map.maps_styles)).addTo(property_map);
        }
    }
});