<?php
class Elementor_REM_Property_Field_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'property_field';
	}

	public function get_title() {
		return __( 'Property Field', 'real-estate-manager' );
	}

	public function get_icon() {
		return 'eicon-toggle';
	}

	public function get_categories() {
		return [ 'single-property-page' ];
	}
	protected function register_controls() {

		$this->start_controls_section(
			'main_settings',
			[
				'label' => __( 'Property Field Settings', 'real-estate-manager' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		global $rem_ob;
		$all_fields = $rem_ob->single_property_fields();
        $fields = array();
        if (!empty($all_fields)) {
        	
	        foreach ($all_fields as $field) {
	        	$fields[$field['key']] = $field['title'];
	        }
        }
		$this->add_control(
			'field_name',
			[
				'label' => __( 'Select Field', 'real-estate-manager' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'property_price',
				'options' => $fields,
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
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'real-estate-manager' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'real-estate-manager' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'toggle' => true,
			]
		);

		$this->add_control(
			'margin',
			[
				'label' => __( 'Margin', 'real-estate-manager' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .rem-custom-field' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'padding',
			[
				'label' => __( 'Padding', 'real-estate-manager' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .rem-custom-field' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => __( 'Border', 'real-estate-manager' ),
				'selector' => '{{WRAPPER}} .rem-custom-field',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'label_settings',
			[
				'label' => __( 'Field Label Settings', 'real-estate-manager' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_label',
			[
				'label' => __( 'Display Field Label', 'real-estate-manager' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'real-estate-manager' ),
				'label_off' => __( 'Hide', 'real-estate-manager' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'field_label',
			[
				'label' => __( 'Custom Label', 'real-estate-manager' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			]
		);

		$this->add_control(
			'label_color',
			[
				'label' => __( 'Label Color', 'real-estate-manager' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rem-field-label' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				'label' => __( 'Label Typography', 'real-estate-manager' ),
				'scheme' => 1,
				'selector' => '{{WRAPPER}} .rem-field-label',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'sep_settings',
			[
				'label' => __( 'Separator Settings', 'real-estate-manager' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'field_sep',
			[
				'label' => __( 'Separator', 'real-estate-manager' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => ':',
			]
		);

		$this->add_control(
			'sep_color',
			[
				'label' => __( 'Separator Color', 'real-estate-manager' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rem-field-sep' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'sep_margin',
			[
				'label' => __( 'Margin', 'real-estate-manager' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .rem-field-sep' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'sep_padding',
			[
				'label' => __( 'Padding', 'real-estate-manager' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .rem-field-sep' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'val_settings',
			[
				'label' => __( 'Field Value Settings', 'real-estate-manager' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_control(
			'default_val',
			[
				'label' => __( 'Default Value', 'real-estate-manager' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			]
		);
		
		$this->add_control(
			'val_color',
			[
				'label' => __( 'Color', 'real-estate-manager' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rem-field-value' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'value_typography',
				'label' => __( 'Typography', 'real-estate-manager' ),
				'scheme' => 2,
				'selector' => '{{WRAPPER}} .rem-field-value',
			]
		);

		$this->end_controls_section();

	}
	protected function render() {

		global $post;
		if ($post->post_type == 'rem_property') { 
			global $rem_hk_ob;
			global $rem_ob;
			$settings = $this->get_settings_for_display();
	        $all_fields = $rem_ob->single_property_fields();
	        $label = $settings['field_label'];
	        $sep = $settings['field_sep'];
	        $align = $settings['text_align'];
	        $default_val = $settings['default_val'];
	        if (empty($label)) {
	        	$label = rem_get_field_label($settings['field_name']);
	        }
	        if( empty( rem_get_field_value($settings['field_name'], $default_val) ) ) {
	        	return ;
	        }
			?>
			<div class="ich-settings-main-wrap"> 
				<div class="rem-custom-field" style="text-align:<?php echo esc_attr($align); ?>">
				<?php if ('yes' === $settings['show_label']) { 
					
					echo '<span class="rem-field-label">'.esc_attr($label).'</span>';
					echo '<span class="rem-field-sep">'.esc_attr($sep).'</span>';
				}
				
				if ($settings['field_name'] == 'property_price') {
					$property_id = $post->ID;
					echo '<span class="rem-field-value">'.rem_display_property_price($property_id).'</span>';
				} else {
					
					echo '<span class="rem-field-value">'.rem_get_field_value($settings['field_name'], $default_val).'</span>'; 
				}
				?>
				
				</div>
			</div>
			<?php 
		}
	}
}
?>