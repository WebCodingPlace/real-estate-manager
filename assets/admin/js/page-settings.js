jQuery(document).ready(function($) {
    $('select').select2();
    var icons = {
        header: "dashicons dashicons-plus",
        activeHeader: "dashicons dashicons-minus"
    }

    // tabs relates
    $("#rem-settings-form .panel-default").hide().first().show();
    $(".wcp-tabs-menu a:first").addClass("active");
    $(".wcp-tabs-menu a").on('click', function (e) {
        e.preventDefault();
        $(this).addClass("active").siblings().removeClass("active");
        $($(this).attr('href')).show().siblings('.panel-default').hide();
    });
    var hash = $.trim( window.location.hash );
    if (hash) $('.wcp-tabs-menu a[href$="'+hash+'"]').trigger('click');


	$('#rem-settings-form').submit(function(event) {
		event.preventDefault();
        $('.wcp-progress').show();
		$('.wcp-progress').html('Please Wait...');
        var data = $(this).serialize();

        $.post(ajaxurl, data, function(resp) {
            $('.wcp-progress').html('');
            swal(resp, "Settings saved in database successfully!", "success");
		});
	});

    $('.colorpicker').wpColorPicker();

    // Media Uploader
    var ich_cpt_uploader;
     
    jQuery('.upload_image_button').live('click', function( event ){
     
        event.preventDefault();

        var this_widget = jQuery(this).closest('.form-group');
     
        // Create the media frame.
        ich_cpt_uploader = wp.media.frames.ich_cpt_uploader = wp.media({
          title: jQuery( this ).data( 'title' ),
          button: {
            text: jQuery( this ).data( 'btntext' ),
          },
          multiple: false  // Set to true to allow multiple files to be selected
        });
     
        // When an image is selected, run a callback.
        ich_cpt_uploader.on( 'select', function() {
          // We set multiple to false so only get one image from the uploader
          attachment = ich_cpt_uploader.state().get('selection').first().toJSON();
            jQuery(this_widget).find('.image-url').val(attachment.url);
        });
     
        // Finally, open the modal
        ich_cpt_uploader.open();
    });

    if ($('#use_map_from').val() == 'leaflet') {
        $('.wrap_maps_api_key').hide();
    }

    $('#use_map_from').change(function(event) {
        event.preventDefault();
        if ($(this).val() == 'google_maps') {
            $('.wrap_maps_api_key').show();
        } else {
            $('.wrap_maps_api_key').hide();
        }
    });
});