jQuery(document).ready(function($) {
    var rem_agent_profile_pic;
     
    jQuery('#agent-profile-form').on('click', '.upload_image_agent' , function( event ){
     
        event.preventDefault();
     
        var parent = jQuery(this).closest('li');
        // Create the media frame.
        rem_agent_profile_pic = wp.media.frames.rem_agent_profile_pic = wp.media({
          title: jQuery( this ).data( 'title' ),
          button: {
            text: jQuery( this ).data( 'btntext' ),
          },
          multiple: false  // Set to true to allow multiple files to be selected
        });
     
        // When an image is selected, run a callback.
        rem_agent_profile_pic.on( 'select', function() {
            // We set multiple to false so only get one image from the uploader
            var selection = rem_agent_profile_pic.state().get('selection');
            selection.map( function( attachment ) {
                attachment = attachment.toJSON();
                parent.find('.img-url').val(attachment.url);
            });  
        });
     
        // Finally, open the modal
        rem_agent_profile_pic.open();
    });

	$('.fa-pencil-alt').click(function(event) {
		$(this).closest('li').find('input').trigger('focus');
	});

	$('#agent-profile-form').submit(function(event) {
		event.preventDefault();
		$('.rem-res').show();
		$.post($('.rem-ajax-url').val(), $(this).serialize(), function(resp) {
			$('.rem-res').html(resp);
			window.location.reload();
		});
	});
});


function rem_agent_location_init() {

    var map = new google.maps.Map(document.getElementById('map-canvas'), {
        center: new google.maps.LatLng(rem_edit_agent_vars.def_lat, rem_edit_agent_vars.def_long),
        scrollwheel: false,
        zoom: parseInt(rem_edit_agent_vars.zoom_level),
        styles: (rem_edit_agent_vars.maps_styles != '') ? JSON.parse(rem_edit_agent_vars.maps_styles) : '',
    });

    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(rem_edit_agent_vars.def_lat, rem_edit_agent_vars.def_long),
        map: map,
        icon: rem_edit_agent_vars.drag_icon,
        draggable: true
    });
    
    google.maps.event.addListener(marker, 'drag', function(event) {
        jQuery('#agent_latitude').val(event.latLng.lat());
        jQuery('#agent_longitude').val(event.latLng.lng());
        jQuery('#position').text('Position: ' + event.latLng.lat() + ' , ' + event.latLng.lng() );
    });
    google.maps.event.addListener(marker, 'dragend', function(event) {
        jQuery('#agent_latitude').val(event.latLng.lat());
        jQuery('#agent_longitude').val(event.latLng.lng());
        jQuery('#position').text('Position: ' + event.latLng.lat() + ' , ' + event.latLng.lng() );
    });


    var searchBox = new google.maps.places.SearchBox(document.getElementById('search-map'));
    google.maps.event.addListener(searchBox, 'places_changed', function() {
        searchBox.set('map', null);
        marker.setMap(null);

        var places = searchBox.getPlaces();

        var bounds = new google.maps.LatLngBounds();
        var i, place;
        for (i = 0; place = places[i]; i++) {
            (function(place) {
                var marker = new google.maps.Marker({
                    position: place.geometry.location,
                    map: map,
                    icon: rem_edit_agent_vars.drag_icon,
                    draggable: true
                });
                var location = place.geometry.location;
                var n_lat = location.lat();
                var n_lng = location.lng();
                jQuery('#agent_latitude').val(n_lat);
                jQuery('#agent_longitude').val(n_lng);
                jQuery('#position').text('Position: ' + n_lat + ' , ' + n_lng );                        
                marker.bindTo('map', searchBox, 'map');
                google.maps.event.addListener(marker, 'map_changed', function(event) {
                    if (!this.getMap()) {
                        this.unbindAll();
                    }
                });
                google.maps.event.addListener(marker, 'drag', function(event) {
                    jQuery('#agent_latitude').val(event.latLng.lat());
                    jQuery('#agent_longitude').val(event.latLng.lng());
                    jQuery('#position').text('Position: ' + event.latLng.lat() + ' , ' + event.latLng.lng() );
                });
                google.maps.event.addListener(marker, 'dragend', function(event) {
                    jQuery('#agent_latitude').val(event.latLng.lat());
                    jQuery('#agent_longitude').val(event.latLng.lng());
                    jQuery('#position').text('Position: ' + event.latLng.lat() + ' , ' + event.latLng.lng() );
                });                                             
                bounds.extend(place.geometry.location);
            }(place));

        }
        map.fitBounds(bounds);
        searchBox.set('map', map);
        map.setZoom(Math.min(map.getZoom(), parseInt(rem_edit_agent_vars.zoom_level)));

    });
}
if (rem_edit_agent_vars.def_lat != 'disable' && rem_edit_agent_vars.use_map_from == 'google_maps') {
    google.maps.event.addDomListener(window, 'load', rem_agent_location_init);
}
jQuery(document).ready(function($) {
    if (rem_edit_agent_vars.use_map_from == 'leaflet') {
        var property_map = L.map('map-canvas').setView([rem_edit_agent_vars.def_lat, rem_edit_agent_vars.def_long], parseInt(rem_edit_agent_vars.zoom_level));
        
        L.tileLayer(rem_edit_agent_vars.leaflet_styles.provider, {
                maxZoom: 21,
                attribution: rem_edit_agent_vars.leaflet_styles.provider.attribution
            }).addTo(property_map);
        var propertyIcon = L.icon({
            iconUrl: rem_edit_agent_vars.drag_icon,
            iconSize: [72, 60],
            iconAnchor: [36, 47],
        });
        var marker = L.marker([rem_edit_agent_vars.def_lat, rem_edit_agent_vars.def_long], {icon: propertyIcon, draggable: true}).addTo(property_map);
        var geocoder = L.Control.geocoder({
            defaultMarkGeocode: false
        })
        .on('markgeocode', function(event) {
            var center = event.geocode.center;
            property_map.setView(center, property_map.getZoom());
            marker.setLatLng(center);
        }).addTo(property_map);        
        marker.on('dragend', function (e) {
            jQuery('#agent_latitude').val(marker.getLatLng().lat);
            jQuery('#agent_longitude').val(marker.getLatLng().lng);
            jQuery('#position').text('Position: ' + marker.getLatLng().lat + ' , ' + marker.getLatLng().lng );            
        });
        marker.on('drag', function (e) {
            jQuery('#agent_latitude').val(marker.getLatLng().lat);
            jQuery('#agent_longitude').val(marker.getLatLng().lng);
            jQuery('#position').text('Position: ' + marker.getLatLng().lat + ' , ' + marker.getLatLng().lng );            
        });
        jQuery('.leaflet-control-geocoder-form input').keypress(function(e){
            if ( e.which == 13 ) e.preventDefault();
        });
    }    
});