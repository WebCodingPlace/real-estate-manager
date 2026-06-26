<?php
class Elementor_REM_Tags_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'tags';
	}

	public function get_title() {
		return __( 'Property Tags', 'real-estate-manager' );
	}

	public function get_icon() {
		return 'eicon-tags';
	}

	public function get_categories() {
		return [ 'single-property-page' ];
	}

	protected function render() {

		global $post;
		if ($post->post_type == 'rem_property') {
			$terms = wp_get_post_terms( $post->ID ,'rem_property_tag' );
			if (!empty($terms)) {
				echo '<div id="filter-box" class="ich-settings-main-wrap">';
                 
                foreach ( $terms as $term ) {
                    $term_link = get_term_link( $term );
                    
                    if ( is_wp_error( $term_link ) ) {
                        continue;
                    }
                    echo '<a class="filter" href="' . esc_url( $term_link ) . '">' . $term->name . ' <span class="glyphicon glyphicon-tags"></span></a>';
                }

            	echo '</div>';
			}
		}
	}

}
?>