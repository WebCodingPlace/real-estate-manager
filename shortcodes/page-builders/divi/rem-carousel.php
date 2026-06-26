<?php
class Divi_REM_Rem_Carousel extends ET_Builder_Module
{
	
	function init() {
	    $this -> name = __('Properties Slider', 'real-estate-manager');
	    $this -> slug = 'et_pb_rem_carousel';
	    $this -> icon = 'S';
	}

	function get_fields() {
		return rem_vc_into_divi_settings('rem_carousel');
	}
	
	public function render( $unprocessed_props, $content = null, $render_slug ) {
		global $rem_sc_ob;
		return $rem_sc_ob->display_carousel($unprocessed_props, $content);
	}	
}

new Divi_REM_Rem_Carousel;
?>