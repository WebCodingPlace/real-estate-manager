<?php
class Elementor_REM_Rem_Carousel_Widget extends \Elementor\Widget_Base {
	
	public function get_name() {
		return 'rem_carousel';
	}

	public function get_title() {
		return __( 'Properties Carousel', 'real-estate-manager' );
	}

	public function get_categories() {
		return [ 'real-estate-manager' ];
	}

	public function get_script_depends() {
		return [ 'rem-carousel-js', 'rem-elementor-sc' ];
	}

	public function get_icon() {
		return 'eicon-posts-carousel';
	}

	public function get_style_depends() {
		return [ 'rem-archive-property-css' ];
	}
	
	protected function register_controls() {
		rem_vc_into_elementor_settings($this, 'rem_carousel');
	}

	public function render() {
		global $rem_sc_ob;
		$settings = $this->get_settings_for_display();
		$fields = rem_page_builder_fields('rem_carousel');
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
			echo $rem_sc_ob->display_carousel($attrs);
		}
	}	
}
?>