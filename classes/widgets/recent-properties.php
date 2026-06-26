<?php
/**
* REM - Recent Properties Widget Class
* since 10.7.0
*/

class REM_Recent_Properties extends WP_Widget {

	/**
	 * Register rem_recent_properties_widget widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'rem_recent_properties_widget', // Base ID
			__( 'REM - Recent Properties', 'real-estate-manager' ), // Name
			array( 'description' => __( 'Displays Recent Properties', 'real-estate-manager' ), ) // Args
		);
	}

	public function widget( $args, $instance ) {
        wp_enqueue_style( 'rem-recent-properties', REM_URL . '/assets/front/css/recent-properties.css' );
		extract($instance);
		?>
			<div class="rem-recent-properties">
			 	<?php
					if ( isset($instance['title']) ) {
						echo wp_kses_post($args['before_title']) . apply_filters( 'widget_title', $instance['title'] ) . wp_kses_post($args['after_title']);
					}
				 	$args = array(
				 		'post_type'   => 'rem_property',
				 		'posts_per_page'         => (isset($instance['total'])) ? $instance['total'] : -1,
				 	);
					if (!isset($instance['display_current'])) {
						global $post;
						$current_post_id = '';
						if (isset($post->ID)) {
						    $current_post_id = $post->ID;
						    $args['post__not_in'] = array($current_post_id);
						}
					}
				 	$the_query = new WP_Query( $args );
					if ( $the_query->have_posts() ) {
						while ( $the_query->have_posts() ) {
							$the_query->the_post(); ?>
							<div class="rem-widget-list rem-widget-list-<?php echo get_the_id(); ?>">
								<a href="<?php the_permalink(); ?>">
									<?php do_action( 'rem_property_picture', get_the_id(), 'thumbnail' ); ?>
									<h2><?php echo get_the_title(); ?></h2>
									<?php echo (isset($instance['display_date'])) ? '<p>'.get_the_date().'</p>' : '' ; ?>
									<?php echo (isset($instance['custom_data']) && $instance['custom_data'] != '') ? '<p>'.rem_get_field_value($instance['custom_data'], get_the_id()).'</p>' : '' ; ?>
								</a>
							</div>
						<?php }
						wp_reset_postdata();
					} else {
						$msg = rem_get_option('no_results_msg', 'No Properties Found.');
						echo stripcslashes($msg);
					}					
			 	?>
			</div>
		<?php
	}

	public function form( $instance ) {
		extract($instance);
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
			<label for="<?php echo esc_attr( $this->get_field_id( 'total' ) ); ?>"><?php esc_attr_e( 'Number of Properties','real-estate-manager' ); ?></label> 
			<input
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'total' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'total' ) ); ?>"
				type="number" value="<?php echo (isset($instance['total'])) ? $instance['total'] : '' ; ?>"
			>
		</p>
		<p>
			<input
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'display_date' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'display_date' ) ); ?>"
				type="checkbox" value="on" <?php echo (isset($instance['display_date']) && $instance['display_date'] == 'on') ? 'checked' : '' ;  ?>
			>
			<label for="<?php echo esc_attr( $this->get_field_id( 'display_date' ) ); ?>"><?php esc_attr_e( 'Display Date','real-estate-manager' ); ?></label> 
		</p>
		<p>
			<input
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'display_current' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'display_current' ) ); ?>"
				type="checkbox" value="on" <?php echo (isset($instance['display_current']) && $instance['display_current'] == 'on') ? 'checked' : '' ;  ?>
			>
			<label for="<?php echo esc_attr( $this->get_field_id( 'display_current' ) ); ?>"><?php esc_attr_e( 'Enable Current Property','real-estate-manager' ); ?></label> 
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'custom_data' ) ); ?>"><?php esc_attr_e( 'Custom Data (Provide field name)','real-estate-manager' ); ?></label> 
			<input
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'custom_data' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'custom_data' ) ); ?>"
				type="text" value="<?php echo (isset($instance['custom_data'])) ? $instance['custom_data'] : '' ; ?>"
			>
		</p>
		<?php 
	}

	public function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

}

if (! function_exists ( 'rem_register_widget_recent_properties' )) :
	function rem_register_widget_recent_properties() {
	    register_widget( 'REM_Recent_Properties' );
	}
endif;
add_action( 'widgets_init', 'rem_register_widget_recent_properties' );
?>