jQuery(document).ready(function($) {
	// Apply ImageFill	
	jQuery('.ich-settings-main-wrap .image-fill').each(function(index, el) {
		jQuery(this).imagefill();
	});

	if ($('.masonry-properties').length) {
		// images have loaded
		$('.masonry-properties').imagesLoaded( function() {
			$('.masonry-properties').masonry({
				itemSelector: '.m-item'
			});
		});		
	}
});