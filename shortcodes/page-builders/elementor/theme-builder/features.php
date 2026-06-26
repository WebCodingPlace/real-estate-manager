<?php
class Elementor_REM_Features_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'rem_features';
	}

	public function get_title() {
		return __( 'Property Features', 'real-estate-manager' );
	}

	public function get_icon() {
		return 'eicon-icon-box';
	}

	public function get_categories() {
		return [ 'single-property-page' ];
	}

	public function get_keywords() {
		return [ 'meta', 'rem', 'fields' ];
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
			'columns',
			[
				'label' => __( 'Features per row', 'real-estate-manager' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '4',
				'options' => [
					'12' => __( '1', 'real-estate-manager' ),
					'6' => __( '2', 'real-estate-manager' ),
					'4' => __( '3', 'real-estate-manager' ),
					'3' => __( '4', 'real-estate-manager' ),
					'5th-1' => __( '5', 'real-estate-manager' ),
					'2' => __( '6', 'real-estate-manager' ),
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => __( 'Text Color', 'real-estate-manager' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rem-feature-title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => __( 'Icon Color', 'real-estate-manager' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rem-feature-icon' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Typography', 'real-estate-manager' ),
				'scheme' => 1,
				'selector' => '{{WRAPPER}} .rem-feature-title',
			]
		);

		$this->add_control(
			'selected_icon',
			[
				'label' => __( 'Icon', 'elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fa fa-square',
					'library' => 'fa-solid',
				],
			]
		);


		$this->end_controls_section();
	}
	protected function render() {

		global $post;
		global $rem_hk_ob;
		$settings = $this->get_settings_for_display();
		$icon = (isset($settings['selected_icon']['value'])) ? $settings['selected_icon']['value'] : 'fa fa-square';
		if ($post->post_type == 'rem_property') { 
			$property_details_cbs = get_post_meta( $post->ID, 'rem_property_detail_cbs', true );
			if (is_array($property_details_cbs)) {
			?>
			<div class="ich-settings-main-wrap">
				<div class="row">
                    <?php foreach ($property_details_cbs as $option_name => $value) { if($option_name != '') {
                        $css_classes = apply_filters( 'rem_single_property_field_columns_frontend', 'col-sm-4 col-xs-12', 'property_features', array(), $post->ID ); 
                        $columns = $settings['columns'] == 'default' ? $css_classes : 'col-md-'.$settings['columns'];
                        ?>
                        <div class="<?php echo esc_attr($columns); ?> wrap_<?php echo (str_replace(' ', '_', strtolower($option_name))); ?>">
                            <span class="rem-feature-title detail">
                            	<i class="rem-feature-icon <?php echo esc_attr($icon); ?>"></i>
                                <?php
                                    $feature = stripcslashes($option_name);
                                    $translated_feature = rem_wpml_translate($option_name, 'real-estate-manager-features');
                                    echo esc_attr($translated_feature);
                                ?>
                            </span>
                        </div>
                    <?php } } ?>
                </div>
			</div>
			<?php
			}
		}
	}
}
?>