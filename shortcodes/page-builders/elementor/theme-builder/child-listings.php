<?php
class Elementor_REM_Child_Listings_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'rem_child_listings';
	}

	public function get_title() {
		return __( 'Child Listings', 'real-estate-manager' );
	}

	public function get_keywords() {
		return [ 'rem', 'child', 'parent' ];
	}

	public function get_icon() {
		return 'eicon-archive';
	}

	public function get_categories() {
		return [ 'single-property-page' ];
	}

	protected function render() {
		global $post;
		echo '<div class="rem-childs-elementor-widget ich-settings-main-wrap">';
				do_action( 'rem_single_property_page_childs', $post->ID );
		echo '</div>';
	}
}
?>