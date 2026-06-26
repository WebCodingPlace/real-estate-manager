<?php
    $args = rem_get_search_query($_REQUEST);
    // the query
    $the_query = new WP_Query( $args );
    
    ?>

    <?php if ( $the_query->have_posts() ) : ?>
    	<?php if (!isset($args['offset'])) { ?>
    		<div class="filter-title">
	            <h2>
	                <?php
	                    $heading = rem_get_option('s_results_h', 'Search Results (%count%)');
	                    $heading = str_replace('%count%', '<span class="rem-results-count">'.$the_query->found_posts.'</span>', $heading);
	                    echo wp_kses_post($heading);
	                ?>
	            </h2>
	        </div>
    	<?php } ?>
        <!-- the loop -->
        <div class="row">
            <?php
                $layout_style = rem_get_option('search_results_style', '1');
                $layout_style = apply_filters( 'rem_search_results_box_style', $layout_style, get_the_id(), $_REQUEST );
                $layout_cols = rem_get_option('search_results_cols', 'col-sm-12');
                $target = rem_get_option('searched_properties_target', '');
            ?>
            <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                <div id="property-<?php echo get_the_id(); ?>" class="<?php echo esc_attr($layout_cols); ?> rem-results-box">
                    <?php do_action('rem_property_box', get_the_id(), $layout_style, $target ); ?>
                </div>
            <?php endwhile; ?>
        </div>
        <?php wp_reset_postdata(); ?>

        <div class="text-center rem-load-more-wrap">
            <?php
                $paged = (isset($_REQUEST['paged'])) ? $_REQUEST['paged'] : 1 ;
                do_action( 'rem_pagination', $paged, $the_query->max_num_pages );
            ?>
        </div>
    <?php else : ?>
        <br>
        <div class="alert with-icon alert-info" role="alert">
            <i class="icon fa fa-info"></i>
            <span style="margin-top: 12px;margin-left: 10px;"><?php $msg = rem_get_option('no_results_msg', __( 'Sorry! No Properties Found. Try Searching Again.', 'real-estate-manager' )); echo apply_filters( 'no_results_msg',  stripcslashes($msg)); ?></span>
        </div>
    <?php endif;
?>