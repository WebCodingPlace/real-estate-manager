jQuery(document).ready(function($) {
    var rem_property_images;
     
    jQuery('.upload_image_button').live('click', function( event ){
     
        event.preventDefault();
     
        // var parent = jQuery(this).closest('.tab-content').find('.thumbs-prev');
        // Create the media frame.
        rem_property_images = wp.media.frames.rem_property_images = wp.media({
          title: jQuery( this ).data( 'title' ),
          button: {
            text: jQuery( this ).data( 'btntext' ),
          },
          multiple: true  // Set to true to allow multiple files to be selected
        });
     
        // When an image is selected, run a callback.
        rem_property_images.on( 'select', function() {
            // We set multiple to false so only get one image from the uploader
            var selection = rem_property_images.state().get('selection');
            selection.map( function( attachment ) {
                attachment = attachment.toJSON();
                jQuery('.thumbs-prev').append('<div><input type="hidden" name="rem_property_data[property_images]['+attachment.id+']" value="'+attachment.id+'"><img src="'+attachment.url+'"><span class="dashicons dashicons-dismiss"></span></div>');

            });  
        });
     
        // Finally, open the modal
        rem_property_images.open();
    });
    jQuery('.thumbs-prev').on('click', '.dashicons-dismiss', function() {
        jQuery(this).parent('div').remove();
    });
    jQuery(".thumbs-prev").sortable({
      placeholder: "ui-state-highlight"
    });

    var rem_attachments;
     
    jQuery('.upload-attachment').live('click', function( event ){
     
        event.preventDefault();
        var text_field = $(this).closest('div').find('.place-attachment');
     
        // var parent = jQuery(this).closest('.tab-content').find('.thumbs-prev');
        // Create the media frame.
        rem_attachments = wp.media.frames.rem_attachments = wp.media({
          title: jQuery( this ).data( 'title' ),
          button: {
            text: jQuery( this ).data( 'btntext' ),
          },
          multiple: true  // Set to true to allow multiple files to be selected
        });
     
        // When an image is selected, run a callback.
        rem_attachments.on( 'select', function() {
            // We set multiple to false so only get one image from the uploader
            var selection = rem_attachments.state().get('selection');
            selection.map( function( attachment ) {
                attachment = attachment.toJSON();
                if (text_field.val() != '') {
                    text_field.val( text_field.val() + '\n'+attachment.id);
                } else {
                    text_field.val( text_field.val() +attachment.id);
                }

            });
        });
     
        // Finally, open the modal
        rem_attachments.open();
    });

    $(".rem-settings-box .tabs-panel").hide().first().show();
    $(".rem-settings-box .nav-tabs li:first").addClass("active");
    $(".rem-settings-box .nav-tabs a").on('click', function (e) {
        e.preventDefault();
        $(this).closest('li').addClass("active").siblings().removeClass("active");
        $($(this).attr('href')).show().siblings('.tabs-panel').hide();
    });    
});

function initialize_rem_maps() {

    var map = new google.maps.Map(document.getElementById('map-canvas'), {
        center: new google.maps.LatLng(rem_map_ob.def_lat, rem_map_ob.def_long),
        scrollwheel: false,
        zoom: parseInt(rem_map_ob.zoom_level)
    });

    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(rem_map_ob.def_lat, rem_map_ob.def_long),
        map: map,
        icon: rem_map_ob.drag_icon,
        draggable: true
    });
    
    google.maps.event.addListener(marker, 'drag', function(event) {
        jQuery('#property_latitude').val(event.latLng.lat());
        jQuery('#property_longitude').val(event.latLng.lng());
        jQuery('#position').text('Position: ' + event.latLng.lat() + ' , ' + event.latLng.lng() );
    });
    google.maps.event.addListener(marker, 'dragend', function(event) {
        jQuery('#property_latitude').val(event.latLng.lat());
        jQuery('#property_longitude').val(event.latLng.lng());
        jQuery('#position').text('Position: ' + event.latLng.lat() + ' , ' + event.latLng.lng() );
    });


    var searchBox = new google.maps.places.SearchBox(document.getElementById('search-map'));
    // map.controls[google.maps.ControlPosition.TOP_LEFT].push(document.getElementById('search-map'));
    google.maps.event.addListener(searchBox, 'places_changed', function() {
        searchBox.set('map', null);


        var places = searchBox.getPlaces();

        var bounds = new google.maps.LatLngBounds();
        var i, place;
        for (i = 0; place = places[i]; i++) {
            (function(place) {
                var marker = new google.maps.Marker({
                    position: place.geometry.location,
                    map: map,
                    icon: rem_map_ob.drag_icon,
                    draggable: true
                });
                var location = place.geometry.location;
                var n_lat = location.lat();
                var n_lng = location.lng();
                jQuery('#property_latitude').val(n_lat);
                jQuery('#property_longitude').val(n_lng);
                jQuery('#position').text('Position: ' + n_lat + ' , ' + n_lng );                        
                marker.bindTo('map', searchBox, 'map');
                google.maps.event.addListener(marker, 'map_changed', function(event) {
                    if (!this.getMap()) {
                        this.unbindAll();
                    }
                });
                google.maps.event.addListener(marker, 'drag', function(event) {
                    jQuery('#property_latitude').val(event.latLng.lat());
                    jQuery('#property_longitude').val(event.latLng.lng());
                    jQuery('#position').text('Position: ' + event.latLng.lat() + ' , ' + event.latLng.lng() );
                });
                google.maps.event.addListener(marker, 'dragend', function(event) {
                    jQuery('#property_latitude').val(event.latLng.lat());
                    jQuery('#property_longitude').val(event.latLng.lng());
                    jQuery('#position').text('Position: ' + event.latLng.lat() + ' , ' + event.latLng.lng() );
                });                                             
                bounds.extend(place.geometry.location);


            }(place));

        }
        map.fitBounds(bounds);
        searchBox.set('map', map);
        map.setZoom(Math.min(map.getZoom(), parseInt(rem_map_ob.zoom_level)));

    });
}
if (rem_map_ob.use_map_from == 'google_maps') {
    google.maps.event.addDomListener(window, 'load', initialize_rem_maps);
}
jQuery(document).ready(function($) {
    if (rem_map_ob.use_map_from == 'leaflet') {
        var property_map = L.map('map-canvas').setView([rem_map_ob.def_lat, rem_map_ob.def_long], parseInt(rem_map_ob.zoom_level));
        
        L.tileLayer('https://{s}.tile.openstreetmap.de/tiles/osmde/{z}/{x}/{y}.png', {
                maxZoom: 21,
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Points &copy 2012 LINZ'
            }).addTo(property_map);
        var propertyIcon = L.icon({
            iconUrl: rem_map_ob.drag_icon,
            iconSize: [72, 60],
            iconAnchor: [36, 47],
        });
        var marker = L.marker([rem_map_ob.def_lat, rem_map_ob.def_long], {icon: propertyIcon, draggable: true}).addTo(property_map);
        marker.on('dragend', function (e) {
            jQuery('#property_latitude').val(marker.getLatLng().lat);
            jQuery('#property_longitude').val(marker.getLatLng().lng);
            jQuery('#position').text('Position: ' + marker.getLatLng().lat + ' , ' + marker.getLatLng().lng );            
        });
        marker.on('drag', function (e) {
            jQuery('#property_latitude').val(marker.getLatLng().lat);
            jQuery('#property_longitude').val(marker.getLatLng().lng);
            jQuery('#position').text('Position: ' + marker.getLatLng().lat + ' , ' + marker.getLatLng().lng );            
        });
        // marker.bindPopup("<b>Hello world!</b><br>I am a popup.");
        if (rem_map_ob.maps_styles != '') {
            // console.log(rem_map_ob.maps_styles);
            // L.geoJSON(JSON.parse(rem_map_ob.maps_styles)).addTo(property_map);
        }
    }    
});