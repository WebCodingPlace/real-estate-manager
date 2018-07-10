<?php if(isset($_GET['simple_search'])){
    $search_string = strtolower($_GET['simple_search']);
 $ppp = rem_get_option('properties_per_page', -1);   ?>
	<div class="ich-settings-main-wrap">
    <div class="row">
		<?php
        $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

		$args = array(
            'post_type'   => 'rem_property',
            'paged'       => $paged,
            'post_status' => 'publish',
            'order'       => $order,
            'orderby'       => $orderby,
            'posts_per_page' => $ppp,
        );

        if (rem_get_option('simple_search_query', '') != '') {
            $simple_search_query = rem_get_option('simple_search_query');
            $all_queries = explode("\n", $simple_search_query);
            $args['meta_query'] = array();
            foreach ($all_queries as $s_query) {
                if ($s_query != '') {
                    $meta_q = explode(",", $s_query);
                    $text = (isset($meta_q[0])) ? strtolower($meta_q[0]) : '' ;
                    $meta_key = (isset($meta_q[1])) ? 'rem_'.$meta_q[1] : '' ;
                    $is_number = (isset($meta_q[2]) && trim($meta_q[2]) == 'true') ? true : false ;
                    $op_value = (isset($meta_q[3])) ? trim($meta_q[3]) : '' ;
                    if (strpos($search_string, $text) !== false && $is_number == true) {
                        $value = str_replace($text, "", $search_string);
                        $value_int = str_replace(' ', '', $value);
                        $args['meta_query'][] = array(
                            'key'     => $meta_key,
                            'value'   => intval($value_int),
                            'compare' => 'LIKE',
                        );
                    } elseif (strpos($search_string, $text) !== false && $is_number == false) {
                        $args['meta_query'][] = array(
                            'key'     => $meta_key,
                            'value'   => ($op_value != '') ? $op_value : $text,
                            'compare' => 'LIKE',
                        );
                    }
                }
            }

            if (empty($args['meta_query'])) {
                $args['s'] = $search_string;
            }
        } else {
            $args['s'] = $search_string;
        }


		$property_query = new WP_Query( $args );
        $layout_style = rem_get_option('search_results_style', '1');
        $layout_cols = rem_get_option('search_results_cols', 'col-sm-12');  
        $target = rem_get_option('searched_properties_target', '');    
			if( $property_query->have_posts() ){
        while( $property_query->have_posts() ){ $property_query->the_post(); 
		 		?>
            <div id="property-<?php echo get_the_id(); ?>" class="<?php echo $layout_cols; ?>">
                <?php do_action('rem_property_box', get_the_id(), $layout_style, $target); ?>
            </div>
        <?php

		 	}
			wp_reset_postdata();
      echo '<div class="clearfix"></div>';
      do_action( 'rem_pagination', $paged, $property_query->max_num_pages );
	} else { ?>
  <div class="clearfix"></div>
    <div class="col-md-12">
        <div class="alert with-icon alert-info" role="alert">
            <p style="margin-top: 12px;margin-left: 10px;">
            <i class="icon fa fa-info"></i> <?php _e( 'Sorry! No Properties Found. Try Searching Again.', 'real-estate-manager' ); ?></p>
        </div>
    </div>
	<?php } ?>
  </div>
	</div>
<?php } ?>