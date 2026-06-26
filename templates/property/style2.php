<div class="rem-style-2 rem-property-box">
	<div class="img-container">
		<a target="<?php echo esc_attr($target); ?>" href="<?php echo get_permalink($property_id); ?>">
			<?php do_action( 'rem_property_ribbon', $property_id, 'box' ); ?>
			<?php if (rem_get_field_value('property_type', $property_id) != '') { ?>
			    <span class="property-type"><?php echo rem_get_field_value('property_type', $property_id); ?></span>
			<?php } ?>
            <span class="address-text">
                <i class="fa fa-map-marker-alt"></i>
                <?php do_action( 'rem_property_box_address', $property_id ); ?>
            </span>
            <span class="images-text">
                <i class="fa fa-camera"></i>
                <?php
                    $images = get_post_meta( $property_id, 'rem_property_images', true );
                    echo (is_array($images)) ? count($images) : 0 ;
                ?>
            </span>
			<?php do_action( 'rem_property_picture', $property_id ); ?>
		</a>
	</div>

	<div class="content-container">
		<a target="<?php echo esc_attr($target); ?>" href="<?php echo get_permalink($property_id); ?>">
		    <h2 class="property-title"><?php echo get_the_title($property_id); ?></h2> 
		</a>
		<p class="property-price">
            <?php if (get_post_meta( $property_id, 'rem_property_price', true ) != '') { ?>
               <span class="price"><?php echo rem_display_property_price($property_id); ?></span> 
            <?php } ?>
		</p>
		<p class="property-excerpt">
			<?php echo wp_trim_words( get_the_excerpt( $property_id ), rem_get_option('properties_excerpt_length', 15)); ?>
		</p>

		<?php do_action( 'rem_property_details_icons', $property_id, 'inline' ); ?>

		<div class="content-footer">
			<div class="agent-info">
			    <?php do_action( 'rem_property_box_agent_info', $property_id, $style, $target ); ?>
			</div>
			<div class="icons-wrap">
				<?php do_action('rem_listing_footer', $property_id, $style , $target); ?>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>