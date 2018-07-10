jQuery(document).ready(function($) {
	var tiles = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			maxZoom: 21,
			attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Points &copy 2012 LINZ'
		}),
		latlng = L.latLng(mapsData.def_lat, mapsData.def_long);

	var map = L.map('leaflet-maps', { scrollWheelZoom: false, center: latlng, zoom: parseInt(mapsData.zoom_level), layers: [tiles]});

	var markers = L.markerClusterGroup();
	jQuery.each(mapsData.properties, function(index, property) {
        var propertyIcon = L.icon({
            iconUrl: property.icon_url,
            iconSize: [43, 47],
            iconAnchor: [18, 30],
        });
		var marker = L.marker(new L.LatLng(property.lat, property.lon), { icon: propertyIcon, title: property.title });
		marker.bindPopup(property.property_box, {maxWidth : 320});
		markers.addLayer(marker);
		// console.log(property);
	});

	map.addLayer(markers);	
});