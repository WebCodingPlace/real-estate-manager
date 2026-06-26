jQuery(document).ready(function($) {
	
	console.log(rem_agent_map);
	// Maps Related
	if (rem_agent_map.show_agent_ocation == 'enable') {
	    function rem_insert_marker(map, position){
	        
	        var image = rem_agent_map.maps_icon_url;
	        var marker = new google.maps.Marker({
	            position: position,
	            map: map,
	            icon: image
	        });
	    }
	    function initializeSinglePropertyMap() {
	        var lat = rem_agent_map.latitude;
	        var lon = rem_agent_map.longitude;
	        var zoom = parseInt(rem_agent_map.zoom);
	        var map_type = rem_agent_map.map_type;
	        var myLatLng = new google.maps.LatLng(lat, lon);
	        var mapProp = {
	            center:myLatLng,
	            zoom: zoom,
	            mapTypeId: map_type,
	            minZoom: zoom - 5,
	            maxZoom: zoom + 5,
	            styles: (rem_agent_map.maps_styles != '') ? JSON.parse(rem_agent_map.maps_styles) : '',
	        };

	        var map=new google.maps.Map(document.getElementById("agent-map-canvas"),mapProp);
	        map.setTilt(0);

	        rem_insert_marker(map, myLatLng);
	    }
	    if (rem_agent_map.use_map_from == 'google_maps') {
	        google.maps.event.addDomListener(window, 'load', initializeSinglePropertyMap);
	    }
	    if (rem_agent_map.use_map_from == 'leaflet') {
	        if ("ontouchstart" in document.documentElement) {
	            var dragging = false;
	        } else {
	            var dragging = true;
	        }        
	    	var property_map = L.map('agent-map-canvas', {scrollWheelZoom: false, dragging: dragging}).setView([rem_agent_map.latitude, rem_agent_map.longitude], parseInt(rem_agent_map.zoom));
	        
	        L.tileLayer(rem_agent_map.leaflet_styles.provider, {
	                maxZoom: 21,
	                attribution: rem_agent_map.leaflet_styles.attribution
	            }).addTo(property_map);
	        var propertyIcon = L.icon({
	            iconUrl: rem_agent_map.maps_icon_url,
	            iconSize: rem_agent_map.icons_size,
	            iconAnchor: rem_agent_map.icons_anchor,
	        });
	        
	        var marker = L.marker([rem_agent_map.latitude, rem_agent_map.longitude], {icon: propertyIcon}).addTo(property_map);
	    }
	};
});