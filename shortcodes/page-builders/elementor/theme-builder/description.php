<?php
class Elementor_REM_Description_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'rem_description';
	}

	public function get_title() {
		return __( 'Property Description', 'real-estate-manager' );
	}

	public function get_icon() {
		return 'eicon-post-content';
	}

	public function get_keywords() {
		return [ 'detail', 'content', 'rem' ];
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
			'desc_color',
			[
				'label' => __( 'Text Color', 'real-estate-manager' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .description' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Font', 'real-estate-manager' ),
				'scheme' => 1,
				'selector' => '{{WRAPPER}} .description',
			]
		);

		$this->end_controls_section();
	}	

	public function get_categories() {
		return [ 'single-property-page' ];
	}

	protected function render() {
		global $rem_hk_ob;
		$rem_hk_ob->single_property_contents(get_the_id());
	}
}
?>