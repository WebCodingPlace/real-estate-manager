<?php
class Elementor_REM_List_Properties_Widget extends \Elementor\Widget_Base {
	
	public function get_name() {
		return 'rem_list_properties';
	}

	public function get_title() {
		return __( 'List Properties', 'real-estate-manager' );
	}

	public function get_categories() {
		return [ 'real-estate-manager' ];
	}

	public function get_style_depends() {
		return [ 'rem-archive-property-css' ];
	}

	public function get_icon() {
		return 'eicon-post-list';
	}

	protected function register_controls() {
		rem_vc_into_elementor_settings($this, 'rem_list_properties');
	}

	public function render() {
		global $rem_sc_ob;
		$settings = $this->get_settings_for_display();
		$fields = rem_page_builder_fields('rem_list_properties');
		$attrs = array();
		foreach ($fields as $field) {
			if (isset($settings[$field['param_name']]) && $settings[$field['param_name']] != '') {
				$attrs[$field['param_name']] = $settings[$field['param_name']];
			}
		}
		echo $rem_sc_ob->list_properties($attrs);
	}	
}
?>