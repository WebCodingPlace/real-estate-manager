jQuery( window ).on( 'elementor/frontend/init', () => {
    const addHandler = ( $element ) => {
        if (jQuery('.fotorama-custom').length) {
            jQuery('.fotorama-custom').on('fotorama:ready fotorama:fullscreenenter fotorama:fullscreenexit', function (e, fotorama) {
                var fotoramaFit = jQuery(this).data('fit');

                if (e.type === 'fotorama:fullscreenenter') {
                    // Options for the fullscreen
                    fotorama.setOptions({
                        fit: 'contain'
                    });
                } else {
                    // Back to normal settings
                    fotorama.setOptions({
                        fit: fotoramaFit
                    });
                }
                
                if (e.type === 'fotorama:ready') {
                    jQuery('#property-content').find('.fotorama-custom').css('visibility', 'visible');
                }        
            }).fotorama();
        }
        
        if (jQuery('.slick-custom').length) {
            jQuery('.slick-custom').not('.slick-initialized').slick();
            if(jQuery('.rem-slider-thumbnails').length){
                jQuery('.rem-slider-thumbnails').not('.slick-initialized').slick({
                  autoplay: false,
                  slidesToShow: 6,
                  slidesToScroll: 1,
                  asNavFor: '.slick-custom',
                  dots: false,
                  arrows: false,
                  focusOnSelect: true,
                  variableWidth: true
                });
            }
        }

        if (jQuery('.rem-attachment-slider').length) {
            jQuery('.rem-attachment-slider').not('.slick-initialized').slick({
              autoplay: true,
              slidesToShow: 1,
              slidesToScroll: 1,
              dots: false,
              arrows: true,
            });
        }

        if (jQuery('.elementor-editor-active .grid-custom').length) {
            var images = jQuery('.grid-custom').children('img').map(function(){
                return jQuery(this).attr('src')
            }).get();
            var grid_options = jQuery('.grid-custom').data('grid');
            grid_options.remimages = images;
            jQuery('.grid-custom').html('');
            jQuery('.grid-custom').imagesGrid(grid_options);
            jQuery('.grid-custom').css('pointer-events', 'none');
        }    
    };
    elementorFrontend.hooks.addAction( 'frontend/element_ready/gallery_images.default', addHandler );
});