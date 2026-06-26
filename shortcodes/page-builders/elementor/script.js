jQuery( window ).on( 'elementor/frontend/init', () => {
    const addHandler = ( $element ) => {
        jQuery(".wcp-slick").each(function(index, el) {
            var slick_ob = {
                infinite: true,
                dots: false,          
                arrows: true,
                prevArrow: jQuery('.my-listings-left'),
                nextArrow: jQuery('.my-listings-right'),
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
            if (jQuery('body').hasClass('rtl')) {
                slick_ob.rtl = true;    
            }       
            jQuery(this).slick(slick_ob);
        });
    };
    elementorFrontend.hooks.addAction( 'frontend/element_ready/rem_agent_profile.default', addHandler );
});