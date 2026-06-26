<?php
class Elementor_REM_Agent_Profile_Widget extends \Elementor\Widget_Base {
	
	public function get_name() {
		return 'rem_agent_profile';
	}

	public function get_title() {
		return __( 'Agent Profile', 'real-estate-manager' );
	}

	public function get_categories() {
		return [ 'real-estate-manager' ];
	}

	public function get_icon() {
		return 'eicon-user-circle-o';
	}

	public function get_style_depends() {
		wp_register_style( 'rem-skillbars-css', REM_URL . '/assets/front/lib/skill-bars.css' );
		wp_register_style( 'rem-archive-property-css', REM_URL . '/assets/front/css/archive-property.css' );
		wp_register_style( 'rem-profile-agent-css', REM_URL . '/assets/front/css/profile-agent.css' );
		return [ 'rem-archive-property-css', 'rem-skillbars-css', 'rem-profile-agent-css' ];
	}

	public function get_script_depends() {
		wp_register_script( 'rem-carousel-js', REM_URL . '/assets/front/lib/slick.min.js', array('jquery'));
		return [ 'rem-carousel-js' ];
	}

	protected function register_controls() {
		rem_vc_into_elementor_settings($this, 'rem_agent_profile');
	}

	public function render() {
		global $rem_sc_ob;
		$settings = $this->get_settings_for_display();
		$fields = rem_page_builder_fields('rem_agent_profile');
		$attrs = array();
		foreach ($fields as $field) {
			if (isset($settings[$field['param_name']]) && $settings[$field['param_name']] != '') {
				$attrs[$field['param_name']] = $settings[$field['param_name']];
			}
		}
		echo $rem_sc_ob->display_agent($attrs);
	}	
}
?>