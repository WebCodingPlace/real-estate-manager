<div class="rem-box-maps">
    <a href="<?php echo $url; ?>" class="img-container" style="background-image:url(' <?php echo $img; ?> ')">
        <span class="title"><?php echo $title; ?></span>
    </a>
    <div class="price"><?php echo $price; ?></div>
    <?php do_action( 'rem_property_details_icons', get_the_id(), 'inline' ); ?>
</div>