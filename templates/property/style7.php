<div class="property-style-7">
    <a target="<?php echo $target; ?>" href="<?php echo get_permalink($property_id); ?>" class="img-container" style="background-image:url(<?php echo get_the_post_thumbnail_url($property_id); ?>)">
        <span class="title"><?php echo get_the_title($property_id); ?></span>
    </a>
    <div class="price">
      <?php if (get_post_meta( $property_id, 'rem_property_price', true ) != '') { ?>
       <?php echo rem_display_property_price($property_id); ?>
      <?php } ?>
    </div>
   <?php do_action( 'rem_property_details_icons', $property_id, 'inline' ); ?>
</div>