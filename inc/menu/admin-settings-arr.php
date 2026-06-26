<?php
$leaflet_map_styles = array();

for ($style=1; $style <= 23 ; $style++) {
    $leaflet_map_styles[$style] =  __( 'Style', 'real-estate-manager' ).' '.$style;
}
$property_layouts = array(
    'plugin' => __( 'Default', 'real-estate-manager' ),
    'style_1' => __( 'Style 1', 'real-estate-manager' ),
    'full_width' => __( 'Full Width', 'real-estate-manager' ),
    'left_sidebar' => __( 'Left Sidebar', 'real-estate-manager' ),
    'theme' => __( 'From Theme', 'real-estate-manager' ),
    'auto' => __( 'Auto Detect', 'real-estate-manager' ),
);

$fieldsData = array(

    array(
        'panel_title'   =>  __( 'Currency Options', 'real-estate-manager' ),
        'panel_name'   =>  'currency_options',
        'icon'   =>  '<span class="glyphicon glyphicon-usd"></span>',

        'fields'        => array(

            array(
                'type' => 'currency',
                'name' => 'currency',
                'title' => __( 'Currency', 'real-estate-manager' ),
                'help' => __( 'Currency Symbol for Properties', 'real-estate-manager' ),
            ),


            array(
                'type' => 'select',
                'name' => 'currency_position',
                'title' => __( 'Currency Position', 'real-estate-manager' ),
                'options' => array(
                    'left' => __( 'Left', 'real-estate-manager' ),
                    'right' => __( 'Right', 'real-estate-manager' ),
                    'left_space' => __( 'Left with Space', 'real-estate-manager' ),
                    'right_space' => __( 'Right with Space', 'real-estate-manager' ),
                ),
                'help' => __( 'Position of the Currency Symbol', 'real-estate-manager' ),
            ),

                array(
                    'type' => 'text',
                    'name' => 'thousand_separator',
                    'title' => __( 'Thousand Separator', 'real-estate-manager' ),
                    'help' => __( 'Thousand separator of display price', 'real-estate-manager' ),
                    'default' => ',',
                ),

                array(
                    'type' => 'text',
                    'name' => 'decimal_separator',
                    'title' => __( 'Decimal Separator', 'real-estate-manager' ),
                    'help' => __( 'Decimal separator of display price', 'real-estate-manager' ),
                    'default' => '.',
                ),

                array(
                    'type' => 'text',   
                    'name' => 'decimal_points',
                    'title' => __( 'Number of Decimals', 'real-estate-manager' ),
                    'help' => __( 'Number of decimal points shown in display price', 'real-estate-manager' ),
                    'default' => '2',
                ),
        ),

    ),

    array(
        'panel_title'   =>  __( 'Property Settings', 'real-estate-manager' ),
        'panel_name'   =>  'property_settings',
        'icon'   =>  '<span class="glyphicon glyphicon-list-alt"></span>',

        'fields'        => array(

            array(
                'type' => 'text',
                'name' => 'properties_area_unit',
                'title' => __( 'Area Unit', 'real-estate-manager' ),
                'help' => __( 'Provide unit of area Eg: Square Feet', 'real-estate-manager' ),
            ),            

            array(
                'type' => 'text',
                'name' => 'properties_excerpt_length',
                'title' => __( 'Excerpt Length', 'real-estate-manager' ),
                'help' => __( 'Number of words to be displayed from the property excerpt. Eg: 15', 'real-estate-manager' ),
            ),
            
            array(
                'type' => 'textarea',
                'name' => 'property_detail_fields',
                'title' => __( 'Property Features', 'real-estate-manager' ),
                'help' => __( 'One per line. This will add checkboxes to your property edit page for you to select. Leave blank to use default', 'real-estate-manager' ),
            ),

            array(
                'type' => 'textarea',
                'name' => 'admin_filtering',
                'title' => __( 'Admin Filtering', 'real-estate-manager' ),
                'help' => __( 'One field key per line. It will enable filtering for those fields in the admin list screen', 'real-estate-manager' ),
            ),

            array(
                'type' => 'textarea',
                'name' => 'admin_columns',
                'title' => __( 'Admin Columns', 'real-estate-manager' ),
                'help' => __( 'One field key per line. It will add columns in the admin lists screen', 'real-estate-manager' ),
            ),

            array(
                'type' => 'textarea',
                'name' => 'admin_quick_edit',
                'title' => __( 'Admin Bulk and Quick Edit', 'real-estate-manager' ),
                'help' => __( 'One field key per line. It will add those fields in the quick edit screen', 'real-estate-manager' ),
            ),

            array(
                'type'  => 'select',
                'name'  => 'energy_eff',
                'title' => __( 'Energy Efficiency', 'real-estate-manager' ),
                'help'  => __( 'It will enable the special fields for energy efficiency', 'real-estate-manager' ),
                'options' => array(
                    'disable' => __( 'Disable', 'real-estate-manager' ),
                    'enable' => __( 'Enable', 'real-estate-manager' ),
                ),
            ),
        ),

    ),

    array(
        
        'panel_title'   =>  __( 'Templates Settings', 'real-estate-manager' ),
        'panel_name'   =>  'template_settings',
        'icon'   =>  '<span class="glyphicon glyphicon-duplicate"></span>',
        'fields'        => array(
            array(
                'type'  => 'text',
                'name'  => 'templates_max_width',
                'theme_dependable' => true,
                'title' => __( 'Container Maximum Width', 'real-estate-manager' ),
                'help'  => __( 'Provide container max width in px, eg: 1140px', 'real-estate-manager' ),
                'default'  => '1170px',
            ),
            array(
                'type'  => 'pages',
                'name'  => 'property_edit_page',
                'title' => __( 'Property Edit Page', 'real-estate-manager' ),
                'help'  => __( 'Paste shortcode on selected page', 'real-estate-manager' ).' <code>[rem_edit_property]</code>',
            ),
            array(
                'type' => 'text',
                'name' => 'property_submit_redirect',
                'title' => __( 'Redirect After Creating Property', 'real-estate-manager' ),
                'help' => __( 'Provide redirect url after creating property from frontend', 'real-estate-manager' ),
            ),
            array(
                'type' => 'text',
                'name' => 'property_edit_redirect',
                'title' => __( 'Redirect After Editing Property', 'real-estate-manager' ),
                'help' => __( 'Provide redirect url after editing property from frontend', 'real-estate-manager' ),
            ),
            array(
                'type' => 'select',
                'name' => 'p_base_page',
                'title' => __( 'Property Base Page', 'real-estate-manager' ),
                'help' => __( 'If you choose custom, create a page having slug', 'real-estate-manager' ).
                ' <code>'.get_option( 'rem_property_permalink', 'property' ).'</code> '.
                __( 'and it will be used as the property base page. After changing this, go to Settings -> Permalinks and click save changes button.', 'real-estate-manager' ),
                'options' => array(
                    'default' => __( 'Default', 'real-estate-manager' ),
                    'custom' => __( 'Custom', 'real-estate-manager' ),
                ),
            ),
            array(
                'type' => 'select',
                'name' => 'dropdown_style',
                'default' => 'rem-easydropdown',
                'title' => __( 'Dropdowns Style', 'real-estate-manager' ),
                'help' => __( 'Choose a style for all dropdowns (select menus) used.', 'real-estate-manager' ),
                'options' => array(
                    'rem-easydropdown' => __( 'Easy Dropdown', 'real-estate-manager' ),
                    'rem-niceselect' => __( 'Nice Select', 'real-estate-manager' ),
                    'form-control' => __( 'Default', 'real-estate-manager' ),
                    'rem-nostyle' => __( 'None', 'real-estate-manager' ),
                ),
            ),
            array(
                'type' => 'select',
                'name' => 'property_fields_help_text',
                'title' => __( 'Fields Help Text', 'real-estate-manager' ),
                'help' => __( 'Enable or disable help icon with fields when creating/editing properties.', 'real-estate-manager' ),
                'options' => array(
                    'enable' => __( 'Enable', 'real-estate-manager' ),
                    'disable' => __( 'Disable', 'real-estate-manager' ),
                ),
            ),
        ),

    ),

    array(
        'panel_title'   =>  __( 'Single Property Page', 'real-estate-manager' ),
        'panel_name'   =>  'single_property_page',
        'icon'   =>  '<span class="glyphicon glyphicon-file"></span>',

        'fields'        => array(
            array(
                'type'  => 'select',
                'name'  => 'single_property_layout',
                'title' => __( 'Property Page Template', 'real-estate-manager' ),
                'help'  => __( 'Choose single property display layout', 'real-estate-manager' ),
                'options' => $property_layouts,
                'theme_dependable' => true,
            ),
            array(
                'type'  => 'select',
                'name'  => 'child_property_layout',
                'title' => __( 'Child Listing Template', 'real-estate-manager' ),
                'help'  => __( 'Choose child property display layout', 'real-estate-manager' ),
                'options' => array(
                    'default' => __( 'Default', 'real-estate-manager' ),
                    'style_1' => __( 'Style 1', 'real-estate-manager' ),
                    'theme' => __( 'From Theme', 'real-estate-manager' ),
                ),
                'theme_dependable' => true,
            ),
            array(
                'type' => 'select',
                'name' => 'single_property_map',
                'title' => __( 'Map', 'real-estate-manager' ),
                'help' => __( 'Show or hide property map on single property page', 'real-estate-manager' ),
                'options' => array(
                    'enable' => __( 'Enable', 'real-estate-manager' ),
                    'disable' => __( 'Disable', 'real-estate-manager' ),
                ),
            ),
            array(
                'type'  => 'select',
                'name'  => 'sections_display',
                'title' => __( 'Sections Display', 'real-estate-manager' ),
                'help'  => __( 'How to display field sections on frontend', 'real-estate-manager' ),
                'options' => array(
                    'default' => __( 'Default', 'real-estate-manager' ),
                    'boxed' => __( 'Boxed', 'real-estate-manager' ),
                ),
            ),
            array(
                'type'  => 'select',
                'name'  => 'property_page_agent_card',
                'title' => __( 'Property Page Agent Contact', 'real-estate-manager' ),
                'help'  => __( 'Enable or disable default agent card and contact form on single property page', 'real-estate-manager' ),
                'options' => array(
                    'enable' => __( 'Enable', 'real-estate-manager' ),
                    'disable' => __( 'Disable', 'real-estate-manager' ),
                ),
            ),
            array(
                'type'  => 'select',
                'name'  => 'agent_sidebar_sticky',
                'title' => __( 'Sticky Agent Contact', 'real-estate-manager' ),
                'help'  => __( 'Enable it to make the agent contact sticky on single property pages', 'real-estate-manager' ),
                'options' => array(
                    'disable' => __( 'Disable', 'real-estate-manager' ),
                    'enable' => __( 'Enable', 'real-estate-manager' ),
                ),
            ),
            array(
                'type'  => 'number',
                'name'  => 'sticky_sidebar_offset',
                'title' => __( 'Sticky Contact Offset from Top ', 'real-estate-manager' ),
                'help'  => __( 'Provide offset in pixels', 'real-estate-manager' ),
                'show_if'  => array('agent_sidebar_sticky', 'enable'),
            ),
            array(
                'type'  => 'widget',
                'name'  => 'property_page_sidebar',
                'theme_dependable' => true,
                'title' => __( 'Property Page Sidebar', 'real-estate-manager' ),
                'help'  => __( 'Choose sidebar for single property page', 'real-estate-manager' ),
            ),
            array(
                'type' => 'select',
                'name' => 'gallery_type',
                'title' => __( 'Gallery Type', 'real-estate-manager' ),
                'help' => __( 'How you want to display gallery images on the single property page', 'real-estate-manager' ),
                'options' => array(
                    'fotorama' => __( 'Fotorama', 'real-estate-manager' ),
                    'slick' => __( 'Slick', 'real-estate-manager' ),
                    'grid' => __( 'Grid', 'real-estate-manager' ),
                ),
            ),

            array(
                'type' => 'select',
                'name' => 'slick_thumbnail',
                'title' => __( 'Bottom Thumbnails', 'real-estate-manager' ),
                'help' => __( 'Slider bottom navigation thumbnails', 'real-estate-manager' ),
                'options' => array(
                    'enable' => __( 'Enable', 'real-estate-manager' ),
                    'disable' => __( 'Disable', 'real-estate-manager' ),
                ),
                'show_if'  => array('gallery_type', 'slick'),
            ),

            array(
                'type' => 'select',
                'name' => 'adaptive_height',
                'title' => __( 'Slider Adaptive Height', 'real-estate-manager' ),
                'help' => __( 'Auto change slider height as per current image', 'real-estate-manager' ),
                'options' => array(
                    'enable' => __( 'Enable', 'real-estate-manager' ),
                    'disable' => __( 'Disable', 'real-estate-manager' ),
                ),
                'show_if'  => array('gallery_type', 'slick'),
            ),
            array(
                'type' => 'text',
                'name' => 'grid_view_txt',
                'default' => 'View all %count% images',
                'title' => __( 'View All Images Text', 'real-estate-manager' ),
                'help' => __( 'If there are more than 5 images, this title will appear.', 'real-estate-manager' ),
                'show_if'  => array('gallery_type', 'grid'),
            ),
            array(
                'type' => 'text',
                'name' => 'slider_width',
                'title' => __( 'Gallery Slider Width', 'real-estate-manager' ),
                'help' => __( 'Slider width with unit. Eg: ', 'real-estate-manager' ).' 100%',
                'show_if'  => array('gallery_type', 'fotorama'),
            ),

            array(
                'type' => 'text',
                'name' => 'slider_height',
                'title' => __( 'Gallery Slider Height', 'real-estate-manager' ),
                'help' => __( 'Slider height with unit. Eg: ', 'real-estate-manager' ).' 100%',
                'show_if'  => array('gallery_type', 'fotorama'),
            ),

            array(
                'type' => 'select',
                'name' => 'slider_fit',
                'title' => __( 'Gallery Slider Fit', 'real-estate-manager' ),
                'help' => __( 'How to fit an image into slider', 'real-estate-manager' ),
                'options' => array(
                    'cover' => __( 'Cover', 'real-estate-manager' ),
                    'contain' => __( 'Contain', 'real-estate-manager' ),
                    'scaledown' => __( 'Scale Down', 'real-estate-manager' ),
                    'none' => __( 'None', 'real-estate-manager' ),
                ),
                'show_if'  => array('gallery_type', 'fotorama'),
            ),

            array(
                'type' => 'select',
                'name' => 'slider_featured_image',
                'title' => __( 'Gallery Featured Image', 'real-estate-manager' ),
                'help' => __( 'Enable to display featured image in slider', 'real-estate-manager' ),
                'options' => array(
                    'enable' => __( 'Enable', 'real-estate-manager' ),
                    'disable' => __( 'Disable', 'real-estate-manager' ),
                ),
            ),

            array(
                'type'  => 'image_sizes',
                'name'  => 'gallery_image_size',
                'title' => __( 'Gallery Images Size', 'real-estate-manager' ),
                'help'  => __( 'Choose size for the gallery images', 'real-estate-manager' ),
            ),

            array(
                'type' => 'select',
                'name' => 'display_p_id',
                'title' => __( 'Display Property ID', 'real-estate-manager' ),
                'help' => __( 'Enable to display property id on frontend', 'real-estate-manager' ),
                'options' => array(
                    'enable' => __( 'Enable', 'real-estate-manager' ),
                    'disable' => __( 'Disable', 'real-estate-manager' ),
                ),
            ),

            array(
                'type' => 'number',
                'name' => 'gallery_images_limit',
                'title' => __( 'Gallery Images Limit', 'real-estate-manager' ),
                'help' => __( 'Provide maximum number of gallery images a property can have', 'real-estate-manager' ),
            ),

            array(
                'type' => 'number',
                'name' => 'gallery_videos_limit',
                'title' => __( 'Gallery Videos Limit', 'real-estate-manager' ),
                'help' => __( 'Provide maximum number of gallery videos a property can have', 'real-estate-manager' ),
            ),

            array(
                'type' => 'select',
                'name' => 'load_video_as',
                'title' => __( 'Load Video As', 'real-estate-manager' ),
                'help' => __( 'How you want to display video player? Please select iframe for cookieless URLs', 'real-estate-manager' ),
                'options' => array(
                    'default' => __( 'Default', 'real-estate-manager' ),
                    'iframe' => __( 'iFrame', 'real-estate-manager' ),
                ),
            ),

            array(
                'type' => 'text',
                'name' => 'date_format',
                'title' => __( 'Date Field Format', 'real-estate-manager' ),
                'help' => __( 'Provide date format if you are using date field. Eg: ', 'real-estate-manager' ).' d-M-Y',
            ),

            array(
                'type' => 'textarea',
                'name' => 'child_listing_fields',
                'title' => __( 'Child Listing Fields', 'real-estate-manager' ),
                'help' => __( 'One field key per line. These fields will display with the child listing title', 'real-estate-manager' ),
            ),
        ),

    ),

    array(
        'panel_title'   =>  __( 'Single Agent Page', 'real-estate-manager' ),
        'panel_name'   =>  'single_agent_page',
        'icon'   =>  '<span class="glyphicon glyphicon-user"></span>',

        'fields'        => array(
            array(
                'type'  => 'select',
                'name'  => 'agent_page_layout',
                'title' => __( 'Agent Page Template', 'real-estate-manager' ),
                'help'  => __( 'Choose agent page display layout', 'real-estate-manager' ),
                'options' => array(
                    'plugin' => __( 'From Plugin', 'real-estate-manager' ),
                    'theme' => __( 'From Theme', 'real-estate-manager' ),
                ),
                'theme_dependable' => true,
            ),
            array(
                'type' => 'select',
                'name' => 'agent_page',
                'theme_dependable' => false,
                'title' => __( 'Enable Agent Template', 'real-estate-manager' ),
                'options' => array(
                    'all' => __( 'All Users', 'real-estate-manager' ),
                    'agent' => __( 'Only Property Agents', 'real-estate-manager' ),
                ),
                'help' => __( 'Choosing all will enable the agent template for admins as well', 'real-estate-manager' ),
            ),
            array(
                'type'  => 'select',
                'name'  => 'agent_page_agent_card',
                'title' => __( 'Agent Page Sidebar Card', 'real-estate-manager' ),
                'help'  => __( 'Enable or disable default agent card and contact form on single agent page', 'real-estate-manager' ),
                'options' => array(
                    'enable' => __( 'Enable', 'real-estate-manager' ),
                    'disable' => __( 'Disable', 'real-estate-manager' ),
                ),
            ),
            array(
                'type'  => 'select',
                'name'  => 'agent_card_style',
                'title' => __( 'Agent Card Style', 'real-estate-manager' ),
                'help'  => __( 'Choose agent profile card', 'real-estate-manager' ),
                'options' => array(
                    '1' => __( 'Style 1', 'real-estate-manager' ),
                    '2' => __( 'Style 2', 'real-estate-manager' ),
                    '3' => __( 'Style 3', 'real-estate-manager' ),
                    '4' => __( 'Style 4', 'real-estate-manager' ),
                    '5' => __( 'Style 5', 'real-estate-manager' ),
                    '6' => __( 'Style 6', 'real-estate-manager' ),
                ),
                'show_if'  => array('agent_page_agent_card', 'enable'),
            ),
            array(
                'type'  => 'select',
                'name'  => 'agent_page_display_cform',
                'title' => __( 'Agent Page Contact Form', 'real-estate-manager' ),
                'help'  => __( 'Enable or disable contact form on agent page', 'real-estate-manager' ),
                'options' => array(
                    'enable' => __( 'Enable', 'real-estate-manager' ),
                    'disable' => __( 'Disable', 'real-estate-manager' ),
                ),
            ),
            array(
                'type'  => 'widget',
                'name'  => 'agent_page_sidebar',
                'theme_dependable' => true,
                'title' => __( 'Agent Page Sidebar', 'real-estate-manager' ),
                'help'  => __( 'Choose sidebar for agent details page', 'real-estate-manager' ),
            ),
            array(
                'type'  => 'select',
                'name'  => 'agent_listing_style',
                'title' => __( 'My Properties Listing Style', 'real-estate-manager' ),
                'help'  => __( 'Listing style for properties slider', 'real-estate-manager' ),
                'options' => array_flip(rem_get_property_listing_styles()),
            ),
            array(
                'type'  => 'select',
                'name'  => 'agent_location',
                'title' => __( 'Agent Location', 'real-estate-manager' ),
                'help'  => __( 'It will add agent location on registration and profile', 'real-estate-manager' ),
                'options' => array(
                    'enable' => __( 'Enable', 'real-estate-manager' ),
                    'disable' => __( 'Disable', 'real-estate-manager' ),
                ),
            ),
        ),
    ),

    array(
        'panel_title'   =>  __( 'Listings', 'real-estate-manager' ),
        'panel_name'   =>  'listings',
        'icon'   =>  '<span class="glyphicon glyphicon-equalizer"></span>',

        'fields'        => array(
            array(
                'type'  => 'select',
                'name'  => 'archive_property_layout',
                'title' => __( 'Archive Page Template', 'real-estate-manager' ),
                'help'  => __( 'Choose tags and archive properties display layout', 'real-estate-manager' ),
                'options' => array(
                    'plugin' => __( 'From Plugin', 'real-estate-manager' ),
                    'theme' => __( 'From Theme', 'real-estate-manager' ),
                ),
                'theme_dependable' => true,
            ),
            array(
                'type'  => 'widget',
                'name'  => 'archive_sidebar',
                'title' => __( 'Archive Page Sidebar', 'real-estate-manager' ),
                'help'  => __( 'Choose sidebar for archive pages', 'real-estate-manager' ),
                'show_if'  => array('archive_property_layout', 'plugin'),
                'theme_dependable' => true,
            ),
            array(
                'type' => 'text',
                'name' => 'properties_per_page_archive',
                'title' => __( 'Properties Per Page', 'real-estate-manager' ),
                'help' => __( 'Number of properties you want to display on archive pages. (tags etc)', 'real-estate-manager' ),
            ),
            array(
                'type'  => 'select',
                'name'  => 'archive_listing_style',
                'title' => __( 'Property Archive Listing Style', 'real-estate-manager' ),
                'help'  => __( 'Listing style for default properties page', 'real-estate-manager' ),
                'options' => array_flip(rem_get_property_listing_styles()),
            ),
            array(
                'type' => 'select',
                'name' => 'archive_page_cols',
                'title' => __( 'Archive Listing Columns', 'real-estate-manager' ),
                'help' => __( 'Choose columns in a row for box styles', 'real-estate-manager' ),
                'options' => array(
                    'col-sm-12' => __( '1', 'real-estate-manager' ),
                    'col-sm-6' => __( '2', 'real-estate-manager' ),
                    'col-sm-4' => __( '3', 'real-estate-manager' ),
                    'col-sm-3' => __( '4', 'real-estate-manager' ),
                    'col-md-5th-1' => __( '5', 'real-estate-manager' ),
                ),
            ),            
            array(
                'type'  => 'textarea',
                'name'  => 'inline_property_bar_fields',
                'title' => __( 'Customize Address', 'real-estate-manager' ),
                'help'  => __( 'Provide field names each per line to display them in the place of address on listing boxes.', 'real-estate-manager' ),
            ),
            array(
                'type'  => 'select',
                'name'  => 'display_listing_features',
                'title' => __( 'Listing Features Type', 'real-estate-manager' ),
                'help'  => __( 'Features are displayed on property listings', 'real-estate-manager' ),
                'options' => array(
                    'icons_data' => __( 'Icons and Data', 'real-estate-manager' ),
                    'labels_data' => __( 'Labels and Data', 'real-estate-manager' ),
                    'icons_labels_and_data' => __( 'Icons, Labels and Data', 'real-estate-manager' ),
                ),
            ),
            array(
                'type'  => 'textarea',
                'name'  => 'custom_listing_features',
                'title' => __( 'Customize Icons Data', 'real-estate-manager' ),
                'help'  => __( 'Displays custom property features. (Label,Field Name,Font Awesome Class) each per line. Eg:', 'real-estate-manager' ).' <code>Status,property_status,fa fa-flag</code>',
            ),

            array(
                'type'  => 'image_sizes',
                'name'  => 'featured_image_size',
                'title' => __( 'Featured Image Size', 'real-estate-manager' ),
                'help'  => __( 'Choose size of featured image to use', 'real-estate-manager' ),
            ),

            array(
                'type'  => 'image',
                'name'  => 'placeholder_image',
                'title' => __( 'Featured Image Placeholder', 'real-estate-manager' ),
                'help'  => __( 'This image will be used for the listings without a featured image', 'real-estate-manager' ),
            ),
            array(
                'type' => 'select',
                'name' => 'enable_compare',
                'title' => __( 'Compare Listings', 'real-estate-manager' ),
                'help' => __( 'Choose either to enable or disable the compare listings feature', 'real-estate-manager' ),
                'options' => array(
                    'enable' => __( 'Enable', 'real-estate-manager' ),
                    'disable' => __( 'Disable', 'real-estate-manager' ),
                ),
            ),
            array(
                'type' => 'textarea',
                'name' => 'property_compare_columns',
                'title' => __( 'Comparison Fields', 'real-estate-manager' ),
                'help' => __( 'Provide label and field key each per line to display in the compare screen. Eg:', 'real-estate-manager' ).'<code>Price|property_price</code>',
                'show_if'  => array('enable_compare', 'enable'),
            ),            
        ),

    ),

    array(
        'panel_title'   =>  __( 'Search Settings', 'real-estate-manager' ),
        'panel_name'   =>  'search_settings',
        'icon'   =>  '<span class="glyphicon glyphicon-search"></span>',

        'fields'        => array(
            array(
                'type' => 'text',
                'name' => 'properties_per_page',
                'title' => __( 'Total Properties', 'real-estate-manager' ),
                'help' => __( 'Number of properties you want to display on search results', 'real-estate-manager' ),
            ),
            array(
                'type' => 'select',
                'name' => 'search_price_range',
                'title' => __( 'Search Price Range Selector', 'real-estate-manager' ),
                'help' => __( 'Choose price ranges input option for searching', 'real-estate-manager' ),
                'options' => array(
                    'slider' => __( 'Price Slider', 'real-estate-manager' ),
                    'min_max' => __( 'Min Max Fields', 'real-estate-manager' ),
                    'min_max_dropdown' => __( 'Min Max Dropdown', 'real-estate-manager' ),
                    'single_options' => __( 'Single Options', 'real-estate-manager' ),
                )
            ),
             array(
                'type' => 'textarea',
                'name' => 'price_dropdown_options',
                'title' => __( 'Price Range Options', 'real-estate-manager' ),
                'help' => __( 'Provide each price range per line. Eg:', 'real-estate-manager' ).'<code>1000-15000</code>',
            ),
            array(
                'type' => 'select',
                'name' => 'search_results_style',
                'title' => __( 'Search Results Style', 'real-estate-manager' ),
                'help' => __( 'Choose style for search results', 'real-estate-manager' ),
                'options' => array_flip(rem_get_property_listing_styles()),
            ),

            array(
                'type' => 'select',
                'name' => 'search_results_cols',
                'title' => __( 'Search Results Columns', 'real-estate-manager' ),
                'help' => __( 'Choose columns in a row for box styles', 'real-estate-manager' ),
                'options' => array(
                    'col-sm-12' => __( '1', 'real-estate-manager' ),
                    'col-sm-6' => __( '2', 'real-estate-manager' ),
                    'col-xs-12 col-sm-6 col-md-4' => __( '3', 'real-estate-manager' ),
                    'col-xs-12 col-sm-6 col-md-3' => __( '4', 'real-estate-manager' ),
                    'col-md-5th-1' => __( '5', 'real-estate-manager' ),
                ),
            ),


            array(
                'type' => 'select',
                'name' => 'search_not_available',
                'title' => __( 'Not Available Properties', 'real-estate-manager' ),
                'help' => __( 'Choose either to display Not Available properties in search results or not', 'real-estate-manager' ),
                'options' => array(
                    'enable' => __( 'Enable', 'real-estate-manager' ),
                    'disable' => __( 'Disable', 'real-estate-manager' ),
                ),
            ),

            array(
                'type' => 'textarea',
                'name' => 'search_area_options',
                'title' => __( 'Search Area Options', 'real-estate-manager' ),
                'help' => __( 'Provide area range each per line, to display dropdown of area ranges instead of input field when searching.', 'real-estate-manager' ),
            ),

            array(
                'type' => 'textarea',
                'name' => 'search_bedrooms_options',
                'title' => __( 'Search Bedrooms Options', 'real-estate-manager' ),
                'help' => __( 'Provide bedrooms range each per line, to display dropdown of bedroom ranges instead of input field when searching.', 'real-estate-manager' ),
            ),

            array(
                'type' => 'textarea',
                'name' => 'search_bathrooms_options',
                'title' => __( 'Search Bathrooms Options', 'real-estate-manager' ),
                'help' => __( 'Provide bathrooms range each per line, to display dropdown of bathroom ranges instead of input field when searching.', 'real-estate-manager' ),
            ),

            array(
                'type' => 'select',
                'name' => 'searched_properties_target',
                'title' => __( 'Search Results Link Target', 'real-estate-manager' ),
                'help' => __( 'How you want to open the listings when user clicks on the search results.', 'real-estate-manager' ),
                'options' => array(
                    '_blank' => __( 'New Tab', 'real-estate-manager' ),
                    '_self' => __( 'Same Tab', 'real-estate-manager' ),
                ),
            ),

            array(
                'type' => 'select',
                'name' => 'multi_select_logic',
                'title' => __( 'Multi Select Fields Searching', 'real-estate-manager' ),
                'help' => __( 'The logical relationship between each field values when more than one are selected.', 'real-estate-manager' ),
                'options' => array(
                    'AND' => __( 'AND', 'real-estate-manager' ),
                    'OR' => __( 'OR', 'real-estate-manager' ),
                ),
            ),

            array(
                'type' => 'textarea',
                'name' => 'simple_search_query',
                'title' => __( 'Simple Search Method', 'real-estate-manager' ),
                'help' => __( 'Provide text,field_name,is_number,value each per line (all lowercase)', 'real-estate-manager' ).' <a target="_blank" href="https://webcodingplace.com/simple-search-option-real-estate-manager-wp-plugin/">'.__( 'Help', 'real-estate-manager' ).'</a>',
            ),

            array(
                'type' => 'select',
                'name' => 'prefill_search_fields',
                'title' => __( 'Prefill Search Fields', 'real-estate-manager' ),
                'help' => __( 'Enable it to display all the available values of fields in a dropdown on the search form to choose.', 'real-estate-manager' ),
                'options' => array(
                    'disable' => __( 'Disable', 'real-estate-manager' ),
                    'enable' => __( 'Enable', 'real-estate-manager' ),
                ),
            ),
            array(
                'type' => 'text',
                'name' => 'range_thousand_separator',
                'title' => __( 'Range Slider Thousand Separator', 'real-estate-manager' ),
                'help' => __( 'Thousand separator for the range selectors on search page', 'real-estate-manager' ),
                'default' => ',',
            ),

            array(
                'type' => 'text',
                'name' => 'range_decimal_separator',
                'title' => __( 'Range Slider Decimal Separator', 'real-estate-manager' ),
                'help' => __( 'Decimal separator for the range selectors on search page', 'real-estate-manager' ),
                'default' => '.',
            ),

            array(
                'type' => 'text',
                'name' => 'range_decimal_points',
                'title' => __( 'Range Slider Number of Decimals', 'real-estate-manager' ),
                'help' => __( 'Number of decimal points for the range selectors', 'real-estate-manager' ),
                'default' => '2',
            ),

            array(
                'type' => 'text',
                'name' => 'range_cb_text',
                'title' => __( 'Range Slider Checkbox label', 'real-estate-manager' ),
                'help' => __( 'It will appear with the checkbox to turn range on/off. Your can also use ', 'real-estate-manager' ).' <code>%field_title%</code>',
                'default' => 'Any %field_title%',
            ),
        ),

    ),

    array(

        'panel_title'   =>  __( 'Price Slider', 'real-estate-manager' ),
        'panel_name'   =>  'price_slider',
        'icon'   =>  '<span class="glyphicon glyphicon-resize-horizontal"></span>',
        'fields'        => array(

            array(
                'type' => 'number',
                'name' => 'minimum_price',
                'title' => __( 'Minimum Price', 'real-estate-manager' ),
                'help' => __( 'Minimum price for price slider', 'real-estate-manager' ),
            ),

            array(
                'type' => 'number',
                'name' => 'maximum_price',
                'title' => __( 'Maximum Price', 'real-estate-manager' ),
                'help' => __( 'Maximum price for price slider', 'real-estate-manager' ),
            ),

            array(
                'type' => 'number',
                'name' => 'price_step',
                'title' => __( 'Step', 'real-estate-manager' ),
                'help' => __( 'Step or interval for price slider', 'real-estate-manager' ),
            ),

            array(
                'type' => 'number',
                'name' => 'default_minimum_price',
                'title' => __( 'Default Minimum Price', 'real-estate-manager' ),
                'help' => __( 'Default Minimum price for price slider', 'real-estate-manager' ),
            ),

            array(
                'type' => 'number',
                'name' => 'default_maximum_price',
                'title' => __( 'Default Maximum Price', 'real-estate-manager' ),
                'help' => __( 'Default Maximum price for price slider', 'real-estate-manager' ),
            ),

            array(
                'type' => 'text',
                'name' => 'switch_ranges',
                'title' => __( 'Field Name to Switch Ranges', 'real-estate-manager' ),
                'help' => __( 'Provide field name and value, based on that the following ranges will be used. Default', 'real-estate-manager' ).'<code>property_purpose|Rent</code>',
            ),

            array(
                'type' => 'number',
                'name' => 'minimum_price_r',
                'title' => __( 'Minimum Price (Rented)', 'real-estate-manager' ),
                'help' => __( 'Minimum price for price slider', 'real-estate-manager' ),
            ),

            array(
                'type' => 'number',
                'name' => 'maximum_price_r',
                'title' => __( 'Maximum Price (Rented)', 'real-estate-manager' ),
                'help' => __( 'Maximum price for price slider', 'real-estate-manager' ),
            ),

            array(
                'type' => 'number',
                'name' => 'price_step_r',
                'title' => __( 'Step (Rented)', 'real-estate-manager' ),
                'help' => __( 'Step or interval for price slider', 'real-estate-manager' ),
            ),

            array(
                'type' => 'number',
                'name' => 'default_minimum_price_r',
                'title' => __( 'Default Minimum Price (Rented)', 'real-estate-manager' ),
                'help' => __( 'Default Minimum price for price slider', 'real-estate-manager' ),
            ),

            array(
                'type' => 'number',
                'name' => 'default_maximum_price_r',
                'title' => __( 'Default Maximum Price (Rented)', 'real-estate-manager' ),
                'help' => __( 'Default Maximum price for price slider', 'real-estate-manager' ),
            ),

        ),

    ),

    array(

        'panel_title'   =>  __( 'Email Messages', 'real-estate-manager' ),
        'panel_name'   =>  'email_messages',
        'icon'   =>  '<span class="glyphicon glyphicon-envelope"></span>',
        'fields'        => array(

            array(
                'type' => 'textarea',
                'name' => 'email_admin_register_agent',
                'title' => __( 'Agent Registered', 'real-estate-manager' ),
                'help' => __( 'This message will sent to ', 'real-estate-manager' ).'<b>'.get_bloginfo('admin_email').'</b>'.__( ' when new agent is registered. You can use %username% and %email% for details', 'real-estate-manager' ),
            ),

            array(
                'type' => 'textarea',
                'name' => 'email_pending_agent',
                'title' => __( 'Agent Pending', 'real-estate-manager' ),
                'help' => __( 'Email Message for agent when new agent is registered but status is pending. You can use %username% and %email% for details', 'real-estate-manager' ),
            ),

            array(
                'type' => 'textarea',
                'name' => 'email_approved_agent',
                'title' => __( 'Agent Approved', 'real-estate-manager' ),
                'help' => __( 'Email Message for agent when registered agent is approved. You can use %username% and %email% for details', 'real-estate-manager' ),
            ),

            array(
                'type' => 'textarea',
                'name' => 'email_reject_agent',
                'title' => __( 'Agent Rejected', 'real-estate-manager' ),
                'help' => __( 'Email Message for agent when registered agent is rejected. You can use %username% and %email% for details', 'real-estate-manager' ),
            ),

            array(
                'type' => 'textarea',
                'name' => 'email_property_submission',
                'title' => __( 'Property Submission', 'real-estate-manager' ),
                'help' => __( 'This message will be sent to ', 'real-estate-manager' ).'<b>'.get_bloginfo('admin_email').'</b>'.__( ' when new property is submitted. You can use variables %username% %approve_url% and %email% for details', 'real-estate-manager' ),
            ),

            array(
                'type' => 'textarea',
                'name' => 'email_property_submission_agent',
                'title' => __( 'Property Submission Message for Agent', 'real-estate-manager' ),
                'help' => __( 'This message will be sent to agent when new property is submitted.', 'real-estate-manager' ),
            ),

            array(
                'type' => 'textarea',
                'name' => 'email_property_approved_agent',
                'title' => __( 'Property Approved Message for Agent', 'real-estate-manager' ),
                'help' => __( 'This message will be sent to agent when new property is approved.', 'real-estate-manager' ),
            ),

            array(
                'type' => 'select',
                'name' => 'email_br',
                'title' => __( 'Line Breaks in Emails', 'real-estate-manager' ),
                'options' => array(
                    'enable' => __( 'Enable', 'real-estate-manager' ),
                    'disable' => __( 'Disable', 'real-estate-manager' ),
                ),
                'help' => __( 'Enable to inserts HTML line breaks before all newlines in the Email message.', 'real-estate-manager' ),
            ),

        ),

    ),

    array(
        'panel_title'   =>  __( 'Agent Contact Form', 'real-estate-manager' ),
        'panel_name'   =>  'agent_contact_form',
        'icon'   =>  '<span class="glyphicon glyphicon-envelope"></span>',
        'fields'        => array(

            array(
                'type'  => 'select',
                'name'  => 'property_page_phone',
                'title' => __( 'Phone Field', 'real-estate-manager' ),
                'help'  => __( 'How you want to display the phone field on agent contact form', 'real-estate-manager' ),
                'options' => array(
                    'default' => __( 'Default', 'real-estate-manager' ),
                    'intltelinput' => __( 'International Telephone Input', 'real-estate-manager' ),
                ),
                'show_if'  => array('property_page_agent_card', 'enable'),
            ),
            array(
                'type' => 'text',
                'name' => 'c_email_subject',
                'title' => __( 'Email Subject', 'real-estate-manager' ),
                'help' => __( 'Provide email subject here if someone contacts through single property page. You can also use these special tags.', 'real-estate-manager' ).' <code>%property_title%</code>, <code>%property_id%</code>',
            ),

            array(
                'type' => 'textarea',
                'name' => 'c_email_msg',
                'title' => __( 'Email Format', 'real-estate-manager' ),
                'help' => __( 'Provide email markup here. You can also use these special tags.', 'real-estate-manager' ). '<code>%property_title%</code>, <code>%property_id%</code>, <code>%property_url%</code>, <code>%client_message%</code>, <code>%client_email%</code>, <code>%client_name%</code>, <code>%client_phone%</code>',
            ),

            array(
                'type' => 'textarea',
                'name' => 'email_agent_contact',
                'title' => __( 'Agent Contact Email Addresses', 'real-estate-manager' ),
                'help' => __( 'Provide Additional Email addresses each per line to cc mail when visitor fills the contact agent form.', 'real-estate-manager' ),
            ),

            array(
                'type' => 'textarea',
                'name' => 'gdpr_message',
                'default' => 'I consent to have this site collect my Name, Email, and Phone.',
                'title' => __( 'GDPR Message', 'real-estate-manager' ),
                'help' => __( 'Provide the message to display with the contact form with a required checkbox.', 'real-estate-manager' ),
            ),
        ),
    ),

    array(

        'panel_title'   =>  __( 'reCAPTCHA V2', 'real-estate-manager' ),
        'panel_name'   =>  'recaptcha',
        'icon'   =>  '<span class="glyphicon glyphicon-repeat"></span>',
        'fields'        => array(

            array(
                'type' => 'text',
                'name' => 'captcha_site_key',
                'title' => __( 'Site key', 'real-estate-manager' ),
                'help' => __( 'Provide Google reCAPTCHA V2 Site Key. You can create Site key ', 'real-estate-manager' ).'<a target="_blank" href="https://www.google.com/recaptcha/admin">'.__( 'here', 'real-estate-manager' ).'</a>',
            ),
            array(
                'type' => 'text',
                'name' => 'captcha_secret_key',
                'title' => __( 'Secret key', 'real-estate-manager' ),
                'help' => __( 'Provide Google reCAPTCHA V2 Secret Key. You can create Secret key ', 'real-estate-manager' ).'<a target="_blank" href="https://www.google.com/recaptcha/admin">'.__( 'here', 'real-estate-manager' ).'</a>',
            ),
            array(
                'type' => 'checkbox',
                'name' => 'captcha_on_registration',
                'title' => __( 'Agent Registration', 'real-estate-manager' ),
                'help' => __( 'Check to enable captcha on new agent registration.', 'real-estate-manager' ),
            ),
            array(
                'type' => 'checkbox',
                'name' => 'captcha_on_agent_contact',
                'title' => __( 'Contact Agent', 'real-estate-manager' ),
                'help' => __( 'Check to enable captcha on agent contact form.', 'real-estate-manager' ),
            ),
            array(
                'type' => 'checkbox',
                'name' => 'captcha_on_agent_login',
                'title' => __( 'Login Agent', 'real-estate-manager' ),
                'help' => __( 'Check to enable captcha on agent login form.', 'real-estate-manager' ),
            ),

        ),

    ),

    array(

        'panel_title'   =>  __( 'Labels and Headings', 'real-estate-manager' ),
        'panel_name'   =>  'labels_headings',
        'icon'   =>  '<span class="glyphicon glyphicon-header"></span>',
        'fields'        => array(

            array(
                'type' => 'text',
                'name' => 'single_property_features_text',
                'title' => __( 'Features Heading', 'real-estate-manager' ),
                'help' => __( 'Provide heading text for property features on property pages', 'real-estate-manager' ),
            ),

            array(
                'type' => 'text',
                'name' => 'single_child_heading',
                'title' => __( 'Child Listings Title', 'real-estate-manager' ),
                'help' => __( 'Provide heading text for child listings wrapper', 'real-estate-manager' ),
            ),

            array(
                'type' => 'text',
                'name' => 'single_property_maps_text',
                'title' => __( 'Maps Heading', 'real-estate-manager' ),
                'help' => __( 'Provide heading text for maps on property pages', 'real-estate-manager' ),
            ),

            array(
                'type' => 'text',
                'name' => 'single_property_tags_text',
                'title' => __( 'Tags Heading', 'real-estate-manager' ),
                'help' => __( 'Provide heading text for tags on property pages', 'real-estate-manager' ),
            ),

            array(
                'type' => 'text',
                'name' => 'category_title',
                'title' => __( 'Heading for Category Base Page', 'real-estate-manager' ),
                'help' => __( 'You can use %category% for category name', 'real-estate-manager' ),
            ),

            array(
                'type' => 'text',
                'name' => 'archive_title',
                'title' => __( 'Heading for Tag Base page', 'real-estate-manager' ),
                'help' => __( 'You can use %tag% for tag name', 'real-estate-manager' ),
            ),

            array(
                'type' => 'text',
                'name' => 'archive_title_properties',
                'title' => __( 'Heading for Property Base Page', 'real-estate-manager' ),
                'help' => __( 'Provide heading for properties archive', 'real-estate-manager' ),
            ),

            array(
                'type' => 'text',
                'name' => 's_results_h',
                'title' => __( 'Search Results Heading', 'real-estate-manager' ),
                'default' => 'Search Results (%count%)',
                'help' => __( 'Provide text to display above the AJAX search results, you can use the variable', 'real-estate-manager' ).'<code>%count%</code>',
            ),

            array(
                'type' => 'text',
                'name' => 'no_results_msg',
                'title' => __( 'No Results Found Message', 'real-estate-manager' ),
                'help' => __( 'Provide custom message when no properties found in search results', 'real-estate-manager' ),
            ),

            array(
                'type' => 'textarea',
                'name' => 'upload_images_inst',
                'title' => __( 'Images Upload Instructions', 'real-estate-manager' ),
                'help' => __( 'This text will be displayed right below the upload gallery images button.', 'real-estate-manager' ),
            ),
        ),

    ),

    array(

        'panel_title'   =>  __( 'Maps Settings', 'real-estate-manager' ),
        'panel_name'   =>  'maps_settings',
        'icon'   =>  '<span class="glyphicon glyphicon-map-marker"></span>',
        'fields'        => array(

            array(
                'type' => 'select',
                'name' => 'use_map_from',
                'title' => __( 'Use Map From', 'real-estate-manager' ),
                'options' => array(
                    'leaflet' => __( 'Leaflet', 'real-estate-manager' ),
                    'google_maps' => __( 'Google Maps', 'real-estate-manager' ),
                ),                
                'help' => __( 'Choose map provider', 'real-estate-manager' ),
            ),

            array(
                'type' => 'text',
                'name' => 'maps_api_key',
                'title' => __( 'Google Maps API Key', 'real-estate-manager' ),
                'help' => __( 'Provide Google Maps API key here. You can create API key ', 'real-estate-manager' ).'<a target="_blank" href="https://developers.google.com/maps/documentation/javascript/get-api-key#get-an-api-key">'.__( 'here', 'real-estate-manager' ).'</a>',
                'show_if'  => array('use_map_from', 'google_maps'),
            ),

            array(
                'type' => 'select',
                'name' => 'maps_type',
                'title' => __( 'Map Type', 'real-estate-manager' ),
                'options' => array(
                    'roadmap' => __( 'Road Map', 'real-estate-manager' ),
                    'satellite' => __( 'Google Earth', 'real-estate-manager' ),
                    'hybrid' => __( 'Hybrid', 'real-estate-manager' ),
                    'terrain' => __( 'Terrain', 'real-estate-manager' ),
                ),                
                'help' => __( 'Choose default map type here', 'real-estate-manager' ),
                'show_if'  => array('use_map_from', 'google_maps'),
            ),

            array(
                'type' => 'text',
                'name' => 'maps_zoom_level',
                'title' => __( 'Map Zoom Level', 'real-estate-manager' ),
                'help' => __( 'Provide Zoom level between 0 and 21+ for single property map', 'real-estate-manager' ),
            ),

            array(
                'type' => 'image',
                'name' => 'maps_drag_image',
                'title' => __( 'Drag Icon URL', 'real-estate-manager' ),
                'help' => __( 'Upload custom icon for dragging on map while creating new property. Recommended size: 72x60', 'real-estate-manager' ),
            ),

            array(
                'type' => 'image',
                'name' => 'maps_location_image',
                'title' => __( 'Location Icon URL', 'real-estate-manager' ),
                'help' => __( 'Upload custom icon for location on map when visiting property page. Recommended size: 72x60', 'real-estate-manager' ),
            ),

            array(
                'type' => 'image',
                'name' => 'maps_property_image',
                'title' => __( 'Property Icon URL', 'real-estate-manager' ),
                'help' => __( 'Upload custom icon for property location marker on large map.', 'real-estate-manager' ),
            ),

            array(
                'type' => 'text',
                'name' => 'leaflet_icons_size',
                'title' => __( 'Icons Size', 'real-estate-manager' ),
                'help' => __( 'Provide custom icons size. Default is ', 'real-estate-manager' ).'<code>43x47</code>',
                'show_if'  => array('use_map_from', 'leaflet'),
            ),

            array(
                'type' => 'text',
                'name' => 'leaflet_icons_anchor',
                'title' => __( 'Icons Anchor', 'real-estate-manager' ),
                'help' => __( 'Provide custom anchor point for the icons. Default is ', 'real-estate-manager' ).'<code>18x47</code>',
                'show_if'  => array('use_map_from', 'leaflet'),
            ),

            array(
                'type' => 'image',
                'name' => 'maps_property_image_hover',
                'title' => __( 'Property Icon URL (Hover)', 'real-estate-manager' ),
                'help' => __( 'Upload custom icon for property location marker on large map for hover state.', 'real-estate-manager' ),
                'show_if'  => array('use_map_from', 'google_maps'),
            ),

            array(
                'type' => 'image',
                'name' => 'maps_circle_image',
                'title' => __( 'Circle Icon URL', 'real-estate-manager' ),
                'help' => __( 'Upload custom icon for circle counter marker on large map.', 'real-estate-manager' ),
                'show_if'  => array('use_map_from', 'google_maps'),
            ),

            array(
                'type' => 'image',
                'name' => 'maps_my_location_image',
                'title' => __( 'My Location Icon URL', 'real-estate-manager' ),
                'help' => __( 'Upload custom icon for my location marker on large map.', 'real-estate-manager' ),
                'show_if'  => array('use_map_from', 'google_maps'),
            ),
            
            array(
                'type' => 'text',
                'name' => 'default_map_lat',
                'title' => __( 'Default Latitude', 'real-estate-manager' ),
                'help' => __( 'Provide latitude for default map location on create property page', 'real-estate-manager' ),
            ),

            array(
                'type' => 'text',
                'name' => 'default_map_long',
                'title' => __( 'Default Longitude', 'real-estate-manager' ),
                'help' => __( 'Provide longitude for default map location on create property page', 'real-estate-manager' ),
            ),

            array(
                'type' => 'textarea',
                'name' => 'maps_styles',
                'title' => __( 'Map Styles Object', 'real-estate-manager' ),
                'help' => __( 'Provide map styles here.', 'real-estate-manager' ).' <a target="_blank" href="https://webcodingplace.com/15000-pre-made-map-styles-real-estate-manager/">'.__( 'Help', 'real-estate-manager' ).'</a>',
                'show_if'  => array('use_map_from', 'google_maps'),
            ),

            array(
                'type' => 'select',
                'name' => 'leaflet_style',
                'title' => __( 'Map Style', 'real-estate-manager' ),
                'options' => $leaflet_map_styles,
                'help' => __( 'Choose style for leaflet map. ', 'real-estate-manager' ).'<a target="_blank" href="https://webcodingplace.com/real-estate-manager-wordpress-plugin/leaflet-map-styles-for-real-estate-manager-wp-plugin/">'.__( 'Preview', 'real-estate-manager' ).'</a>',
                'show_if'  => array('use_map_from', 'leaflet'),
            ), 

            array(
                'type' => 'select',
                'name' => 'property_map_location_style',
                'title' => __( 'Display location as', 'real-estate-manager' ),
                'options' => array(
                    'pin' => __( 'Exact Pin', 'real-estate-manager' ),
                    'circle' => __( 'Radius Circle', 'real-estate-manager' ),
                    ),
                'help' => __( 'How you want to display location on the single property page', 'real-estate-manager' ),
            ), 

            array(
                'type' => 'select',
                'name' => 'get_direction_btn',
                'title' => __( 'Display Direction Button', 'real-estate-manager' ),
                'options' => array(
                    'enable' => __( 'Enable', 'real-estate-manager' ),
                    'disable' => __( 'Disable', 'real-estate-manager' ),
                    ),
                'help' => __( 'It will display the directions button under the map', 'real-estate-manager' ),
            ),

            array(
                'type' => 'number',
                'name' => 'property_map_radius',
                'title' => __( 'Circle Radius', 'real-estate-manager' ),
                'help' => __( 'If above is set to Radius Circle, provide the radius in meters here', 'real-estate-manager' ),
                'show_if'  => array('property_map_location_style', 'circle'),
            ),
        ),

    ),

    array(

        'panel_title'   =>  __( 'Colors and CSS', 'real-estate-manager' ),
        'panel_name'   =>  'colors_css',
        'icon'   =>  '<span class="glyphicon glyphicon-tint"></span>',
        'fields'        => array(

            array(
                'type' => 'color',
                'name' => 'rem_main_color',
                'title' => __( 'Theme Main Color', 'real-estate-manager' ),
                'default' => '#1FB7A6',
                'help' => __( 'Choose main theme color for templates', 'real-estate-manager' ),
            ),

            array(
                'type' => 'color',
                'name' => 'headings_underline_color_default',
                'title' => __( 'Headings Underline', 'real-estate-manager' ),
                'default' => '#F2F2F2',
                'help' => __( 'Choose bottom border color for headings area', 'real-estate-manager' ),
            ),

            array(
                'type' => 'color',
                'name' => 'headings_underline_color_active',
                'title' => __( 'Headings Underline Active', 'real-estate-manager' ),
                'default' => '#1fb7a6',
                'help' => __( 'Choose bottom border color for headings active area', 'real-estate-manager' ),
            ),

            array(
                'type' => 'color',
                'name' => 'buttons_background_color',
                'title' => __( 'Buttons Background', 'real-estate-manager' ),
                'default' => '#fff',
                'help' => __( 'Choose background color for buttons', 'real-estate-manager' ),
            ),

            array(
                'type' => 'color',
                'name' => 'buttons_text_color',
                'title' => __( 'Buttons Text', 'real-estate-manager' ),
                'default' => '#333',
                'help' => __( 'Choose text color for buttons', 'real-estate-manager' ),
            ),

            array(
                'type' => 'color',
                'name' => 'buttons_background_color_hover',
                'title' => __( 'Buttons Background - Hover', 'real-estate-manager' ),
                'default' => '#e6e6e6',
                'help' => __( 'Choose background color for buttons on hover state', 'real-estate-manager' ),
            ),

            array(
                'type' => 'color',
                'name' => 'buttons_text_color_hover',
                'title' => __( 'Buttons Text - Hover', 'real-estate-manager' ),
                'default' => '#333',
                'help' => __( 'Choose text color for buttons', 'real-estate-manager' ),
            ),

            array(
                'type' => 'color',
                'name' => 'ribbon_bg',
                'title' => __( 'Ribbons Color', 'real-estate-manager' ),
                'default' => '',
                'help' => __( 'Choose color for the featured ribbon', 'real-estate-manager' ),
            ),

            array(
                'type' => 'color',
                'name' => 'badge_bg',
                'title' => __( 'Badge Color', 'real-estate-manager' ),
                'default' => '',
                'help' => __( 'Choose color for the listing type badge', 'real-estate-manager' ),
            ),

            array(
                'type' => 'textarea',
                'name' => 'custom_css',
                'title' => __( 'Custom CSS Code', 'real-estate-manager' ),
                'default' => '',
                'help' => __( 'Paste your custom css code here, you can prefix with', 'real-estate-manager' ).'<code>.ich-settings-main-wrap</code>',
            ),

            array(
                'type' => 'textarea',
                'name' => 'custom_js',
                'title' => __( 'Custom JavaScript Code', 'real-estate-manager' ),
                'default' => '',
                'help' => __( 'Please keep this box empty if you are not sure what you are doing','real-estate-manager' ),
            ),

        ),

    ),

    array(
        'panel_title'   =>  __( 'Listing Ribbons', 'real-estate-manager' ),
        'panel_name'   =>  'listing_ribbons',
        'icon'   =>  '<span class="glyphicon glyphicon-bookmark"></span>',
        'fields'        => array(
            array(
                'type' => 'select',
                'name' => 'ribbon_style',
                'title' => __( 'Ribbon Style', 'real-estate-manager' ),
                'options' => array(
                    'rem-sale rem-sale-top-left' => __( 'Style 1', 'real-estate-manager' ),
                    'rem-sale-ribbon-2' => __( 'Style 2', 'real-estate-manager' ),
                ),
                'help' => __( 'Choose ribbon style', 'real-estate-manager' ),
            ),
            array(
                'type' => 'text',
                'name' => 'property_sale_ribbon_text',
                'title' => __( 'Sale Ribbon Text', 'real-estate-manager' ),
                'help' => __( 'It displays when sale price of property is set, leave blank to disable it', 'real-estate-manager' ),
            ),
            array(
                'type' => 'text',
                'name' => 'property_rent_ribbon_text',
                'title' => __( 'Rented Properties', 'real-estate-manager' ),
                'help' => __( 'It displays when property purpose is set to rent, leave blank to disable it', 'real-estate-manager' ),
            ),
            array(
                'type' => 'text',
                'name' => 'property_sell_ribbon_text',
                'title' => __( 'For Sale Properties', 'real-estate-manager' ),
                'help' => __( 'It displays when property purpose is set to sell, leave blank to disable it', 'real-estate-manager' ),
            ),
            array(
                'type' => 'text',
                'name' => 'property_sold_ribbon_text',
                'title' => __( 'Sold Properties', 'real-estate-manager' ),
                'help' => __( 'It displays when property status is set to sold, leave blank to disable it', 'real-estate-manager' ),
            ),
            array(
                'type' => 'text',
                'name' => 'property_featured_ribbon_text',
                'title' => __( 'Featured Properties', 'real-estate-manager' ),
                'help' => __( 'It displays when featured option is set to yes, leave blank to disable it', 'real-estate-manager' ),
            ),
            array(
                'type' => 'text',
                'name' => 'listings_ribbon_type',
                'title' => __( 'Custom Ribbon', 'real-estate-manager' ),
                'help' => __( 'Provide key with value. Eg:', 'real-estate-manager' ).'<code>property_type=House</code>, <code>property_type=ANY</code>',
            ),
            array(
                'type' => 'text',
                'name' => 'custom_ribbon_text',
                'title' => __( 'Custom Ribbon Text', 'real-estate-manager' ),
                'help' => __( 'Provide text to display for custom ribbon. You can also provide field name for dynamic label.', 'real-estate-manager' ),
            ),
        ),
    ),

    array(
        'panel_title'   =>  __( 'Page Builders', 'real-estate-manager' ),
        'panel_name'   =>  'page_builders',
        'icon'   =>  '<span class="glyphicon glyphicon-tasks"></span>',
        'fields'        => array(
            array(
                'type' => 'select',
                'name' => 'gutenberg_blocks',
                'multiple' => 'true',
                'title' => __( 'Gutenberg Blocks', 'real-estate-manager' ),
                'options' => array(
                    'login_agent' => __( 'Login Agent', 'real-estate-manager' ),
                    'register_agent' => __( 'Register Agent', 'real-estate-manager' ),
                    'simple_search' => __( 'Simple Search', 'real-estate-manager' ),
                ),
                'help' => __( 'Enable or disable Gutenberg Blocks here. More are coming...', 'real-estate-manager' ),
            ),
            array(
                'type' => 'select',
                'name' => 'wpbakery_addons',
                'title' => __( 'WPBakery Page Builder Addons', 'real-estate-manager' ),
                'options' => array(
                    'enable' => __( 'Enable', 'real-estate-manager' ),
                    'disable' => __( 'Disable', 'real-estate-manager' ),
                ),
                'help' => __( 'Enable or disable WPBakery Page Builder addons here.', 'real-estate-manager' ),
            ),
            array(
                'type' => 'select',
                'name' => 'divi_modules',
                'title' => __( 'Divi Modules', 'real-estate-manager' ),
                'options' => array(
                    'enable' => __( 'Enable', 'real-estate-manager' ),
                    'disable' => __( 'Disable', 'real-estate-manager' ),
                ),
                'help' => __( 'Enable or disable Divi modules here.', 'real-estate-manager' ),
            ),
            array(
                'type' => 'select',
                'name' => 'elementor_widgets',
                'title' => __( 'Elementor Widgets', 'real-estate-manager' ),
                'options' => array(
                    'enable' => __( 'Enable', 'real-estate-manager' ),
                    'disable' => __( 'Disable', 'real-estate-manager' ),
                ),
                'help' => __( 'Enable or disable Elementor widgets here.', 'real-estate-manager' ),
            ),
            array(
                'type' => 'select',
                'name' => 'elementor_theme_builder',
                'title' => __( 'Elementor Pro Theme Builder', 'real-estate-manager' ),
                'options' => array(
                    'enable' => __( 'Enable', 'real-estate-manager' ),
                    'disable' => __( 'Disable', 'real-estate-manager' ),
                ),
                'help' => __( 'It will enable Single Property Page builder in Elementor Theme Builder.', 'real-estate-manager' ),
            ),
        ),
    ),

    array(
        'panel_title'   =>  __( 'Advanced Settings', 'real-estate-manager' ),
        'panel_name'   =>  'advanced_settings',
        'icon'   =>  '<span class="glyphicon glyphicon-modal-window"></span>',

        'fields'        => array(
            array(
                'type' => 'select',
                'name' => 'use_bootstrap',
                'title' => __( 'Bootstrap CSS', 'real-estate-manager' ),
                'options' => array(
                    'enable' => __( 'Enable', 'real-estate-manager' ),
                    'disable' => __( 'Disable', 'real-estate-manager' ),
                ),
                'help' => __( 'Disable it, if your theme loads its own bootstrap 3 styles', 'real-estate-manager' ),
            ),
            array(
                'type' => 'select',
                'name' => 'disable_map_script',
                'title' => __( 'Disable Map Script', 'real-estate-manager' ),
                'options' => array(
                    'no' => __( 'No', 'real-estate-manager' ),
                    'yes' => __( 'Yes', 'real-estate-manager' ),
                ),
                'help' => __( 'If you want to load map scripts from your theme, choose Yes', 'real-estate-manager' ),
            ),
            array(
                'type' => 'select',
                'name' => 'use_fontawesome',
                'title' => __( 'Font Awesome', 'real-estate-manager' ),
                'options' => array(
                    'enable' => __( 'Enable', 'real-estate-manager' ),
                    'disable' => __( 'Disable', 'real-estate-manager' ),
                ),
                'help' => __( 'Disable it, if your theme loads its own font awesome icons', 'real-estate-manager' ),
            ),
            array(
                'type' => 'select',
                'name' => 'property_submission_mode',
                'title' => __( 'Property Submission Mode', 'real-estate-manager' ),
                'options' => array(
                    'publish' => __( 'Publish Right Away', 'real-estate-manager' ),
                    'approve' => __( 'Approve by Administrator', 'real-estate-manager' ),
                ),
                'help' => __( 'Set permission for agents for creating new property', 'real-estate-manager' ),
            ),
            array(
                'type' => 'number',
                'name' => 'max_properties',
                'title' => __( 'Maximum Number of Properties', 'real-estate-manager' ),
                'help' => __( 'Set maximum number of properties an agent can publish at a time', 'real-estate-manager' ),
            ),
            array(
                'type' => 'select',
                'name' => 'property_deletion',
                'options' => array(
                    'delete' => __( 'Delete Permanently', 'real-estate-manager' ),
                    'trash' => __( 'Move to Trash', 'real-estate-manager' ),
                ),                
                'title' => __( 'Property Deletion', 'real-estate-manager' ),
                'help' => __( 'What to do when an agent deletes a property.', 'real-estate-manager' ),
            ),
            array(
                'type' => 'select',
                'name' => 'attachment_deletion',
                'options' => array(
                    'remain' => __( 'Keep', 'real-estate-manager' ),
                    'delete' => __( 'Delete', 'real-estate-manager' ),
                ),                
                'title' => __( 'Attachments Deletion', 'real-estate-manager' ),
                'help' => __( 'What to do with gallery images after deleting property.', 'real-estate-manager' ),
            ),
            array(
                'type' => 'select',
                'name' => 'agents_approval',
                'title' => __( 'Agents Approval', 'real-estate-manager' ),
                'options' => array(
                    'manual' => __( 'Manual', 'real-estate-manager' ),
                    'auto' => __( 'Automatic', 'real-estate-manager' ),
                ),
                'help' => __( 'We recommend you to use manual method', 'real-estate-manager' ),
            ),
            array(
                'type' => 'select',
                'name' => 'auto_login',
                'title' => __( 'Auto Login', 'real-estate-manager' ),
                'options' => array(
                    'disable' => __( 'Disable', 'real-estate-manager' ),
                    'enable' => __( 'Enable', 'real-estate-manager' ),
                ),
                'help' => __( 'Auto-login newly registered agents. If agents approval is set to automatic', 'real-estate-manager' ),
                'show_if'  => array('agents_approval', 'auto'),
            ),
        ),
    ),
);

$fieldsData = apply_filters( 'rem_admin_settings_fields', $fieldsData );
?>