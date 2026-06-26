<?php
class Divi_REM_Create_Property extends ET_Builder_Module
{
	
	function init() {
	    $this -> name = __('Create Property Form', 'real-estate-manager');
	    $this -> slug = 'et_pb_rem_create_property';
	    $this -> icon = 'V';
	}

	function get_fields() {
		return rem_vc_into_divi_settings('rem_create_property');
	}
	
	public function render( $unprocessed_props, $content = null, $render_slug ) {
		global $rem_sc_ob;
		return $rem_sc_ob->create_property($unprocessed_props, $content);
	}	
}

new Divi_REM_Create_Property;
?>