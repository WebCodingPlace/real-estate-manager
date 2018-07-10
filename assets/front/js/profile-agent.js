jQuery(document).ready(function($) {
	// Contact Agent frontend
	$('#contact-agent').submit(function(event) {
		event.preventDefault();
		$('.sending-email').show();
		var ajaxurl = $(this).data('ajaxurl');
		var data = $(this).serialize();
		// console.log(data);

		$.post(ajaxurl, data, function(resp) {
			// console.log(resp);
			if (resp.status == 'sent') {
				$('.sending-email').removeClass('alert-info').addClass('alert-success');
				$('.sending-email .msg').html(resp.msg);
			} else {
				$('.sending-email').removeClass('alert-info').addClass('alert-danger');
				$('.sending-email .msg').html(resp.msg);
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
			autoplay: true,
			autoplaySpeed: 2000,
			draggable: true,
			speed: 2000,
			slidesToShow: 4,
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
		};
		$(this).slick(slick_ob);
	});	

	// Apply ImageFill	
	jQuery('.ich-settings-main-wrap .image-fill').each(function(index, el) {
		jQuery(this).imagefill();
	});
});