<?php
class Elementor_REM_Map_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'map';
	}

	public function get_title() {
		return __( 'Property Map', 'real-estate-manager' );
	}

	public function get_icon() {
		return 'eicon-google-maps';
	}

	public function get_categories() {
		return [ 'single-property-page' ];
	}
	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Settings', 'real-estate-manager' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'important_note',
			[
				'label' => __( 'Notice', 'real-estate-manager' ),
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => __( 'Live Preview for the map is not available at the moment.', 'real-estate-manager' ),
				'content_classes' => 'your-class',
			]
		);

		$this->add_control(
			'map_height',
			[
				'label' => __( 'Height in px', 'real-estate-manager' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 100,
				'default' => 200,
			]
		);

		$this->end_controls_section();
	}
	protected function render() {

		global $post;
		global $rem_hk_ob;
		if ($post->post_type == 'rem_property') {
			$settings = $this->get_settings_for_display();
			if (rem_single_property_has_map($post->ID)) { ?>
			<div class="ich-settings-main-wrap"> 
	            <div class="wrap-map rem-section-box">
	                <div class="map-container" id="map-canvas" style="height: <?php echo esc_attr($settings['map_height']); ?>px"></div>
	            </div>
            </div>
        <?php }
		}
	}
}
?>