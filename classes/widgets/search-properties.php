<?php
/**
* REM - Search Property Widget Class
* since 3.6
*/

class REM_Search_Property_Widget extends WP_Widget {

	/**
	 * Register rem_search_property_widget widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'rem_search_property_widget', // Base ID
			__( 'REM - Search Property', 'real-estate-manager' ), // Name
			array( 'description' => __( 'Search Properties', 'real-estate-manager' ), ) // Args
		);
	}

	public function widget( $args, $instance ) {

        rem_load_bs_and_fa();
        rem_load_basic_styles();
        wp_enqueue_style( 'rem-archive-property-css', REM_URL . '/assets/front/css/archive-property.css' );
        
        wp_enqueue_style( 'rem-nouislider-css', REM_URL . '/assets/front/lib/nouislider.min.css' );
        wp_enqueue_style( 'rem-easydropdown-css', REM_URL . '/assets/front/lib/easydropdown.css' );
        wp_enqueue_style( 'rem-labelauty-css', REM_URL . '/assets/front/lib/labelauty.css' );
        wp_enqueue_script( 'rem-labelauty', REM_URL . '/assets/front/lib/labelauty.min.js', array('jquery'));
        wp_enqueue_script( 'rem-easy-drop', REM_URL . '/assets/front/lib/jquery.easydropdown.min.js', array('jquery'));
        wp_enqueue_script( 'rem-nouislider-drop', REM_URL . '/assets/front/lib/nouislider.all.min.js', array('jquery'));
        wp_enqueue_script( 'rem-match-height', REM_URL . '/assets/front/lib/jquery.matchheight-min.js', array('jquery'));

        wp_enqueue_script( 'rem-imagefill-js', REM_URL . '/assets/front/lib/imagefill.min.js', array('jquery'));   
        wp_enqueue_script( 'rem-imagesloaded-js', REM_URL . '/assets/front/lib/imagesloaded.min.js', array('jquery'));
        
        wp_enqueue_style( 'rem-search-css', REM_URL . '/assets/front/css/search-property.css' );

        $script_settings = array(
            'price_min'         => rem_get_option('minimum_price', '350'),
            'price_max'         => rem_get_option('maximum_price', '45000'), 
            'price_min_default' => rem_get_option('default_minimum_price', '7000'), 
            'price_max_default' => rem_get_option('default_maximum_price', '38500'), 
            'price_step'        => rem_get_option('price_step', '10'),
            'currency_symbol'   => rem_get_currency_symbol(),
            'thousand_separator'=> rem_get_option('thousand_separator', ''),
            'decimal_separator' => rem_get_option('decimal_separator', ''),
            'decimal_points'    => rem_get_option('decimal_points', '0'),
        );
        wp_enqueue_script( 'rem-search-script', REM_URL . '/assets/front/js/search-property.js', array('jquery'));
        wp_localize_script( 'rem-search-script', 'rem_ob', $script_settings );
	
		extract($instance);
		
		echo $args['before_widget'];
		
		 ?>
		 	
		 	<?php
				if ( isset($instance['title']) ) {
					echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
				}
					// geting data from rem class
					global $rem_ob;
					$all_fields = $rem_ob->single_property_fields();
		 	?>
		 	<div class="ich-settings-main-wrap">
			<div class="search-box-page">
				<div class="row">
					<form method="get" action="<?php echo get_permalink( $result_page ); ?>">
						<?php if(isset($search_field)){ ?>
							<div class="col-md-12 space-div">
								<input class="form-control" value="<?php echo (isset($_GET['search_property'])) ? esc_attr($_GET['search_property']) : '' ; ?>" type="text" name="search_property" id="keywords" placeholder="<?php _e( 'Keywords','real-estate-manager' ); ?>" />
							</div>
						<?php } else {
							echo '<input value="" type="hidden" name="search_property" />';
						} ?>
						<?php foreach ($all_fields as $field) { if (isset($instance[$field['key']]) && $field['key'] != 'property_price'): ?>
							<div class="col-md-12 space-div">
								<label for="<?php echo $field['key']; ?>"><?php echo $field['title']; ?></label>
								<?php rem_render_property_search_fields($field); ?>
							</div>
						<?php endif; } ?>
						<?php $special_fields_titles = array(
							'order' => __( 'Order', 'real-estate-manager' ),
							'orderby' => __( 'Order By', 'real-estate-manager' ),
							'agent' => __( 'Agent', 'real-estate-manager' ),
							'property_id' => __( 'Property ID', 'real-estate-manager' ),
						); ?>
						<?php foreach ($instance as $key => $value) { if ($key == 'order' || $key == 'orderby' || $key == 'agent'|| $key == 'property_id'): ?>
							<div class="col-md-12 space-div">
								<label for="<?php echo $key; ?>"><?php echo $special_fields_titles[$key]; ?></label>
								<?php rem_render_special_search_fields($key); ?>
							</div>
						<?php endif; } ?>
						
						<?php if ($property_price) { ?>
							<div class="col-md-12 p-slide-wrap space-div">
								<?php rem_render_price_range_field(); ?>
							</div>
						<?php } ?>
						<div class="col-md-12 space-div">
							<button type="submit" class="btn btn-default btn-block search-button"><?php _e( 'Search', 'real-estate-manager' ); ?></button>
						</div><!-- ./footer -->
					</form>
				</div><!-- ./row 2 -->
			</div>
			</div> <!-- ./ich-settings-main-wrap -->
		<?php
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		extract($instance);
		global $rem_ob;
		$default_fields = $rem_ob->single_property_fields();
		$ignore_fields = array('after_price_text', 'property_sale_price', 'property_latitude', 'property_longitude', 'property_video', 'file_attachments');
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title','real-estate-manager' ); ?></label> 
			<input
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
				type="text" value="<?php echo (isset($instance['title'])) ? $instance['title'] : '' ; ?>"
			>
		</p>
		<p>
			<input
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'search_field' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'search_field' ) ); ?>"
				type="checkbox" value="on" <?php echo (isset($instance['search_field']) && $instance['search_field'] == 'on') ? 'checked' : '' ;  ?>
			>
			<label for="<?php echo esc_attr( $this->get_field_id( 'search_field' ) ); ?>"><?php _e( 'Search Field','real-estate-manager' ); ?></label> 
		</p>
		<?php foreach ($default_fields as $field) { if(!in_array($field['key'], $ignore_fields)){ ?>
			<p>
				<input
					class="widefat"
					id="<?php echo esc_attr( $this->get_field_id( $field['key'] ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( $field['key'] ) ); ?>"
					type="checkbox" value="on" <?php echo (isset($instance[$field['key']]) && $instance[$field['key']] == 'on') ? 'checked' : '' ;  ?>
				>
				<label for="<?php echo esc_attr( $this->get_field_id( $field['key'] ) ); ?>"><?php echo $field['title']; ?></label> 
			</p>
		<?php }} ?>
		<p>
			<input
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>"
				type="checkbox" value="on" <?php echo (isset($instance['order']) && $instance['order'] == 'on') ? 'checked' : '' ;  ?>
			>
			<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"><?php _e( 'Order','real-estate-manager' ); ?></label> 
		</p>
		<p>
			<input
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>"
				type="checkbox" value="on" <?php echo (isset($instance['orderby']) && $instance['orderby'] == 'on') ? 'checked' : '' ;  ?>
			>
			<label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"><?php _e( 'Order By','real-estate-manager' ); ?></label> 
		</p>
		<p>
			<input
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'agent' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'agent' ) ); ?>"
				type="checkbox" value="on" <?php echo (isset($instance['agent']) && $instance['agent'] == 'on') ? 'checked' : '' ;  ?>
			>
			<label for="<?php echo esc_attr( $this->get_field_id( 'agent' ) ); ?>"><?php _e( 'Agent','real-estate-manager' ); ?></label> 
		</p>
		<p>
			<input
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'property_id' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'property_id' ) ); ?>"
				type="checkbox" value="on" <?php echo (isset($instance['property_id']) && $instance['property_id'] == 'on') ? 'checked' : '' ;  ?>
			>
			<label for="<?php echo esc_attr( $this->get_field_id( 'property_id' ) ); ?>"><?php _e( 'Property ID','real-estate-manager' ); ?></label> 
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'result_page' ) ); ?>"><?php _e( 'Search Results Page','real-estate-manager' ); ?></label>
			<?php
				$args = array(			
					'post_type'   => 'page',
					'posts_per_page'         => -1,
				);			
				$the_query_pages = new WP_Query( $args );

				// The Loop
				if ( $the_query_pages->have_posts() ) {
					echo '<select class="widefat" id="'.esc_attr( $this->get_field_id( 'result_page' ) ).'" name="'.esc_attr( $this->get_field_name( 'result_page' ) ).'">';
					while ( $the_query_pages->have_posts() ) {
						$the_query_pages->the_post();
						?>
							<option value="<?php the_id(); ?>" <?php echo (isset($instance['result_page']) && $instance['result_page'] == get_the_id()) ? 'selected' : '' ; ?>><?php the_title(); ?></option>
						<?php
					}
					echo '</select>';
					/* Restore original Post Data */
					wp_reset_postdata();
				} else {
					echo __( 'No Pages Found!', 'real-estate-manager' );
				}
			?>
			<span><?php _e( 'Paste following shortcode in selected page to display results', 'real-estate-manager' ); ?>
			<code>[rem_search_results]</code></span>
		</p>
		<?php 
	}

	public function update( $new_instance, $old_instance ) {

		return $new_instance;
	}

}

if (! function_exists ( 'rem_register_widget_search_property' )) :
	function rem_register_widget_search_property() {
	    register_widget( 'REM_Search_Property_Widget' );
	}
endif;
add_action( 'widgets_init', 'rem_register_widget_search_property' );
?>