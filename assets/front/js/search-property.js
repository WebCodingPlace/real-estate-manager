jQuery(document).ready(function($) {
	if (typeof $('.rem-select2-field').select2 === "function") { 
		$('.rem-select2-field').select2({placeholder: $(this).data('placeholder')});
	    $('.select2-container').width('100%');
	}
	$('.ich-settings-main-wrap .image-fill').each(function(index, el) {
		jQuery(this).imagefill();
	});

	if ($('.search-options .wcp-eq-height').length) {
		$('.search-options .wcp-eq-height > div').matchHeight({byRow: false});
	}

	$('ul.page-numbers').addClass('pagination');
	$('.page-numbers.current').closest('li').addClass('active');
	
	$('.search-property-form').submit(function(event) {
		event.preventDefault();
		$(this).data('offset', parseInt(rem_ob.offset));
		var s_wrap = $(this).closest('.ich-settings-main-wrap');
		var results_cont = '';
		if ($(this).data('resselector') != '') {
			selectorTest = $(this).data('resselector');
			if ( selectorTest.indexOf('.') != 0 && selectorTest.indexOf('#') != 0 ){
				if ( $("." + selectorTest).length )
				{
					results_cont = $("." + selectorTest);
				} else if ( $("#" + selectorTest).length ) {
					results_cont = $("#" + selectorTest);
				}
			} else {
				if ( $(selectorTest).length ){
					results_cont = $(selectorTest);
				}
			}
		}

		if ( results_cont == '' || typeof results_cont === "undefined" ){
			results_cont = s_wrap.find('.searched-properties');
		}
		s_wrap.find('.searched-properties').html('');
		s_wrap.find('.loader').show();

	    var ajaxurl = $(this).data('ajaxurl');
	    var formData = $(this).serializeArray();

		 
	    function arrayClean(thisArray, thisName) {
	    	
		    $.each(thisArray, function(index, item) {
		        if (item != undefined ) {

			        if (item.name == thisName) {
			            formData.splice( index, 1);      
			        }
		        };
		    });
		}
	    var fields = $(".rem-field-hide select").map(function() {
        	return $(this).attr('name');
       	}).get();
	    $.each( fields, function(index, key){
	    	arrayClean( formData, key);
	    });

	    $.post(ajaxurl, formData, function(resp) {
			s_wrap.find('.loader').hide();
	    	results_cont.html(resp);
	    	if (s_wrap.data('autoscroll') == 'enable') {
			    $('html, body').animate({
			        scrollTop: results_cont.offset().top
			    }, 2000);
	    	}
			$('.ich-settings-main-wrap .image-fill').each(function(index, el) {
				jQuery(this).imagefill();
			});
			
			if ($('.search-property-form').data('offset') == '-1') {
				$('.rem-load-more-wrap').hide();
			}
			if ($('.masonry-enabled').length) {
				$('.searched-properties').imagesLoaded( function() {
					$('.searched-properties > .row').masonry();
				});
			}
			$('ul.page-numbers').addClass('pagination');
			
			$('.page-numbers.current').closest('li').addClass('active');
	    });
	}); 

	if ($('.search-property-form').length > 0 && $('.search-property-form').data('offset') != '-1') {
		
		$('body').on('click', '.rem-load-more-wrap a.page-numbers', function(event) {
			event.preventDefault();
			var paged = $(this).text();
			if($(this).hasClass('next')){
				paged = parseInt($(this).closest('.pagination').find('.current').text()) + 1;
			}
			if($(this).hasClass('prev')){
				paged = parseInt($(this).closest('.pagination').find('.current').text()) - 1;
			}

			var form = $('.search-property-form');
			var s_wrap = $(form).closest('.ich-settings-main-wrap');
			var results_cont = '';
			if ($(form).data('resselector') != '') {
				selectorTest = $(form).data('resselector');
				if ( selectorTest.indexOf('.') != 0 && selectorTest.indexOf('#') != 0 ){
					if ( $("." + selectorTest).length )
					{
						results_cont = $("." + selectorTest);
					} else if ( $("#" + selectorTest).length ) {
						results_cont = $("#" + selectorTest);
					}
				} else {
					if ( $(selectorTest).length ){
						results_cont = $(selectorTest);
					}
				}
			}

			if ( results_cont == '' || typeof results_cont === "undefined" ){
				results_cont = s_wrap.find('.searched-properties');
			}

			results_cont.addClass('rem-loading-ajax');

		    var ajaxurl = $(form).data('ajaxurl');
		    var formData = $(form).serializeArray();

			 
		    function arrayClean(thisArray, thisName) {
		    	
			    $.each(thisArray, function(index, item) {
			        if (item != undefined ) {

				        if (item.name == thisName) {
				            formData.splice( index, 1);      
				        }
			        };
			    });
			}
		    var fields = $(".rem-field-hide select").map(function() {
	        	return $(form).attr('name');
	       	}).get();
	       	
		    $.each( fields, function(index, key){
		    	arrayClean( formData, key);
		    });
		    var paged_obj = {
		    	name : 'paged',
		    	value : parseInt(paged)
		    }
		    formData.push(paged_obj);
		    
		    $.post(ajaxurl, formData, function(resp) {
		    	results_cont.html(resp);
				$('.ich-settings-main-wrap .image-fill').each(function(index, el) {
					jQuery(this).imagefill();
				});

				setTimeout(function() {
					if ($('.masonry-enabled').length) {
						$('.searched-properties').imagesLoaded( function() {
							$('.searched-properties > .row').masonry();
						});
					}
				}, 500);

				$('ul.page-numbers').addClass('pagination');
				$('.page-numbers.current').closest('li').addClass('active');
				results_cont.removeClass('rem-loading-ajax');
		    });
		});
	}

	if (jQuery('.labelauty-unchecked-image').length == 0 && jQuery(".labelauty").length) {
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

	if ($('.search-container.auto-complete').length > 0) {
		$('.search-container.auto-complete input[type=text]').autocomplete({
		    source: function (request, response) {
		    	var element_id = $(this.element).attr('id');
		    	var ajax_url = $('#search-property').data('ajaxurl');
		    	var data = {
		    		action: 'rem_search_autocomplete',
		    		field: element_id,
		    		search: request.term
		    	}
		    	$.post(ajax_url, data, function(resp) {
		    		if (resp != '') {
		    			response( JSON.parse(resp) );	
		    		}
		    	});
		    }
		});		
	}

	if ($('.rem-widget-search.auto-complete').length > 0) {
		$('.rem-widget-search.auto-complete input[type=text]').autocomplete({
		    source: function (request, response) {
		    	var element_id = $(this.element).attr('id');
		    	var ajax_url = $('.rem-ajax-url').val();
		    	var data = {
		    		action: 'rem_search_autocomplete',
		    		field: element_id,
		    		search: request.term
		    	}
		    	$.post(ajax_url, data, function(resp) {
		    		if (resp != '') {
		    			response( JSON.parse(resp) );	
		    		}
		    	});
		    }
		});		
	}
	$('button[type="reset"]').on('click', function(event) {
		$('.p-slide-wrap').each(function(index, el) {
			$(this).find('.price-range').val([parseInt(rem_ob.price_min_default), parseInt(rem_ob.price_max_default) ]);
		});

		$('.slider-range-input').each(function(index, el) {
			$(this).find('.price-range').val([ parseInt($(this).data('default_min')), parseInt($(this).data('default_max')) ]);
		});

		if (typeof $('.rem-select2-field').select2 === "function") { 
			jQuery('.rem-select2-field').val([]).change();
		}
	});

	rerender_price_ranges = function(element, type = '', initial = false){
		if(!initial){
			element.get(0).destroy();
		}
		element.noUiSlider({
			start: [ parseInt(rem_ob['price_min_default'+type]), parseInt(rem_ob['price_max_default'+type]) ],
			behaviour: 'drag',
			direction: rem_ob.site_direction,
			step: parseInt(rem_ob['price_step'+type]),
			connect: true,
			change: function(){
			},
			range: {
				'min': parseInt(rem_ob['price_min'+type]),
				'max': parseInt(rem_ob['price_max'+type])
			},
			format: wNumb({
				decimals: parseInt(rem_ob.decimal_points),
				mark: rem_ob.decimal_separator,
				thousand: rem_ob.thousand_separator,
			}),
		});
		var wrap = element.closest('.p-slide-wrap');
		element.Link('lower').to( wrap.find('#price-value-min') );
		element.Link('lower').to( wrap.find('#min-value') );
		element.Link('upper').to( wrap.find('#price-value-max') );
		element.Link('upper').to( wrap.find('#max-value') );
	}

	$('.p-slide-wrap').each(function(index, el) {
		rerender_price_ranges($(this).find('.price-range'), '', true);
	});

	$('.rem-search-form-wrap').on('change', '[name='+rem_ob.price_range_name+']', function(event) {
		event.preventDefault();
		if ($(this).val() == rem_ob.price_range_value) {
			rerender_price_ranges($(this).closest('.rem-search-form-wrap').find('.price-range'), '_r');
		} else {
			rerender_price_ranges($(this).closest('.rem-search-form-wrap').find('.price-range'));
		}
	});

	$('.slider-range-input').each(function(index, el) {
	    
	    $(this).noUiSlider({
	        start: [ parseInt($(this).data('default_min')), parseInt($(this).data('default_max')) ],
	        behaviour: 'drag',
	        direction: rem_ob.site_direction,
	        step: 1,
	        connect: true,
	        range: {
	            'min': parseInt($(this).data('min')),
	            'max': parseInt($(this).data('max'))
	        },
			format: wNumb({
				decimals: parseInt(rem_ob.range_decimal_points
					),
				mark: rem_ob.range_decimal_separator,
				thousand: rem_ob.range_thousand_separator,
			}),
	    });
	    $(this).Link('lower').to( $(this).siblings('.price-slider').find('.price-value-min') );
	    $(this).Link('lower').to( $(this).siblings('.min-value') );
	    $(this).Link('upper').to( $(this).siblings('.price-slider').find('.price-value-max') );
	    $(this).Link('upper').to( $(this).siblings('.max-value') );
	});


	$('.price-slider').on('change', '.any-check', function(event) {
		event.preventDefault();
		var rangeWrapper = $(this).closest('.p-slide-wrap');
		if ($(this).find('input').is(":checked")){
			rangeWrapper.find('.noUi-base, span').css({
				'opacity': '0.5',
				'pointer-events': 'none'
			});
			rangeWrapper.find('.min-value').val('');
			rangeWrapper.find('.max-value').val('');
		} else {
			rangeWrapper.find('.noUi-base, span').css({
				'opacity': '1',
				'pointer-events': 'inherit'
			});
			var min_val = rangeWrapper.find('.price-value-min').text();
			var max_val = rangeWrapper.find('.price-value-max').text();
			rangeWrapper.find('.min-value').val(min_val);
			rangeWrapper.find('.max-value').val(max_val);
		}
	});
	
	$('.price-slider .any-check').each(function(index, checkbox) {
		var rangeWrapper = $(this).closest('.p-slide-wrap');
		if ($(checkbox).find('input').is(':checked')) {
			rangeWrapper.find('.noUi-base, span').css({
				'opacity': '0.5',
				'pointer-events': 'none'
			});
			rangeWrapper.find('.min-value').val('');
			rangeWrapper.find('.max-value').val('');
		};
	});

	// price dropdown 
	$('body').on('change', '.rem_price_dropdown', function(event) {
		event.preventDefault();
		/* Act on the event */
		
		var optionSelected = $("option:selected", this);
		var min = optionSelected.data('min');
		var max = optionSelected.data('max');
		
		$(this).siblings('.rem_price_dropdown_values').find('#min-value').val(min);
		$(this).siblings('.rem_price_dropdown_values').find('#max-value').val(max);
	});

	$('.rem_ajax_search_property_form').change(function() {
		var ajax_url = $('.rem-ajax-url').val();
		var formData = $(this).serializeArray();
		var result_area_id = $(this).data('result_area_id');
		$(result_area_id).css({
			'opacity': '.5'
		});
		
		$.post(ajax_url, formData, function(resp) {
			$(result_area_id).css({
				'opacity': '1'
			});
	    	$(result_area_id).html(resp);
			    $('html, body').animate({
			        scrollTop: $(result_area_id).offset().top
			    }, 2000);
			$('.ich-settings-main-wrap .image-fill').each(function(index, el) {
				jQuery(this).imagefill();
			});
			
			if ($('.masonry-enabled').length) {
				$('.searched-properties').imagesLoaded( function() {
					$('.searched-properties > .row').masonry();
				});
			}
			$(result_area_id).find('.rem-load-more-wrap').hide();
	    });
	});

    if ($('.rem-states-list').length && $('.rem-countries-list').length) {
        $('#rem-search-box').on('change', '.rem-countries-list', function(event) {
            var currentTab = $(this).closest('.row');
            var ajax_url = $('#search-property').data('ajaxurl');
            event.preventDefault();
            var data = {
                action: 'rem_get_states',
                country: $(this).val(),
                nonce: rem_ob.nonce_states
            }
            $.post(ajax_url, data, function(resp) {
                currentTab.find('.rem-states-list').html(resp);
                var state = currentTab.find('.rem-states-list').data('state');
                currentTab.find('.rem-states-list').val(state);
            });
        });
        if ($('.rem-countries-list').val() != '') {
	        $('.rem-countries-list').trigger('change');
	    }
    }
});