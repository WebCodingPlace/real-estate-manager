jQuery(document).ready(function($) {
    var rem_agent_profile_pic;
     
    jQuery('.upload_image_agent').live('click', function( event ){
     
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