<div class="rem-box-maps">
    <a href="<?php echo esc_url($url); ?>" class="img-container" style="background-image:url(' <?php echo esc_url($img); ?> ')">
        <span class="title"><?php echo esc_attr($title); ?></span>
    </a>
    <div class="price"><?php echo wp_kses_post($price); ?>
    </div>
    <?php do_action( 'rem_property_details_icons', $property_id, 'inline' ); ?>
</div>