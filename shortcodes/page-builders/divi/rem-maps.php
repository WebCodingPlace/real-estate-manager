<?php
class Divi_REM_Maps extends ET_Builder_Module
{
	
	function init() {
	    $this -> name = __('Large Map', 'real-estate-manager');
	    $this -> slug = 'et_pb_rem_maps';
	    $this -> icon = 'F';
	}

	function get_fields() {
		return rem_vc_into_divi_settings('rem_maps');
	}
	
	public function render( $unprocessed_props, $content = null, $render_slug ) {
		global $rem_sc_ob;
		return $rem_sc_ob->display_maps($unprocessed_props, $content);
	}	
}

new Divi_REM_Maps;
?>