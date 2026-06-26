jQuery(document).ready(function($) {
	$('.ich-settings-main-wrap .image-fill').each(function(index, el) {
		jQuery(this).imagefill();
	});
	$('.rem-search-results-wrap').imagesLoaded( function() {
		$('.rem-search-results-wrap > .row').masonry();
	});
});