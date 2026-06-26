<?php
class Divi_REM_Manage_Properties extends ET_Builder_Module
{
	
	function init() {
	    $this -> name = __('Manage Properties', 'real-estate-manager');
	    $this -> slug = 'et_pb_rem_manage_properties';
	}

	function get_fields() {
		return rem_vc_into_divi_settings('rem_manage_properties');
	}
	
	public function render( $unprocessed_props, $content = null, $render_slug ) {
		global $rem_sc_ob;
		return $rem_sc_ob->manage_properties($unprocessed_props, $content);
	}	
}

new Divi_REM_Manage_Properties;
?>