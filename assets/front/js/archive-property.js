jQuery(document).ready(function($) {
	if (jQuery('.rem-fixed-images').length) {
		jQuery('.rem-fixed-images').find('.rem-style-2 .img-container').addClass('image-fill');
		jQuery('.rem-fixed-images').find('.rem-style-1 .img-container').addClass('image-fill');
		var images_height = jQuery('.rem-fixed-images').data('imagesheight');
		if (images_height != '') {
			jQuery('.rem-fixed-images').find('.rem-style-2 .img-container').css('height', images_height);
			jQuery('.rem-fixed-images').find('.rem-style-1 .img-container').css('height', images_height);
		}
	}
	if ($('.masonry-properties').length) {
		// images have loaded
		$('.masonry-properties').imagesLoaded( function() {
			$('.masonry-properties').masonry({
				itemSelector: '.m-item'
			});
		});		
	}
	$( '.icons-wrap li a' ).tooltip({
	    trigger : 'hover',
	});
});
jQuery(window).on('load', function() {
	// Apply ImageFill	
	jQuery('.ich-settings-main-wrap .image-fill').each(function(index, el) {
		jQuery(this).imagefill();
	});
});