jQuery(document).ready(function($) {
    $('#agent_login').submit(function(event){
        event.preventDefault();
        var data = new FormData(this);
        data.append("action", 'rem_agent_register');
        
        if ($('.ich-settings-main-wrap input[name="password"]').val() == $('.ich-settings-main-wrap input[name="repassword"]').val()) {
            swal(rem_registration_vars.wait_text, '', "info");
            $.ajax({
                url: rem_registration_vars.ajaxurl,
                data: data,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function(resp){
                    console.log(resp);
                    if (resp.status == 'already') {
                        swal(rem_registration_vars.error_text, resp.msg, "info");
                    } else if (resp.status == 'error') {
                        swal(rem_registration_vars.error_text, resp.msg, "error");
                    } else {
                        swal(rem_registration_vars.success_text, resp.msg, "success");
                        if (rem_registration_vars.redirect != '') {
                            window.location = rem_registration_vars.redirect;
                        }
                    }
                }
            });
        } else {
            swal(rem_registration_vars.error_text, rem_registration_vars.password_mismatch, "error");
        }
    });
    $("#rem_agent_meta_image").change(function(){
        if (this.files && this.files[0]) {
            var allowedTypes = $(this).data('types');
            var allowedSize = $(this).data('size');
            var fileSize = ((this.files[0].size/1024)/1024).toFixed(4); // MB
            if (fileSize <= allowedSize) {

                if ($.inArray($(this).val().split('.').pop().toLowerCase(), allowedTypes) == -1) {
                    var types = allowedTypes.map(function(type){
                        return "<code>" + type + "</code>";
                    }).join(",");                    
                    $('.upload-response').html('<p class="alert alert-danger">'+rem_registration_vars.file_format_error+' '+types);
                    $('.agent-dp-prev img').attr('src', '');
                    $(this).val('');
                } else {
                    
                    $('.upload-response').html('');
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('.agent-dp-prev img').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(this.files[0]);
                }
            } else{
                $('.upload-response').html('<p class="alert alert-danger">'+rem_registration_vars.file_size_error+' '+allowedSize+'MB</p>');
                $('.agent-dp-prev img').attr('src', '');
                $(this).val('');
            }
        }
    });
});

function rem_agent_location_init() {

    var map = new google.maps.Map(document.getElementById('map-canvas'), {
        center: new google.maps.LatLng(rem_registration_vars.def_lat, rem_registration_vars.def_long),
        scrollwheel: false,
        zoom: parseInt(rem_registration_vars.zoom_level),
        styles: (rem_registration_vars.maps_styles != '') ? JSON.parse(rem_registration_vars.maps_styles) : '',
    });

    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(rem_registration_vars.def_lat, rem_registration_vars.def_long),
        map: map,
        icon: rem_registration_vars.drag_icon,
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
                    icon: rem_registration_vars.drag_icon,
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
        map.setZoom(Math.min(map.getZoom(), parseInt(rem_registration_vars.zoom_level)));

    });
}
if (rem_registration_vars.def_lat != 'disable' && rem_registration_vars.use_map_from == 'google_maps') {
    google.maps.event.addDomListener(window, 'load', rem_agent_location_init);
}
jQuery(document).ready(function($) {
    if (rem_registration_vars.use_map_from == 'leaflet') {
        var property_map = L.map('map-canvas').setView([rem_registration_vars.def_lat, rem_registration_vars.def_long], parseInt(rem_registration_vars.zoom_level));
        
        L.tileLayer(rem_registration_vars.leaflet_styles.provider, {
                maxZoom: 21,
                attribution: rem_registration_vars.leaflet_styles.provider.attribution
            }).addTo(property_map);
        var propertyIcon = L.icon({
            iconUrl: rem_registration_vars.drag_icon,
            iconSize: [72, 60],
            iconAnchor: [36, 47],
        });
        var marker = L.marker([rem_registration_vars.def_lat, rem_registration_vars.def_long], {icon: propertyIcon, draggable: true}).addTo(property_map);
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