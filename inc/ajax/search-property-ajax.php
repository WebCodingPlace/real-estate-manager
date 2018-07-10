<?php
    $args = rem_get_search_query($_REQUEST);
    // the query
    $the_query = new WP_Query( $args );
    $rem_all_settings = get_option( 'rem_all_settings' );
    ?>

    <?php if ( $the_query->have_posts() ) : ?>

        <div class="filter-title">
            <h2><?php _e( 'Search Results', 'real-estate-manager' ); ?> </h2>
        </div>
        <!-- the loop -->
        <div class="row">
            <?php
                $layout_style = rem_get_option('search_results_style', '1');
                $layout_cols = rem_get_option('search_results_cols', 'col-sm-12');
                $target = rem_get_option('searched_properties_target', '');
            ?>
            <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                <div id="property-<?php echo get_the_id(); ?>" class="<?php echo $layout_cols; ?>">
                    <?php do_action('rem_property_box', get_the_id(), $layout_style, $target ); ?>
                </div>
            <?php endwhile; ?>
        </div>
        <?php wp_reset_postdata(); ?>

    <?php else : ?>
        <br>
        <div class="alert with-icon alert-info" role="alert">
            <i class="icon fa fa-info"></i>
            <span style="margin-top: 12px;margin-left: 10px;"><?php _e( 'Sorry! No Properties Found. Try Searching Again.', 'real-estate-manager' ); ?></span>
        </div>
    <?php endif;
?>