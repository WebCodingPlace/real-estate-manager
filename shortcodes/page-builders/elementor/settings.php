<?php
/**
* Structure the settings array as per Elementor Controls
*/

function rem_vc_into_elementor_settings($class, $sc){
	$fields = rem_page_builder_fields($sc);
	
	$class->start_controls_section(
		'content_section',
		[
			'label' => __( 'Settings', 'real-estate-manager' ),
			'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
		]
	);

	foreach ($fields as $field) {
		switch ($field['type']) {
			
			case 'textfield':
				$class->add_control(
					$field['param_name'],
					[
						'label' => $field['heading'],
						'type' => \Elementor\Controls_Manager::TEXT,
						'description' => $field['description'],
						'default' => '',
					]
				);
				break;

			case 'dropdown':
				$class->add_control(
					$field['param_name'],
					[
						'label' => $field['heading'],
						'type' => \Elementor\Controls_Manager::SELECT,
						'description' => $field['description'],
						'default' => '',
						'options' => array_flip($field['value']),
					]
				);
				break;

			case 'textarea_html':
				$class->add_control(
					'main_content',
					[
						'label' => $field['heading'],
						'type' => \Elementor\Controls_Manager::WYSIWYG,
						'description' => $field['description'],
					]
				);
				break;
			
			default:
				
				break;
		}
	}

	$class->end_controls_section();
}

?>