<?php
class Elementor_REM_Attachments_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'rem_attachments';
	}

	public function get_title() {
		return __( 'Files, Images', 'real-estate-manager' );
	}

	public function get_keywords() {
		return [ 'rem', 'files', 'attachments' ];
	}

	public function get_icon() {
		return 'eicon-document-file';
	}
	public function get_script_depends() {
		if (\Elementor\Plugin::$instance->editor->is_edit_mode() || \Elementor\Plugin::$instance->preview->is_preview_mode()) {
		    return [ 'rem-carousel-js', 'rem-magnific-js' ];
		}
		$settings = $this->get_settings_for_display();
		if ($settings['display'] == "slider") {
	        return [ 'rem-carousel-js', 'rem-magnific-js' ];
        } else {
        	return ['rem-magnific-js'];
        }
        
	}
	public function get_style_depends() {
		if (\Elementor\Plugin::$instance->editor->is_edit_mode() || \Elementor\Plugin::$instance->preview->is_preview_mode()) {
		    return [ 'rem-magnific-css', 'rem-carousel-css' ];
		}
		$settings = $this->get_settings_for_display();
		if ($settings['display'] == "slider") {
	        return [ 'rem-magnific-css', 'rem-carousel-css' ];
        } else {
        	return ['rem-magnific-css'];
        }
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
			'field_name',
			[
				'label' => __( 'Field Name', 'real-estate-manager' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'file_attachments',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Font', 'real-estate-manager' ),
				'scheme' => 1,
				'selector' => '{{WRAPPER}} .rem-attachment-title',
			]
		);

		$this->add_control(
			'columns',
			[
				'label' => __( 'Columns', 'real-estate-manager' ),
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
			'display',
			[
				'label' => __( 'Dispaly', 'real-estate-manager' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'grid',
				'options' => [
					'grid' => __( 'Grid', 'real-estate-manager' ),
					'slider' => __( 'Slider', 'real-estate-manager' ),
				],
			]
		);

		$this->end_controls_section();

	}
	public function get_categories() {
		return [ 'single-property-page' ];
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$field_name = isset($settings['field_name']) && $settings['field_name'] != '' ? $settings['field_name'] : 'file_attachments';
		$field = rem_get_field_data($field_name);
		$label = apply_filters( 'rem_single_property_field_label_frontend', $field['title'], $field_name, $field, get_the_id() );

		$value = get_post_meta(get_the_id(), 'rem_'.$field_name, true);
		$max_length = apply_filters( 'rem_attachments_title_length', '16', get_the_id() );

		echo '<div class="ich-settings-main-wrap"><div class="row">';
		if (!empty($value)) {
			
	        if ($value != '' && !is_array($value)) {
	            $attachments = explode("\n", $value);
	        }
	        if (is_array($value)) {
	            $attachments = $value;
	        }
	        if(isset($attachments) && is_array($attachments)){

	            if(isset($field['only_images']) && $field['only_images'] == 'true'){ ?>
	                <div class="col-sm-12">
	                <p class="text-center rem-additional-images-title"><?php echo rem_wpml_translate($label, 'real-estate-manager-fields'); ?></p>
	                
	                <?php 
	                $attachments_class = $settings['display'] == "slider" ? "rem-attachment-slider": "rem-attachment-grid";
	                ?>
	                <div class="rem-additional-images <?php echo esc_attr($attachments_class); ?>">
	                    <?php
	                        foreach ($attachments as $a_id) {
	                            if ($a_id != '') {
	                                $a_id = intval($a_id);
	                                if (wp_attachment_is_image($a_id)) { ?>
	                                    <div title="<?php echo get_the_title($a_id); ?>" class="rem-single-image" data-url="<?php echo wp_get_attachment_url($a_id) ?>">
	                                        <?php echo wp_get_attachment_image($a_id, 'thumbnail'); ?>
	                                    </div>
	                                <?php }
	                            }
	                        }
	                    ?>
	                </div>
	                </div>
	            <?php } else {
	                foreach ($attachments as $a_id) {
	                    if ($a_id != '') {
	                        $a_id = intval($a_id);
	                        $filename_only = basename( get_attached_file( $a_id ) );
	                        $fullsize_path = get_attached_file( $a_id );
	                        $attachment_title = get_the_title($a_id);
	                        $display_title = ($attachment_title != '') ? $attachment_title : $filename_only ;                        
	                        $file_url = wp_get_attachment_url( $a_id );
	                        $file_type = wp_check_filetype_and_ext($fullsize_path, $filename_only);
	                        $extension = ($file_type['ext']) ? $file_type['ext'] : 'file' ; ?>
	                        	
	                        <div class="<?php echo esc_attr($css_classes); ?> rem-attachment-icon">
	                            <span class="file-type-icon pull-left <?php echo esc_attr($extension); ?>" filetype="<?php echo esc_attr($extension); ?>">
	                                <span class="fileCorner"></span>
	                            </span>
	                            <a target="_blank" href="<?php echo esc_url($file_url); ?>"><?php echo substr(esc_attr($display_title), 0, $max_length); ?></a>
	                        </div>
	                    <?php
	                    }
	                }
	            }
	        }

		}  else {
        	echo '<div class="alert alert-info">'.__( 'No attachments found for the property', 'real-estate-manager' ).' <b>'.get_the_title().'</b></div>';
        }
        echo '</div></div>'; 
	}
}
?>