<?php
/**
* REM - Search Property Widget Class
* since 
*/

class REM_AJAX_Search_Property_Widget extends WP_Widget {

	/**
	 * Register rem_search_property_widget widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'rem_ajax_search_property_widget', // Base ID
			__( 'REM - AJAX Search Property', 'real-estate-manager' ), // Name
			array( 'description' => __( 'Live Search Properties', 'real-estate-manager' ), ) // Args
		);
	}

	public function widget( $args, $instance ) {

        rem_load_bs_and_fa();
        rem_load_basic_styles();
        rem_load_dropdown_styles();
        wp_enqueue_style( 'rem-archive-property-css', REM_URL . '/assets/front/css/archive-property.css' );

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
            'thousand_separator'=> stripcslashes(rem_get_option('thousand_separator', '')),
            'decimal_separator' => rem_get_option('decimal_separator', ''),
            'decimal_points'    => rem_get_option('decimal_points', '0'),
            'range_thousand_separator'=> stripcslashes(rem_get_option('range_thousand_separator', '')),
            'range_decimal_separator' => rem_get_option('range_decimal_separator', ''),
            'range_decimal_points'    => rem_get_option('range_decimal_points', '0'),
            'nonce_states' => wp_create_nonce('rem-nonce-states'),
        );
        wp_enqueue_script( 'rem-search-script', REM_URL . '/assets/front/js/search-property.js', array('jquery', 'jquery-ui-autocomplete'));
        wp_localize_script( 'rem-search-script', 'rem_ob', $script_settings );
	
		extract($instance); ?>
		 	
		 	<div class="ich-settings-main-wrap search-widget">
			<div class="search-box-page">
			 	<?php
					if ( isset($instance['title']) ) {
						echo wp_kses_post($args['before_title']) . apply_filters( 'widget_title', $instance['title'] ) . wp_kses_post($args['after_title']);
					}
					// geting data from rem class
					global $rem_ob;
					$all_fields = $rem_ob->single_property_fields();
			 	?>
				<input type="hidden" class="rem-ajax-url" value="<?php echo admin_url( 'admin-ajax.php' ); ?>">
				<div class="row rem-widget-search">
					<form class="rem_ajax_search_property_form" data-result_area_id="<?php echo esc_attr($instance['result_area_id']); ?>">
						<input type="hidden" name="action" value="rem_search_property">
						<?php 
						$fixed_fields = array();
						if (isset($instance['fixed_fields']) && $instance['fixed_fields'] != '') {
							$fixed_va_arr = explode("\n", trim($instance['fixed_fields']));
							foreach ($fixed_va_arr as $fixed_va) {
								$fixed_data = explode("|", $fixed_va);
								echo '<input type="hidden" name="'.trim($fixed_data[0]).'" value="'.trim($fixed_data[1]).'">';
								$fixed_fields[trim($fixed_data[0])] =  trim($fixed_data[1]);
							}
						}
						$wpml_current_language = apply_filters( 'wpml_current_language', NULL );
						if ($wpml_current_language) {
							echo '<input type="hidden" name="lang" value="'.$wpml_current_language.'">';
						}						
						?>
						<?php foreach ($all_fields as $field) { if ( isset( $instance[$field['key']] ) ): ?>
							<div class="col-md-12 space-div">
								<label for="<?php echo esc_attr($field['key']); ?>"><?php echo rem_wpml_translate($field['title'], 'real-estate-manager-fields'); ?></label>
								<?php rem_render_property_dropdown_fields($field,$fixed_fields); ?>
							</div>
						<?php endif; } ?>
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
		
		<?php foreach ($default_fields as $field) { if(!in_array($field['key'], $ignore_fields) && ($field['type'] == 'select' || $field['type'] == 'select2') ){ 			?>
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
			<label for="<?php echo esc_attr( $this->get_field_id( 'result_area_id' ) ); ?>"><?php esc_attr_e( 'Results Selector','real-estate-manager' ); ?></label> 
			<input
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'result_area_id' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'result_area_id' ) ); ?>"
				type="text" value="<?php echo (isset($instance['result_area_id'])) ? $instance['result_area_id'] : '' ; ?>"
			>
			<i><?php esc_attr_e( 'Provide HTML selector where you want to display search results on current page', 'real-estate-manager' ); ?></i>
		</p>
		<?php 
	}

	public function update( $new_instance, $old_instance ) {

		return $new_instance;
	}

}

if (! function_exists ( 'rem_register_widget_ajax_search' )) :
	function rem_register_widget_ajax_search() {
	    register_widget( 'REM_AJAX_Search_Property_Widget' );
	}
endif;
add_action( 'widgets_init', 'rem_register_widget_ajax_search' );
?>