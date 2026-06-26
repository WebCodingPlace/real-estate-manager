<?php
function rem_page_builder_fields($shortcode = ''){
	$property_styles = rem_get_property_listing_styles();
	$all_agents = get_users( 'role=rem_property_agent' );
	$agents_arr = array( 'Administrator' => 1 );
	foreach ($all_agents as $agent) {
		$agents_arr[$agent->display_name] = $agent->ID;
	}	
	switch ($shortcode) {
		case 'rem_list_properties':
			$fields = array(
				array(
			        'type' 			=> 'dropdown',
			        'param_name' 	=> 'order',
			        'heading' 		=> __('Order', 'real-estate-manager'),
			        'description' 	=> __('Designates the ascending or descending order of the below option.', 'real-estate-manager'),
			        'value' => array(
			            __('Ascending', 'real-estate-manager') => 'ASC',
			            __('Descending', 'real-estate-manager') => 'DESC',
			        ),
				),
				array(
			        'type' 			=> 'dropdown',
			        'param_name' 	=> 'orderby',
			        'heading' 		=> __('Order By', 'real-estate-manager'),
			        'description' 	=> __('Choose option to sort properties by', 'real-estate-manager'),
			        'value' => array(
			            __('Date', 'real-estate-manager') => 'date',
			            __('ID', 'real-estate-manager') => 'ID',
			            __('Agent', 'real-estate-manager') => 'author',
			            __('Property Title', 'real-estate-manager') => 'title',
			            __('Property Price', 'real-estate-manager') => 'price',
			            __('Random', 'real-estate-manager') => 'rand',
			        ),
				),
				array(
			        'type' 			=> 'textfield',
			        'param_name' 	=> 'orderby_custom',
			        'heading' 		=> __('Order by custom meta', 'real-estate-manager'),
			        'description' 	=> __('Provide custom field key to sort by custom field. Eg: property_status', 'real-estate-manager'),
				),
				array(
			        'type' 			=> 'dropdown',
			        'param_name' 	=> 'style',
			        'heading' 		=> __('Property Style', 'real-estate-manager'),
			        'description' 	=> __('Choose properties display style', 'real-estate-manager'),
			        'value' => $property_styles,
				),
				array(
			        'type' 			=> 'dropdown',
			        'param_name' 	=> 'class',
			        'heading' 		=> __('Columns', 'real-estate-manager'),
			        'description' 	=> __('Number of properties in a row', 'real-estate-manager'),
			        'value' => array(
			            __('1 Columns', 'real-estate-manager') => 'col-sm-12',
			            __('2 Columns', 'real-estate-manager') => 'col-sm-6',
			            __('3 Columns', 'real-estate-manager') => 'col-sm-4',
			            __('4 Columns', 'real-estate-manager') => 'col-sm-3',
			            __('5 Columns', 'real-estate-manager') => 'col-md-5th-1',
			        ),
				),
				array(
			        'type' 			=> 'dropdown',
			        'param_name' 	=> 'top_bar',
			        'heading' 		=> __('Top Bar', 'real-estate-manager'),
			        'description' 	=> __('Top bar to sort or change layout', 'real-estate-manager'),
			        'value' => array(
			            __('Disable', 'real-estate-manager') => 'disable',
			            __('Enable', 'real-estate-manager') => 'enable',
			        ),
				),
				array(
			        'type' 			=> 'dropdown',
			        'param_name' 	=> 'grid_style',
			        'heading' 		=> __('Default Grid Style', 'real-estate-manager'),
			        'description' 	=> __('Default style of grid for top bar.', 'real-estate-manager'),
			        'value' => $property_styles,
				),
				array(
			        'type' 			=> 'dropdown',
			        'param_name' 	=> 'grid_style_col',
			        'heading' 		=> __('Grid Style Columns', 'real-estate-manager'),
			        'description' 	=> __('Columns for Grid Style', 'real-estate-manager'),
			        'value' => array(
			            __('1 Columns', 'real-estate-manager') => 'col-sm-12',
			            __('2 Columns', 'real-estate-manager') => 'col-sm-6',
			            __('3 Columns', 'real-estate-manager') => 'col-sm-4',
			            __('4 Columns', 'real-estate-manager') => 'col-sm-3',
			            __('5 Columns', 'real-estate-manager') => 'col-md-5th-1',
			        ),
				),
				array(
			        'type' 			=> 'dropdown',
			        'param_name' 	=> 'list_style',
			        'heading' 		=> __('Default List Style', 'real-estate-manager'),
			        'description' 	=> __('Default style of list for top bar.', 'real-estate-manager'),
			        'value' => $property_styles,
				),
				array(
			        'type' 			=> 'dropdown',
			        'param_name' 	=> 'list_style_col',
			        'heading' 		=> __('Grid Style Columns', 'real-estate-manager'),
			        'description' 	=> __('Columns for List Style', 'real-estate-manager'),
			        'value' => array(
			            __('1 Columns', 'real-estate-manager') => 'col-sm-12',
			            __('2 Columns', 'real-estate-manager') => 'col-sm-6',
			            __('3 Columns', 'real-estate-manager') => 'col-sm-4',
			            __('4 Columns', 'real-estate-manager') => 'col-sm-3',
			            __('5 Columns', 'real-estate-manager') => 'col-md-5th-1',
			        ),
				),
				array(
			        'type' 			=> 'dropdown',
			        'param_name' 	=> 'not_available',
			        'heading' 		=> __('Not Available Properties', 'real-estate-manager'),
			        'description' 	=> __('Display properties having status Not Available or not', 'real-estate-manager'),
			        'value' => array(
			            __('Disable', 'real-estate-manager') => 'disable',
			            __('Enable', 'real-estate-manager') => 'enable',
			        ),
				),
				array(
			        'type' 			=> 'textfield',
			        'param_name' 	=> 'posts',
			        'heading' 		=> __('Number of Properties', 'real-estate-manager'),
			        'description' 	=> __('Provide total number of properties to show, after that pagination will display', 'real-estate-manager'),
				),
				array(
			        'type' 			=> 'textfield',
			        'param_name' 	=> 'images_height',
			        'heading' 		=> __('Images Height', 'real-estate-manager'),
			        'description' 	=> __('Provide height with units if you want to make images height fixed', 'real-estate-manager'),
				),
				array(
			        'type' 			=> 'textfield',
			        'param_name' 	=> 'tags',
			        'heading' 		=> __('Tags Specific', 'real-estate-manager'),
			        'description' 	=> __('Comma separated list of tags to filter properties', 'real-estate-manager'),
				),
				array(
			        'type' 			=> 'textfield',
			        'param_name' 	=> 'cats',
			        'heading' 		=> __('Categories', 'real-estate-manager'),
			        'description' 	=> __('Comma separated list of categories to filter properties', 'real-estate-manager'),
				),
				array(
			        'type' 			=> 'textfield',
			        'param_name' 	=> 'features',
			        'heading' 		=> __('Features Specific', 'real-estate-manager'),
			        'description' 	=> __('Comma separated list of features to filter properties', 'real-estate-manager'),
				),
				array(
			        'type' 			=> 'textfield',
			        'param_name' 	=> 'author',
			        'heading' 		=> __('Agent Specific', 'real-estate-manager'),
			        'description' 	=> __('Agent ID or comma separated IDs to display their properties', 'real-estate-manager'),
				),
			    array(
			        'type' 			=> 'exploded_textarea',
			        'param_name' 	=> 'meta',
			        'heading' 		=> __('Filter Properties by Meta', 'real-estate-manager'),
			        'description' 	=> __('Provide meta key and value on each line to filter. Eg: property_status|normal', 'real-estate-manager').' <a target="_blank" href="https://wp-rem.com/online-documentation/faqs/use-meta-attribute-in-the-shortcodes/">Help</a>',
			    ),
				array(
			        'type' 			=> 'dropdown',
			        'param_name' 	=> 'nearest_properties',
			        'heading' 		=> __('Prefer Nearest Properties', 'real-estate-manager'),
			        'description' 	=> __('It will enable Geo Location to track visitor location and will display properties near them', 'real-estate-manager'),
			        'value' => array(
			            __('Disable', 'real-estate-manager') => 'disable',
			            __('Enable', 'real-estate-manager') => 'enable',
			        ),
				),
				array(
			        'type' 			=> 'dropdown',
			        'param_name' 	=> 'masonry',
			        'heading' 		=> __('Justified Grid (Masonry)', 'real-estate-manager'),
			        'description' 	=> __('It will enable masonry grid for properties', 'real-estate-manager'),
			        'value' => array(
			            __('Disable', 'real-estate-manager') => 'disable',
			            __('Enable', 'real-estate-manager') => 'enable',
			        ),
				),
				array(
			        'type' 			=> 'dropdown',
			        'param_name' 	=> 'pagination',
			        'heading' 		=> __('Pagination', 'real-estate-manager'),
			        'description' 	=> __('Enable or Disable Pagination', 'real-estate-manager'),
			        'value' => array(
			            __('Enable', 'real-estate-manager') => 'enable',
			            __('Disable', 'real-estate-manager') => 'disable',
			        ),
				),
				array(
			        'type' 			=> 'dropdown',
			        'param_name' 	=> 'ajax',
			        'heading' 		=> __('AJAX Pagination', 'real-estate-manager'),
			        'description' 	=> __('Enable or Disable Pagination', 'real-estate-manager'),
			        'value' => array(
			            __('Disable', 'real-estate-manager') => 'disable',
			            __('Enable', 'real-estate-manager') => 'enable',
			        ),
				),
			);
			break;
		case 'rem_register_agent':
			$fields = array(
				array(
    				'type'			=>	'textfield',
    				'param_name'	=>	'redirect',
    				'heading'		=>	__( 'Redirect', 'real-estate-manager' ),
    				'description'	=>	__( 'Provide URL to redirect after successful registration', 'real-estate-manager' ),
				),
				array(
    				'type'			=>	'textarea',
    				'param_name'	=>	'required_text',
    				'heading'		=>	__( 'Required Text', 'real-estate-manager' ),
    				'description'	=>	__( 'Provide terms and conditions', 'real-estate-manager' ),
				),
				array(
    				'type'			=>	'textarea_html',
    				'param_name'	=>	'content',
    				'heading'		=>	__( 'Content for Logged In Users', 'real-estate-manager' ),
    				'description'	=>	__( 'Provide contents for already logged in users', 'real-estate-manager' ),
				),
			);
			break;
		case 'rem_simple_search':
			$fields = array(
				array(
    				'type'			=>	'textfield',
    				'param_name'	=>	'placeholder',
    				'heading'		=>	__( 'Placeholder', 'real-estate-manager' ),
    				'description'	=>	__( 'Placeholder for search field', 'real-estate-manager' ),
				),
				array(
    				'type'			=>	'textfield',
    				'param_name'	=>	'width',
    				'heading'		=>	__( 'Field Width', 'real-estate-manager' ),
    				'description'	=>	__( 'Width with units. Eg: 450px', 'real-estate-manager' ),
				),
				array(
    				'type'			=>	'colorpicker',
    				'param_name'	=>	'border_color',
    				'heading'		=>	__( 'Border Color', 'real-estate-manager' ),
    				'description'	=>	__( 'Choose color for border', 'real-estate-manager' ),
				),
				array(
    				'type'			=>	'textfield',
    				'param_name'	=>	'results_page',
    				'heading'		=>	__( 'Results Page URL', 'real-estate-manager' ),
    				'description'	=>	__( 'Provide URL for the search results page', 'real-estate-manager' ),
				),
				array(
    				'type'			=>	'textfield',
    				'param_name'	=>	'search_icon',
    				'heading'		=>	__( 'Search Icon', 'real-estate-manager' ),
    				'description'	=>	__( 'Provide fontawesome icon with markup.', 'real-estate-manager' ),
				),
			);
			break;
		case 'rem_carousel':
			$fields = array(
				array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'order',
		            'heading' 		=> __('Order', 'real-estate-manager'),
		            'description' 	=> __('Choose order to display properties', 'real-estate-manager'),
		            'value' => array(
		                __('Ascending', 'real-estate-manager') => 'ASC',
		                __('Descending', 'real-estate-manager') => 'DESC',
		            ),
				),
				array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'orderby',
		            'heading' 		=> __('Order By', 'real-estate-manager'),
		            'description' 	=> __('Choose order by to display properties', 'real-estate-manager'),
		            'value' => array(
		                __('Date', 'real-estate-manager') => 'date',
		                __('Agent', 'real-estate-manager') => 'author',
		                __('Property Name', 'real-estate-manager') => 'title',
		                __('Random', 'real-estate-manager') => 'rand',
		            ),
				),
				array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'style',
		            'heading' 		=> __('Property Style', 'real-estate-manager'),
		            'description' 	=> __('Choose properties display style', 'real-estate-manager'),
		            'value' => $property_styles,
				),
				array(
		            'type' 			=> 'textfield',
		            'param_name' 	=> 'total_properties',
		            'heading' 		=> __('Total Properties', 'real-estate-manager'),
		            'description' 	=> __('Provide total number of properties to show', 'real-estate-manager'),
				),
		        array(
		            'type' 			=> 'exploded_textarea',
		            'param_name' 	=> 'meta',
		            'heading' 		=> __('Filter Properties by Meta', 'real-estate-manager'),
		            'description' 	=> __('Provide meta key and value on each line to filter. Eg: property_status|normal', 'real-estate-manager'),
		        ),
		        array(
		            'type' 			=> 'exploded_textarea',
		            'param_name' 	=> 'tags',
		            'heading' 		=> __('Tags', 'real-estate-manager'),
		            'description' 	=> __('Provide tags each per line to display specific properties', 'real-estate-manager'),
		        ),
		        array(
		            "type" => "exploded_textarea",
		            "param_name" => "ids",
		            "heading" => __("Property IDs", 'real-estate-manager'),
		            "description" => __("Provide IDs if you want to display specific properties, each per line", 'real-estate-manager'),
		        ),
				array(
		            'type' 			=> 'textfield',
		            'param_name' 	=> 'author',
		            'heading' 		=> __('Agent', 'real-estate-manager'),
		            'description' 	=> __('Agent ID or comma separated IDs to display their properties', 'real-estate-manager'),
				),		        
				array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'nearest_properties',
		            'heading' 		=> __('Prefer Nearest Properties', 'real-estate-manager'),
		            'description' 	=> __('It will enable Geo Location Trackor to track visitors location and will display properties near them', 'real-estate-manager'),
		            'value' => array(
		                __('Disable', 'real-estate-manager') => 'disable',
		                __('Enable', 'real-estate-manager') => 'enable',
		            ),
				),

		        array(
		            "type" => "textfield",
		            "param_name" => "slidestoshow",
		            "heading" => __("Properties in Row", 'real-estate-manager'),
		            "description" => __("Provide number of properties you want to show at a time", 'real-estate-manager'),
		            "group" => "Carousel Settings",
		        ),
		        array(
		            "type" => "textfield",
		            "param_name" => "slidestoscroll",
		            "heading" => __("Properties to Scroll", 'real-estate-manager'),
		            "description" => __("Provide number of properties you want to scroll at a time", 'real-estate-manager'),
		            "group" => "Carousel Settings",
		        ),
		        array(
		            "type" => "textfield",
		            "param_name" => "speed",
		            "heading" => __("Speed", 'real-estate-manager'),
		            "description" => __("Speed in ms Eg: 2000", 'real-estate-manager'),
		            "group" => "Carousel Settings",
		        ),
				array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'autoplay',
		            'heading' 		=> __('Auto Play', 'real-estate-manager'),
		            'description' 	=> __('Enable to display auto rotation of properties', 'real-estate-manager'),
		            'value' => array(
		                __('Disable', 'real-estate-manager') => 'disable',
		                __('Enable', 'real-estate-manager') => 'enable',
		            ),
		            "group" => "Carousel Settings",
				),
				array(
		            'type' 			=> 'textfield',
		            'param_name' 	=> 'autoplayspeed',
		            'heading' 		=> __('Auto Play Speed', 'real-estate-manager'),
		            'description' 	=> __('Auto play speed in ms Eg: 2000', 'real-estate-manager'),
		            "group" => "Carousel Settings",
				),
				array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'arrows',
		            'heading' 		=> __('Arrows', 'real-estate-manager'),
		            'description' 	=> __('Enable to display arrows for navigation', 'real-estate-manager'),
		            'value' => array(
		                __('Disable', 'real-estate-manager') => 'disable',
		                __('Enable', 'real-estate-manager') => 'enable',
		            ),
		            "group" => "Carousel Settings",
				),
				array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'dots',
		            'heading' 		=> __('Dots', 'real-estate-manager'),
		            'description' 	=> __('Enable to display bottom dots for navigation', 'real-estate-manager'),
		            'value' => array(
		                __('Disable', 'real-estate-manager') => 'disable',
		                __('Enable', 'real-estate-manager') => 'enable',
		            ),
		            "group" => "Carousel Settings",
				),
			);
			break;
		case 'rem_agent_edit':
			$fields = array(
				array(
    				'type'			=>	'textarea_html',
    				'param_name'	=>	'content',
    				'heading'		=>	__( 'Content for Non Logged In Users', 'real-estate-manager' ),
    				'description'	=>	__( 'Provide contents for non logged in users', 'real-estate-manager' ),
				),
			);
			break;
		case 'rem_agent_login':
			$fields = array(
				array(
    				'type'			=>	'textfield',
    				'param_name'	=>	'heading',
    				'heading'		=>	__( 'Heading', 'real-estate-manager' ),
    				'description'	=>	__( 'Heading will appear above the login form', 'real-estate-manager' ),
				),
				array(
    				'type'			=>	'textfield',
    				'param_name'	=>	'redirect',
    				'heading'		=>	__( 'Redirect', 'real-estate-manager' ),
    				'description'	=>	__( 'Provide URL to redirect after successful login', 'real-estate-manager' ),
				),
				array(
    				'type'			=>	'textarea_html',
    				'param_name'	=>	'content',
    				'heading'		=>	__( 'Content for Logged In Users', 'real-estate-manager' ),
    				'description'	=>	__( 'Provide contents for already logged in users', 'real-estate-manager' ),
				),
			);
			break;
		case 'rem_create_property':
			$fields = array(
				array(
				    'type' 			=> 'textfield',
				    'param_name' 	=> 'roles',
				    'heading' 		=> __('User Roles', 'real-estate-manager'),
				    'description' 	=> __('Comma separated list of roles who can create listing', 'real-estate-manager'),
				    'value' => 'rem_property_agent',
				),
				array(
    				'type'			=>	'textarea_html',
    				'param_name'	=>	'content',
    				'heading'		=>	__( 'Content for Non Logged In Users', 'real-estate-manager' ),
    				'description'	=>	__( 'Provide contents to display if user is not logged in', 'real-estate-manager' ),
				),
			);
			break;
		case 'rem_edit_property':
			$fields = array(
				array(
    				'type'			=>	'textarea_html',
    				'param_name'	=>	'content',
    				'heading'		=>	__( 'Content for Non Logged In Users', 'real-estate-manager' ),
    				'description'	=>	__( 'Provide contents to display if user is not logged in', 'real-estate-manager' ),
				),
			);
			break;
		case 'rem_property':
			$fields = array(
				array(
    				'type'			=>	'textfield',
    				'param_name'	=>	'id',
    				'heading'		=>	__( 'Property ID', 'real-estate-manager' ),
    				'description'	=>	__( 'Provide property id here', 'real-estate-manager' ),
				),
			);
			break;
		case 'rem_my_properties':
			$fields = array(
				array(
    				'type'			=>	'textarea_html',
    				'param_name'	=>	'content',
    				'heading'		=>	__( 'Content for Non Logged In Users', 'real-estate-manager' ),
    				'description'	=>	__( 'Provide content to display if user is not logged in', 'real-estate-manager' ),
				),
			);
			break;
		case 'rem_my_profile':
			$fields = array(
				array(
    				'type'			=>	'textarea_html',
    				'param_name'	=>	'content',
    				'heading'		=>	__( 'Content for Non Logged In Users', 'real-estate-manager' ),
    				'description'	=>	__( 'Provide content to display if user is not logged in', 'real-estate-manager' ),
				),
			);
			break;
		case 'rem_agent_logout':
			$fields = array(
				array(
    				'type'			=>	'textfield',
    				'param_name'	=>	'redirect',
    				'heading'		=>	__( 'Redirect URL', 'real-estate-manager' ),
    				'description'	=>	__( 'Provide URL to redirect after logout', 'real-estate-manager' ),
				),
				array(
    				'type'			=>	'textfield',
    				'param_name'	=>	'button_classes',
    				'heading'		=>	__( 'CSS Class', 'real-estate-manager' ),
    				'description'	=>	__( 'Provide css classes for button', 'real-estate-manager' ),
				),
				array(
    				'type'			=>	'textfield',
    				'param_name'	=>	'label',
    				'heading'		=>	__( 'Label', 'real-estate-manager' ),
    				'description'	=>	__( 'Provide button label', 'real-estate-manager' ),
				),
			);
			break;
		case 'rem_agent_profile':
			$fields = array(
		        array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'author_id',
		            'heading' 		=> __('Agent', 'real-estate-manager'),
		            'description' 	=> __('Choose agent to display his/her profile.', 'real-estate-manager'),
		            'value' => $agents_arr,
		        ),
			);
			break;
		case 'rem_manage_properties':
			$fields = array(
		        array(
		            'type' 			=> 'textfield',
		            'param_name' 	=> 'role',
		            'heading' 		=> __('Role', 'real-estate-manager'),
		            'description' 	=> __('Provide role name who can manage properties from this page.', 'real-estate-manager'),
		        ),
				array(
    				'type'			=>	'textarea_html',
    				'param_name'	=>	'content',
    				'heading'		=>	__( 'Content for Non Logged In Users', 'real-estate-manager' ),
    				'description'	=>	__( 'Provide content to display if user is not logged in', 'real-estate-manager' ),
				),		        
			);
			break;
		case 'rem_search_property':
			$fields = array(
				array(
    				'type'			=>	'checkbox',
    				'param_name'	=>	'fields_to_show',
    				'heading'		=>	__( 'Check Fields to Display', 'real-estate-manager' ),
    				'description'	=>	__( 'Check the required fields for search menu', 'real-estate-manager' ),
		            'value' => get_search_fields_for_page_builders(),    				
				),
				array(
    				'type'			=>	'checkbox',
    				'param_name'	=>	'fields_to_hide',
    				'heading'		=>	__( 'Check Fields to Display under More Filters', 'real-estate-manager' ),
    				'description'	=>	__( 'These fields will be hidden until show fields button clicked. Works with specific form styles', 'real-estate-manager' ),
		            'value' => get_search_fields_for_page_builders(),    				
				),
		        array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'columns',
		            'heading' 		=> __('Columns', 'real-estate-manager'),
		            'description' 	=> __('Choose number of fields in each row', 'real-estate-manager'),
		            'value' => array(
		                __('2 Columns', 'real-estate-manager') => '6',
		                __('3 Columns', 'real-estate-manager') => '4',
		                __('4 Columns', 'real-estate-manager') => '3',
		                __('5 Columns', 'real-estate-manager') => '5th-1',
		                __('6 Columns', 'real-estate-manager') => '2',
		                __('1 Column', 'real-estate-manager') => '12',
		            ),
		        ),
		        array(
		            'type' 			=> 'textfield',
		            'param_name' 	=> 'search_btn_text',
		            'heading' 		=> __('Search Button Title', 'real-estate-manager'),
		            'description' 	=> __('Provide text for search button', 'real-estate-manager'),
		        ),
	        	array(
	                'type' 			=> 'dropdown',
	                'param_name' 	=> 'more_filters_features',
	                'heading' 		=> __('More Filters Features', 'real-estate-manager'),
	                'description' 	=> __('Enable or Disable features checkboxes', 'real-estate-manager'),
	                'value' => array(
	                    __('Enable', 'real-estate-manager') => 'enable',
	                    __('Disable', 'real-estate-manager') => 'disable',
	                ),
	        	),
		        array(
		            'type' 			=> 'textfield',
		            'param_name' 	=> 'filters_btn_text',
		            'heading' 		=> __('Filter Button Title', 'real-estate-manager'),
		            'description' 	=> __('Provide text for more filter button', 'real-estate-manager'),
		        ),
		        array(
		            'type' 			=> 'textfield',
		            'param_name' 	=> 'reset_btn_text',
		            'heading' 		=> __('Reset Button Title', 'real-estate-manager'),
		            'description' 	=> __('Provide text for more reset button', 'real-estate-manager'),
		        ),
		        array(
		            'type' 			=> 'textfield',
		            'param_name' 	=> 'results_page',
		            'heading' 		=> __('Results Page', 'real-estate-manager'),
		            'description' 	=> __('Provide url, it will disable AJAX search and will open up that page to display results. Make sure to paste shortcode [rem_search_results] on provided page to display results.', 'real-estate-manager'),
		        ),
		        array(
		            'type' 			=> 'textfield',
		            'param_name' 	=> 'results_selector',
		            'heading' 		=> __('Result Selector', 'real-estate-manager'),
		            'description' 	=> __('HTML selector if you want to display results in some other place on current page', 'real-estate-manager'),
		        ),
		        array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'style',
		            'heading' 		=> __('Form Style', 'real-estate-manager'),
		            'description' 	=> __('Choose search form template here', 'real-estate-manager'),
			        'value' => array(
			            __('Style 1', 'real-estate-manager') => '1',
			            __('Style 2', 'real-estate-manager') => '2',
			            __('Style 3', 'real-estate-manager') => '3',
			            __('Style 4', 'real-estate-manager') => '4',
			        ),
		        ),
		        array(
		            'type' 			=> 'exploded_textarea',
		            'param_name' 	=> 'fixed_fields',
		            'heading' 		=> __('Fixed Fields', 'real-estate-manager'),
		            'description' 	=> __('Provide data for fixed fields on each line. Eg: property_status|normal', 'real-estate-manager'),
		        ),
				array(
    				'type'			=>	'textarea_html',
    				'param_name'	=>	'content',
    				'heading'		=>	__( 'Default Results', 'real-estate-manager' ),
    				'description'	=>	__( 'You can paste shortcode here to list some default properties', 'real-estate-manager' ),
				),
				array(
		            'type' 			=> 'textfield',
		            'param_name' 	=> 'agent_id',
		            'heading' 		=> __('Agent ID', 'real-estate-manager'),
		            'description' 	=> __('Agent ID or comma separated IDs for agent specific search', 'real-estate-manager'),
				),
				array(
		            'type' 			=> 'textfield',
		            'param_name' 	=> 'more_filters_column_class',
		            'heading' 		=> __('More Filters Column Classes', 'real-estate-manager'),
		            'description' 	=> __('CSS classes for more filters (features).', 'real-estate-manager'),
				),
				array(
			        'type' 			=> 'dropdown',
			        'param_name' 	=> 'auto_complete',
			        'heading' 		=> __('Auto Complete', 'real-estate-manager'),
			        'description' 	=> __('Enable or Disable auto suggestions', 'real-estate-manager'),
			        'value' => array(
			            __('Enable', 'real-estate-manager') => 'enable',
			            __('Disable', 'real-estate-manager') => 'disable',
			        ),
				),
				array(
			        'type' 			=> 'dropdown',
			        'param_name' 	=> 'scroll_results',
			        'heading' 		=> __('Auto Scroll', 'real-estate-manager'),
			        'description' 	=> __('Enable or Disable auto scroll to results', 'real-estate-manager'),
			        'value' => array(
			            __('Enable', 'real-estate-manager') => 'enable',
			            __('Disable', 'real-estate-manager') => 'disable',
			        ),
				),	
				array(
			        'type' 			=> 'dropdown',
			        'param_name' 	=> 'masonry',
			        'heading' 		=> __('Masonry', 'real-estate-manager'),
			        'description' 	=> __('Enable for justified layout of results', 'real-estate-manager'),
			        'value' => array(
			            __('Disable', 'real-estate-manager') => 'disable',
			            __('Enable', 'real-estate-manager') => 'enable',
			        ),
				),	
				array(
			        'type' 			=> 'dropdown',
			        'param_name' 	=> 'disable_eq_height',
			        'heading' 		=> __('Equal Height', 'real-estate-manager'),
			        'description' 	=> __('It will make all the fields same in height', 'real-estate-manager'),
			        'value' => array(
			            __('Disable', 'real-estate-manager') => 'disable',
			            __('Enable', 'real-estate-manager') => 'enable',
			        ),
				),
				array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'order',
		            'heading' 		=> __('Order', 'real-estate-manager'),
		            'description' 	=> __('Choose order to display results', 'real-estate-manager'),
		            'value' => array(
		                __('Ascending', 'real-estate-manager') => 'ASC',
		                __('Descending', 'real-estate-manager') => 'DESC',
		            ),
				),
				array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'orderby',
		            'heading' 		=> __('Order By', 'real-estate-manager'),
		            'description' 	=> __('Choose order by to display results', 'real-estate-manager'),
		            'value' => array(
		                __('Date', 'real-estate-manager') => 'date',
		                __('Agent', 'real-estate-manager') => 'author',
		                __('Property Name', 'real-estate-manager') => 'title',
		                __('Random', 'real-estate-manager') => 'rand',
		                __('Price', 'real-estate-manager') => 'price',
		            ),
				),
		        array(
		            'type' 			=> 'textfield',
		            'param_name' 	=> 'tabs_field',
		            'heading' 		=> __('Tabs Field Name', 'real-estate-manager'),
		            'description' 	=> __('Provide field name to display its options on top', 'real-estate-manager'),
		        ),
		        array(
		            'type' 			=> 'textfield',
		            'param_name' 	=> 'tabs_all_text',
		            'heading' 		=> __('Tabs All Text', 'real-estate-manager'),
		            'description' 	=> __('Label for the first tab', 'real-estate-manager'),
		        ),
			);
			break;
		case 'rem_maps':
			$fields = array(
		        array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'query_type',
		            'heading' 		=> __('Display By', 'real-estate-manager'),
		            'description' 	=> __('How you want to display properties on map', 'real-estate-manager'),
		            'value' => array(
		                __('Properties by IDs', 'real-estate-manager') => 'ids',
		                __('Use Property Query', 'real-estate-manager') => 'p_query',
		            ),
		        ),				
		        array(
		            "type" => "exploded_textarea",
		            "param_name" => "ids",
		            "heading" => __("Property IDs", 'real-estate-manager'),
		            "description" => __("Property ID each per line to display on map", 'real-estate-manager'),
		            'dependency' => array(
		                'element' => 'query_type',
		                'value' => array( 'ids' ),
		            ),
		        ),
				array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'order',
		            'heading' 		=> __('Order', 'real-estate-manager'),
		            'description' 	=> __('Choose order to display properties', 'real-estate-manager'),
		            'value' => array(
		                __('Ascending', 'real-estate-manager') => 'ASC',
		                __('Descending', 'real-estate-manager') => 'DESC',
		            ),
		            'dependency' => array(
		                'element' => 'query_type',
		                'value' => array( 'p_query' ),
		            ),
				),
				array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'orderby',
		            'heading' 		=> __('Order By', 'real-estate-manager'),
		            'description' 	=> __('Choose order by to display properties', 'real-estate-manager'),
		            'value' => array(
		                __('Date', 'real-estate-manager') => 'date',
		                __('Agent', 'real-estate-manager') => 'author',
		                __('Property Name', 'real-estate-manager') => 'title',
		            ),
		            'dependency' => array(
		                'element' => 'query_type',
		                'value' => array( 'p_query' ),
		            ),
				),
				array(
		            'type' 			=> 'textfield',
		            'param_name' 	=> 'total_properties',
		            'heading' 		=> __('Number of Properties', 'real-estate-manager'),
		            'description' 	=> __('Provide total number of properties to show. -1 for all', 'real-estate-manager'),
		            'dependency' => array(
		                'element' => 'query_type',
		                'value' => array( 'p_query' ),
		            ),		            
				),
		        array(
		            'type' 			=> 'exploded_textarea',
		            'param_name' 	=> 'meta',
		            'heading' 		=> __('Filter Properties by Meta', 'real-estate-manager'),
		            'description' 	=> __('Provide meta key and value on each line to filter. Eg: property_status|normal', 'real-estate-manager'),
		            'dependency' => array(
		                'element' => 'query_type',
		                'value' => array( 'p_query' ),
		            ),
		        ),
				array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'type_filtering',
		            'heading' 		=> __('Property Type Filtering', 'real-estate-manager'),
		            'description' 	=> __('Enable to display property type buttons below maps to filter', 'real-estate-manager'),
		            'value' => array(
		                __('Disable', 'real-estate-manager') => 'disable',
		                __('Enable', 'real-estate-manager') => 'enable',
		            ),
				),
				array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'auto_center',
		            'heading' 		=> __('Auto Center', 'real-estate-manager'),
		            'description' 	=> __('Enable to auto set map on the selected properties', 'real-estate-manager'),
		            'value' => array(
		                __('Enable', 'real-estate-manager') => 'enable',
		                __('Disable', 'real-estate-manager') => 'disable',
		            ),
				),
		        array(
		            'type' 			=> 'textfield',
		            'param_name' 	=> 'filter_by_key',
		            'heading' 		=> __('Filter Key', 'real-estate-manager'),
		            'description' 	=> __('Field key to use for filter menu', 'real-estate-manager'),
		            'dependency' => array(
		                'element' => 'type_filtering',
		                'value' => array( 'enable' ),
		            ),
		        ),
		        array(
		            'type' 			=> 'textfield',
		            'param_name' 	=> 'filter_options',
		            'heading' 		=> __('Filter Options', 'real-estate-manager'),
		            'description' 	=> __('Provide comma-separated values to display on filter menu', 'real-estate-manager'),
		            'dependency' => array(
		                'element' => 'type_filtering',
		                'value' => array( 'enable' ),
		            ),
		        ),
		        array(
		            'type' 			=> 'textfield',
		            'param_name' 	=> 'def_lat',
		            'heading' 		=> __('Default Latitude', 'real-estate-manager'),
		            'description' 	=> __('Provide default latitude if you are using Leaflet Map', 'real-estate-manager'),
		        ),
		        array(
		            'type' 			=> 'textfield',
		            'param_name' 	=> 'def_long',
		            'heading' 		=> __('Default Longitude', 'real-estate-manager'),
		            'description' 	=> __('Provide default longitude if you are using Leaflet Map', 'real-estate-manager'),
		        ),
		        array(
		            'type' 			=> 'textfield',
		            'param_name' 	=> 'map_zoom',
		            'heading' 		=> __('Map Zoom Level', 'real-estate-manager'),
		            'description' 	=> __('Provide zoom level if you are using Leaflet Map', 'real-estate-manager'),
		        ),
		        array(
		            'type' 			=> 'textfield',
		            'param_name' 	=> 'map_id',
		            'heading' 		=> __('Map ID', 'real-estate-manager'),
		            'description' 	=> __('Lowercase without spaces id for using multiple maps on the same page.', 'real-estate-manager'),
		        ),
		        array(
		            'type' 			=> 'exploded_textarea',
		            'param_name' 	=> 'tags',
		            'heading' 		=> __('Filter by Tags', 'real-estate-manager'),
		            'description' 	=> __('Provide single tag on each line to filter.', 'real-estate-manager'),
		            'dependency' => array(
		                'element' => 'query_type',
		                'value' => array( 'p_query' ),
		            ),
		        ),
				array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'nearest_properties',
		            'heading' 		=> __('Prefer Nearest Properties', 'real-estate-manager'),
		            'description' 	=> __('It will enable Geo Location Trackor to track visitors location and will display properties near them', 'real-estate-manager'),
		            'value' => array(
		                __('Disable', 'real-estate-manager') => 'disable',
		                __('Enable', 'real-estate-manager') => 'enable',
		            ),
				),
		        array(
		            'type' 			=> 'textfield',
		            'param_name' 	=> 'map_height',
		            'heading' 		=> __('Map Height', 'real-estate-manager'),
		            'description' 	=> __('Provide map height Eg: 550px', 'real-estate-manager'),
		        ),
		        array(
		            'type' 			=> 'textfield',
		            'param_name' 	=> 'agent',
		            'heading' 		=> __('Agent', 'real-estate-manager'),
		            'description' 	=> __('Provide agent id for specific listings', 'real-estate-manager'),
		        ),
		        array(
		            "type" => "textfield",
		            "param_name" => "load_heading",
		            "heading" => __("Loading Heading", 'real-estate-manager'),
		            "description" => __("Provide map loading text heading", 'real-estate-manager'),
		            "group" => __("Settings", 'real-estate-manager'),
		        ),
		        array(
		            "type" => "textfield",
		            "param_name" => "load_desc",
		            "heading" => __("Loading Description", 'real-estate-manager'),
		            "description" => __("Provide map loading text description", 'real-estate-manager'),
		            "group" => __("Settings", 'real-estate-manager'),
		        ),
		        array(
		            "type" => "colorpicker",
		            "param_name" => "btn_bg_color",
		            "heading" => __("Buttons Background Color", 'real-estate-manager'),
		            "description" => __("Choose background color for map buttons", 'real-estate-manager'),
		            "group" => __("Colors", 'real-estate-manager'),
		        ),
		        array(
		            "type" => "colorpicker",
		            "param_name" => "btn_text_color",
		            "heading" => __("Buttons Text Color", 'real-estate-manager'),
		            "description" => __("Choose text color for map buttons", 'real-estate-manager'),
		            "group" => __("Colors", 'real-estate-manager'),
		        ),
		        array(
		            "type" => "colorpicker",
		            "param_name" => "btn_bg_color_hover",
		            "heading" => __("Buttons Background Color - Hover", 'real-estate-manager'),
		            "description" => __("Choose hover background color for map buttons", 'real-estate-manager'),
		            "group" => __("Colors", 'real-estate-manager'),
		        ),
		        array(
		            "type" => "colorpicker",
		            "param_name" => "btn_text_color_hover",
		            "heading" => __("Buttons Text Color - Hover", 'real-estate-manager'),
		            "description" => __("Choose text hover color for map buttons", 'real-estate-manager'),
		            "group" => __("Colors", 'real-estate-manager'),
		        ),
		        array(
		            "type" => "colorpicker",
		            "param_name" => "loader_color",
		            "heading" => __("Loader Color", 'real-estate-manager'),
		            "description" => __("Choose color for maps loader box", 'real-estate-manager'),
		            "group" => __("Colors", 'real-estate-manager'),
		        ),
		        array(
		            "type" => "colorpicker",
		            "param_name" => "filter_bg",
		            "heading" => __("Type Filtering Background", 'real-estate-manager'),
		            "description" => __("Choose background color for filtering overlay", 'real-estate-manager'),
		            "group" => __("Colors", 'real-estate-manager'),
		        ),

		        array(
		            "type" => "colorpicker",
		            "param_name" => "water_color",
		            "heading" => __("Water Color", 'real-estate-manager'),
		            "description" => __("Choose water color in map", 'real-estate-manager'),
		            "group" => __("Map Colors", 'real-estate-manager'),
		        ),
		        array(
		            "type" => "colorpicker",
		            "param_name" => "fill_color",
		            "heading" => __("Fill Color", 'real-estate-manager'),
		            "description" => __("Choose natural fill color in map", 'real-estate-manager'),
		            "group" => __("Map Colors", 'real-estate-manager'),
		        ),
		        array(
		            "type" => "colorpicker",
		            "param_name" => "poi_color",
		            "heading" => __("Points of Interest Color", 'real-estate-manager'),
		            "description" => __("Choose poi color in map", 'real-estate-manager'),
		            "group" => __("Map Colors", 'real-estate-manager'),
		        ),
		        array(
		            "type" => "colorpicker",
		            "param_name" => "poi_color_hue",
		            "heading" => __("Points of Interest Hue Color", 'real-estate-manager'),
		            "description" => __("Choose poi hue color in map", 'real-estate-manager'),
		            "group" => __("Map Colors", 'real-estate-manager'),
		        ),
		        array(
		            "type" => "textfield",
		            "param_name" => "roads_lightness",
		            "heading" => __("Road Lightness", 'real-estate-manager'),
		            "description" => __("Choose road lightness in map, Default: 100", 'real-estate-manager'),
		            "group" => __("Map Colors", 'real-estate-manager'),
		        ),
		        array(
		            "type" => "textfield",
		            "param_name" => "lines_lightness",
		            "heading" => __("Lines Lightness", 'real-estate-manager'),
		            "description" => __("Choose line lightness in map, Default: 700", 'real-estate-manager'),
		            "group" => __("Map Colors", 'real-estate-manager'),
		        ),
		        array(
		            'type' 			=> 'textfield',
		            'param_name' 	=> 'icons_by_meta',
		            'heading' 		=> __('Field Name for Icons', 'real-estate-manager'),
		            'description' 	=> __('Provide field data name to filter icons by. Eg: property_type', 'real-estate-manager'),
		            "group" => __("Custom Icons", 'real-estate-manager'),
		        ),
		        array(
		            'type' 			=> 'exploded_textarea',
		            'param_name' 	=> 'icons_data',
		            'heading' 		=> __('Icon URLs', 'real-estate-manager'),
		            'description' 	=> __('Provide meta value, static and hover icon urls seaprated with pipe sign. Eg: house|some_image.png|some_image_hover.png', 'real-estate-manager'),
		            "group" => __("Custom Icons", 'real-estate-manager'),
		        ),
		        array(
		            'type' 			=> 'textfield',
		            'param_name' 	=> 'my_location_icon',
		            'heading' 		=> __('My Location Icon Url', 'real-estate-manager'),
		            'description' 	=> __('Provide icon url for my location pin', 'real-estate-manager'),
		            "group" => __("Custom Icons", 'real-estate-manager'),
		        ),
		        array(
		            'type' 			=> 'textfield',
		            'param_name' 	=> 'circle_icon',
		            'heading' 		=> __('Circle Icon Url', 'real-estate-manager'),
		            'description' 	=> __('Provide icon url for multiple properties. Size 55x55', 'real-estate-manager'),
		            "group" => __("Custom Icons", 'real-estate-manager'),
		        ),
			);
			break;
		case 'rem_list_agents':
			$fields = array(
				array(
    				'type'			=>	'textfield',
    				'param_name'	=>	'ids',
    				'heading'		=>	__( 'Agent IDs', 'real-estate-manager' ),
    				'description'	=>	__( 'Comma-separated ids of the agents for a specific listing', 'real-estate-manager' ),
				),
				array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'columns',
		            'heading' 		=> __('Columns', 'real-estate-manager'),
		            'description' 	=> __('Number of columns in a row', 'real-estate-manager'),
		            'value' => array(
		                __('1 Columns', 'real-estate-manager') => 'col-sm-12',
		                __('2 Columns', 'real-estate-manager') => 'col-sm-6',
		                __('3 Columns', 'real-estate-manager') => 'col-sm-4',
		                __('4 Columns', 'real-estate-manager') => 'col-sm-3',
		                __('5 Columns', 'real-estate-manager') => 'col-md-5th-1',
		            ),
				),
				array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'order',
		            'heading' 		=> __('Order', 'real-estate-manager'),
		            'description' 	=> __('Designates the ascending or descending order of the below option.', 'real-estate-manager'),
		            'value' => array(
		                __('Ascending', 'real-estate-manager') => 'ASC',
		                __('Descending', 'real-estate-manager') => 'DESC',
		            ),
				),
				array(
			        'type' 			=> 'dropdown',
			        'param_name' 	=> 'orderby',
			        'heading' 		=> __('Order By', 'real-estate-manager'),
			        'description' 	=> __('Choose option to sort agents by', 'real-estate-manager'),
			        'value' => array(
			            __('Agent ID', 'real-estate-manager') => 'ID',
			            __('Login', 'real-estate-manager') => 'login',
			            __('Nice Name', 'real-estate-manager') => 'nicename',
			            __('Email Address', 'real-estate-manager') => 'email',
			            __('URL', 'real-estate-manager') => 'url',
			            __('Registered', 'real-estate-manager') => 'registered',
			            __('Display Name', 'real-estate-manager') => 'display_name',
			            __('Properties Count', 'real-estate-manager') => 'post_count',
			            __('IDs Provided Above', 'real-estate-manager') => 'include',
			            __('Meta Value', 'real-estate-manager') => 'meta_value',
			        ),
				),
				array(
    				'type'			=>	'textfield',
    				'param_name'	=>	'meta_key',
    				'heading'		=>	__( 'Custom Meta Key', 'real-estate-manager' ),
    				'description'	=>	__( 'Provide field name here for specific agent listing.', 'real-estate-manager' ),
				),
				array(
    				'type'			=>	'textfield',
    				'param_name'	=>	'meta_value',
    				'heading'		=>	__( 'Custom Meta Value', 'real-estate-manager' ),
    				'description'	=>	__( 'Provide field value here for specific agent listing.', 'real-estate-manager' ),
				),
				array(
    				'type'			=>	'textfield',
    				'param_name'	=>	'total',
    				'heading'		=>	__( 'Total Agents', 'real-estate-manager' ),
    				'description'	=>	__( 'Number of agents to display.', 'real-estate-manager' ),
				),
				array(
    				'type'			=>	'textfield',
    				'param_name'	=>	'style',
    				'heading'		=>	__( 'Template Style', 'real-estate-manager' ),
    				'description'	=>	__( 'Provide style number here.', 'real-estate-manager' ),
				),
				array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'masonry',
		            'heading' 		=> __('Masonry', 'real-estate-manager'),
		            'description' 	=> __('Justified Layout', 'real-estate-manager'),
		            'value' => array(
		                __('enable', 'real-estate-manager') => 'Enable',
		                __('disable', 'real-estate-manager') => 'Disable',
		            ),
				),
			);
			break;
		
		default:
			$fields = array();
			break;
	}

	return $fields;
}
?>