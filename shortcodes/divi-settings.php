<?php
/**
* Class for Divi Modules
*/
class Divi_REM_List_Properties extends ET_Builder_Module
{
	
	function init() {
	    $this -> name = __('List Properties', 'real-estate-manager');
	    $this -> slug = 'et_pb_rem_list_properties';
	}

	function get_fields() {
	    $fields = array(
	        'order' => array(
	            'label' => esc_html__('Order', 'real-estate-manager'),
	            'type' => 'select',
	            'options' => array(
	                'ASC' => esc_html__('Ascending', 'real-estate-manager'),
	                'DESC' => esc_html__('Descending', 'real-estate-manager'),
	            ),
	            'description' => esc_html__('Order of properties you want to display.', 'real-estate-manager'),
	        ),
	        'orderby' => array(
	            'label' => esc_html__('Order By', 'real-estate-manager'),
	            'type' => 'select',
	            'options' => array(
	                'date' => esc_html__('Date Created', 'real-estate-manager'),
	                'ID' => esc_html__('ID', 'real-estate-manager'),
	                'author' => esc_html__('Property Agent', 'real-estate-manager'),
	                'title' => esc_html__('Property Title', 'real-estate-manager'),
	                'rand' => esc_html__('Random', 'real-estate-manager'),
	            ),
	            'description' => esc_html__('Sort retrieved properties by specific parameter.', 'real-estate-manager'),
	        ),
	        'style' => array(
	            'label' => esc_html__('Property Style', 'real-estate-manager'),
	            'type' => 'select',
	            'options' => array_flip(rem_get_property_listing_styles()),
	            'description' => esc_html__('Choose property style.', 'real-estate-manager'),
	        ),
	        'posts' => array(
	            'label' => esc_html__('Total Properties', 'real-estate-manager'),
	            'type' => 'text',
	            'description' => esc_html__('Number of properties to display at time.', 'real-estate-manager'),
	        ),
	        'class' => array(
	            'label' => esc_html__('Columns', 'real-estate-manager'),
	            'type' => 'select',
	            'options' => array(
	                'col-sm-12' => esc_html__('1', 'real-estate-manager'),
	                'col-sm-6' => esc_html__('2', 'real-estate-manager'),
	                'col-sm-4' => esc_html__('3', 'real-estate-manager'),
	                'col-sm-3' => esc_html__('4', 'real-estate-manager'),
	                'col-sm-5th-1' => esc_html__('5', 'real-estate-manager'),
	                'col-sm-2' => esc_html__('6', 'real-estate-manager'),
	            ),
	            'description' => esc_html__('Number of properties in a row.', 'real-estate-manager'),
	        ),
	        'tags' => array(
	            'label' => esc_html__('Tags', 'real-estate-manager'),
	            'type' => 'text',
	            'description' => esc_html__('Comma separated list of tags to display tag specific properties.', 'real-estate-manager'),
	        ),
	        'pagination' => array(
	            'label' => esc_html__('Pagination', 'real-estate-manager'),
	            'type' => 'select',
	            'options' => array(
	                'enable' => esc_html__('Enable', 'real-estate-manager'),
	                'disable' => esc_html__('Disable', 'real-estate-manager'),
	            ),
	            'description' => esc_html__('Display pagination if there are more properties.', 'real-estate-manager'),
	        ),
	        'masonry' => array(
	            'label' => esc_html__('Masonry Grid', 'real-estate-manager'),
	            'type' => 'select',
	            'options' => array(
	                'disable' => esc_html__('Disable', 'real-estate-manager'),
	                'enable' => esc_html__('Enable', 'real-estate-manager'),
	            ),
	            'description' => esc_html__('Activates Justified Grid mode.', 'real-estate-manager'),
	        ),
	        'nearest_porperties' => array(
	            'label' => esc_html__('Prefer Near Properties', 'real-estate-manager'),
	            'type' => 'select',
	            'options' => array(
	                'disable' => esc_html__('Disable', 'real-estate-manager'),
	                'enable' => esc_html__('Enable', 'real-estate-manager'),
	            ),
	            'description' => esc_html__('It will enable Geo Location service. Needs SSL to work properly', 'real-estate-manager'),
	        ),
	        'meta' => array(
	            'label' => esc_html__('Meta Filtration', 'real-estate-manager'),
	            'type' => 'textarea',
	            'description' => esc_html__('Please see details here', 'real-estate-manager').' <a href="http://rem.webcodingplace.com/real-estate-manager-documentation-and-help/shortcodes-detail/">'.__( 'Shortcodes', 'real-estate-manager' ).'</a>',
	        ),
	    );
	    return $fields;
	}
}
?>