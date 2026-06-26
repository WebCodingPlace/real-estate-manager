jQuery(document).ready(function($) {

	// Contact Agent frontend
	$('.contact-agent-form').submit(function(event) {
		event.preventDefault();
        var c_form = $(this);
		c_form.closest('div').find('.sending-email').show();
		var ajaxurl = c_form.data('ajaxurl');
		var data = c_form.serialize();

		$.post(ajaxurl, data, function(resp) {
			// console.log(resp);
			if (resp.status == 'sent') {
				c_form.closest('div').find('.sending-email').removeClass('alert-info').addClass('alert-success');
				c_form.closest('div').find('.msg').html(resp.msg);
                c_form.trigger("reset");
            } else {
                c_form.closest('div').find('.sending-email').removeClass('alert-info').addClass('alert-danger');
                c_form.closest('div').find('.msg').html(resp.msg);
			}
		}, 'json');
	});

    $('.child-listings-wrap').on('click', '.panel-heading', function(event) {
        event.preventDefault();
        $(this).closest('.panel').find('.panel-body').slideToggle();
    });

    $('.ich-settings-main-wrap').on('click', '.rem-directions-btn', function(event) {
        event.preventDefault();
        var lat = $(this).data('lat');
        var long = $(this).data('long');
        if((navigator.platform.indexOf("iPhone") != -1) || 
             (navigator.platform.indexOf("iPad") != -1) || 
             (navigator.platform.indexOf("iPod") != -1)){
            window.open("maps://maps.google.com/maps?daddr="+lat+","+long+"&amp;ll=");
        } else {
            window.open("https://maps.google.com/maps?daddr="+lat+","+long+"&amp;ll=");
        }
    });

	// Apply ImageFill	
	jQuery('.ich-settings-main-wrap .image-fill').each(function(index, el) {
		jQuery(this).imagefill();
	});

    if ($('.fotorama-custom').length) {
        var fotoramaSlider = $('.fotorama-custom').on('fotorama:ready fotorama:fullscreenenter fotorama:fullscreenexit', function (e, fotorama) {
            var fotoramaFit = $(this).data('fit');

            if (e.type === 'fotorama:fullscreenenter') {
                // Options for the fullscreen
                fotorama.setOptions({
                    fit: 'contain'
                });
            } else {
                // Back to normal settings
                fotorama.setOptions({
                    fit: fotoramaFit
                });
            }
            
            if (e.type === 'fotorama:ready') {
                $('.ich-settings-main-wrap').find('.fotorama-custom').css('visibility', 'visible');
            }        
        }).fotorama();

        $('.wrap-slider').on('click', '.rem-open-gallery', function(event) {
            event.preventDefault();
            var fotoranaObj = fotoramaSlider.data('fotorama');
            fotoranaObj.requestFullScreen();
        });
    }
    
    if ($('.slick-custom').length) {
        $('.slick-custom').not('.slick-initialized').slick();
        $('.slick-custom').magnificPopup({
            delegate: '.rem-slider-image',
            type: 'image',
            fixedContentPos: true,
            closeOnBgClick: true,
            alignTop: false,
            mainClass: 'rem-gallery-popup',
            gallery: {
                enabled: true,
                navigateByImgClick: true,
                preload: [0,1] // Will preload 0 - before current, and 1 after the current image
            },
            callbacks: {
                elementParse: function(item) { item.src = item.el.attr('src'); }
            }
        });
        if($('.rem-slider-thumbnails').length){
            $('.rem-slider-thumbnails').not('.slick-initialized').slick({
              autoplay: false,
              slidesToShow: 6,
              slidesToScroll: 1,
              asNavFor: '.slick-custom',
              dots: false,
              arrows: false,
              focusOnSelect: true,
              variableWidth: true
            });
        }

        $('.rem-additional-images').each(function(index, el) {
            $(this).magnificPopup({
                delegate: '.rem-single-image',
                type: 'image',
                fixedContentPos: true,
                closeOnBgClick: true,
                alignTop: false,
                mainClass: 'rem-gallery-popup',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0,1]
                },
                callbacks: {
                    elementParse: function(item) {
                        console.log(item.el);
                        item.src = item.el.data('url');
                    }
                }
            });
        });
    }

    if($('.rem-additional-gallery').length){
        $('.rem-additional-gallery').slick();
    }

    if($('.rem-additional-gallery-thumbnails').length){
        $('.rem-additional-gallery-thumbnails').slick();
    }

    if ($('.contact-agent-form input[type="tel"]').length) {
        var intlTelInputVars = $('.contact-agent-form input[type="tel"]').data();
        $('.contact-agent-form input[type="tel"]').intlTelInput(intlTelInputVars);
    }

    if ($('.grid-custom').length) {
        var images = $('.grid-custom').children('img').map(function(){
            return $(this).attr('src')
        }).get();
        var grid_options = $('.grid-custom').data('grid');
        grid_options.remimages = images;
        grid_options.getViewAllText = function(imagesCount) {
            var txt = rem_property_map.grid_view_txt;
            txt = txt.replace("%count%", imagesCount);
            return txt;
        }
        $('.grid-custom').html('');
        $('.grid-custom').imagesGrid(grid_options);
    }

	// Maps Related
    function rem_insert_marker(map, position){
        if (rem_property_map.property_map_location_style == 'pin') {
            var image = rem_property_map.maps_icon_url;
            var marker = new google.maps.Marker({
                position: position,
                map: map,
                icon: image
            });

        } else {
            var locationCircle = new google.maps.Circle({
                strokeColor: rem_property_map.rem_main_color,
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: rem_property_map.rem_main_color,
                fillOpacity: 0.35,
                map: map,
                center: position,
                radius: parseInt(rem_property_map.property_map_radius)
            });
        };
    }
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
            minZoom: zoom - 5,
            maxZoom: zoom + 5,
            styles: (rem_property_map.maps_styles != '') ? JSON.parse(rem_property_map.maps_styles) : '',
        };

        var map=new google.maps.Map(document.getElementById("map-canvas"),mapProp);
        map.setTilt(0);

        rem_insert_marker(map, myLatLng);

        if (load_map_from == 'address') {
            var geocoder = new google.maps.Geocoder();
            var address = rem_property_map.address;
            geocoder.geocode({'address': address}, function(results, status) {
                if (status === 'OK') {
                    map.setCenter(results[0].geometry.location);
                    rem_insert_marker(map, results[0].geometry.location);
                } else {
                    alert('Unable to load map because : ' + status);
                }
            });
        }
    }

    if (rem_property_map.latitude != 'disable' && rem_property_map.use_map_from == 'google_maps' && jQuery('#map-canvas').length) {
        google.maps.event.addDomListener(window, 'load', initializeSinglePropertyMap);
    }
    if (rem_property_map.use_map_from == 'leaflet') {
        if ("ontouchstart" in document.documentElement) {
            var dragging = false;
        } else {
            var dragging = true;
        }        
        var property_map = L.map('map-canvas', {scrollWheelZoom: false, dragging: dragging}).setView([rem_property_map.latitude, rem_property_map.longitude], parseInt(rem_property_map.zoom));
        
        L.tileLayer(rem_property_map.leaflet_styles.provider, {
                maxZoom: 21,
                attribution: rem_property_map.leaflet_styles.attribution
            }).addTo(property_map);
        var propertyIcon = L.icon({
            iconUrl: rem_property_map.maps_icon_url,
            iconSize: rem_property_map.icons_size,
            iconAnchor: rem_property_map.icons_anchor,
        });
        if (rem_property_map.load_map_from == 'address') {
            jQuery.get(location.protocol + '//nominatim.openstreetmap.org/search?format=json&q='+rem_property_map.address, function(data){
               if (data.length > 0) {
                    var lat = data[0].lat;
                    var lon = data[0].lon;
                    property_map.setView([lat, lon], parseInt(rem_property_map.zoom));
                    if (rem_property_map.property_map_location_style == 'pin') {
                        var marker = L.marker([lat, lon], {icon: propertyIcon}).addTo(property_map);
                    } else {
                        var circle = L.circle([lat, lon], parseInt(rem_property_map.property_map_radius), { color: rem_property_map.rem_main_color, fillColor: rem_property_map.rem_main_color, fillOpacity: 0.5 }).addTo(property_map);
                    }
               } else {
                    alert('No results found for address: '+rem_property_map.address);
               }
            });
        } else {
            if (rem_property_map.property_map_location_style == 'pin') {
                var marker = L.marker([rem_property_map.latitude, rem_property_map.longitude], {icon: propertyIcon}).addTo(property_map);
            } else {
                var circle = L.circle([rem_property_map.latitude, rem_property_map.longitude], parseInt(rem_property_map.property_map_radius), { color: rem_property_map.rem_main_color, fillColor: rem_property_map.rem_main_color, fillOpacity: 0.5 }).addTo(property_map);
            }            
        }


        if (rem_property_map.maps_styles != '') {
            // console.log(rem_property_map.maps_styles);
            // L.geoJSON(JSON.parse(rem_property_map.maps_styles)).addTo(property_map);
        }
    }
        
});