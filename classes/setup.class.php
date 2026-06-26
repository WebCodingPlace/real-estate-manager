<?php

/**
* Real Estate Management Main Class - Since 1.0.0
*/

class WCP_Real_Estate_Management
{
    
    function __construct(){

        /***********************************************************************************************/
        /* Admin Menus, Settings, Scripts */
        /***********************************************************************************************/

        // Actions
        add_action( 'init', array($this, 'register_property' ) );
        add_action( 'admin_menu', array( $this, 'menu_pages' ) );
        add_action( 'admin_enqueue_scripts', array($this, 'admin_scripts' ) );
        add_action( 'wp_enqueue_scripts', array($this, 'front_scripts' ) );
        add_action( 'save_post', array($this, 'save_property' ) );
        add_action( 'save_post', array($this, 'save_quick_edit' ) );
        add_action( 'add_meta_boxes', array($this, 'property_metaboxes' ) );
        add_action( 'admin_init', array($this, 'rem_role_cap') , 999);

        // Edit Profile Fields
        add_action( 'show_user_profile', array($this, 'rem_agent_extra_fields' ) );
        add_action( 'edit_user_profile', array($this, 'rem_agent_extra_fields' ) );

        // Save Profile Fields
        add_action( 'personal_options_update', array($this, 'save_rem_agent_fields' ) );
        add_action( 'edit_user_profile_update', array($this, 'save_rem_agent_fields' ) );

        // Bulk & Quick Edit Admin
        add_action( 'quick_edit_custom_box', array($this, 'listings_quick_edit_fields' ), 10, 2 );
        add_action( 'bulk_edit_custom_box', array($this, 'listings_quick_edit_fields' ), 10, 2 );

        // Filters
        add_filter( 'post_updated_messages', array($this, 'property_messages' ) );
        add_filter( 'template_include', array($this, 'rem_templates'), 99 );

        //disable WordPress sanitization to allow more than just $allowedtags from /wp-includes/kses.php
        remove_filter('pre_user_description', 'wp_filter_kses');

        // Translations
        add_action( 'plugins_loaded', array($this, 'wcp_load_plugin_textdomain' ) );

        // Change author in proeprties page
        add_filter( 'wp_dropdown_users', array($this, 'author_override') );

        // Permalink settings
        add_filter( 'load-options-permalink.php', array($this, 'permalink_settings') ); 

        // Image in Category    
        add_action( 'rem_property_cat_add_form_fields', array( $this, 'add_category_image' ), 10, 1 );
        add_action( 'created_rem_property_cat', array( $this, 'save_category_image' ), 10, 2 );
        add_action( 'rem_property_cat_edit_form_fields', array( $this, 'edit_category_image' ), 10, 2 );
        add_action( 'edited_rem_property_cat', array( $this, 'update_category_image' ), 10, 2 );

        /***********************************************************************************************/
        /* AJAX Callbacks */
        /***********************************************************************************************/

        // Saving Admin Settings
        add_action( 'wp_ajax_wcp_rem_save_settings', array($this, 'save_admin_settings' ) );

        // Saving Bulk Edit
        add_action( 'wp_ajax_rem_save_bulk_edit', array($this, 'save_bulk_edit' ) );
        
        // Contact Agent
        add_action( 'wp_ajax_rem_contact_agent', array($this, 'send_email_agent' ) );
        add_action( 'wp_ajax_nopriv_rem_contact_agent', array($this, 'send_email_agent' ) );
        
        // Get States providing Country
        add_action( 'wp_ajax_rem_get_states', array($this, 'get_country_states' ) );
        add_action( 'wp_ajax_nopriv_rem_get_states', array($this, 'get_country_states' ) );

        // Agent Approve/ Deny
        add_action( 'wp_ajax_deny_agent', array($this, 'deny_agent' ) );
        add_action( 'wp_ajax_approve_agent', array($this, 'approve_agent' ) );
        
        // Create Basic Pages
        add_action( 'wp_ajax_rem_create_pages_auto', array($this, 'create_pages_auto' ) );

        // Manage Columns and filter on admin listings
        add_filter( 'manage_rem_property_posts_columns', array($this, 'rem_property_column_head'));
        add_action( 'manage_rem_property_posts_custom_column', array($this, 'rem_property_column_content'), 10, 2);
        add_action( 'manage_edit-rem_property_sortable_columns', array($this, 'rem_property_column_sorting'), 10, 2);
        add_action( 'restrict_manage_posts', array($this, 'filter_properties_list_admin') , 10);
        add_filter( 'parse_query', array($this, 'filter_properties_request_query') , 10);

        add_action( 'wp_ajax_wcp_rem_save_custom_agent_fields', array($this, 'save_custom_agent_fields' ) );
        add_action( 'wp_ajax_wcp_rem_reset_custom_agent_fields', array($this, 'reset_custom_agent_fields' ) );
        add_action( 'after_setup_theme', array($this, 'remove_admin_bar' ) );
        add_filter( 'mce_buttons', array($this, 'remove_tiny_mce_link_buttons') );
        add_filter( 'use_block_editor_for_post_type', array($this, 'rem_disable_gutenberg'), 10, 2);

        // Parent Listing Help
        add_action( 'page_attributes_misc_attributes', array($this, 'display_parent_listing_help'), 10, 1 );
    }

    function wcp_load_plugin_textdomain(){
        load_plugin_textdomain( 'real-estate-manager', false, basename( REM_PATH ) . '/languages/' );
    }

    /**
    * Registers a new post type property
    * @since 1.0.0
    */
    function register_property() {
        include_once REM_PATH.'/inc/admin/register-property.php';
    }
    
    /**
    * Property page settings metaboxes
    * @since 1.0.0
    */
    function property_metaboxes(){
        add_meta_box( 'property_settings_meta_box', __( 'Listing Information', 'real-estate-manager' ), array($this, 'render_property_settings' ), array('rem_property'));
        add_meta_box( 'property_maps_meta_box', __( 'Location on Map', 'real-estate-manager' ), array($this, 'render_property_location' ), array('rem_property'));
        add_meta_box( 'property_images_meta_box', __( 'Gallery Images', 'real-estate-manager' ), array($this, 'render_property_images' ), array('rem_property'));
        add_meta_box( 'property_multiple_agents_meta_box', __( 'Additional Agents', 'real-estate-manager' ), array($this, 'render_agents_box' ), array('rem_property'), 'side');

        // Changing Title
        remove_meta_box( 'pageparentdiv' , 'rem_property' , 'side' );
        add_meta_box( 'pageparentdiv', __( 'Listing Attributes', 'real-estate-manager' ), 'page_attributes_meta_box', 'rem_property', 'side' );
    }

    function render_agents_box($post) {

        $saved_agents = get_post_meta($post->ID, 'rem_property_multiple_agents', true);
        $blogusers = get_users( array( 'fields' => array( 'ID','display_name' ) ) );
        $author_id=$post->post_author;
        
        // Array of stdClass objects.
        foreach ( $blogusers as $user ) {
            if ( is_array($saved_agents) && in_array( $user->ID, $saved_agents ) ) {
                $checked = 'checked';
            }else {
                $checked = '';
            }
            // property authore not show in multiple agents
            if ($user->ID != $author_id) {
                
                echo '<div style="padding: 10px;">';
                echo "<label for='".$user->ID."'><input type='checkbox' id='".$user->ID."' name='rem_multiple_agents[]' value='".$user->ID."' ".$checked." > <strong>". esc_html( $user->display_name ) ."<strong></label>";
                echo '</div>';
            }
        }
    }

    function render_property_settings(){
        wp_nonce_field( plugin_basename( __FILE__ ), 'rem_property_settings_nonce' );
        include_once REM_PATH.'/inc/admin/property-settings-metabox.php';
    }

    function render_property_images(){
        include REM_PATH.'/inc/admin/property-images-metabox.php';
    }

    function render_property_location(){
        include REM_PATH.'/inc/admin/property-location-map.php';
    }

    function save_property($post_id){
        // verify if this is an auto save routine. 
        // If it is our form has not been submitted, so we dont want to do anything
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
            return;

        // verify this came from the our screen and with proper authorization,
        // because save_post can be triggered at other times
        if ( !isset( $_POST['rem_property_settings_nonce'] ) )
            return;

        if ( !wp_verify_nonce( $_POST['rem_property_settings_nonce'], plugin_basename( __FILE__ ) ) )
            return;

        // OK, we're authenticated: we need to find and save the data
        $hidden_fields_json = isset( $_REQUEST['hidden_fields'] ) ? $_REQUEST['hidden_fields'] : '' ;
        if ($hidden_fields_json != '') {
            $hidden_fields_array = json_decode(stripcslashes($hidden_fields));
        }

        if (isset($_POST['rem_property_data']) && $_POST['rem_property_data'] != '') {
            foreach ($_POST['rem_property_data'] as $key => $value) {
                if (!isset($hidden_fields_array) || (isset($hidden_fields_array) && !in_array($key, $hidden_fields))) {
                    if ($key == 'property_price' && strpos($value, '-') ) {
                        $price_array =  explode("-", $value);
                        $min_price = $price_array[0];
                        $max_price = $price_array[1];
                        
                        update_post_meta( $post_id, 'rem_property_min_price', $min_price );
                        update_post_meta( $post_id, 'rem_property_max_price', $max_price );
                    }
                    update_post_meta( $post_id, 'rem_'.$key, $value );
                } else {  
                    update_post_meta( $post_id, 'rem_'.$key, '' );
                }
            }

            if (!isset($_POST['rem_property_data']['property_detail_cbs'])) {
                update_post_meta( $post_id, 'rem_property_detail_cbs', '' );
            }
            if (!isset($_POST['rem_property_data']['property_images'])) {
                update_post_meta( $post_id, 'rem_property_images', '' );
            }
            if (!isset($_POST['rem_property_data']['file_attachments'])) {
                update_post_meta( $post_id, 'rem_file_attachments', '' );
            }

            if (isset($_POST['rem_property_data']['property_price'])) {
                update_post_meta( $post_id, 'rem_regular_price', $_POST['rem_property_data']['property_price'] );
            }

            if (isset($_POST['rem_property_data']['property_sale_price'])) {
                update_post_meta( $post_id, 'rem_regular_price', $_POST['rem_property_data']['property_sale_price'] );
            }

            // unsetting mutli-select fields
            $all_fields = $this->single_property_fields();

            foreach ($all_fields as $fieldData) {
                if (isset($fieldData['type']) && $fieldData['type'] == 'select2' && !isset($_POST['rem_property_data'][$fieldData['key']])) {
                    update_post_meta( $post_id, 'rem_'.$fieldData['key'], '' );
                }
                if (isset($fieldData['type']) && $fieldData['type'] == 'upload' && !isset($_POST['rem_property_data'][$fieldData['key']])) {
                    update_post_meta( $post_id, 'rem_'.$fieldData['key'], '' );
                }
            }
        }

        if (isset($_POST['rem_multiple_agents']) && $_POST['rem_multiple_agents'] != '') {
            update_post_meta( $post_id, 'rem_property_multiple_agents', $_POST['rem_multiple_agents'] );
        } else {
            update_post_meta( $post_id, 'rem_property_multiple_agents', '' );
        }

        if (isset($_POST['_disable_map'])) {
            update_post_meta( $post_id, '_disable_map', 'yes');
        } else {
            update_post_meta( $post_id, '_disable_map', 'no');
        }
        
        do_action( "rem_after_property_create_admin", $post_id, $_POST['rem_property_data'] );

    }

    function save_bulk_edit(){
        if ( !wp_verify_nonce( $_POST['nonce'], 'rem_quick_edit' ) ) {
            die();
        }

        if( empty( $_POST[ 'post_ids' ] ) ) {
            die();
        }

        if( empty( $_POST[ 'save_data' ] ) ) {
            die();
        }

        $dataToSave = isset($_POST['save_data']) ? json_decode(stripslashes($_POST['save_data']), true) : '';
        
        foreach( $_POST[ 'post_ids' ] as $id ) {
            foreach ($dataToSave as $data) {
                if(isset($data['key']) && isset($data['value']) && $data['value'] != ''){
                    update_post_meta( $id, 'rem_'.$data['key'], $data['value'] );
                }
            }
        }

        die();
    }

    function save_quick_edit($post_id){
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
            return;
        }
        if ( !isset( $_POST['_rem_quick_edit_nonce'] ) ){
            return;
        }

        if ( !wp_verify_nonce( $_POST['_rem_quick_edit_nonce'], 'rem_quick_edit' ) ){
            return;
        }

        $admin_quick_edit = rem_get_option('admin_quick_edit', "property_type \n property_purpose \n property_status \n property_price");
        $dataToSave = (isset($_POST['rem_property_data'])) ? $_POST['rem_property_data'] : '' ;
        if ($admin_quick_edit != '') {
            $field_keys = array_map('trim', explode("\n", $admin_quick_edit));
            $all_fields = $this->single_property_fields();
            foreach ($all_fields as $fieldData) {
                if (isset($fieldData['key']) && in_array($fieldData['key'], $field_keys) && isset($dataToSave[$fieldData['key']])) {
                    update_post_meta( $post_id, 'rem_'.$fieldData['key'], $dataToSave[$fieldData['key']] );
                }
            }
        }
    }

    function admin_scripts($check){
        global $post;
        if ( $check == 'edit.php' ) {
            if (isset($post->post_type) && 'rem_property' === $post->post_type) {
                $admin_quick_edit = rem_get_option('admin_quick_edit', "property_type \n property_purpose \n property_status \n property_price");
                if($admin_quick_edit != ''){
                    $field_keys = array_map('trim', explode("\n", $admin_quick_edit));
                    wp_enqueue_script( 'rem-quick-edit', REM_URL . '/assets/admin/js/quick-edit.js' , array('jquery'));
                    wp_localize_script( 'rem-quick-edit', 'rem_qe_fields', $field_keys );
                }
                
            }
        }

        if ( $check == 'post-new.php' || $check == 'post.php' ) {
            if (isset($post->post_type) && 'rem_property' === $post->post_type) {
                wp_enqueue_media();
                rem_load_bs_and_fa();
                wp_enqueue_style( 'rem-new-property-css', REM_URL . '/assets/admin/css/admin.css' );
                
                wp_enqueue_style( 'select2', REM_URL . '/assets/admin/css/select2.min.css' );
                wp_enqueue_script( 'select2', REM_URL . '/assets/admin/js/select2.min.js' , array('jquery'));
                
                $maps_api = apply_filters( 'rem_maps_api', 'AIzaSyBbpbij9IIXGftKhFLMHOuTpAbFoTU_8ZQ' );

                if (rem_get_option('use_map_from', 'leaflet') == 'leaflet') {
                    wp_enqueue_style( 'rem-leaflet-css', REM_URL . '/assets/front/leaflet/leaflet.css');
                    wp_enqueue_script( 'rem-leaflet-js', REM_URL . '/assets/front/leaflet/leaflet.js', array('jquery'));
                    wp_enqueue_style( 'rem-leaflet-geo-css', 'https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css');
                    wp_enqueue_script( 'rem-leaflet-geo-js', 'https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js');
                } else {
                    if (is_ssl()) {
                        wp_enqueue_script( 'google-maps', 'https://maps.googleapis.com/maps/api/js?key='.$maps_api.'&libraries=places' );
                    } else {
                        wp_enqueue_script( 'google-maps', 'http://maps.googleapis.com/maps/api/js?key='.$maps_api.'&libraries=places' );
                    }
                }

                wp_enqueue_script( 'rem-new-property-js', REM_URL . '/assets/admin/js/admin-property.js' , array('jquery', 'wp-color-picker', 'jquery-ui-sortable'));

                $def_lat = rem_get_option('default_map_lat', '-33.890542'); 
                $def_long = rem_get_option('default_map_long', '151.274856');

                if (isset($post->ID) && get_post_meta( $post->ID, 'rem_property_latitude', true ) != '') {
                    $def_lat = get_post_meta( $post->ID, 'rem_property_latitude', true );
                }
                if (isset($post->ID) && get_post_meta( $post->ID, 'rem_property_longitude', true ) != '') {
                    $def_long = get_post_meta( $post->ID, 'rem_property_longitude', true );
                }

                $localize_vars = array(
                    'use_map_from' => rem_get_option('use_map_from', 'leaflet'),
                    'post_edit_url' => admin_url( 'post.php' ),
                    'def_lat' => $def_lat,
                    'leaflet_styles' => rem_get_leaflet_provider(rem_get_option('leaflet_style')),
                    'def_long' => $def_long,
                    'zoom_level' => rem_get_option('maps_zoom_level', '18'),
                    'drag_icon' => apply_filters( 'rem_maps_drag_icon', REM_URL.'/assets/images/pin-drag.png' ),
                    'post_edit_url' => admin_url( 'post.php' ),
                    'nonce_states' => wp_create_nonce('rem-nonce-states'),
                    'nonce_edit_img' => wp_create_nonce('rem-nonce-edit-img'),
                );

                wp_localize_script( 'rem-new-property-js', 'rem_map_ob', $localize_vars );
            }

            if (isset($post->post_type) && 'attachment' === $post->post_type && isset($_GET['rem_image_editor']) && wp_verify_nonce( $_GET['nonce'], 'rem-nonce-edit-img' )) {
                wp_enqueue_style( 'rem-image-editor', REM_URL . '/assets/admin/css/image-editor.css' );
                wp_enqueue_script( 'rem-image-editor', REM_URL . '/assets/admin/js/image-editor.js', array('jquery') );
            }
        }

        if ( $check == 'rem_property_page_rem_settings' ) {
            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_media();
            wp_enqueue_style( 'rem-bs-css', REM_URL . '/assets/admin/css/bootstrap.min.css' );
            wp_enqueue_style( 'select2', REM_URL . '/assets/admin/css/select2.min.css' );
            wp_enqueue_style( 'rem-new-property-css', REM_URL . '/assets/admin/css/admin.css' );
            wp_enqueue_script( 'select2', REM_URL . '/assets/admin/js/select2.min.js' , array('jquery'));
            wp_enqueue_script( 'sweet-alerts', REM_URL . '/assets/admin/js/sweetalert.min.js' , array('jquery'));
            wp_enqueue_script( 'rem-conditionize', REM_URL . '/assets/admin/js/conditionize.js' , array('jquery'));
            wp_enqueue_script( 'rem-save-settings-js', REM_URL . '/assets/admin/js/page-settings.js' , array('jquery', 'wp-color-picker' ));
        }

        if ($check == 'user-edit.php' || $check == 'profile.php') {
            wp_enqueue_media();
            wp_enqueue_script( 'rem-profile-edit', REM_URL . '/assets/admin/js/profile.js' , array('jquery'));
        }

        if ($check == 'rem_property_page_rem_property_agents') {
            wp_enqueue_style( 'rem-bs-css', REM_URL . '/assets/admin/css/bootstrap.min.css' );
            wp_enqueue_script( 'sweet-alerts', REM_URL . '/assets/admin/js/sweetalert.min.js' , array('jquery'));
            wp_enqueue_script( 'rem-agents-settings-js', REM_URL . '/assets/admin/js/manage-agents.js'  , array('jquery'));
            wp_localize_script( 'rem-agents-settings-js', 'rem_agents_vars', array(
                'nonce_deny' => wp_create_nonce('rem-nonce-deny'),
                'nonce_approve' => wp_create_nonce('rem-nonce-approve'),
            ) );
        }

        if ($check == 'rem_property_page_rem_documentation') {
            wp_enqueue_style( 'rem-bs-css', REM_URL . '/assets/admin/css/bootstrap.min.css' );
            wp_enqueue_script( 'sweet-alerts', REM_URL . '/assets/admin/js/sweetalert.min.js' , array('jquery'));
            wp_enqueue_script( 'rem-docs-admin', REM_URL . '/assets/admin/js/tools.js', array('jquery') );
            wp_localize_script( 'rem-docs-admin', 'rem_tools_var', array(
                'nonce_pages' =>  wp_create_nonce('rem-nonce-pages'),
            ) );
        }

        if ($check == 'rem_property_page_rem_extensions') {
            wp_enqueue_style( 'rem-bs-css', REM_URL . '/assets/admin/css/bootstrap.min.css' );
        }

        if ($check == 'rem_property_page_rem_custom_fields') {
            wp_enqueue_style( 'rem-bs-css', REM_URL . '/assets/admin/css/bootstrap.min.css' );
            wp_enqueue_style( 'rem-fields-builder', REM_URL . '/assets/admin/css/fields-builder.css' );
            wp_enqueue_script( 'sweet-alerts', REM_URL . '/assets/admin/js/sweetalert.min.js' , array('jquery'));
            if ( !defined("REM_FIELDS_PATH")  ) {
                wp_enqueue_script( 'rem-property-fields', REM_URL . '/assets/admin/js/property-fields.js'  , array( 'jquery', 'jquery-ui-accordion', 'jquery-ui-sortable', 'jquery-ui-draggable' ));
                wp_localize_script( 'rem-property-fields', 'rem_fields_var', array(
                    'nonce' => wp_create_nonce('rem-nonce-fields'),
                ) );
            }
        }

        if ($check == 'rem_property_page_rem_custom_field_sections') {
            wp_enqueue_style( 'rem-bs-css', REM_URL . '/assets/admin/css/bootstrap.min.css' );
            wp_enqueue_style( 'field-sections', REM_URL . '/assets/admin/css/field-sections.css');
            wp_enqueue_script( 'sweet-alerts', REM_URL . '/assets/admin/js/sweetalert.min.js' , array('jquery'));

            wp_enqueue_script( 'rem-property-sections', REM_URL . '/assets/admin/js/field-sections.js', array('jquery','jquery-ui-sortable', 'jquery-effects-highlight') );
            wp_localize_script( 'rem-property-sections', 'rem_sections_var', array(
                'nonce' => wp_create_nonce('rem-nonce-sections'),
            ) );
        }

        if ($check == 'rem_property_page_rem_agent_registration') {
            wp_enqueue_style( 'rem-bs-css', REM_URL . '/assets/admin/css/bootstrap.min.css' );
            wp_enqueue_style( 'rem-fields-builder', REM_URL . '/assets/admin/css/fields-builder.css' );
            wp_enqueue_script( 'sweet-alerts', REM_URL . '/assets/admin/js/sweetalert.min.js' , array('jquery'));
            wp_enqueue_script( 'rem-agent-fields-page', REM_URL . '/assets/admin/js/agent-registration.js'  , array( 'jquery', 'jquery-ui-accordion', 'jquery-ui-sortable', 'jquery-ui-draggable' ));
            wp_localize_script( 'rem-agent-fields-page', 'rem_agent_fields_var', array(
                'nonce' => wp_create_nonce('rem-nonce-fields'),
            ) );
        }     

        if ($check == 'edit-tags.php' || $check == 'term.php') {
            if (isset($_GET['post_type']) && 'rem_property' === $_GET['post_type']) {
                wp_enqueue_media();
                wp_enqueue_script( 'rem-category-admin', REM_URL . '/assets/admin/js/category.js', array('jquery'));
            }
        }
    }

    function front_scripts(){
        $layout_agent = rem_get_option('agent_page_layout', 'plugin');
        $layout_archive = rem_get_option('archive_property_layout', 'plugin');
        $disable_map_script = rem_get_option('disable_map_script', 'no');
        if (is_singular( 'rem_property' )) {

            global $post;
            $property_id = (isset($post->ID)) ? $post->ID : '';

            rem_load_bs_and_fa();

            rem_load_basic_styles();

            $gallery_type = rem_get_option('gallery_type', 'fotorama');
            $gallery_type = apply_filters( 'rem_single_property_gallery_type', $gallery_type, $property_id);

            if ($gallery_type == 'fotorama') {
                wp_enqueue_style( 'rem-fotorama-css', REM_URL . '/assets/front/lib/fotorama.min.css' );
                wp_enqueue_script( 'rem-photorama-js', REM_URL . '/assets/front/lib/fotorama.min.js', array('jquery'));
            }
            
            wp_enqueue_style( 'rem-carousel-css', REM_URL . '/assets/front/lib/slick.css' );
            wp_enqueue_script( 'rem-carousel-js', REM_URL . '/assets/front/lib/slick.min.js', array('jquery'));

            if ($gallery_type == 'slick') {
                wp_enqueue_script( 'rem-magnific-js', REM_URL . '/assets/front/lib/jquery.magnific-popup.min.js', array('jquery'));
                wp_enqueue_style( 'rem-magnific-css', REM_URL . '/assets/front/lib/magnific-popup.css' );
            }
            if ($gallery_type == 'grid') {
                wp_enqueue_style( 'rem-grid-css', REM_URL . '/assets/front/lib/images-grid.css' );
                wp_enqueue_script( 'rem-grid-js', REM_URL . '/assets/front/lib/images-grid.js', array('jquery'));
            }
            if (rem_get_option('property_page_phone') == 'intltelinput') {
                wp_enqueue_style( 'rem-tell-input', REM_URL . '/assets/front/css/intlTelInput.min.css');
                wp_enqueue_script( 'rem-tell-input-js', REM_URL . '/assets/front/js/intlTelInput-jquery.js', array('jquery'));
            }

            // Imagesfill and Loaded
            wp_enqueue_script( 'rem-imagefill-js', REM_URL . '/assets/front/lib/imagefill.min.js', array('jquery'));   
            wp_enqueue_script( 'rem-imagesloaded-js', REM_URL . '/assets/front/lib/imagesloaded.min.js', array('jquery'));   
            
            // Page Specific
            wp_enqueue_style( 'rem-single-property-css', REM_URL . '/assets/front/css/single-property.css' );

            if (rem_single_property_has_map($post->ID)) {
                $property_id = ($post->post_parent) ? $post->post_parent : $property_id;
                $latitude = get_post_meta($property_id, 'rem_property_latitude', true);
                $longitude = get_post_meta($property_id, 'rem_property_longitude', true);
                $address = get_post_meta($property_id, 'rem_property_address', true);
                $city = get_post_meta($property_id, 'rem_property_city', true);
                $state = get_post_meta($property_id, 'rem_property_state', true);
                $country = get_post_meta($property_id, 'rem_property_country', true);
                $zoom = rem_get_option( 'maps_zoom_level', 10);
                $map_type = rem_get_option( 'maps_type', 'roadmap');
                $maps_api = apply_filters( 'rem_maps_api', 'AIzaSyBbpbij9IIXGftKhFLMHOuTpAbFoTU_8ZQ');
                $maps_icon_url = apply_filters( 'rem_maps_location_icon', REM_URL . '/assets/images/pin-maps.png', $post->ID );
                $load_map_from = ($latitude == '' || $longitude == '') ? 'address' : 'coords' ;
                if ($disable_map_script != "yes") {
                    
                    if (rem_get_option('use_map_from', 'leaflet') == 'leaflet') {
                        wp_enqueue_style( 'rem-leaflet-css', REM_URL . '/assets/front/leaflet/leaflet.css');
                        wp_enqueue_script( 'rem-leaflet-js', REM_URL . '/assets/front/leaflet/leaflet.js', array('jquery'));
                    } else {
                        if (is_ssl()) {
                            wp_enqueue_script( 'rem-single-property-map', 'https://maps.googleapis.com/maps/api/js?key='.$maps_api);
                        } else {
                            wp_enqueue_script( 'rem-single-property-map', 'http://maps.googleapis.com/maps/api/js?key='.$maps_api);
                        }
                    }
                }
                $icons_size = rem_get_option('leaflet_icons_size', '43x47');
                $icons_anchor = rem_get_option('leaflet_icons_anchor', '18x47');

                $localize_vars = array(
                    'use_map_from' => rem_get_option('use_map_from', 'leaflet'),
                    'grid_view_txt' => rem_get_option('grid_view_txt'),
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'zoom' => $zoom,
                    'map_type' => $map_type,
                    'leaflet_styles' => rem_get_leaflet_provider(rem_get_option('leaflet_style')),
                    'address' => implode( ' ', array_filter( array( $address, $city, $state, $country ) ) ),
                    'load_map_from' => $load_map_from,
                    'maps_icon_url' => $maps_icon_url,
                    'icons_size' => explode("x", $icons_size),
                    'icons_anchor' => explode("x", $icons_anchor),
                    'maps_styles' => stripcslashes(rem_get_option('maps_styles')),
                    'property_map_location_style' => rem_get_option('property_map_location_style', 'pin'),
                    'property_map_radius' => rem_get_option('property_map_radius', '100'),
                    'rem_main_color' => rem_get_option('rem_main_color', '#1FB7A6'),
                );
            }
            
            wp_enqueue_script( 'rem-single-property-js', REM_URL . '/assets/front/js/single-property.js', array('jquery'));

            if (isset($localize_vars)) {
                wp_localize_script( 'rem-single-property-js', 'rem_property_map', $localize_vars );
            } else {
                $localize_vars = array(
                    'latitude' => 'disable',
                    'grid_view_txt' => rem_get_option('grid_view_txt'),
                );                
                wp_localize_script( 'rem-single-property-js', 'rem_property_map', $localize_vars );
            }

        }
        if(is_author()){
            global $wp_query;
            $curauth = $wp_query->get_queried_object();
            $author_info = $curauth;
            $author_id = $curauth->ID;
            $load_tem = true;
            if(rem_get_option('agent_page', 'all') == 'agent'){
                if ( in_array( 'rem_property_agent', (array) $curauth->roles ) ) {
                    $load_tem = true;
                } else {
                    $load_tem = false;
                }
            }
            
            if ( $load_tem ) {
                rem_load_bs_and_fa();
                rem_load_basic_styles();
                wp_enqueue_style( 'rem-skillbars-css', REM_URL . '/assets/front/lib/skill-bars.css' );

                // Imagesfill and Loaded
                wp_enqueue_script( 'rem-imagefill-js', REM_URL . '/assets/front/lib/imagefill.min.js', array('jquery'));   
                wp_enqueue_script( 'rem-imagesloaded-js', REM_URL . '/assets/front/lib/imagesloaded.min.js', array('jquery'));   

                if (rem_get_option('property_page_phone') == 'intltelinput') {
                    wp_enqueue_style( 'rem-tell-input', REM_URL . '/assets/front/css/intlTelInput.min.css');
                    wp_enqueue_script( 'rem-tell-input-js', REM_URL . '/assets/front/js/intlTelInput-jquery.js', array('jquery'));
                }
                // Carousel
                wp_enqueue_style( 'rem-carousel-css', REM_URL . '/assets/front/lib/slick.css' );
                wp_enqueue_script( 'rem-carousel-js', REM_URL . '/assets/front/lib/slick.min.js', array('jquery'));

                // Page Specific
                wp_enqueue_style( 'rem-archive-property-css', REM_URL . '/assets/front/css/archive-property.css' );
                wp_enqueue_style( 'rem-profile-agent-css', REM_URL . '/assets/front/css/profile-agent.css' );
                wp_enqueue_script( 'rem-profile-agent-js', REM_URL . '/assets/front/js/profile-agent.js', array('jquery'));
            }            
        }
        if (is_archive() && $layout_archive == 'plugin') {
            global $post;
            if (isset($post->post_type) && $post->post_type == 'rem_property') {
                rem_load_bs_and_fa();
                rem_load_basic_styles();

                // Imagesfill and Loaded
                wp_enqueue_script( 'rem-imagefill-js', REM_URL . '/assets/front/lib/imagefill.min.js', array('jquery'));   
                wp_enqueue_script( 'rem-imagesloaded-js', REM_URL . '/assets/front/lib/imagesloaded.min.js', array('jquery'));   
                
                // Page Specific
                wp_enqueue_style( 'rem-archive-property-css', REM_URL . '/assets/front/css/archive-property.css' );
                wp_enqueue_script( 'rem-tooltip', REM_URL . '/assets/front/lib/tooltip.js', array('jquery'));
                wp_enqueue_script( 'rem-archive-property-js', REM_URL . '/assets/front/js/archive-property.js', array('jquery'));
            }
        }
    }

    function rem_role_cap(){

        if (!$GLOBALS['wp_roles']->is_role( 'rem_property_agent' )) {
            add_role(
                'rem_property_agent',
                __( 'Property Agent', 'real-estate-manager' ),
                array(
                    'read' => true,
                    'edit_posts' => true,
                    'delete_posts' => false,
                    'publish_posts' => false,
                    'upload_files' => true,
                )
            );
            flush_rewrite_rules();
        }

        $roles = array('rem_property_agent', 'editor', 'administrator');

        // Loop through each role and assign capabilities
        foreach($roles as $the_role) { 

            $role = get_role($the_role);

            if ($role) {
                $role->add_cap( 'read' );
                $role->add_cap( 'read_rem_property');
                $role->add_cap( 'read_private_rem_properties' );
                $role->add_cap( 'edit_rem_property' );
                $role->add_cap( 'edit_rem_properties' );

                if($the_role == 'administrator'){
                    $role->add_cap( 'edit_others_rem_properties' );
                    $role->add_cap( 'delete_others_rem_properties' );
                    if (rem_get_option('property_submission_mode') == 'approve') {
                        $role->add_cap( 'publish_rem_properties' );
                    }
                }
                if (rem_get_option('property_submission_mode') == 'publish') {
                    $role->add_cap( 'publish_rem_properties' );
                }
                $role->add_cap( 'edit_published_rem_properties' );
                $role->add_cap( 'delete_private_rem_properties' );
                $role->add_cap( 'delete_published_rem_properties' );
            }
        }
    }

    function rem_agent_extra_fields($user){
        include REM_PATH . '/inc/menu/agent-profile-fields.php';
    }

    function save_rem_agent_fields($user_id){
        if (
            current_user_can( 'edit_user', $user_id ) &&
            isset( $_POST['rem_agent_fields_nonce'] ) &&
            check_admin_referer( 'rem_save_agent_fields', 'rem_agent_fields_nonce' )
        ){
            $agent_fields = $this->get_agent_fields();
            foreach ($agent_fields as $field) {
                if (isset($_POST[$field['key']])) {
                    update_user_meta( $user_id, $field['key'], $_POST[$field['key']] );
                    rem_wpml_register($_POST[$field['key']], 'Agent', $field['key'].'_'.$user_id);
                }
            }
            if (isset($_POST['display_name']) && $_POST['display_name'] != '') {
                rem_wpml_register($_POST['display_name'], 'Agent', 'display_name_'.$user_id);
            }
        }
    }

    function listings_quick_edit_fields( $column_name, $post_type ){
        if($post_type == 'rem_property'){
            $admin_quick_edit = rem_get_option('admin_quick_edit', "property_type \n property_purpose \n property_status \n property_price");
            if ($admin_quick_edit != '') {
                $field_keys = array_map('trim', explode("\n", $admin_quick_edit));
                $all_fields = $this->single_property_fields();
                foreach ($all_fields as $fieldData) {
                    if (isset($fieldData['key']) && in_array($fieldData['key'], $field_keys) && $fieldData['key'] == $column_name) {
                        echo '<table><tr>';
                            echo '<td>';
                                echo '<span class="title">'.$fieldData['title'].'</span>';
                            echo '</td>';
                            echo '<td>';
                                rem_render_field($fieldData, true);
                                wp_nonce_field( 'rem_quick_edit', '_rem_quick_edit_nonce' );
                            echo '</td>';
                        echo '</tr></table>';
                    }
                }
            }
        }
    }

    function get_all_property_features(){

        $property_individual_cbs = array(
            __( 'Attic', 'real-estate-manager' ),
            __( 'Gas Heat', 'real-estate-manager' ),
            __( 'Balcony', 'real-estate-manager' ),
            __( 'Wine Cellar', 'real-estate-manager' ),
            __( 'Basketball Court', 'real-estate-manager' ),
            __( 'Trash Compactors', 'real-estate-manager' ),
            __( 'Fireplace', 'real-estate-manager' ),
            __( 'Pool', 'real-estate-manager' ),
            __( 'Lake View', 'real-estate-manager' ),
            __( 'Solar Heat', 'real-estate-manager' ),
            __( 'Separate Shower', 'real-estate-manager' ),
            __( 'Wet Bar', 'real-estate-manager' ),
            __( 'Remodeled', 'real-estate-manager' ),
            __( 'Skylights', 'real-estate-manager' ),
            __( 'Stone Surfaces', 'real-estate-manager' ),
            __( 'Golf Course', 'real-estate-manager' ),
            __( 'Health Club', 'real-estate-manager' ),
            __( 'Backyard', 'real-estate-manager' ),
            __( 'Pet Allowed', 'real-estate-manager' ),
            __( 'Office/Den', 'real-estate-manager' ),
            __( 'Laundry', 'real-estate-manager' ),
        );

        if(has_filter('rem_property_features')) {
            $property_individual_cbs = apply_filters('rem_property_features', $property_individual_cbs);
        }

        return $property_individual_cbs;
    }

    function get_all_property_types(){

        $property_type_options  = array(
            __( 'Duplex', 'real-estate-manager' )   => __( 'Duplex', 'real-estate-manager' ),
            __( 'House', 'real-estate-manager' )    => __( 'House', 'real-estate-manager' ),
            __( 'Office', 'real-estate-manager' )   => __( 'Office', 'real-estate-manager' ),
            __( 'Retail', 'real-estate-manager' )   => __( 'Retail', 'real-estate-manager' ),
            __( 'Vila', 'real-estate-manager' )     => __( 'Vila', 'real-estate-manager' ),
        );

        if(has_filter('rem_property_types')) {
            $property_type_options = apply_filters('rem_property_types', $property_type_options);
        }

        return $property_type_options;
    }

    function get_all_property_purpose(){
        
        $property_purpose_options  = array(
           __( 'Rent', 'real-estate-manager' )  => __( 'Rent', 'real-estate-manager' ) ,
           __( 'Sell', 'real-estate-manager' )  => __( 'Sell', 'real-estate-manager' ) ,
        );

        if(has_filter('rem_property_purposes')) {
            $property_purpose_options = apply_filters('rem_property_purposes', $property_purpose_options);
        }

        return $property_purpose_options;
    }

    function get_all_property_status(){

        $property_status_options  = array(
            __( 'Normal', 'real-estate-manager' )       => __( 'Normal', 'real-estate-manager' ),
            __( 'Available', 'real-estate-manager' )    => __( 'Available', 'real-estate-manager' ),
            __( 'Not Available', 'real-estate-manager' )=> __( 'Not Available', 'real-estate-manager' ),
            __( 'Sold', 'real-estate-manager' )         => __( 'Sold', 'real-estate-manager' ),
            __( 'Open House', 'real-estate-manager' )   => __( 'Open House', 'real-estate-manager' ),
        );
        
        if(has_filter('rem_property_statuses')) {
            $property_status_options = apply_filters('rem_property_statuses', $property_status_options);
        }

        return $property_status_options;
    }

    function send_email_agent(){
        if ( ! wp_verify_nonce( $_REQUEST['rem_contact_nonce'], 'rem-contact-nonce' ) ) {
            die ( 'Nonce Failed!');
        } else {
            if (isset($_REQUEST) && $_REQUEST != '') {

                if (isset($_REQUEST['g-recaptcha-response'])) {
                    if (!$_REQUEST['g-recaptcha-response']) {
                        $resp = array('fail' => 'already', 'msg' => __( 'Please check the captcha form.', 'real-estate-manager' ));
                        echo wp_json_encode($resp); exit;
                    } else {
                        $captcha = $_REQUEST['g-recaptcha-response'];
                        $secretKey = rem_get_option('captcha_secret_key', '6LcDhUQUAAAAAGKQ7gd1GsGAkEGooVISGEl3s7ZH');
                        $ip = $_SERVER['REMOTE_ADDR'];
                        $response = wp_remote_post("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
                        $responseKeys = json_decode($response['body'], true);
                        if(intval($responseKeys["success"]) !== 1) {
                            $resp = array('fail' => 'error', 'msg' => __( 'There was an error. Please try again after reloading page', 'real-estate-manager' ));
                            echo wp_json_encode($resp); exit;
                        }
                    }
                }

                // Gather the form data
                $client_name = (isset($_REQUEST['client_name'])) ? sanitize_text_field( $_REQUEST['client_name'] ) : '' ;
                $client_email = (isset($_REQUEST['client_email'])) ? sanitize_email( $_REQUEST['client_email'] ) : '' ;
                $client_phone = (isset($_REQUEST['client_phone'])) ? sanitize_text_field( $_REQUEST['client_phone'] ) : '' ;
                $client_msg = (isset($_REQUEST['client_msg'])) ? sanitize_text_field( $_REQUEST['client_msg'] ) : '' ;
                $agent_id = (isset($_REQUEST['agent_id'])) ? intval( $_REQUEST['agent_id'] ) : '' ;
                
                if($client_name && $client_email && $client_msg && $agent_id){
                    
                    $subject = rem_get_option('c_email_subject', 'Listing Contact');
                    $message = rem_get_option('c_email_msg', $client_msg);
                    
                    // if property id is available
                    if (isset($_REQUEST['property_id']) && $_REQUEST['property_id'] != '') {
                        $property_id = intval($_REQUEST['property_id']);
                        $property_title = esc_attr( get_the_title( $property_id ) );
                        $subject = str_replace("%property_title%", $property_title, $subject);
                        $subject = str_replace("%property_id%", $property_id, $subject);

                        $message = str_replace("%property_id%", $property_id, $message);
                        $message = str_replace("%property_title%", $property_title, $message);
                        $message = str_replace("%property_url%", get_permalink( $property_id ), $message);
                    }

                    $message = str_replace("%user_message%", $client_msg, $message);
                    $message = str_replace("%client_message%", $client_msg, $message);
                    $message = str_replace("%user_email%", $client_email, $message);
                    $message = str_replace("%client_email%", $client_email, $message);
                    $message = str_replace("%client_name%", $client_name, $message);
                    $message = str_replace("%phone%", $client_phone, $message);
                    $message = str_replace("%client_phone%", $client_phone, $message);
                    
                    if (rem_get_option('email_br', 'enable') == 'enable') {
                       $message = nl2br(stripcslashes($message));
                    }

                    $message = apply_filters( 'rem_agent_contact_email_message', $message, $_REQUEST );

                    $agent_info = get_userdata($agent_id);
                    $agent_email = $agent_info->user_email;

                    $headers = array();
                    $headers[] = "From: {$client_name} <{$client_email}>";
                    $headers[] = "Content-Type: text/html";
                    $headers[] = "MIME-Version: 1.0\r\n";

                    $headers = apply_filters( 'rem_email_headers', $headers );
                    
                    // Additional Emails
                    $emails_meta = rem_get_option('email_agent_contact', '');            
                    if ($emails_meta != '') {
                        $emails = explode("\n", $emails_meta);
                        if (is_array($emails)) {
                            foreach ($emails as $e) {
                                $headers[] = "Cc: $e";
                            }
                        }
                    }

                    // Finally send the emails
                    if (wp_mail( $agent_email, $subject, $message, $headers )) {
                        $resp = array('status' => 'sent', 'msg' => __( 'Email Sent Successfully', 'real-estate-manager' ) );
                    } else {
                        $resp = array('status' => 'fail', 'msg' => __( 'There is some problem, please try later', 'real-estate-manager' ) );
                    }

                    echo wp_json_encode($resp); die(0);

                } else {
                    $resp = array('fail' => 'error', 'msg' => __( 'Please fill the required fields.', 'real-estate-manager' ));
                    echo wp_json_encode($resp); exit;
                }
            }

        }
    }

    function get_country_states(){
        if ( ! wp_verify_nonce( $_POST['nonce'], 'rem-nonce-states' ) ) {
            die ( 'Nonce Failed!');
        } else {
            if (isset($_REQUEST['country']) && $_REQUEST['country'] != '') {
                $countries_obj   = new REM_Countries();
                $states   = $countries_obj->get_states($_REQUEST['country']);
                $html = '<option value="">-- '.esc_html(__( 'State', 'real-estate-manager' )).' --</option>';
                if (!empty($states)) {
                    foreach ($states as $key => $value) {
                        $html .= '<option value="'.esc_attr($key).'">'.esc_html($value).'</option>';
                    }
                }

                // This variable $html is already escaped above
                echo $html;
                die(0);
            }
        }
    }

    function menu_pages(){
        add_submenu_page( 'edit.php?post_type=rem_property', 'Real Estate Manager - Custo5m Fields Section', __( 'Field Sections (Pro)', 'real-estate-manager' ), 'manage_options', 'rem_custom_field_sections', array($this, 'render_custom_field_sections_page') );
        add_submenu_page( 'edit.php?post_type=rem_property', 'Real Estate Manager - Custom Fields', __( 'Property Fields (Pro)', 'real-estate-manager' ), 'manage_options', 'rem_custom_fields', array($this, 'render_custom_fields_page') );
        add_submenu_page( 'edit.php?post_type=rem_property', 'Real Estate Manager - Agent Fields', __( 'Agent Meta Fields', 'real-estate-manager' ), 'manage_options', 'rem_agent_registration', array($this, 'render_agent_fields_page') );
        add_submenu_page( 'edit.php?post_type=rem_property', 'All Property Agents', __( 'Agents', 'real-estate-manager' ), 'manage_options', 'rem_property_agents', array($this, 'render_agents_page') );
        add_submenu_page( 'edit.php?post_type=rem_property', 'Real Estate Manager - Settings', __( 'Settings', 'real-estate-manager' ), 'manage_options', 'rem_settings', array($this, 'render_settings_page') );
        add_submenu_page( 'edit.php?post_type=rem_property', 'Real Estate Manager - Extensions', __( 'Addons', 'real-estate-manager' ), 'manage_options', 'rem_extensions', array($this, 'render_ext_page') );
        add_submenu_page( 'edit.php?post_type=rem_property', 'Real Estate Manager - Tools', __( 'Tools', 'real-estate-manager' ), 'manage_options', 'rem_documentation', array($this, 'render_docs_page') );
    }

    function render_custom_fields_page(){
        include_once REM_PATH. '/inc/menu/property-fields-builder/menu-page.php';
    }
    
    function render_custom_field_sections_page(){
        include_once REM_PATH. '/inc/menu/field-sections-page.php';
    }

    function render_agent_fields_page(){
        include_once REM_PATH. '/inc/menu/agent-fields-builder/menu-page.php';
    }

    function render_agents_page(){
        include_once REM_PATH. '/inc/menu/page-agents.php';
    }

    function render_docs_page(){
        include_once REM_PATH. '/inc/menu/page-docs.php';
    }

    function render_ext_page(){
        include_once REM_PATH. '/inc/menu/page-extensions.php';
    }

    function render_settings_page(){
        include_once REM_PATH. '/inc/menu/page-settings.php';
    }

    function deny_agent(){
        $nonce = isset( $_REQUEST['nonce'] ) ? sanitize_text_field( $_REQUEST['nonce'] ) : '';
        $userindex = isset( $_REQUEST['userindex'] ) ? sanitize_text_field( $_REQUEST['userindex'] ) : '';

        if ( ! wp_verify_nonce( $nonce, 'rem-nonce-deny' ) ) {
            die ( 'Nonce Denied!');
        } else {
            if (isset($_REQUEST) && current_user_can( 'manage_options' )) {
                $pending_agents = get_option( 'rem_pending_users' );
                if (isset($pending_agents[$userindex])) {
                    do_action( 'rem_new_agent_rejected', $pending_agents[$userindex] );
                    unset($pending_agents[$userindex]);
                    update_option( 'rem_pending_users', $pending_agents );
                }
            }
            die(0);
        }
    }

    function approve_agent(){
        $nonce = isset( $_REQUEST['nonce'] ) ? sanitize_text_field( $_REQUEST['nonce'] ) : '';
        $userindex = isset( $_REQUEST['userindex'] ) ? sanitize_text_field( $_REQUEST['userindex'] ) : '';

        if ( ! wp_verify_nonce( $nonce, 'rem-nonce-approve' ) ) {
            die ( 'Nonce Denied!');
        } else {
            if (isset($_REQUEST) && current_user_can( 'manage_options' )) {
                $pending_agents = get_option( 'rem_pending_users' );

                if (isset($pending_agents[$userindex])) {
                    $new_agent = $pending_agents[$userindex];

                    // Sanitize each value in the new agent data
                    foreach ($new_agent as $key => $value) {
                        $new_agent[$key] = sanitize_text_field( $value );
                    }

                    extract($new_agent);

                    $agent_id = wp_create_user( $username, $password, $useremail );

                    do_action( 'rem_new_agent_approved', $new_agent );

                    if ($agent_id != '') {
                        wp_update_user( array( 'ID' => $agent_id, 'role' => 'rem_property_agent' ) );
                        // WPML Language
                        if (isset($_REQUEST['wpml_user_email_language'])) {
                            update_user_meta( $agent_id, 'icl_admin_language', sanitize_text_field( $_REQUEST['wpml_user_email_language'] ) );
                        }
                    }

                    $agent_fields = $this->get_agent_fields();

                    foreach ($agent_fields as $field) {
                        if (isset($new_agent[$field['key']])) {
                            update_user_meta( $agent_id, $field['key'], sanitize_text_field( $new_agent[$field['key']] ) );
                        }
                    }

                    if (!empty($new_agent['agent_longitude'])) {
                        update_user_meta( $agent_id, 'agent_longitude', sanitize_text_field( $new_agent['agent_longitude'] ) );
                    }
                    if (!empty($new_agent['agent_latitude'])) {
                        update_user_meta( $agent_id, 'agent_latitude', sanitize_text_field( $new_agent['agent_latitude'] ) );
                    }

                    unset($pending_agents[$userindex]);

                    update_option( 'rem_pending_users', $pending_agents );
                }
            }

            die(0);
        }
    }

    function create_pages_auto(){
        if (isset($_REQUEST) && wp_verify_nonce( $_REQUEST['nonce'], 'rem-nonce-pages' ) ) {
            
            $rempages = array(
                array(
                    'title' => 'All Listings Page',
                    'content' => '[rem_list_properties style="1" top_bar="enable" posts="9"]'
                ),
                array(
                    'title' => 'Search Properties Page',
                    'content' => '[rem_search_property fields_to_show="search,property_price,property_type,property_purpose,property_status,property_bedrooms,property_bathrooms,property_country" columns="3"][rem_list_properties posts="9" style="2" class="col-md-4" masonry="enable"][/rem_search_property]'
                ),
                array(
                    'title' => 'Create Property Page',
                    'content' => '[rem_create_property][rem_agent_login heading="Please login below to create a listing."][/rem_create_property]'
                ),
                array(
                    'title' => 'Agent Registration Page',
                    'content' => '[rem_register_agent]You are already logged in![/rem_register_agent]'
                ),
                array(
                    'title' => 'Agent Login Page',
                    'content' => '[rem_agent_login heading="Please Provide Email and Password"]'
                ),
                array(
                    'title' => 'Edit Profile Page',
                    'content' => '[rem_agent_edit][rem_agent_login heading="Please login below to edit your profile."][/rem_agent_edit]'
                ),
                array(
                    'title' => 'Edit Property Page',
                    'content' => '[rem_edit_property]'
                ),
                array(
                    'title' => 'My Properties Page',
                    'content' => '[rem_my_properties][rem_agent_login heading="Please login below to manage your properties.][/rem_my_properties]'
                ),
            );
            
            foreach ($rempages as $pagedata) {
                wp_insert_post( array(
                    'post_title'    => wp_strip_all_tags( $pagedata['title'] ),
                    'post_content'  => $pagedata['content'],
                    'post_status'   => 'publish',
                    'post_type'     => 'page',
                ) );
            }

            update_option( 'rem_basic_pages_created', true );

        } else {
            die ( 'Nonce Failed!');
        }
    }
    
    static function rem_activated(){
        /*
         * Adding Custom Role 'rem_property_agent'
         */
        $roles_set = get_option('rem_role_isset');

        if(!$roles_set){
            add_role(
                'rem_property_agent',
                __( 'Property Agent', 'real-estate-manager' ),
                array(
                    'read' => true,
                    'edit_posts' => true,
                    'delete_posts' => false,
                    'publish_posts' => false,
                    'upload_files' => true,
                )
            );
            flush_rewrite_rules();
            update_option('rem_role_isset', true);
        }
    }

    function rem_templates($template){

        if (class_exists('Landz_Theme_Init')) {
            return $template;
        }

        $layout_agent = rem_get_option('agent_page_layout', 'plugin');
        $layout_archive = rem_get_option('archive_property_layout', 'plugin');
        $property_layout = rem_get_option('single_property_layout', 'plugin');

        if (is_author() && $layout_agent == 'plugin') {
            global $wp_query;
            $curauth = $wp_query->get_queried_object();
            $author_info = $curauth;
            $author_id = $curauth->ID;
            $load_tem = true;
            if(rem_get_option('agent_page', 'all') == 'agent'){
                if ( in_array( 'rem_property_agent', (array) $curauth->roles ) ) {
                    $load_tem = true;
                } else {
                    $load_tem = false;
                }
            }
            if ( $load_tem ) {
                $template = REM_PATH . '/templates/agent.php';
            }
        }

        if (is_archive() && $layout_archive == 'plugin') {
            global $post;
            if (isset($post->post_type) && $post->post_type == 'rem_property') {
                $template = REM_PATH . '/templates/list-properties.php';
            }
        }

        if (is_singular( 'rem_property' )) {

            $queried = get_queried_object();

            if ( $queried->post_type == 'rem_property' ) {
                
                // Is child
                if ($queried->post_parent) {
                    $child_layout = rem_get_option('child_property_layout', 'default');
                    
                    // Load from Theme
                    if ( $child_layout == 'theme' ) {
                        return locate_template( 'child-rem_property' );
                    } else {
                        $template = REM_PATH . '/templates/child/'.$child_layout.'.php';
                    }
                } else {
                    // Load from Theme
                    if ( $property_layout == 'theme' ) {
                        if(file_exists(get_stylesheet_directory() . '/single-rem_property.php')){
                            return get_stylesheet_directory() . '/single-rem_property.php';
                        } else {
                            return $template;
                        }
                    }

                    // Auto Detect
                    if ( $property_layout == 'auto' ) {

                        $theme = wp_get_theme();
                        $template_path = REM_PATH.'/templates/single/'.$theme.'.php';
                        if (file_exists($template_path)) {
                            $template = $template_path;
                        } else {
                            $template = REM_PATH . '/templates/single/default.php';
                        }

                        return $template;

                    }

                    // Other Templates
                    $template = REM_PATH . '/templates/single/'.$property_layout.'.php';

                    if ($property_layout == 'plugin') {
                        $template = REM_PATH . '/templates/single/default.php';
                    }
                }
            }
        }

        return $template;
    }

    function admin_settings_fields(){

        include REM_PATH.'/inc/menu/admin-settings-arr.php';

        return $fieldsData;
    }

    function render_setting_field($field){
        ob_start();
        include REM_PATH.'/inc/menu/render-admin-settings.php';
        $field_html = ob_get_clean();
        return apply_filters( 'rem_admin_settings_field_raw_html', $field_html, $field );
    }

    function save_admin_settings(){
        if (isset($_REQUEST) && wp_verify_nonce( $_REQUEST['rem_nonce_settings'], 'rem-nonce-settings' )) {
            $resp = array('status' => '', 'title' => '', 'message' => '');
            
            $rem_settings = $_REQUEST;
            if (isset($_REQUEST['property_detail_fields']) && $_REQUEST['property_detail_fields'] != '') {
                $features_arr = explode("\n", stripcslashes($_REQUEST['property_detail_fields']));
                $rem_settings['property_detail_fields'] = array();
                foreach ($features_arr as $feature) {
                    $feature = trim($feature);
                    rem_wpml_register($feature, 'real-estate-manager-features');
                    $rem_settings['property_detail_fields'][] = $feature;
                }
            }
            if (update_option( 'rem_all_settings', $rem_settings )) {
                $resp['status'] = 'success';
                $resp['title'] = __( 'Settings Saved!', 'real-estate-manager' );
                $resp['message'] = __( 'Settings are saved in the database successfully.', 'real-estate-manager' );
                if (isset($_REQUEST['property_submission_mode'])) {
                    $role = get_role( 'rem_property_agent' );
                    if ($_REQUEST['property_submission_mode'] == 'publish') {
                        $role->add_cap( 'publish_rem_properties' );
                    } elseif ($_REQUEST['property_submission_mode'] == 'approve') {
                        $role->remove_cap( 'publish_rem_properties' );
                    }
                }
            } else {
                $resp['status'] = 'error';
                $resp['title'] = __( 'Failed!', 'real-estate-manager' );
                $resp['message'] = __( 'There is some error or you did not make any change.', 'real-estate-manager' );
            }
            echo wp_json_encode($resp);
        }
        die(0);
    }

    function property_messages( $messages ) {
        $post             = get_post();
        $post_type        = get_post_type( $post );
        $post_type_object = get_post_type_object( $post_type );

        $messages['rem_property'] = array(
            0  => '', // Unused. Messages start at index 1.
            1  => __( 'Property updated.', 'real-estate-manager' ),
            2  => __( 'Custom field updated.', 'real-estate-manager' ),
            3  => __( 'Custom field deleted.', 'real-estate-manager' ),
            4  => __( 'Property updated.', 'real-estate-manager' ),
            /* translators: %s: date and time of the revision */
            5  => isset( $_GET['revision'] ) ? sprintf( __( 'Property restored to revision', 'real-estate-manager' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
            6  => __( 'Property published.', 'real-estate-manager' ),
            7  => __( 'Property saved.', 'real-estate-manager' ),
            8  => __( 'Property submitted.', 'real-estate-manager' ),
            9  => sprintf(
                __( 'Property scheduled.', 'real-estate-manager' ),
                // translators: Publish box date format, see http://php.net/date
                date_i18n( __( 'M j, Y @ G:i', 'real-estate-manager' ), strtotime( $post->post_date ) )
            ),
            10 => __( 'Property draft updated.', 'real-estate-manager' )
        );

        if ( $post_type_object->publicly_queryable && 'rem_property' === $post_type ) {
            $permalink = get_permalink( $post->ID );

            $view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View Property', 'real-estate-manager' ) );
            $messages[ $post_type ][1] .= $view_link;
            $messages[ $post_type ][6] .= $view_link;
            $messages[ $post_type ][9] .= $view_link;

            $preview_permalink = add_query_arg( 'preview', 'true', $permalink );
            $preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview Property', 'real-estate-manager' ) );
            $messages[ $post_type ][8]  .= $preview_link;
            $messages[ $post_type ][10] .= $preview_link;
        }

        return $messages;
    }

    function single_property_fields(){
        $area_unit = rem_get_option('properties_area_unit', 'Sq Ft');
        $saved_fields = get_option( 'rem_property_fields' );
        $inputFields  = array();
        if ($saved_fields != '' && is_array($saved_fields)) {
            $inputFields = $saved_fields;
        } else {
            include REM_PATH.'/inc/arrays/property-fields.php';
        }

        if(has_filter('rem_property_settings_fields')) {
            $inputFields = apply_filters('rem_property_settings_fields', $inputFields);
        }

        return $inputFields;
    }

    function get_all_property_fields(){
        $inputFields = array();
        include REM_PATH . '/inc/admin/single-property-fields.php';
        return apply_filters( 'rem_all_input_fields', $inputFields );
    }

    function author_override($output){
        global $post, $user_ID;
        if (isset($post->post_type) && 'rem_property' === $post->post_type) {

            // return if this isn't the theme author override dropdown
            if (!preg_match('/post_author_override/', $output)) return $output;

            // return if we've already replaced the list (end recursion)
            if (preg_match ('/post_author_override_replaced/', $output)) return $output;

            // replacement call to wp_dropdown_users
            $output = wp_dropdown_users(array(
                'echo' => 0,
                'name' => 'post_author_override_replaced',
                'selected' => empty($post->ID) ? $user_ID : $post->post_author,
                'include_selected' => true
            ));

            // put the original name back
            $output = preg_replace('/post_author_override_replaced/', 'post_author_override', $output);

        }

        return $output;

    }

    function permalink_settings(){
        if ( isset($_POST['rem_nonce_permalinks']) && wp_verify_nonce( $_POST['rem_nonce_permalinks'], 'rem-nonce-permalinks' ) ) {
            if( isset( $_POST['rem_property_permalink'] ) ){
                update_option( 'rem_property_permalink', sanitize_title_with_dashes( $_POST['rem_property_permalink'] ) );
            }
            if( isset( $_POST['rem_category_permalink'] ) ){
                update_option( 'rem_category_permalink', sanitize_title_with_dashes( $_POST['rem_category_permalink'] ) );
            }
            if( isset( $_POST['rem_tag_permalink'] ) ){
                update_option( 'rem_tag_permalink', sanitize_title_with_dashes( $_POST['rem_tag_permalink'] ) );
            }
            
        }
        // Add setting fields to the permalink page
        add_settings_section( 'rem_permalink_settings', 'Real Estate Manager Permalinks', array($this, 'render_property_permalink_field'), 'permalink' );
    }


    function render_property_permalink_field(){
        $property_base = get_option( 'rem_property_permalink' );
        $property_slug = ($property_base != '') ? $property_base : 'property' ;

        $category_base = get_option( 'rem_category_permalink' );
        $category_slug = ($category_base != '') ? $category_base : 'property_category' ;

        $tag_base = get_option( 'rem_tag_permalink' );
        $tag_slug = ($tag_base != '') ? $tag_base : 'property_tag' ;
        ?>
        <input type="hidden" name="rem_nonce_permalinks" value="<?php echo wp_create_nonce('rem-nonce-permalinks'); ?>">
        <table class="form-table">
            <tr>
                <th><label for="rem_property_permalink"><?php esc_attr_e( 'Property Page Base' , 'real-estate-manager' ); ?></label></th>
                <td><input type="text" value="<?php echo esc_attr( $property_slug ); ?>" name="rem_property_permalink" id="rem_property_permalink" class="regular-text" /></td>
            </tr>
            <tr>
                <th><label for="rem_category_permalink"><?php esc_attr_e( 'Property Category Base' , 'real-estate-manager' ); ?></label></th>
                <td><input type="text" value="<?php echo esc_attr( $category_slug ); ?>" name="rem_category_permalink" id="rem_category_permalink" class="regular-text" /></td>
            </tr>
            <tr>
                <th><label for="rem_tag_permalink"><?php esc_attr_e( 'Property Tag Base' , 'real-estate-manager' ); ?></label></th>
                <td><input type="text" value="<?php echo esc_attr( $tag_slug ); ?>" name="rem_tag_permalink" id="rem_tag_permalink" class="regular-text" /></td>
            </tr>
        </table>
        <?php
    }

    function add_category_image( $taxonomy ){
        include REM_PATH.'/inc/admin/add-category-image.php';
    }

    function save_category_image( $term_id, $tt_id ) {
       if( isset( $_POST['category_image_id'] ) && wp_verify_nonce( $_POST['rem_nonce_add_category_img'], 'rem-nonce-add-category-img' ) && '' !== $_POST['category_image_id'] ){
        $image = $_POST['category_image_id'];
        add_term_meta( $term_id, 'category-image-id', sanitize_text_field($image), true );
       }
    }
    function edit_category_image( $term, $taxonomy ) {
        include REM_PATH.'/inc/admin/edit-category-image.php';
    }
    function update_category_image( $term_id, $tt_id ) {
        if (isset($_POST['rem_nonce_edit_category_img']) && wp_verify_nonce( $_POST['rem_nonce_edit_category_img'], 'rem-nonce-edit-category-img' )) {
           if( isset( $_POST['category_image_id'] ) && '' !== $_POST['category_image_id'] ){
             $image = $_POST['category_image_id'];
             update_term_meta ( $term_id, 'category-image-id', sanitize_text_field($image) );
           } else {
             update_term_meta ( $term_id, 'category-image-id', '' );
           }
        }
    }

    function get_agent_fields(){
        $saved_fields = get_option( 'rem_agent_fields' );
        $fields  = array();
        if ($saved_fields != '' && is_array($saved_fields)) {
            $fields = $saved_fields;
        } else {
            include REM_PATH.'/inc/arrays/agent-fields.php';
        }

        $fields = apply_filters( 'rem_agent_fields', $fields );

        return $fields;
    }

    function rem_property_column_head($defaults){
        $admin_columns = rem_get_option('admin_columns');
        if ($admin_columns != '') {
            $field_keys = array_map('trim', explode("\n", $admin_columns));
            $all_fields = $this->single_property_fields();
            foreach ($all_fields as $fieldData) {
                if (isset($fieldData['key']) && in_array($fieldData['key'], $field_keys)) {
                    $defaults[$fieldData['key']] = $fieldData['title'];
                }
            }
        } else {
            $defaults['property_type'] = __( 'Type', 'real-estate-manager' );
            $defaults['property_purpose'] = __( 'Purpose', 'real-estate-manager' );
            $defaults['property_status'] = __( 'Status', 'real-estate-manager' );
            $defaults['property_featured'] = __( 'Is Featured', 'real-estate-manager' );
        }

        $defaults['property_price'] = __( 'Price', 'real-estate-manager' );

        return $defaults;
    }

    function rem_property_column_content($column_name, $p_id){
        $all_fields = $this->single_property_fields();
        foreach ($all_fields as $fieldData) {
            if (isset($fieldData['key']) && $column_name == $fieldData['key']) {
                $meta_value = get_post_meta( $p_id, 'rem_'.$fieldData['key'], true );
                if ($column_name == 'property_price' && $meta_value != '') {
                    echo rem_get_property_price($meta_value);
                    echo '<span class="rem-price-int hidden">'.$meta_value.'</span>';
                } else {
                    echo esc_attr($meta_value);
                }
            }
        }
    }

    function rem_property_column_sorting($columns){
        $columns['property_price'] = 'property_price';
        return $columns;
    }

    function filter_properties_list_admin($post_type){
        if('rem_property' !== $post_type){
          return; //filter only properties
        }

        wp_nonce_field( 'rem-nonce-admin-filter', 'rem_nonce_admin_filter' );

        if (rem_get_option('admin_filtering') != '') {
            $field_keys = explode("\n", rem_get_option('admin_filtering'));
            foreach ($field_keys as $field_key) {
                if ($field_key != '') {
                    $field_key = trim($field_key);
                    $field_data = rem_get_field_data($field_key);
                    if (isset($field_data['options']) && $field_data['options'] != '') {
                        $options = $field_data['options'];
                        echo '<select id="filter-by-'.$field_key.'" name="rem_filter['.$field_key.']">';
                        echo '<option value="">' . $field_data['title'] . ' </option>';
                        $selected = (isset($_REQUEST['rem_filter'][$field_key]) && wp_verify_nonce( $_REQUEST['rem_nonce_admin_filter'], 'rem-nonce-admin-filter' )) ? $_REQUEST['rem_filter'][$field_key] : '' ;
                        foreach($options as $option){
                          $select = ($option == $selected) ? ' selected="selected"':'';
                          echo '<option value="'.$option.'"'.$select.'>' . $option . ' </option>';
                        }
                        echo '</select>';
                    }
                }
            }
        } else {
            $all_types = $this->get_all_property_types();

            echo '<select id="filter-by-property-type" name="filter_property_type">';
            echo '<option value="">' . __( 'All Types', 'real-estate-manager' ) . ' </option>';
            $selected = (isset($_REQUEST['filter_property_type']) && wp_verify_nonce( $_REQUEST['rem_nonce_admin_filter'], 'rem-nonce-admin-filter' )) ? $_REQUEST['filter_property_type'] : '' ;
            foreach($all_types as $type){
              $select = ($type == $selected) ? ' selected="selected"':'';
              echo '<option value="'.$type.'"'.$select.'>' . $type . ' </option>';
            }
            echo '</select>';


            $all_purpose = $this->get_all_property_purpose();

            echo '<select id="filter-by-property-purpose" name="filter_property_purpose">';
            echo '<option value="">' . __( 'All Purpose', 'real-estate-manager' ) . ' </option>';
            $selected = (isset($_REQUEST['filter_property_purpose']) && wp_verify_nonce( $_REQUEST['rem_nonce_admin_filter'], 'rem-nonce-admin-filter' )) ? $_REQUEST['filter_property_purpose'] : '' ;
            foreach($all_purpose as $purpose){
              $select = ($purpose == $selected) ? ' selected="selected"':'';
              echo '<option value="'.$purpose.'"'.$select.'>' . $purpose . ' </option>';
            }
            echo '</select>';

            $all_status = $this->get_all_property_status();

            echo '<select id="filter-by-property-status" name="filter_property_status">';
            echo '<option value="">' . __( 'All Status', 'real-estate-manager' ) . ' </option>';
            $selected = (isset($_REQUEST['filter_property_status']) && wp_verify_nonce( $_REQUEST['rem_nonce_admin_filter'], 'rem-nonce-admin-filter' )) ? $_REQUEST['filter_property_status'] : '' ;
            foreach($all_status as $status){
              $select = ($status == $selected) ? ' selected="selected"':'';
              echo '<option value="'.$status.'"'.$select.'>' . $status . ' </option>';
            }
            echo '</select>';
        }

        // Filters for categories and tags
        $selected_cat = (isset($_REQUEST['rem_category_id']) && wp_verify_nonce( $_REQUEST['rem_nonce_admin_filter'], 'rem-nonce-admin-filter' )) ? $_REQUEST['rem_category_id'] : '' ;
        wp_dropdown_categories(array(
            'show_option_all' =>  __( 'All Categories', 'real-estate-manager' ),
            'taxonomy'        =>  'rem_property_cat',
            'name'            =>  'rem_category_id',
            'orderby'         =>  'name',
            'selected'        =>  $selected_cat,
            'hierarchical'    =>  true,
            'depth'           =>  3,
            'show_count'      =>  true,
            'hide_empty'      =>  true,
            'value_field'     =>  'term_id',
        ));
        $selected_tag = (isset($_REQUEST['rem_tag_id']) && wp_verify_nonce( $_REQUEST['rem_nonce_admin_filter'], 'rem-nonce-admin-filter' )) ? $_REQUEST['rem_tag_id'] : '' ;
        wp_dropdown_categories(array(
            'show_option_all' =>  __( 'All Tags', 'real-estate-manager' ),
            'taxonomy'        =>  'rem_property_tag',
            'name'            =>  'rem_tag_id',
            'orderby'         =>  'name',
            'selected'        =>  $selected_tag,
            'hierarchical'    =>  true,
            'depth'           =>  3,
            'show_count'      =>  true,
            'hide_empty'      =>  true,
            'value_field'     =>  'term_id',
        ));
    }

    function remove_admin_bar(){
        if( is_user_logged_in() ) {
            $user = wp_get_current_user();
            $roles = ( array ) $user->roles;
            if (is_array($roles) && in_array("rem_property_agent", $roles)) {
               show_admin_bar(false);
            }
        }
    }

    function remove_tiny_mce_link_buttons($buttons){
        if( is_user_logged_in() ) {
            $user = wp_get_current_user();
            $roles = ( array ) $user->roles;
            if (is_array($roles) && in_array("rem_property_agent", $roles)) {
                $remove = 'link';
                if ( ( $key = array_search( $remove, $buttons ) ) !== false ){
                    unset( $buttons[$key] );
                }
            }
        }
        return $buttons;
    }

    function rem_disable_gutenberg($current_status, $post_type){
        if ($post_type === 'rem_property') return false;
        return $current_status;
    }

    function display_parent_listing_help($post){
        if ('rem_property' === $post->post_type) { ?>
            <p class="post-attributes-help-text">
                <?php esc_attr_e( 'Setting a parent will change the front layout of this listing.', 'real-estate-manager' ); ?>
                <a target="_blank" href="https://wp-rem.com/online-documentation/faqs/setup-floor-plan-or-hotel-rooms/"><?php esc_attr_e( 'Learn more about this.', 'real-estate-manager' ) ?></a>
            </p>
        <?php }
    }

    function filter_properties_request_query($query){
        //modify the query only if it admin and main query.
        if( !(is_admin() AND $query->is_main_query()) ){ 
          return $query;
        }

        //we want to modify the query for the targeted custom post and filter option
        if( !('rem_property' === $query->query['post_type']) ){
          return $query;
        }

        if (isset($_REQUEST['rem_nonce_admin_filter']) && wp_verify_nonce( $_REQUEST['rem_nonce_admin_filter'], 'rem-nonce-admin-filter' ) ){
            if( isset($_REQUEST['filter_property_type']) && $_REQUEST['filter_property_type'] != ''){
                $query->query_vars['meta_query'][] = array(
                    array(
                        'key'     => 'rem_property_type',
                        'value'   => $_REQUEST['filter_property_type'],
                        'type'    => 'LIKE',
                    ),
                );
            }

            if(isset($_REQUEST['filter_property_purpose']) && $_REQUEST['filter_property_purpose'] != ''){
                $query->query_vars['meta_query'][] = array(
                    array(
                        'key'     => 'rem_property_purpose',
                        'value'   => $_REQUEST['filter_property_purpose'],
                        'type'    => 'LIKE',
                    ),
                );
            }

            if(isset($_REQUEST['filter_property_status']) && $_REQUEST['filter_property_status'] != ''){
                $query->query_vars['meta_query'][] = array(
                    array(
                        'key'     => 'rem_property_status',
                        'value'   => $_REQUEST['filter_property_status'],
                        'type'    => 'LIKE',
                    ),
                );
            }

            if(isset($_REQUEST['rem_category_id']) && $_REQUEST['rem_category_id'] != '0'){
                $query->query_vars['tax_query'][] = array(
                    array(
                        'taxonomy'     => 'rem_property_cat',
                        'field'    => 'term_id',
                        'terms'   => $_REQUEST['rem_category_id'],
                    ),
                );
            }

            if(isset($_REQUEST['rem_tag_id']) && $_REQUEST['rem_tag_id'] != '0'){
                $query->query_vars['tax_query'][] = array(
                    array(
                        'taxonomy'     => 'rem_property_tag',
                        'field'    => 'term_id',
                        'terms'   => $_REQUEST['rem_tag_id'],
                    ),
                );
            }
            
            if(isset($_REQUEST['rem_filter']) && is_array($_REQUEST['rem_filter'])){
                foreach ($_REQUEST['rem_filter'] as $key => $value) {
                    if ($value != '') {
                        $query->query_vars['meta_query'][] = array(
                            array(
                                'key'     => 'rem_'.$key,
                                'value'   => $value,
                                'type'    => 'LIKE',
                            ),
                        );
                    }
                }
            }

            if(isset($_REQUEST['orderby']) && $_REQUEST['orderby'] == 'property_price'){
                $query->set( 'meta_key', 'rem_property_price' );
                $query->set( 'orderby', 'meta_value_num' );
            }
        }



        return $query;
    }

    function save_custom_agent_fields(){
        if (isset($_REQUEST['fields']) && wp_verify_nonce( $_REQUEST['nonce'], 'rem-nonce-fields' )) {
            $resp = array('status' => '', 'title' => '', 'message' => '');
            foreach ($_REQUEST['fields'] as $field) {
                if (isset($field['title']) && $field['title'] != '') {
                    rem_wpml_register($field['title'], 'real-estate-manager-fields');
                }
                if (isset($field['help']) && $field['help'] != '') {
                    rem_wpml_register($field['help'], 'real-estate-manager-fields');
                }
                if (isset($field['default']) && $field['default'] != '') {
                    rem_wpml_register($field['default'], 'real-estate-manager-fields');
                }
            }            
            if (update_option( 'rem_agent_fields', $_REQUEST['fields'] )) {
                $resp['status'] = 'success';
                $resp['title'] = __( 'Settings Saved!', 'real-estate-manager' );
                $resp['message'] = __( 'Settings are saved in the database successfully.', 'real-estate-manager' );
            } else {
                $resp['status'] = 'error';
                $resp['title'] = __( 'Failed!', 'real-estate-manager' );
                $resp['message'] = __( 'There is some error or you did not make any change.', 'real-estate-manager' );
            }
            echo wp_json_encode($resp);
        }
        die(0);
    }

    function reset_custom_agent_fields(){
        if (isset($_REQUEST['reset']) && $_REQUEST['reset'] == 'yes' && wp_verify_nonce( $_REQUEST['nonce'], 'rem-nonce-fields' )) {
            delete_option( 'rem_agent_fields' );
        }
        die(0);
    }

    /**
     * Get the drag drop property fields inner setting fields
     * @since 10.8.1
     */
    function rem_get_property_fields_data_fields(){
        $fields = array();
        include REM_PATH.'/inc/menu/property-fields-builder/fields-array.php';
        return $fields;
    }

    /**
     * Get the drag drop agent fields inner setting fields
     * @since 10.8.1
     */
    function rem_get_agent_fields_data_fields(){
        $fields = array();
        include REM_PATH.'/inc/menu/agent-fields-builder/fields-array.php';
        return $fields;
    }

    /**
     * Renders the drag drop fields inner setting fields
     * @since 10.8.1
     */
    function rem_render_fields_builder_field($field, $data){
        $render_it = true;
        if (isset($field['show_if'])) {
            if (!in_array($data['type'], $field['show_if'])) {
                $render_it = false;
            }
        }
        if ($render_it) {
            include REM_PATH.'/inc/menu/property-fields-builder/render-field.php';
        }
    }

    /**
     * Renders the drag drop fields builder headings for inner fields
     * @since 10.8.1
     */
    function rem_render_fields_builder_field_heading($title, $label){
        ?>
        <b><?php echo ($title != '') ? esc_html(stripcslashes($title)).' - ' : '' ; ?></b>
        <?php echo esc_attr($label); ?>
        <span class="pull-right btn btn-xs btn-default trigger-sort">
            <span class="glyphicon glyphicon-move"></span>
        </span>
        <a href="#" class="btn btn-xs btn-default pull-right trigger-toggle">
            <span class="glyphicon glyphicon-menu-down"></span>
        </a>
        <a href="#" class="pull-right btn btn-xs btn-danger remove-field">
            <span class="glyphicon glyphicon-minus-sign"></span>
        </a>
        <?php
    }

}
?>