<?php if(isset($_GET['search_property'])){
 $ppp = rem_get_option('properties_per_page', -1);   ?>
	<div class="ich-settings-main-wrap">
    <div class="row">
		<?php
        $args = rem_get_search_query($_REQUEST);
        $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1; 
        $args['paged'] = $paged;
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