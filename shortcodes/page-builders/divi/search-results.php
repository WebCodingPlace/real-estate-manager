<?php
class Divi_REM_Search_Results extends ET_Builder_Module
{
	
	function init() {
	    $this -> name = __('Search Results', 'real-estate-manager');
	    $this -> slug = 'et_pb_rem_search_results';
	}

	function get_fields() {
		return rem_vc_into_divi_settings('rem_search_results');
	}
	
	public function render( $unprocessed_props, $content = null, $render_slug ) {
		global $rem_sc_ob;
		return $rem_sc_ob->display_search_results($unprocessed_props, $content);
	}	
}

new Divi_REM_Search_Results;
?>