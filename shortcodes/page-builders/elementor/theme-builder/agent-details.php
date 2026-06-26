<?php
class Elementor_REM_Agent_Details_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'rem_agent_details';
	}

	public function get_title() {
		return __( 'Agent Details', 'real-estate-manager' );
	}

	public function get_icon() {
		return 'eicon-user-circle-o';
	}

	public function get_keywords() {
		return [ 'rem', 'card', 'contact' ];
	}

	public function get_categories() {
		return [ 'single-property-page' ];
	}

	protected function render() {

		global $post;
		global $rem_hk_ob;
		if ($post->post_type == 'rem_property') { 
			$author_id = $post->post_author; ?>
			<div class="ich-settings-main-wrap"> 
				<?php $rem_hk_ob->single_property_agent_form($author_id); ?>
			</div>
			<?php 
		}
	}
}
?>