<?php
/**
 * Adds REM_Mortgage_Calculator widget.
 */
class REM_Mortgage_Calculator extends WP_Widget {

	/**
	 * Register rem_martgage_calculator_widget widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'rem_martgage_calculator_widget', // Base ID
			__( 'REM - Mortgage Calculator', 'real-estate-manager' ), // Name
			array( 'description' => __( 'Displays Mortgage Calculator', 'real-estate-manager' ), ) // Args
		);
	}

	public function widget( $args, $instance ) {
        rem_load_bs_and_fa();
        rem_load_basic_styles();
        wp_enqueue_style( 'rem-mortgage-calculator-css', REM_URL . '/assets/front/css/mortgage-calculator.css' );
        wp_enqueue_script( 'rem-mc-js', REM_URL . '/assets/front/js/mortgage-calculator.js', array('jquery'));
        $price_symbol = rem_get_currency_symbol();
        wp_localize_script( 'rem-mc-js', 'rem_mort', array( 'symbol' => $price_symbol ) );

		extract($instance);
		$all_settings = get_option( 'rem_all_settings' );
		$price_symbol = rem_get_currency_symbol();
		echo $args['before_widget'];
		
		 ?>
		 	
		 	<?php
				if ( isset($instance['title']) ) {
					echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
				}
		 	?>
			<div class="mortgage-calculator-box ich-settings-main-wrap">
				<form method="post" role="form">
					<div class="form-group">
						<label><?php _e( 'Sale price', 'real-estate-manager' ); ?> (<?php echo $price_symbol; ?>)</label>
						<input type="text" id="mc-price" class="form-control" placeholder="eg: 200000" />
					</div>
					<div class="form-group">
						<label><?php _e( 'Down payment', 'real-estate-manager' ); ?> (%)</label>
						<input type="text" id="mc-down" class="form-control" placeholder="eg: 5" />
					</div>
					<div class="form-group">
						<label><?php _e( 'Interest Rate', 'real-estate-manager' ); ?> (%)</label>
						<input type="text" id="mc-rate" class="form-control" placeholder="eg: 6" />
					</div>
					<div class="form-group">
						<label><?php _e( 'Term', 'real-estate-manager' ); ?> (<?php _e( 'years', 'real-estate-manager' ); ?>)</label>
						<input type="text" id="mc-term" class="form-control" placeholder="eg: 20" />
					</div>
					<button id="mortgage-calc" class="btn btn-default" type="button"><?php _e( 'Calculate', 'real-estate-manager' ); ?></button>
				</form>
				<div class="result-calc" id="mc-payment"><?php echo $price_symbol; ?> 0,00</div>
			</div><!-- /.mortgage-calculator -->
		 	<?php 
			echo (isset($args['after_widget'])) ? $args['after_widget'] : '';
	}

	public function form( $instance ) {
		extract($instance);
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
		<?php 
	}

	public function update( $new_instance, $old_instance ) {

		return $new_instance;
	}

}

if (! function_exists ( 'rem_mortgage_calculator' )) :
	function rem_mortgage_calculator() {
	    register_widget( 'REM_Mortgage_Calculator' );
	}
endif;
add_action( 'widgets_init', 'rem_mortgage_calculator' );

?>