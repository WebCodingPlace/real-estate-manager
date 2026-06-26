<div class="propery-style-6">
    <?php do_action( 'rem_property_ribbon', $property_id ); ?>
    <a target="<?php echo esc_attr($target); ?>" href="<?php echo get_permalink($property_id); ?>">
    <div class="post-img image image-fill">
        <?php do_action( 'rem_property_picture', $property_id ); ?>
        <div class="category">
            <span class="price">
                <?php if (get_post_meta( $property_id, 'rem_property_price', true ) != '') { ?>
                    <?php echo rem_display_property_sale_price($property_id); ?>
                <?php } ?>
            </span>
            <span><?php echo esc_attr($city); ?></span>
        </div>
        <?php if ($purpose != '') { ?>
            <div class="category-1"><?php echo esc_attr($purpose); ?></div>
        <?php } ?>
        <?php if ($property_type != '') { ?>
        <div class="property-type"><?php echo esc_attr($property_type); ?></div>
        <?php } ?>
    </div>
    </a>
    <div class="post-review">
        <h3 class="post-title">
            <?php echo get_the_title($property_id); ?>
        </h3>
        <span class="location"><i class="fa fa-map-marker-alt" aria-hidden="true"></i> <?php echo esc_attr($address); ?></span>
        <p class="post-description">
            <?php echo wp_trim_words( get_the_excerpt( $property_id ), rem_get_option('properties_excerpt_length', 15)); ?>
        </p>
        <hr>
        <div class="post-bar">
            <?php do_action( 'rem_property_details_icons', $property_id, 'inline' ); ?>
            <div class="footer-buttons">
            <?php 
                do_action('rem_listing_footer', $property_id, $style , $target);
             ?>
            </div>
        </div>
    </div>
</div>