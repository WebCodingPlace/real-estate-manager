<?php
class Elementor_REM_Energy_Efficiency_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'energy_efficency';
	}

	public function get_title() {
		return __( 'Property Energy Efficiency', 'real-estate-manager' );
	}

	public function get_icon() {
		return 'eicon-skill-bar';
	}

	public function get_categories() {
		return [ 'single-property-page' ];
	}

	protected function render() {

		global $post;
		global $rem_hk_ob;
		if ($post->post_type == 'rem_property') {
			$rem_hk_ob->ef_render_graph($post->ID);
		}
	}
}
?>