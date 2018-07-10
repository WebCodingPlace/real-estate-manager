jQuery(document).ready(function($) {

	// Property Carousel
	$(".wcp-slick").each(function(index, el) {
		var slick_ob = {
		  	infinite: true,
			dots: ($(this).data('dots') == 'enable') ? true : false,		  
			arrows: ($(this).data('arrows') == 'enable') ? true : false,		  
			autoplay: ($(this).data('autoplay') == 'enable') ? true : false,
			autoplaySpeed: $(this).data('autoplayspeed'),
			draggable: true,
			speed: $(this).data('speed'),
			slidesToShow: $(this).data('slidestoshow'),
			slidesToScroll: $(this).data('slidestoscroll'),
			slidesPerRow: 1,
			rows: 1,
		  	responsive: [{
		      breakpoint: 768,
		      settings: {
		        slidesToShow: 2,
		        slidesToScroll: 1,
		      }
		    },
		    {
		      breakpoint: 480,
		      settings: {
		        slidesToShow: 1,
		        slidesToScroll: 1,
		      }
		    }]			
		};
		$(this).slick(slick_ob);
	});

	// Apply ImageFill	
	jQuery('.ich-settings-main-wrap .image-fill').each(function(index, el) {
		jQuery(this).imagefill();
	});
});