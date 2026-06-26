<?php
class Divi_REM_My_Profile extends ET_Builder_Module
{
	
	function init() {
	    $this -> name = __('My Profile', 'real-estate-manager');
	    $this -> slug = 'et_pb_rem_my_profile';
	    $this -> icon = 'G';
	}

	function get_fields() {
		return rem_vc_into_divi_settings('rem_my_profile');
	}
	
	public function render( $unprocessed_props, $content = null, $render_slug ) {
		global $rem_sc_ob;
		return $rem_sc_ob->my_profile($unprocessed_props, $content);
	}	
}

new Divi_REM_My_Profile;
?>