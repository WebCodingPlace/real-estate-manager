jQuery(document).ready(function($) {
    $('.rem-select2-field').select2(); 
    $('.select2-container').width('100%');
    jQuery(".labelauty").labelauty();
    var rem_property_images;
    var existingImages = parseInt($('body .thumbs-prev div[data-media-type="image"]').length);
    var existingVideos = parseInt($('body .thumbs-prev div[data-media-type="video"]').length);

    $('.general_settings-fields > div').matchHeight({byRow: false});
     
    jQuery('.info-block').on('click', '.upload_image_button', function( event ){
     
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

            selection.map( function( attachment, index ) {
                attachment = attachment.toJSON();

                // Images
                if (attachment.type == 'image') {
                    if ( existingImages <  parseInt(rem_property_vars.images_limit) || rem_property_vars.images_limit == 0 ) {
                        var thumb_box = rem_upload_file_preview(attachment);
                        jQuery('.thumbs-prev').append(thumb_box);
                        existingImages++;
                        console.log(existingImages);
                    } else {
                        alert(rem_property_vars.images_limit_message+rem_property_vars.images_limit);
                    }
                }

                // Videos
                if (attachment.type == 'video') {
                    if ( existingVideos <  parseInt(rem_property_vars.videos_limit) || rem_property_vars.videos_limit == 0 ) {
                        var thumb_box = rem_upload_file_preview(attachment);
                        jQuery('.thumbs-prev').append(thumb_box);
                        existingVideos++;
                    } else {
                        alert(rem_property_vars.videos_limit_message+rem_property_vars.videos_limit);
                    }
                }

            });
        });
     
        // Finally, open the modal
        rem_property_images.open();
    });
    jQuery('.thumbs-prev, .attachments-prev').on('click', '.remove-image', function() {
        var type = $(this).closest('.rem-preview-image').find('.rem-image-wrap').data('media-type');
        console.log(type);
        if (type == 'image') {
            existingImages--;
        }
        if (type == 'video') {
            existingVideos--;
        }
        jQuery(this).closest('.col-sm-3').remove();
    });
    jQuery(".thumbs-prev, .attachments-prev").sortable({
        start: function(e, ui){
            ui.placeholder.height(ui.item.find('.rem-preview-image').innerHeight()-10);
            ui.placeholder.width(ui.item.find('.rem-preview-image').innerWidth()-10);
        },
        placeholder: "drag-placeholder col-sm-3"
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
    
    // preving property 
    jQuery('#form-submit').click(function(event){
        if ( $('.preview_property').length > 0 ) {
            $('.preview_property').remove();
        }
    });
    jQuery('#preview-property').click(function(event){
        event.preventDefault();
        var el = '<input type="hidden" class="preview_property" name="preview_property">';
        if ( jQuery('#title').val() != '' ) {

            if ( $('.preview_property').length == 0 ) {
                $('#create-property').append(el);
            }
            $('#create-property').submit();
        } else {
            alert("Title is required");
            jQuery( "#title" ).focus();
        };
        
    });
    // Creating Property
    jQuery('#create-property').submit(function(event){
        event.preventDefault();
        $('.creating-prop').show();
        
        if (jQuery("#wp-rem-content-wrap").hasClass("tmce-active")){
            content = tinyMCE.get('rem-content').getContent();
        }else{
            content = $('#rem-content').val();
        }        

        var ajaxurl = $(this).data('ajaxurl');
        var data = $(this).serialize()+"&content="+encodeURIComponent(content);

        $.post(ajaxurl, data , function(resp) {
            // console.log(resp);
            if (typeof resp.property_id != "undefined" ) {
                jQuery('.preview_property').val(resp.property_id);
                // window.location = resp.preview_link;
                if ( $('.property_preview_id').length == 0 ) {
                    var el = '<input type="hidden" class="property_preview_id" name="property_preview_id" value="'+resp.property_id+'">';
                    $('#create-property').append(el);
                } else {
                    $('.property_preview_id').val(resp.property_id);
                }
                $('.creating-prop').hide();
                var win = window.open(resp.preview_link, '_blank');
                if (win) {
                    //Browser has allowed it to be opened
                    win.focus();
                } else {
                    //Browser has blocked it
                    alert('Please allow popups for this website');
                }
            }else{
                $('.creating-prop').removeClass('alert-info').addClass('alert-success');
                $('.creating-prop .msg').html(rem_property_vars.success_message);
                window.location = resp;
            };
        });
    });
    if ($('.rem-field-label .glyphicon-question-sign').length) {
        $( '.rem-field-label .glyphicon-question-sign' ).tooltip({
            trigger : 'hover',
        });
    }

    if ($('.rem-states-list').length && $('.rem-countries-list').length) {
        $('.info-block').on('change', '.rem-countries-list', function(event) {
            var currentTab = $(this).closest('.info-block');
            event.preventDefault();
            var data = {
                action: 'rem_get_states',
                country: $(this).val(),
                nonce: rem_property_vars.nonce_states
            }
            $.post(ajaxurl, data, function(resp) {
                currentTab.find('.rem-states-list').html(resp);
                var state = currentTab.find('.rem-states-list').data('state');
                currentTab.find('.rem-states-list').val(state);
            });
        });
        $('.rem-countries-list').trigger('change');
    }
});

function rem_upload_file_preview(attachment, key = 'property_images'){
    var html = '<div class="col-sm-3">';
            html += '<div class="rem-preview-image">';
                    if (key == 'property_images') {
                        html += '<input type="hidden" name="rem_property_data[property_images]['+attachment.id+']" value="'+attachment.id+'">';
                    } else {
                        html += '<input type="hidden" name="'+key+'['+attachment.id+']" value="'+attachment.id+'">';
                    }
                html += '<div class="rem-image-wrap" data-media-type="'+attachment.type+'">';
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
                        html += '<a target="_blank" href="'+rem_property_vars.post_edit_url+'?post='+attachment.id+'&action=edit&image-editor&rem_image_editor" class="btn btn-info btn-sm">';
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

function rem_edit_property_initialize() {

    var map = new google.maps.Map(document.getElementById('map-canvas'), {
        center: new google.maps.LatLng(rem_property_vars.def_lat, rem_property_vars.def_long),
        scrollwheel: false,
        zoom: parseInt(rem_property_vars.zoom_level),
        styles: (rem_property_vars.maps_styles != '') ? JSON.parse(rem_property_vars.maps_styles) : '',
    });

    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(rem_property_vars.def_lat, rem_property_vars.def_long),
        map: map,
        icon: rem_property_vars.drag_icon,
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
        marker.setMap(null);

        var places = searchBox.getPlaces();

        var bounds = new google.maps.LatLngBounds();
        var i, place;
        for (i = 0; place = places[i]; i++) {
            (function(place) {
                var marker = new google.maps.Marker({
                    position: place.geometry.location,
                    map: map,
                    icon: rem_property_vars.drag_icon,
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
        map.setZoom(Math.min(map.getZoom(), parseInt(rem_property_vars.zoom_level)));

    });
}
if (rem_property_vars.def_lat != 'disable' && rem_property_vars.use_map_from == 'google_maps') {
    google.maps.event.addDomListener(window, 'load', rem_edit_property_initialize);
}
jQuery(document).ready(function($) {
    if (rem_property_vars.use_map_from == 'leaflet') {
        var property_map = L.map('map-canvas').setView([rem_property_vars.def_lat, rem_property_vars.def_long], parseInt(rem_property_vars.zoom_level));
        
        L.tileLayer(rem_property_vars.leaflet_styles.provider, {
                maxZoom: 21,
                attribution: rem_property_vars.leaflet_styles.provider.attribution
            }).addTo(property_map);
        var propertyIcon = L.icon({
            iconUrl: rem_property_vars.drag_icon,
            iconSize: [72, 60],
            iconAnchor: [36, 47],
        });
        var marker = L.marker([rem_property_vars.def_lat, rem_property_vars.def_long], {icon: propertyIcon, draggable: true}).addTo(property_map);
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
        // marker.bindPopup("<b>Hello world!</b><br>I am a popup.");
        if (rem_property_vars.maps_styles != '') {
            // console.log(rem_property_vars.maps_styles);
            // L.geoJSON(JSON.parse(rem_property_vars.maps_styles)).addTo(property_map);
        }
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