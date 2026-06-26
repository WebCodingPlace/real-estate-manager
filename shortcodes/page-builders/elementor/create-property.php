<?php
class Elementor_REM_Create_Property_Widget extends \Elementor\Widget_Base {
	
	public function get_name() {
		return 'rem_create_property';
	}

	public function get_title() {
		return __( 'Create Property', 'real-estate-manager' );
	}

	public function get_categories() {
		return [ 'real-estate-manager' ];
	}

	public function get_icon() {
		return 'eicon-document-file';
	}

	protected function register_controls() {
		rem_vc_into_elementor_settings($this, 'rem_create_property');
	}

	public function render() {
		global $rem_sc_ob;
		$settings = $this->get_settings_for_display();
		$fields = rem_page_builder_fields('rem_create_property');
		$attrs = array();
		foreach ($fields as $field) {
			if (isset($settings[$field['param_name']]) && $settings[$field['param_name']] != '') {
				$attrs[$field['param_name']] = $settings[$field['param_name']];
			}
		}
		if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
			echo "<div class='ich-settings-main-wrap'>";
				echo "<div class='alert alert-info'>";
					echo __( 'Live Preview is not available in Elementor edit mode but will work when visiting this page.', 'real-estate-manager' );
					
				echo "</div>";
			echo "</div>";
		} else {
			echo $rem_sc_ob->create_property($attrs, $settings['main_content']);
		}
	}	
}
?>