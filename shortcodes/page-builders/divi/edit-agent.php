<?php
class Divi_REM_Edit_Agent extends ET_Builder_Module
{
	
	function init() {
	    $this -> name = __('Edit Agent Form', 'real-estate-manager');
	    $this -> slug = 'et_pb_rem_agent_edit';
	    $this -> icon = 'G';
	}

	function get_fields() {
		return rem_vc_into_divi_settings('rem_agent_edit');
	}
	
	public function render( $unprocessed_props, $content = null, $render_slug ) {
		global $rem_sc_ob;
		return $rem_sc_ob->edit_agent($unprocessed_props, $content);
	}	
}

new Divi_REM_Edit_Agent;
?>