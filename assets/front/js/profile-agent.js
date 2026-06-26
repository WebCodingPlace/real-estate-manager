jQuery(document).ready(function($) {

    if ($('.contact-agent-form input[type="tel"]').length) {
        var intlTelInputVars = $('.contact-agent-form input[type="tel"]').data();
        $('.contact-agent-form input[type="tel"]').intlTelInput(intlTelInputVars);
    }
    
	// Contact Agent frontend
	$('.contact-agent-form').submit(function(event) {
		event.preventDefault();
        var c_form = $(this);
		c_form.closest('div').find('.sending-email').show();
		var ajaxurl = c_form.data('ajaxurl');
		var data = c_form.serialize();

		$.post(ajaxurl, data, function(resp) {
			// console.log(resp);
			if (resp.status == 'sent') {
				c_form.closest('div').find('.sending-email').removeClass('alert-info').addClass('alert-success');
				c_form.closest('div').find('.msg').html(resp.msg);
			} else {
				c_form.closest('div').find('.sending-email').removeClass('alert-info').addClass('alert-danger');
				c_form.closest('div').find('.msg').html(resp.msg);
			}
		}, 'json');
	});
	// SkillsBars
	setTimeout(function() {
		$('.skillbar').each(function(){
			/*$(this).find('.skillbar-bar').animate({
				width:$(this).attr('data-percent')
			}, 2000);*/
			var c_num_arr = $(this).attr('data-percent').split(/([^0-9])/);
			var c_ch = (undefined !== c_num_arr[1]) ? c_num_arr[1] : '';
			// console.log(c_num_arr[1]);
		    $(this).prop('Counter',0).animate({
		        Counter: parseInt(c_num_arr[0])
		    }, {
		        duration: 3000,
		        easing: 'swing',
		        step: function (now) {
		        	$(this).find('.skill-bar-percent').text(Math.ceil(now)+c_ch);
		        }
		    });		
		});
	}, 200);

	$(".wcp-slick").each(function(index, el) {
		var slick_ob = {
		  	infinite: true,
			dots: false,		  
			arrows: true,
			prevArrow: $('.my-listings-left'),
			nextArrow: $('.my-listings-right'),
			autoplay: true,
			autoplaySpeed: 2000,
			draggable: true,
			speed: 1000,
			slidesToShow: 3,
			slidesToScroll: 1,
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
		}
		if ($('body').hasClass('rtl')) {
			slick_ob.rtl = true;	
		}		
		$(this).slick(slick_ob);
	});	

	// Apply ImageFill	
	jQuery('.ich-settings-main-wrap .image-fill').each(function(index, el) {
		jQuery(this).imagefill();
	});
	
});