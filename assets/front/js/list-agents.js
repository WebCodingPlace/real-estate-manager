jQuery(document).ready(function($) {

	if ($('.masonry-agents').length) {
		// images have loaded
		$('.masonry-agents').imagesLoaded( function() {
			$('.masonry-agents').masonry({
				itemSelector: '.rem-agent-container'
			});
		});		
	}
});