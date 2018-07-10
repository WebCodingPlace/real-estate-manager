<div class="landz-box-property box-list">
    <?php do_action( 'rem_property_ribbon', $property_id ); ?>
	<a target="<?php echo $target; ?>" class="hover-effect image image-fill" href="<?php echo get_permalink($property_id); ?>">
		<span class="cover"></span>
		<?php do_action( 'rem_property_picture', $property_id ); ?>
		<h3 class="title"><?php echo get_the_title($property_id); ?></h3>
	</a>
    <?php if (get_post_meta( $property_id, 'rem_property_price', true ) != '') { ?>
	   <span class="price"><?php echo rem_display_property_price($property_id); ?></span> 
    <?php } ?>
	<span class="address">
        <i class="fa fa-map-marker"></i>
        <?php if (rem_get_option('inline_property_bar_fields', '') != '') {
            $fields = explode("\n", rem_get_option('inline_property_bar_fields'));
            $fields_val = array();
            foreach ($fields as $f) {
                if (get_post_meta( $property_id, 'rem_'.trim($f), true ) != '') {
                    $fields_val[] = get_post_meta( $property_id, 'rem_'.trim($f), true );
                }
            }
            $fields_sep = apply_filters( 'rem_inline_top_fields_sep', ', ' );
            echo implode( $fields_sep, $fields_val );
        } else {
            echo $address;
        } ?>
    </span>
	<span class="description"><?php echo wp_trim_words( get_the_excerpt( $property_id ), rem_get_option('properties_excerpt_length', 15)); ?></span>

	<?php do_action( 'rem_property_details_icons', $property_id, 'inline' ); ?>
	
	<div class="footer">
            <?php
                $terms = wp_get_post_terms( $property_id ,'rem_property_tag' );
                 
                echo '<div id="filter-box" class="hidden-xs">';
                 
                foreach ( $terms as $term ) {
                    // The $term is an object, so we don't need to specify the $taxonomy.
                    $term_link = get_term_link( $term );
                    
                    // If there was an error, continue to the next term.
                    if ( is_wp_error( $term_link ) ) {
                        continue;
                    }
                    // We successfully got a link. Print it out.
                    echo '<a style="margin-left:10px;position:relative !important;margin-top:10px;" class="filter" href="' . esc_url( $term_link ) . '">' . $term->name . ' <i class="fa fa-tag"></i></a>';
                }
                 
                echo '</div>';
                ?>	
		<a target="<?php echo $target ?>" class="btn btn-default" href="<?php echo get_permalink($property_id); ?>"><?php _e( 'Details', 'real-estate-manager' ); ?></a>
	</div>
</div>