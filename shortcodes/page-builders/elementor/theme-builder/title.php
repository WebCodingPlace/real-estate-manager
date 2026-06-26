<?php
class Elementor_REM_Title_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'property_title';
	}

	public function get_title() {
		return __( 'Property Title', 'real-estate-manager' );
	}

	public function get_icon() {
		return 'eicon-product-title';
	}

	public function get_categories() {
		return [ 'single-property-page' ];
	}

	public function get_keywords() {
		return [ 'rem', 'real', 'estate' ];
	}

	public function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Settings', 'real-estate-manager' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'wrapper',
			[
				'label' => __( 'Title Wrapper Tag', 'real-estate-manager' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'h3',
				'options' => [
					'h1' => __( 'h1', 'real-estate-manager' ),
					'h2' => __( 'h2', 'real-estate-manager' ),
					'h3' => __( 'h3', 'real-estate-manager' ),
					'h4' => __( 'h4', 'real-estate-manager' ),
					'h5' => __( 'h5', 'real-estate-manager' ),
					'h6' => __( 'h6', 'real-estate-manager' ),
					'p'  => __( 'p', 'real-estate-manager' ),
					'span' => __( 'span', 'real-estate-manager' ),
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Title Font', 'real-estate-manager' ),
				'scheme' => 1,
				'selector' => '{{WRAPPER}} .title',
			]
		);

		$this->add_control(
			'text_align',
			[
				'label' => __( 'Alignment', 'real-estate-manager' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'real-estate-manager' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'real-estate-manager' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'real-estate-manager' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'center',
				'toggle' => true,
			]
		);

		$this->end_controls_section();

	}

	public function render() {
		$settings = $this->get_settings_for_display();
		$title = get_the_title();
		$wrap = $settings['wrapper'];
		$align = $settings['text_align'];
		echo "<$wrap style='text-align: ".$align."' class='title'>".stripcslashes($title)."</$wrap>";
	}
}
?>