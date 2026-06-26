jQuery(document).ready(function($) {
	$('ul.page-numbers').addClass('pagination');
	$('.page-numbers.current').closest('li').addClass('active');

	$('.rem-listings-wrap-ajax-enable').on('click', 'a.page-numbers', function(event) {
		event.preventDefault();
		var parent = $(this).closest('.rem-listings-wrap-ajax-enable');
		parent.addClass('rem-loading-ajax');
		var paged = $(this).text();
		if($(this).hasClass('next')){
			paged = parseInt($(this).closest('.pagination').find('.current').text()) + 1;
		}
		if($(this).hasClass('prev')){
			paged = parseInt($(this).closest('.pagination').find('.current').text()) - 1;
		}
		var data = {
			action: 'rem_list_properties_ajax',
			args: JSON.parse($('.rem-ajax-query-args').val()),
			total: parent.data('total'),
			paged: paged,
		}
		$.post(rem_pagination.ajax_url, data, function(resp) {
			parent.html(resp);
			parent.removeClass('rem-loading-ajax');
			$('ul.page-numbers').addClass('pagination');
			$('.page-numbers.current').closest('li').addClass('active');

			if (parent.find('.rem-fixed-images').length) {
				parent.find('.rem-fixed-images').find('.rem-style-2 .img-container').addClass('image-fill');
				parent.find('.rem-fixed-images').find('.rem-style-1 .img-container').addClass('image-fill');
				var images_height = parent.find('.rem-fixed-images').data('imagesheight');
				if (images_height != '') {
					parent.find('.rem-fixed-images').find('.rem-style-2 .img-container').css('height', images_height);
					parent.find('.rem-fixed-images').find('.rem-style-1 .img-container').css('height', images_height);
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
			parent.find('.image-fill').each(function(index, el) {
				jQuery(this).imagefill();
			});
		});
	});
});