jQuery(document).ready(function($) {

	$('.ich-settings-main-wrap .image-fill').each(function(index, el) {
		jQuery(this).imagefill();
	});

	$('.search-options .wcp-eq-height > div').matchHeight({byRow: false});

	$('ul.page-numbers').addClass('pagination');
	$('.page-numbers.current').closest('li').addClass('active');
	
	$('.search-property-form').submit(function(event) {
		event.preventDefault();
		var s_wrap = $(this).closest('.ich-settings-main-wrap');
		var results_cont = '';
		if ($(this).data('resselector') != '') {
			results_cont = $($(this).data('resselector'));
		} else {
			results_cont = s_wrap.find('.searched-proerpties');
		}
		s_wrap.find('.searched-proerpties').html('');
		s_wrap.find('.loader').show();

	    var ajaxurl = $(this).data('ajaxurl');
	    var formData = $(this).serialize();

	    $.post(ajaxurl, formData, function(resp) {
			s_wrap.find('.loader').hide();
	    	results_cont.html(resp);
		    $('html, body').animate({
		        scrollTop: results_cont.offset().top
		    }, 2000);
			$('.ich-settings-main-wrap .image-fill').each(function(index, el) {
				jQuery(this).imagefill();
			});
			/*$('.searched-proerpties').imagesLoaded( function() {
				$('.searched-proerpties > .row').masonry({
					// itemSelector: '.m-item'
				});
			});*/
	    });
	});
	
	if (jQuery('.labelauty-unchecked-image').length == 0) {
		jQuery(".labelauty").labelauty();
	}

	var $filter = jQuery('.filter', '#rem-search-box');

	jQuery('.botton-options', '#rem-search-box').on('click', function(){
		hideSearcher();
	});

	function hideSearcher(navigatorMap){

		if(navigatorMap==true){
			$searcher.slideUp(500);
		} else {
			$searcher.slideToggle(500);
		}
		return false;
	}

	jQuery(".set-searcher", '#rem-search-box').on('click', hideSearcher);

	jQuery(".more-button", '#rem-search-box').on('click', function(){
		$filter.toggleClass('hide-filter');
		return false;
	});

	$('.p-slide-wrap').each(function(index, el) {
		$(this).find('.price-range').noUiSlider({
			start: [ parseInt(rem_ob.price_min_default), parseInt(rem_ob.price_max_default) ],
			behaviour: 'drag',
			step: parseInt(rem_ob.price_step),
			connect: true,
			range: {
				'min': parseInt(rem_ob.price_min),
				'max': parseInt(rem_ob.price_max)
			},
			format: wNumb({
				decimals: parseInt(rem_ob.decimal_points),
				mark: rem_ob.decimal_separator,
				thousand: rem_ob.thousand_separator,
			}),
		});

		$(this).find('.price-range').Link('lower').to( $(this).find('#price-value-min') );
		$(this).find('.price-range').Link('lower').to( $(this).find('#min-value') );
		$(this).find('.price-range').Link('upper').to( $(this).find('#price-value-max') );
		$(this).find('.price-range').Link('upper').to( $(this).find('#max-value') );
	});
	
});