jQuery(document).ready(function($) {
	jQuery('.rem-leaflet-map-area').each(function(index, el) {
		if ("ontouchstart" in document.documentElement) {
			var dragging = false;
		} else {
			var dragging = true;
		}		
		var token = jQuery(this).attr('id');
		var mapsData = window['mapsData' + token];
		var tiles = L.tileLayer(mapsData.leaflet_styles.provider, {
				maxZoom: 21,
				attribution: mapsData.leaflet_styles.attribution
			}),
			latlng = L.latLng(mapsData.def_lat, mapsData.def_long);

		var map = L.map(token, { scrollWheelZoom: false, dragging: dragging, center: latlng, zoom: parseInt(mapsData.zoom_level), layers: [tiles]});

		var markers = L.markerClusterGroup();
		jQuery.each(mapsData.properties, function(index, property) {
	        var propertyIcon = L.icon({
	            iconUrl: property.icon_url,
	            iconSize: mapsData.icons_size,
	            iconAnchor: mapsData.icons_anchor,
	        });

	        if (property.lat != '' && property.lon != '') {
	        	var marker = L.marker(new L.LatLng(property.lat, property.lon), { icon: propertyIcon, title: rem_html_special_chars_decode(property.title) });
	   			marker.bindPopup(property.property_box, {maxWidth : 320});
				markers.addLayer(marker);
	        } else {
				jQuery.get('http://nominatim.openstreetmap.org/search?format=json&q='+property.address, function(data){
	               if (data.length > 0) {
	                    var lat = data[0].lat;
	                    var lon = data[0].lon;
	                    map.setView([lat, lon], parseInt(mapsData.zoom_level));
	                    
	                    var marker = L.marker([lat, lon], {icon: propertyIcon, title: rem_html_special_chars_decode(property.title)});
			   			marker.bindPopup(property.property_box, {maxWidth : 320});
						markers.addLayer(marker);
	                    
	               	} else {
	                    console.log('No results found for address: '+property.address);
	               	}
		        });
	        }
		});

		map.addLayer(markers);
        setTimeout(function() {
            map.invalidateSize();
        }, 1000);
	});

	jQuery('.toggle a').click(function(){
		setTimeout(function() {
			window.dispatchEvent(new Event('resize'));
		}, 100);
	});
});

function rem_html_special_chars_decode(text) {
    var map = {
        '&amp;': '&',
        '&#038;': "&",
        '&lt;': '<',
        '&gt;': '>',
        '&quot;': '"',
        '&#039;': "'",
        '&#8217;': "’",
        '&#8216;': "‘",
        '&#8211;': "–",
        '&#8212;': "—",
        '&#8230;': "…",
        '&#8221;': '”'
    };

    return text.replace(/\&[\w\d\#]{2,5}\;/g, function(m) { return map[m]; });
};