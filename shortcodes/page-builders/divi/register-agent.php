<?php
class Divi_REM_Register_Agent extends ET_Builder_Module
{
	
	function init() {
	    $this -> name = __('Register Agent', 'real-estate-manager');
	    $this -> slug = 'et_pb_rem_register_agent';
	    $this -> icon = 'G';
	}

	function get_fields() {
		return rem_vc_into_divi_settings('rem_register_agent');
	}
	
	public function render( $unprocessed_props, $content = null, $render_slug ) {
		global $rem_sc_ob;
		return $rem_sc_ob->register_agent($unprocessed_props, $content);
	}	
}
new Divi_REM_Register_Agent;
?>