<?php
class Divi_REM_Single_Property extends ET_Builder_Module
{
	
	function init() {
	    $this -> name = __('Single Property', 'real-estate-manager');
	    $this -> slug = 'et_pb_rem_property';
	    $this -> icon = 'p';
	}

	function get_fields() {
		return rem_vc_into_divi_settings('rem_property');
	}
	
	public function render( $unprocessed_props, $content = null, $render_slug ) {
		global $rem_sc_ob;
		return $rem_sc_ob->single_property($unprocessed_props, $content);
	}	
}

new Divi_REM_Single_Property;
?>