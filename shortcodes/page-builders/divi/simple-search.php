<?php
class Divi_REM_Simple_Search extends ET_Builder_Module
{
	
	function init() {
	    $this -> name = __('Simple Search Properties', 'real-estate-manager');
	    $this -> slug = 'et_pb_rem_simple_search';
	}

	function get_fields() {
		return rem_vc_into_divi_settings('rem_simple_search');
	}
	
	public function render( $unprocessed_props, $content = null, $render_slug ) {
		global $rem_sc_ob;
		return $rem_sc_ob->simple_search_property($unprocessed_props, $content);
	}	
}

new Divi_REM_Simple_Search;
?>