<?php
class Elementor_REM_Gallery_Images_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'gallery_images';
	}

	public function get_title() {
		return __( 'Property Gallery Images', 'real-estate-manager' );
	}

	public function get_icon() {
		return 'eicon-slider-push';
	}

	public function get_script_depends() {
		$gallery_type = rem_get_option('gallery_type', 'fotorama');
        $gallery_type = apply_filters( 'rem_single_property_gallery_type', $gallery_type );
        if ($gallery_type == 'fotorama') {
           return [ 'rem-photorama-js', 'rem-elementor-scripts' ];
        }
        if ($gallery_type == 'slick') {
            return [ 'rem-carousel-js', 'rem-elementor-scripts' ];
        }
        if ($gallery_type == 'grid') {
           return [ 'rem-grid-js', 'rem-elementor-scripts' ];
        }
	}
	public function get_style_depends() {
		$gallery_type = rem_get_option('gallery_type', 'fotorama');
        $gallery_type = apply_filters( 'rem_single_property_gallery_type', $gallery_type );
        if ($gallery_type == 'fotorama') {
           return [ 'rem-fotorama-css' ];
        }
        if ($gallery_type == 'slick') {
            return [ 'rem-carousel-css' ];
        }
        if ($gallery_type == 'grid') {
            return [ 'rem-grid-css' ];
        }
	}

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Gallery Outer', 'real-estate-manager' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'label' => __( 'Shadow', 'real-estate-manager' ),
				'selector' => '{{WRAPPER}} .rem-slider-elementor-widget',
			]
		);

		$this->end_controls_section();

	}

	public function get_categories() {
		return [ 'single-property-page' ];
	}

	public function get_keywords() {
		return [ 'rem', 'real', 'estate' ];
	}

	protected function render() {

		global $post;
		echo '<div class="rem-slider-elementor-widget ich-settings-main-wrap" id="property-content">';
				do_action( 'rem_single_property_page_slider', $post->ID );
				echo "<style>.elementor-widget-container #property-content {padding: 0 !important;}</style>";
		echo '</div>';

	}

}
?>