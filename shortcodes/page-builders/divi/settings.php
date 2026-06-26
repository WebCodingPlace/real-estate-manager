<?php
/**
* Structure the settings array as per Divi
*/

function rem_vc_into_divi_settings($sc){
	$fields = rem_page_builder_fields($sc);
	$divi_fields = array();
	foreach ($fields as $field) {
		$settings_arr = array();
		foreach ($field as $key => $value) {
			if ($key == 'type' && $value == 'dropdown') {
				$value = 'select';
			}
			if($key == 'value' && is_array($value)){
				$value = array_flip($value);
				$key = 'options';
			}
			if ($key == 'heading') {
				$key = 'label';
			}
			if ($key == 'type' && $value == 'textfield') {
				$value = 'text';
			}
			if ($key == 'type' && $value == 'colorpicker') {
				$value = 'color';
			}
			if ($key == 'type' && $value == 'exploded_textarea') {
				$value = 'textarea';
			}
			if ($key == 'type' && $value == 'textarea_html') {
				$value = 'tiny_mce';
			}
			if ($key == 'type' && $value == 'checkbox') {
				$value = 'multiple_checkboxes';
			}
			$settings_arr[$key] =	$value;
		}
		$divi_fields[$field['param_name']] = $settings_arr;
	}
	return $divi_fields;
}

?>