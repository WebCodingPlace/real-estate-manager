jQuery(document).ready(function($) {

    $('.rem-select2-field').select2();
    $('.rem-select2-field').height('36px');
    $('.rem-select2-field').width('100%');
    var rem_property_images;
     
    jQuery('#property_images_meta_box').on('click', '.upload_image_button', function( event ){
     
        event.preventDefault();
     
        // var parent = jQuery(this).closest('.tab-content').find('.thumbs-prev');
        // Create the media frame.
        rem_property_images = wp.media.frames.rem_property_images = wp.media({
          title: jQuery( this ).data( 'title' ),
          button: {
            text: jQuery( this ).data( 'btntext' ),
          },
          library: {
                type: [ 'image', 'video' ]
          },
          multiple: true  // Set to true to allow multiple files to be selected
        });
     
        // When an image is selected, run a callback.
        rem_property_images.on( 'select', function() {
            // We set multiple to false so only get one image from the uploader
            var selection = rem_property_images.state().get('selection');
            selection.map( function( attachment ) {
                attachment = attachment.toJSON();
                var thumb_box = rem_upload_file_preview(attachment);
                jQuery('.thumbs-prev').append(thumb_box);
            });  
        });
     
        // Finally, open the modal
        rem_property_images.open();
    });
    jQuery(".thumbs-prev, .attachments-prev").sortable({
        start: function(e, ui){
            ui.placeholder.height(ui.item.find('.rem-preview-image').innerHeight()-10);
            ui.placeholder.width(ui.item.find('.rem-preview-image').innerWidth()-10);
        },
        placeholder: "drag-placeholder col-sm-4"
    });
    jQuery('.attachments-prev').on('click', '.remove-image', function(e) {
        e.preventDefault();
        jQuery(this).closest('.col-sm-4').remove();
    });
    jQuery('.thumbs-prev').on('click', '.remove-image', function(e) {
        e.preventDefault();
        jQuery(this).closest('.col-sm-3').remove();
    });

    // Attachments Related
    var rem_attachments;
     
    jQuery('.upload-attachments-wrap').on('click', '.upload-attachment', function( event ){
     
        event.preventDefault();
        var wrap = $(this).closest('.upload-attachments-wrap');
        var field_key = $(this).data('field_key');
        var max_files = ($(this).data('max_files') != '') ? $(this).data('max_files') : 0;
        var file_type = $(this).data('file_type');
        var max_files_msg = $(this).data('max_files_msg');
        if (file_type != '') {
            var file_type_arr = file_type.split(',');
            allowed_types = { type: file_type_arr }
        } else {
            allowed_types = {}
        }
        rem_attachments = wp.media.frames.rem_attachments = wp.media({
          title: jQuery( this ).data( 'title' ),
          button: {
            text: jQuery( this ).data( 'btntext' ),
          },
          library: allowed_types,
          multiple: true  // Set to true to allow multiple files to be selected
        });
     
        // When an image is selected, run a callback.
        rem_attachments.on( 'select', function() {
            var selection = rem_attachments.state().get('selection');
            var already_selected = parseInt(wrap.find('.attachments-prev > div').length);
            var new_selected = parseInt(selection.length);
            var total_attachments = already_selected + new_selected;
            if (total_attachments > max_files && max_files != 0) {
                alert(max_files_msg+' '+max_files);
            }
            selection.map( function( attachment, index ) {
                if ( index < (parseInt(max_files) - already_selected ) || max_files == 0 ) {
                    attachment = attachment.toJSON();
                    var thumb_box = rem_upload_file_preview(attachment, field_key);
                    wrap.find('.attachments-prev').append(thumb_box);
                };
            });
        });
     
        // Finally, open the modal
        rem_attachments.open();
    }); 

    $(".rem-settings-box .tabs-panel").hide().first().show();
    $(".rem-settings-box .rem-field-sections a:first").addClass("active");
    $(".rem-settings-box .rem-field-sections a").on('click', function (e) {
        e.preventDefault();
        $(this).addClass("active").siblings().removeClass("active");
        $($(this).attr('href')).show().siblings('.tabs-panel').hide();
    });   

    $('body').on('blur', '#property_address', function(event) {
        event.preventDefault();
        var address = $(this).val();
        var p_lat = $('#property_latitude').val();
        var p_long = $('#property_longitude').val();

        if(!p_lat && !p_long && address != '' ){
        
            if (rem_map_ob.use_map_from == 'google_maps') {
               
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({'address': address}, function(results, status) {
                    if (status === 'OK') {
                        var lat = results[0].geometry.location.lat();
                        var lon = results[0].geometry.location.lng();
                        rem_add_lat_long(lat, lon);
                    }
                });
            }else {
                jQuery.get(location.protocol + '//nominatim.openstreetmap.org/search?format=json&q='+address, function(data){
                    if (data.length > 0) {
                        var lat = data[0].lat;
                        var lon = data[0].lon;
                        rem_add_lat_long(lat, lon);
                    }
                });
            }
        }

    });

    if ($('.rem-states-list').length && $('.rem-countries-list').length) {
        $('.tabs-panel').on('change', '.rem-countries-list', function(event) {
            var currentTab = $(this).closest('.tabs-panel');
            event.preventDefault();
            var data = {
                action: 'rem_get_states',
                country: $(this).val(),
                nonce: rem_map_ob.nonce_states
            }
            $.post(ajaxurl, data, function(resp) {
                currentTab.find('.rem-states-list').html(resp);
                var state = currentTab.find('.rem-states-list').data('state');
                currentTab.find('.rem-states-list').val(state);
            });
        });
        if ($('.rem-countries-list').val() != '') {
            $('.rem-countries-list').trigger('change');
        }
    }
});
function rem_add_lat_long( lat, lon ){
    var lat_exist = jQuery('#property_latitude').length;
    var long_exist = jQuery('#property_longitude').length;
    if (!lat_exist && !long_exist) {
        var long_html = '<input type="hidden" name="rem_property_data[property_longitude]" value="'+lon+'">';
        var lat_html = '<input type="hidden" name="rem_property_data[property_latitude]" value="'+lat+'">';
        jQuery('#property_settings_meta_box').append(long_html);
        jQuery('#property_settings_meta_box').append(lat_html);
    } else {
        jQuery('#property_latitude').val(lat);
        jQuery('#property_longitude').val(lon);
    };
}
function rem_upload_file_preview(attachment, key = 'property_images'){
    var wrapper_class = (key == 'property_images') ? 'col-sm-3' : 'col-sm-4';
    var html = '<div class="'+wrapper_class+'">';
            html += '<div class="rem-preview-image">';
                    if (key == 'property_images') {
                        html += '<input type="hidden" name="rem_property_data[property_images]['+attachment.id+']" value="'+attachment.id+'">';
                    } else {
                        html += '<input type="hidden" name="rem_property_data['+key+']['+attachment.id+']" value="'+attachment.id+'">';
                    }
                html += '<div class="rem-image-wrap">';
                    if (key == 'property_images') {
                        if (attachment.type == 'video') {
                            html += '<img src="'+attachment.icon+'">';
                        } else {
                            html += '<img src="'+attachment.url+'">';
                        }
                    } else {
                        html += '<img class="attachment-icon" src="'+attachment.icon+'">';
                        html += '<span class="attachment-name"><a target="_blank" href="'+attachment.url+'">'+attachment.title+'</a></span>';
                    }
                html += '</div>';
                html += '<div class="rem-actions-wrap">';
                    if (key == 'property_images') {
                        html += '<a target="_blank" href="'+rem_map_ob.post_edit_url+'?post='+attachment.id+'&action=edit&image-editor&rem_image_editor&nonce=' + rem_map_ob.nonce_edit_img+ '" class="btn btn-info btn-sm">';
                            html += '<i class="fa fa-crop"></i>';
                        html += '</a>';
                    }
                    html += '<a href="javascript:void(0)" class="btn remove-image btn-sm">';
                        html += '<i class="fa fa-times"></i>';
                    html += '</a>';
                html += '</div>';
            html += '</div>';
        html += '</div>';

    return html;
}

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
    jQuery('#property_address').blur(function(event) {
        jQuery('#search-map').val(jQuery(this).val());
    });

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
    if (rem_map_ob.use_map_from == 'leaflet' && $('#map-canvas').length != 0) {
        var property_map = L.map('map-canvas').setView([rem_map_ob.def_lat, rem_map_ob.def_long], parseInt(rem_map_ob.zoom_level));
        
        L.tileLayer(rem_map_ob.leaflet_styles.provider, {
                maxZoom: 21,
                // attribution: rem_map_ob.leaflet_styles.attribution
            }).addTo(property_map);
        var propertyIcon = L.icon({
            iconUrl: rem_map_ob.drag_icon,
            iconSize: [72, 60],
            iconAnchor: [36, 47],
        });
        var marker = L.marker([rem_map_ob.def_lat, rem_map_ob.def_long], {icon: propertyIcon, draggable: true}).addTo(property_map);
        setTimeout(function() {
            property_map.invalidateSize();
        }, 1000);

        var geocoder = L.Control.geocoder({
            defaultMarkGeocode: false
        })
        .on('markgeocode', function(event) {
            var center = event.geocode.center;
            property_map.setView(center, property_map.getZoom());
            marker.setLatLng(center);
        }).addTo(property_map);

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

        jQuery('.leaflet-control-geocoder-form input').keypress(function(e){
            if ( e.which == 13 ) e.preventDefault();
        });
    }
});

jQuery(document).ready(function($) {
    function isValidLatitude(latitude) {
      // regular expression for latitude
      var latRegex = /^-?([1-8]?\d(?:\.\d{1,18})?|90(?:\.0{1,18})?)$/;
      return latRegex.test(latitude);
    }

    function isValidLongitude(longitude) {
      // regular expression for longitude
      var longRegex = /^-?((?:1[0-7]|[1-9])?\d(?:\.\d{1,18})?|180(?:\.0{1,18})?)$/;
      return longRegex.test(longitude);
    }

    jQuery('#property_latitude').on('keyup', function(event) {
        event.preventDefault();
        /* Act on the event */
        var property_latitude = jQuery('#property_latitude').val();
        
        $("#long_response").remove();
        if ( !isValidLongitude(property_latitude) ) {

            $("<p id='long_response' style='color: red;'>Latitude value is not correct.</p>").insertAfter('#property_latitude');
       };
    });
    jQuery('#property_longitude').on('keyup', function(event) {
        event.preventDefault();
        /* Act on the event */
        var property_longitude = jQuery('#property_longitude').val();
        
        $("#lat_response").remove();
        if ( !isValidLongitude(property_longitude) ) {

            $("<p id='lat_response' style='color: red;'>Longitude value is not correct.</p>").insertAfter('#property_longitude');
       }
    });

});