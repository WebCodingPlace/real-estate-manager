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
        rem_load_dropdown_styles();
        wp_enqueue_style( 'rem-archive-property-css', REM_URL . '/assets/front/css/archive-property.css' );
        //select2 css js
        wp_enqueue_style( 'rem-select2-css', REM_URL . '/assets/admin/css/select2.min.css' );
        wp_enqueue_script( 'rem-select2-js', REM_URL . '/assets/admin/js/select2.min.js' , array('jquery'));
                
        wp_enqueue_style( 'rem-nouislider-css', REM_URL . '/assets/front/lib/nouislider.min.css' );
        wp_enqueue_style( 'rem-labelauty-css', REM_URL . '/assets/front/lib/labelauty.css' );
        wp_enqueue_script( 'rem-labelauty', REM_URL . '/assets/front/lib/labelauty.min.js', array('jquery'));
        wp_enqueue_script( 'rem-nouislider-drop', REM_URL . '/assets/front/lib/nouislider.all.min.js', array('jquery'));
        wp_enqueue_script( 'rem-match-height', REM_URL . '/assets/front/lib/jquery.matchheight-min.js', array('jquery'));

        wp_enqueue_script( 'rem-imagefill-js', REM_URL . '/assets/front/lib/imagefill.min.js', array('jquery'));   
        wp_enqueue_script( 'rem-imagesloaded-js', REM_URL . '/assets/front/lib/imagesloaded.min.js', array('jquery'));
        
        wp_enqueue_style( 'rem-search-css', REM_URL . '/assets/front/css/search-property.css' );

        if (isset($_GET['price_min']) && isset($_GET['price_max'])) {
	        $min =  str_replace(stripcslashes(rem_get_option('range_thousand_separator', '')), "", $_GET['price_min']);
	        $min = number_format(intval($min), 0, rem_get_option('decimal_separator', ''), '');
	        
	        $max =  str_replace(stripcslashes(rem_get_option('range_thousand_separator', '')), "", $_GET['price_max']);
	        $max = number_format(intval($max), 0, rem_get_option('decimal_separator', ''), '');
        } else {
        	
        	$min = rem_get_option('default_minimum_price', '7000');
        	$max = rem_get_option('default_maximum_price', '38500');
        }
        
        $range_field_base = rem_get_option('switch_ranges', 'property_purpose|Rent');
        $switch_ranges = explode("|", $range_field_base);
        $price_range_name = (isset($switch_ranges[0]) ? trim($switch_ranges[0]) : 'property_purpose');
        $price_range_value = (isset($switch_ranges[1]) ? trim($switch_ranges[1]) : 'Rent');

        $script_settings = array(
            'price_min'         => rem_get_option('minimum_price', '350'),
            'price_max'         => rem_get_option('maximum_price', '45000'), 
            'price_min_default' => $min,
            'price_max_default' => $max,
            'price_step'        => rem_get_option('price_step', '10'),
            'site_direction'    => (is_rtl()) ? 'rtl' : 'ltr',
            'currency_symbol'   => rem_get_currency_symbol(),
            'thousand_separator'=> stripcslashes(rem_get_option('thousand_separator', '')),
            'decimal_separator' => rem_get_option('decimal_separator', ''),
            'decimal_points'    => rem_get_option('decimal_points', '0'),
            'range_thousand_separator'=> stripcslashes(rem_get_option('range_thousand_separator', '')),
            'range_decimal_separator' => rem_get_option('range_decimal_separator', ''),
            'range_decimal_points'    => rem_get_option('range_decimal_points', '0'),
            'price_step_r'        => rem_get_option('price_step_r', '5'),
            'price_min_r'         => rem_get_option('minimum_price_r', '10'),
            'price_max_r'         => rem_get_option('maximum_price_r', '5000'), 
            'price_min_default_r' => rem_get_option('default_minimum_price_r', '950'),
            'price_max_default_r' => rem_get_option('default_maximum_price_r', '4500'),
            'price_range_name'    => $price_range_name,
            'price_range_value'    => $price_range_value,
            'offset'    => rem_get_option('properties_per_page', 15),
            'nonce_states' => wp_create_nonce('rem-nonce-states'),
        );
        wp_enqueue_script( 'rem-search-script', REM_URL . '/assets/front/js/search-property.js', array('jquery', 'jquery-ui-autocomplete'));
        wp_localize_script( 'rem-search-script', 'rem_ob', $script_settings );
	
		extract($instance); ?>
		 	
		 	<div class="ich-settings-main-wrap search-widget">
			<div class="search-box-page rem-search-form-wrap">
			 	<?php
					if ( isset($instance['title']) ) {
						echo wp_kses_post($args['before_title']) . apply_filters( 'widget_title', $instance['title'] ) . wp_kses_post($args['after_title']);
					}
					// geting data from rem class
					global $rem_ob;
					$all_fields = $rem_ob->single_property_fields();
			 	?>
				<input type="hidden" class="rem-ajax-url" value="<?php echo admin_url( 'admin-ajax.php' ); ?>">
				<div class="row rem-widget-search <?php echo (isset($instance['auto_complete'])) ? 'auto-complete' : '' ; ?>">
					<form method="get" action="<?php echo get_permalink( $result_page ); ?>">
						<?php if(isset($search_field)){ ?>
							<div class="col-md-12 space-div">
								<input class="form-control" value="<?php echo (isset($_GET['search_property'])) ? esc_attr( $_GET['search_property'] ) : '' ; ?>" type="text" name="search_property" id="keywords" placeholder="<?php esc_attr_e( 'Keywords','real-estate-manager' ); ?>" />
							</div>
						<?php } else {
							echo '<input value="" type="hidden" name="search_property" />';
						}
						if (isset($instance['fixed_fields']) && $instance['fixed_fields'] != '') {
							$fixed_va_arr = explode("\n", trim($instance['fixed_fields']));
							foreach ($fixed_va_arr as $fixed_va) {
								$fixed_data = explode("|", $fixed_va);
								echo '<input type="hidden" name="'.trim($fixed_data[0]).'" value="'.trim($fixed_data[1]).'">';
							}
						}
						$wpml_current_language = apply_filters( 'wpml_current_language', NULL );
						if ($wpml_current_language) {
							echo '<input type="hidden" name="lang" value="'.$wpml_current_language.'">';
						}						
						?>
						<?php foreach ($all_fields as $field) { if (isset($instance[$field['key']]) && $field['key'] != 'property_price'): ?>
							<div class="col-md-12 space-div">
								<label for="<?php echo esc_attr($field['key']); ?>"><?php echo rem_wpml_translate($field['title'], 'real-estate-manager-fields'); ?></label>
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
								<label for="<?php echo esc_attr($key); ?>"><?php echo esc_attr($special_fields_titles[$key]); ?></label>
								<?php rem_render_special_search_fields($key); ?>
							</div>
						<?php endif; } ?>
						
						<?php if (isset($property_price)) { ?>
							<div class="col-md-12 p-slide-wrap space-div">
								<?php rem_render_price_range_field(); ?>
							</div>
						<?php } ?>
						<div class="col-md-12 space-div">
							<button type="submit" class="btn btn-default btn-block search-button"><?php esc_attr_e( 'Search', 'real-estate-manager' ); ?></button>
						</div>
					</form>
				</div><!-- ./row 2 -->
			</div>
			</div> <!-- ./ich-settings-main-wrap -->
		<?php
	}

	public function form( $instance ) {
		extract($instance);
		global $rem_ob;
		$default_fields = $rem_ob->single_property_fields();
		$ignore_fields = array('after_price_text', 'property_sale_price', 'property_latitude', 'property_longitude', 'property_video', 'file_attachments');
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title','real-estate-manager' ); ?></label> 
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
			<label for="<?php echo esc_attr( $this->get_field_id( 'search_field' ) ); ?>"><?php esc_attr_e( 'Search Field','real-estate-manager' ); ?></label> 
		</p>
		<?php foreach ($default_fields as $field) { if(!in_array($field['key'], $ignore_fields)){ ?>
			<p>
				<input
					class="widefat"
					id="<?php echo esc_attr( $this->get_field_id( $field['key'] ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( $field['key'] ) ); ?>"
					type="checkbox" value="on" <?php echo (isset($instance[$field['key']]) && $instance[$field['key']] == 'on') ? 'checked' : '' ;  ?>
				>
				<label for="<?php echo esc_attr( $this->get_field_id( $field['key'] ) ); ?>"><?php echo rem_wpml_translate($field['title'], 'real-estate-manager-fields'); ?></label> 
			</p>
		<?php }} ?>
		<p>
			<input
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>"
				type="checkbox" value="on" <?php echo (isset($instance['order']) && $instance['order'] == 'on') ? 'checked' : '' ;  ?>
			>
			<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"><?php esc_attr_e( 'Order','real-estate-manager' ); ?></label> 
		</p>
		<p>
			<input
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>"
				type="checkbox" value="on" <?php echo (isset($instance['orderby']) && $instance['orderby'] == 'on') ? 'checked' : '' ;  ?>
			>
			<label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"><?php esc_attr_e( 'Order By','real-estate-manager' ); ?></label> 
		</p>
		<p>
			<input
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'agent' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'agent' ) ); ?>"
				type="checkbox" value="on" <?php echo (isset($instance['agent']) && $instance['agent'] == 'on') ? 'checked' : '' ;  ?>
			>
			<label for="<?php echo esc_attr( $this->get_field_id( 'agent' ) ); ?>"><?php esc_attr_e( 'Agent','real-estate-manager' ); ?></label> 
		</p>
		<p>
			<input
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'property_id' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'property_id' ) ); ?>"
				type="checkbox" value="on" <?php echo (isset($instance['property_id']) && $instance['property_id'] == 'on') ? 'checked' : '' ;  ?>
			>
			<label for="<?php echo esc_attr( $this->get_field_id( 'property_id' ) ); ?>"><?php esc_attr_e( 'Property ID','real-estate-manager' ); ?></label> 
		</p>
		<p>
			<input
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'auto_complete' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'auto_complete' ) ); ?>"
				type="checkbox" value="on" <?php echo (isset($instance['auto_complete']) && $instance['auto_complete'] == 'on') ? 'checked' : '' ;  ?>
			>
			<label for="<?php echo esc_attr( $this->get_field_id( 'auto_complete' ) ); ?>"><?php esc_attr_e( 'Enable Auto Complete Fields','real-estate-manager' ); ?></label> 
			<br>
			<i><?php esc_attr_e( 'It will auto suggest words in text fields as user type in.', 'real-estate-manager' ); ?></i>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'fixed_fields' ) ); ?>"><?php esc_attr_e( 'Fixed Fields','real-estate-manager' ); ?></label> 
			<textarea
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'fixed_fields' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'fixed_fields' ) ); ?>"
			><?php echo (isset($instance['fixed_fields'])) ? $instance['fixed_fields'] : '' ;  ?></textarea>
			<br>
			<i><?php esc_attr_e( 'Provide data for fixed fields on each line. Eg: property_status|normal', 'real-estate-manager' ); ?></i>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'result_page' ) ); ?>"><?php esc_attr_e( 'Search Results Page','real-estate-manager' ); ?></label>
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
			<span><?php esc_attr_e( 'Paste following shortcode in selected page to display results', 'real-estate-manager' ); ?>
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