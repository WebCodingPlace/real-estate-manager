<?php
class Elementor_REM_Video_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'rem_video';
	}

	public function get_title() {
		return __( 'Property Video', 'real-estate-manager' );
	}

	public function get_icon() {
		return 'eicon-video-playlist';
	}

	public function get_categories() {
		return [ 'single-property-page' ];
	}

	protected function render() {

		global $post;
		global $rem_hk_ob;
		$value = get_post_meta($post->ID, 'rem_property_video', true); 
		if (!empty($value)) { ?>
	        <div class="rem-video-wrap">
	            <?php if (rem_get_option('load_video_as', 'default') == 'iframe') { ?>
	                <iframe class="rem-iframe" src="<?php echo esc_url( $value ); ?>" frameborder="0"></iframe>
	            <?php } else {
	                echo apply_filters( 'the_content', $value );
	            } ?>
	        </div> <?php 
		}
	}
}
?>