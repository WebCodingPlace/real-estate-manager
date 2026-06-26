<div class="box-property-slide propery-style-5">
    <?php do_action( 'rem_property_ribbon', $property_id ); ?>
	<a target="<?php echo esc_attr($target); ?>" href="<?php echo get_permalink($property_id); ?>" class="hover-effect right-block image-fill">
		<?php do_action( 'rem_property_picture', $property_id ); ?>
		<span class="cover"></span>
		<span class="cover-title"><?php echo get_the_title($property_id); ?></span>
	</a>
	<div class="left-block">
		<span class="title"><?php echo esc_attr($address); ?></span>
		<span class="description"><?php echo wp_trim_words( get_the_excerpt( $property_id ), rem_get_option('properties_excerpt_length', 15)); ?></span>

		<?php do_action( 'rem_property_details_icons', $property_id ); ?>

		<span class="price"><?php echo rem_display_property_price($property_id); ?></span>
		<div class="footer-buttons">
            <?php 
                do_action('rem_listing_footer', $property_id, $style , $target);
             ?>
            </div>
	</div>
</div><!-- /.box-property-slide -->