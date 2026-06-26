<?php
/**
* Real Estate Management - Shortcodes Class
*/
class REM_Shortcodes
{
	
	function __construct(){

        /***********************************************************************************************/
        /* Add Shortcodes */
        /***********************************************************************************************/

		add_shortcode( 'rem_register_agent', array($this, 'register_agent') );
		add_shortcode( 'rem_search_property', array($this, 'search_property') );
		add_shortcode( 'rem_search_property_inline', array($this, 'search_property_inline') );
		add_shortcode( 'rem_agent_login', array($this, 'login_agent') );
		add_shortcode( 'rem_create_property', array($this, 'create_property') );
		add_shortcode( 'rem_edit_property', array($this, 'edit_property') );
		add_shortcode( 'rem_list_properties', array($this, 'list_properties') );
		add_shortcode( 'rem_search_results', array($this, 'display_search_results') );
		add_shortcode( 'rem_carousel', array($this, 'display_carousel') );
		add_shortcode( 'rem_maps', array($this, 'display_maps') );
		add_shortcode( 'rem_agents_map', array($this, 'display_agents_on_map') );
		add_shortcode( 'rem_agent_profile', array($this, 'display_agent') );
		add_shortcode( 'rem_my_profile', array($this, 'my_profile') );
		add_shortcode( 'rem_agent_edit', array($this, 'edit_agent') );
		add_shortcode( 'rem_property', array($this, 'single_property') );
		add_shortcode( 'rem_list_agents', array($this, 'list_agents') );
		add_shortcode( 'rem_agent_logout', array($this, 'logout_button') );
		add_shortcode( 'rem_categories', array($this, 'render_categories') );
		add_shortcode( 'rem_change_password', array($this, 'change_password_form') );
		add_shortcode( 'rem_property_field', array($this, 'rem_property_field') );

        /***********************************************************************************************/
        /* WP Bakery Page Builder, Elementor Pro, and Divi Modules Support */
        /***********************************************************************************************/
		add_action( 'vc_before_init', array($this, 'rem_vc_addons_setup' ) );
        add_action('et_builder_ready', array($this, 'rem_divi_modules_setup' ));
        add_action('elementor/elements/categories_registered', array($this, 'rem_elementor_category' ));
        add_action('elementor/widgets/register', array($this, 'rem_elementor_widgets' ));

        /***********************************************************************************************/
        /* AJAX Callbacks */
        /***********************************************************************************************/

        // Agent Login
        add_action( 'wp_ajax_nopriv_rem_user_login', array($this, 'rem_user_login_check' ) );

        // Create Property Frontend
        add_action( 'wp_ajax_rem_create_pro_ajax', array($this, 'create_property_frontend' ) );
        
        // Saving Agent Profile Frontend
        add_action( 'wp_ajax_rem_save_profile_front', array($this, 'rem_save_profile_front' ) );
        
        // Search Property Frontend
        add_action( 'wp_ajax_rem_search_property', array($this, 'search_results' ) );
        add_action( 'wp_ajax_nopriv_rem_search_property', array($this, 'search_results' ) );
        
        // Search Property Frontend
        add_action( 'wp_ajax_rem_search_autocomplete', array($this, 'rem_search_autocomplete' ) );
        add_action( 'wp_ajax_nopriv_rem_search_autocomplete', array($this, 'rem_search_autocomplete' ) );
        
        // AJAX Pagination Frontend
        add_action( 'wp_ajax_rem_list_properties_ajax', array($this, 'rem_list_properties_ajax' ) );
        add_action( 'wp_ajax_nopriv_rem_list_properties_ajax', array($this, 'rem_list_properties_ajax' ) );

        // Register New Agent
        add_action( 'wp_ajax_nopriv_rem_agent_register', array($this, 'rem_register_agent' ) );

        // Delete Property
        add_action( 'wp_ajax_rem_delete_property', array($this, 'delete_property') );

        // Change Password
        add_action( 'wp_ajax_rem_change_password', array($this, 'change_password') );
	}

	function register_agent($attrs, $content = ''){
		if (!is_user_logged_in()) {

			extract( shortcode_atts( array(
				'redirect' => '',
				'required_text' => '',
			), $attrs ) );

            rem_load_bs_and_fa();
            rem_load_basic_styles();
            wp_enqueue_script( 'sweet-alerts', REM_URL . '/assets/admin/js/sweetalert.min.js' , array('jquery'));
            wp_enqueue_style( 'rem-register-css', REM_URL . '/assets/front/css/register-agent.css' );
            

            $rem_registration_vars = array(
                'error_text' => __( 'Error', 'real-estate-manager' ),
                'wait_text' => __( 'Please Wait...', 'real-estate-manager' ),
                'ajaxurl' => admin_url( 'admin-ajax.php' ),
                'redirect' => $redirect,
                'success_text' => __( 'Registration Successful', 'real-estate-manager' ),
                'password_mismatch' => __( 'Passwords did not match!', 'real-estate-manager' ),
                'file_size_error' => __( 'Maximum file size allowed is:', 'real-estate-manager' ),
                'file_format_error' => __( 'Allowed formats are:', 'real-estate-manager' ),
            );

            if (rem_get_option('agent_location') == 'enable') {
                $def_lat = rem_get_option('default_map_lat', '-33.890542'); 
                $def_long = rem_get_option('default_map_long', '151.274856');
                $zoom_level = rem_get_option('maps_zoom_level', '18');
                $map_type = rem_get_option( 'maps_type', 'roadmap');
                $maps_api = apply_filters( 'rem_maps_api', 'AIzaSyBbpbij9IIXGftKhFLMHOuTpAbFoTU_8ZQ');
                $drag_icon = apply_filters( 'rem_maps_drag_icon', REM_URL.'/assets/images/pin-drag.png' );
                if (rem_get_option('use_map_from', 'leaflet') == 'leaflet') {
                    wp_enqueue_style( 'rem-leaflet-css', REM_URL . '/assets/front/leaflet/leaflet.css');
                    wp_enqueue_script( 'rem-leaflet-js', REM_URL . '/assets/front/leaflet/leaflet.js', array('jquery'));
                    wp_enqueue_style( 'rem-leaflet-geo-css', 'https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css');
                    wp_enqueue_script( 'rem-leaflet-geo-js', 'https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js');
                } else {
                    if (is_ssl()) {
                        wp_enqueue_script( 'rem-agent-map', 'https://maps.googleapis.com/maps/api/js?key='.$maps_api.'&libraries=places');
                    } else {
                        wp_enqueue_script( 'rem-agent-map', 'http://maps.googleapis.com/maps/api/js?key='.$maps_api.'&libraries=places');
                    }
                }

                $rem_registration_vars['use_map_from'] = rem_get_option('use_map_from', 'leaflet');
                $rem_registration_vars['def_lat'] = $def_lat;
                $rem_registration_vars['def_long'] = $def_long;
                $rem_registration_vars['zoom_level'] = $zoom_level;
                $rem_registration_vars['map_type'] = $map_type;
                $rem_registration_vars['leaflet_styles'] = rem_get_leaflet_provider(rem_get_option('leaflet_style'));
                $rem_registration_vars['maps_api'] = $maps_api;
                $rem_registration_vars['drag_icon'] = $drag_icon;
                $rem_registration_vars['maps_styles'] = stripcslashes(rem_get_option('maps_styles'));
            }

			wp_enqueue_script( 'rem-register-agent-js', REM_URL . '/assets/front/js/register-agent.js', array('jquery'));
            wp_localize_script( 'rem-register-agent-js', 'rem_registration_vars', $rem_registration_vars );

			ob_start();
				$in_theme = get_stylesheet_directory().'/rem/shortcodes/register-agent.php';
				if (file_exists($in_theme)) {
					include $in_theme;
				} else {
					include REM_PATH. '/shortcodes/register-agent.php';
				}
			return ob_get_clean();
		} else {
			return apply_filters( 'the_content', $content );
		}
	}

	function search_property($attrs, $content = ''){

		if (is_admin()) {
			return __( 'It will work on the frontend', 'real-estate-manager' );
		}

		if ( class_exists('Elementor\Plugin') && \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			return __( 'Live Preview is not available in Elementor edit mode but will work when visiting this page.', 'real-estate-manager' );
		}

		extract( shortcode_atts( array(
			'fields_to_show' => 'property_address,search,property_type,property_country,property_purpose,property_price',
			'fields_to_hide' => '',
			'columns' => '6',
			'search_btn_text' => __( 'Search', 'real-estate-manager' ),
			'more_filters_features' => 'enable',
			'filters_btn_text' => __( 'More Filters', 'real-estate-manager' ),
			'reset_btn_text' => '',
			'fixed_fields' => '',
			'results_page' => '',
			'results_selector' => '',
			'disable_eq_height' => '',
			'more_filters_column_class' => 'col-xs-6 col-sm-4 col-md-3',
			'agent_id' => '',
			'order' => 'ASC',
			'orderby' => '',
			'auto_complete' => 'enable',
			'scroll_results' => 'enable',
			'masonry' => '',
			'style' => '1',
			'tabs_field' => 'property_purpose',
			'tabs_all_text' => 'All Purpose',
		), $attrs ) );
		
        rem_load_bs_and_fa();
        rem_load_basic_styles();
        rem_load_dropdown_styles();
        wp_enqueue_style( 'rem-archive-property-css', REM_URL . '/assets/front/css/archive-property.css' );
        
        wp_enqueue_style( 'rem-nouislider-css', REM_URL . '/assets/front/lib/nouislider.min.css' );
        wp_enqueue_style( 'rem-labelauty-css', REM_URL . '/assets/front/lib/labelauty.css' );
        wp_enqueue_script( 'rem-labelauty', REM_URL . '/assets/front/lib/labelauty.min.js', array('jquery'));

        wp_enqueue_script( 'rem-nouislider-drop', REM_URL . '/assets/front/lib/nouislider.all.min.js', array('jquery'));
        wp_enqueue_script( 'rem-match-height', REM_URL . '/assets/front/lib/jquery.matchheight-min.js', array('jquery'));

        wp_enqueue_script( 'rem-imagefill-js', REM_URL . '/assets/front/lib/imagefill.min.js', array('jquery'));   
        wp_enqueue_script( 'rem-imagesloaded-js', REM_URL . '/assets/front/lib/imagesloaded.min.js', array('jquery'));
        
        wp_enqueue_style( 'rem-search-css', REM_URL . '/assets/front/css/search-property.css' );


		wp_enqueue_style( 'rem-select2-css', REM_URL . '/assets/admin/css/select2.min.css' );
        wp_enqueue_script( 'rem-select2-js', REM_URL . '/assets/admin/js/select2.min.js' , array('jquery'));
           
        if (isset($_GET['price_min']) && isset($_GET['price_max'])) {
	        $min =  str_replace(stripcslashes(rem_get_option('range_thousand_separator', '')), "", $_GET['price_min']);
	        $min = number_format(intval($min), 0, rem_get_option('decimal_separator', ''), '');
	        
	        $max =  str_replace(stripcslashes(rem_get_option('range_thousand_separator', '')), "", $_GET['price_max']);
	        $max = number_format(intval($max), 0, rem_get_option('decimal_separator', ''), '');
        } else {
        	
        	$min = rem_get_option('default_minimum_price', '7000');
        	$max = rem_get_option('default_maximum_price', '38500');
        }

        $range_field_base = rem_get_option('switch_ranges', 'property_purpose|Rent');
        $switch_ranges = explode("|", $range_field_base);
        $price_range_name = (isset($switch_ranges[0]) ? trim($switch_ranges[0]) : 'property_purpose');
        $price_range_value = (isset($switch_ranges[1]) ? trim($switch_ranges[1]) : 'Rent');
        
        $script_settings = array(
            'price_min'         => rem_get_option('minimum_price', '350'),
            'price_max'         => rem_get_option('maximum_price', '45000'), 
            'price_min_default' => $min,
            'price_max_default' => $max,
            'price_step'        => rem_get_option('price_step', '10'),
            'price_step_r'        => rem_get_option('price_step_r', '5'),
            'price_min_r'         => rem_get_option('minimum_price_r', '10'),
            'price_max_r'         => rem_get_option('maximum_price_r', '5000'), 
            'price_min_default_r' => rem_get_option('default_minimum_price_r', '950'),
            'price_max_default_r' => rem_get_option('default_maximum_price_r', '4500'),
            'site_direction'        => (is_rtl()) ? 'rtl' : 'ltr',
            'currency_symbol'   => rem_get_currency_symbol(),
            'thousand_separator'=> stripcslashes(rem_get_option('thousand_separator', '')),
            'decimal_separator' => rem_get_option('decimal_separator', ''),
            'decimal_points'    => rem_get_option('decimal_points', '0'),
            'range_thousand_separator'=> stripcslashes(rem_get_option('range_thousand_separator', '')),
            'range_decimal_separator' => rem_get_option('range_decimal_separator', ''),
            'range_decimal_points'    => rem_get_option('range_decimal_points', '0'),
            'offset'    => rem_get_option('properties_per_page', 15),
            'price_range_name'    => $price_range_name,
            'price_range_value'    => $price_range_value,
            'nonce_states' => wp_create_nonce('rem-nonce-states'),
        );
        wp_enqueue_script( 'rem-search-script', REM_URL . '/assets/front/js/search-property.js', array('jquery', 'jquery-masonry', 'jquery-ui-autocomplete'));
        wp_localize_script( 'rem-search-script', 'rem_ob', $script_settings );

		ob_start();
			$in_theme = get_stylesheet_directory().'/rem/shortcodes/search-property.php';
			if (file_exists($in_theme)) {
				include $in_theme;
			} else {
				include REM_PATH. '/shortcodes/search-property.php';
			}
		return ob_get_clean();
	}
	
	function search_property_inline($attrs, $content = ''){

		if ( class_exists('Elementor\Plugin') && \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			return __( 'Live Preview is not available in Elementor edit mode but will work when visiting this page.', 'real-estate-manager' );
		}		

		extract( shortcode_atts( array(
			'fields_inline_show' => 'property_type,property_country',
			'fields_to_show' => 'property_address,search,property_type,property_country,property_purpose,property_price',
			'columns' => '6',
			'search_btn_text' => __( 'Go', 'real-estate-manager' ),
			'filters_btn_text' => __( 'More ', 'real-estate-manager' ),
			'reset_btn_text' => '',
			'fixed_fields' => '',
			'results_page' => '',
			'results_selector' => '',
			'disable_eq_height' => '',
			'more_filters_column_class' => 'col-xs-6 col-sm-4 col-md-3',
			'agent_id' => '',
			'order' => 'ASC',
			'orderby' => '',
			'auto_complete' => 'enable',
			'scroll_results' => 'enable',
		), $attrs ) );
		
        rem_load_bs_and_fa();
        rem_load_basic_styles();
        rem_load_dropdown_styles();
        wp_enqueue_style( 'rem-archive-property-css', REM_URL . '/assets/front/css/archive-property.css' );
        
        wp_enqueue_style( 'rem-nouislider-css', REM_URL . '/assets/front/lib/nouislider.min.css' );
        
        wp_enqueue_style( 'rem-labelauty-css', REM_URL . '/assets/front/lib/labelauty.css' );
        wp_enqueue_script( 'rem-labelauty', REM_URL . '/assets/front/lib/labelauty.min.js', array('jquery'));

        wp_enqueue_script( 'rem-nouislider-drop', REM_URL . '/assets/front/lib/nouislider.all.min.js', array('jquery'));
        wp_enqueue_script( 'rem-match-height', REM_URL . '/assets/front/lib/jquery.matchheight-min.js', array('jquery'));

        wp_enqueue_script( 'rem-imagefill-js', REM_URL . '/assets/front/lib/imagefill.min.js', array('jquery'));   
        wp_enqueue_script( 'rem-imagesloaded-js', REM_URL . '/assets/front/lib/imagesloaded.min.js', array('jquery'));
        
        wp_enqueue_style( 'rem-search-css', REM_URL . '/assets/front/css/search-property.css' );


		wp_enqueue_style( 'rem-select2-css', REM_URL . '/assets/admin/css/select2.min.css' );
        wp_enqueue_script( 'rem-select2-js', REM_URL . '/assets/admin/js/select2.min.js' , array('jquery'));
                 
        $script_settings = array(
            'price_min'         => rem_get_option('minimum_price', '350'),
            'price_max'         => rem_get_option('maximum_price', '45000'), 
            'price_min_default' => rem_get_option('default_minimum_price', '7000'), 
            'price_max_default' => rem_get_option('default_maximum_price', '38500'),
            'site_direction'    => (is_rtl()) ? 'rtl' : 'ltr',
            'price_step'        => rem_get_option('price_step', '10'),
            'currency_symbol'   => rem_get_currency_symbol(),
            'thousand_separator'=> stripcslashes(rem_get_option('thousand_separator', '')),
            'decimal_separator' => rem_get_option('decimal_separator', ''),
            'decimal_points'    => rem_get_option('decimal_points', '0'),
            'range_thousand_separator'=> stripcslashes(rem_get_option('range_thousand_separator', '')),
            'range_decimal_separator' => rem_get_option('range_decimal_separator', ''),
            'range_decimal_points'    => rem_get_option('range_decimal_points', '0'),
            'offset'    => rem_get_option('properties_per_page', '0'),
            'nonce_states' => wp_create_nonce('rem-nonce-states'),
        );
        wp_enqueue_script( 'rem-search-script', REM_URL . '/assets/front/js/search-property.js', array('jquery', 'jquery-masonry', 'jquery-ui-autocomplete'));
        wp_localize_script( 'rem-search-script', 'rem_ob', $script_settings );

		ob_start();
			$in_theme = get_stylesheet_directory().'/rem/shortcodes/search-property-inline.php';
			if (file_exists($in_theme)) {
				include $in_theme;
			} else {
				include REM_PATH. '/shortcodes/search-property-inline.php';
			}			
		return ob_get_clean();
	}

	function login_agent($attrs = array(), $content = ''){
		if (is_user_logged_in()) {
			return apply_filters( 'the_content', $content );
		} else {

	        rem_load_bs_and_fa();
	        rem_load_basic_styles();
	        wp_enqueue_style( 'rem-login-css', REM_URL . '/assets/front/css/login-agent.css' );
	        wp_enqueue_style( 'rem-labelauty-css', REM_URL . '/assets/front/lib/labelauty.css' );
	        wp_enqueue_script( 'rem-labelauty', REM_URL . '/assets/front/lib/labelauty.min.js', array('jquery'));
	        wp_enqueue_script( 'rem-login-agent', REM_URL . '/assets/front/js/login.js', array('jquery'));
	        wp_localize_script( 'rem-login-agent', 'rem_login_data', array('wait_msg' => __( 'Logging In, Please Wait...', 'real-estate-manager' )) );

			extract( shortcode_atts( array(
				'heading' => 'Login Here',
				'redirect' => '',
			), $attrs ) );
			ob_start();
				$in_theme = get_stylesheet_directory().'/rem/shortcodes/login.php';
				if (file_exists($in_theme)) {
					include $in_theme;
				} else {
					include REM_PATH. '/shortcodes/login.php';
				}
			return ob_get_clean();
		}
	}

	function create_property($attrs, $content = 'Please Login to create properties'){
		if (is_user_logged_in()) {
			extract( shortcode_atts( array(
                'style' => '',
				'roles' => 'rem_property_agent,administrator',
			), $attrs ) );

            $can_create = false;
            $user = wp_get_current_user();
            $enabled_roles = explode(",", $roles);
            foreach ($enabled_roles as $role) {
                if ( in_array( trim($role), (array) $user->roles ) ) {
                    $can_create = true;
                }
            }

            if(!$can_create){
                return '<div class="ich-settings-main-wrap"><div class="alert alert-danger">'.__( 'Sorry, you are not allowed to submit listings.', 'real-estate-manager' ).'</div></div>';
            }

			global $rem_ob;
	        wp_enqueue_media();
			rem_load_bs_and_fa();
			rem_load_basic_styles();
			rem_load_dropdown_styles();
			
			$images_limit = rem_get_option('gallery_images_limit', 0);
			$images_limit = apply_filters('rem_gallery_images_limit', $images_limit);

			$videos_limit = rem_get_option('gallery_videos_limit', 0);
			$videos_limit = apply_filters('rem_gallery_videos_limit', $videos_limit);

			wp_enqueue_style( 'rem-admin-css', REM_URL . '/assets/admin/css/admin.css' );

			wp_enqueue_style( 'rem-labelauty-css', REM_URL . '/assets/front/lib/labelauty.css' );
			wp_enqueue_script( 'rem-labelauty', REM_URL . '/assets/front/lib/labelauty.min.js', array('jquery'));
			wp_enqueue_script( 'rem-match-height', REM_URL . '/assets/front/lib/jquery.matchheight-min.js', array('jquery'));
			wp_enqueue_script( 'rem-tooltip', REM_URL . '/assets/front/lib/tooltip.js', array('jquery'));
			wp_enqueue_style( 'rem-select2-css', REM_URL . '/assets/admin/css/select2.min.css' );
            wp_enqueue_script( 'rem-select2-js', REM_URL . '/assets/admin/js/select2.min.js' , array('jquery'));
                
            // If Map is enabled
            if (rem_get_option('single_property_map', 'enable') == 'enable') {

                $def_lat = rem_get_option('default_map_lat', '-33.890542'); 
                $def_long = rem_get_option('default_map_long', '151.274856');
                $zoom_level = rem_get_option('maps_zoom_level', '18');
                $map_type = rem_get_option( 'maps_type', 'roadmap');
                $maps_api = apply_filters( 'rem_maps_api', 'AIzaSyBbpbij9IIXGftKhFLMHOuTpAbFoTU_8ZQ');
                $drag_icon = apply_filters( 'rem_maps_drag_icon', REM_URL.'/assets/images/pin-drag.png' );
                if (rem_get_option('use_map_from', 'leaflet') == 'leaflet') {
                    wp_enqueue_style( 'rem-leaflet-css', REM_URL . '/assets/front/leaflet/leaflet.css');
                    wp_enqueue_script( 'rem-leaflet-js', REM_URL . '/assets/front/leaflet/leaflet.js', array('jquery'));
                    wp_enqueue_style( 'rem-leaflet-geo-css', 'https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css');
                    wp_enqueue_script( 'rem-leaflet-geo-js', 'https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js');
                } else {
	                if (is_ssl()) {
	                    wp_enqueue_script( 'rem-edit-property-map', 'https://maps.googleapis.com/maps/api/js?key='.$maps_api.'&libraries=places');
	                } else {
	                    wp_enqueue_script( 'rem-edit-property-map', 'http://maps.googleapis.com/maps/api/js?key='.$maps_api.'&libraries=places');
	                }
                }
                $localize_vars = array(
                    'use_map_from' => rem_get_option('use_map_from', 'leaflet'),
                    'def_lat' => $def_lat,
                    'def_long' => $def_long,
                    'zoom_level' => $zoom_level,
                    'map_type' => $map_type,
                    'post_edit_url' => admin_url( 'post.php' ),
                    'leaflet_styles' => rem_get_leaflet_provider(rem_get_option('leaflet_style')),
                    'maps_api' => $maps_api,
                    'drag_icon' => $drag_icon,
                    'maps_styles' => stripcslashes(rem_get_option('maps_styles')),
                    'images_limit' => $images_limit,
                    'videos_limit' => $videos_limit,
                    'success_message' => __( 'Successful', 'real-estate-manager' ),
                    'images_limit_message' => __( 'Maximum Images limit is: ', 'real-estate-manager' ),
                    'videos_limit_message' => __( 'Maximum Videos limit is: ', 'real-estate-manager' ),
                    'nonce_states' => wp_create_nonce('rem-nonce-states'),
                );
            }

			wp_enqueue_script( 'rem-create-pro', REM_URL . '/assets/front/js/create-property.js', array('jquery', 'jquery-ui-sortable'));

            if (isset($localize_vars)) {
                wp_localize_script( 'rem-create-pro', 'rem_property_vars', $localize_vars );
            } else {
                $localize_vars = array(
                    'def_lat' => 'disable',
                    'images_limit' => $images_limit,
                    'videos_limit' => $videos_limit,
                    'images_limit_message' => __( 'Maximum Images limit is: ', 'real-estate-manager' ),
                    'videos_limit_message' => __( 'Maximum Videos limit is: ', 'real-estate-manager' ),
                    'success_message' => __( 'Successful', 'real-estate-manager' ),
                );                
                wp_localize_script( 'rem-create-pro', 'rem_property_vars', $localize_vars );
            }
			ob_start();
				$property_individual_cbs = $rem_ob->get_all_property_features();
				$in_theme = get_stylesheet_directory().'/rem/shortcodes/create-property.php';
				if (file_exists($in_theme)) {
					include $in_theme;
				} else {
					include REM_PATH. '/shortcodes/create-property.php';
				}
			return ob_get_clean();
		} else {
			return apply_filters( 'the_content', $content );
		}		
	}

	function edit_property($attrs, $content = ''){
		$current_user_data = wp_get_current_user();
		if (!is_admin() && is_user_logged_in() && isset($_GET['property_id']) && (get_post_field( 'post_author', $_REQUEST['property_id'] ) == $current_user_data->ID || current_user_can('administrator'))) {
			extract( shortcode_atts( array(
				'style' => '',
				'waiting_message' => 'This listing is waiting for approval',
			), $attrs ) );

			global $rem_ob;
	        wp_enqueue_media();
			rem_load_bs_and_fa();
			rem_load_basic_styles();
			rem_load_dropdown_styles();
			wp_enqueue_style( 'rem-admin-css', REM_URL . '/assets/admin/css/admin.css' );
			
			wp_enqueue_style( 'rem-labelauty-css', REM_URL . '/assets/front/lib/labelauty.css' );
			wp_enqueue_script( 'rem-labelauty', REM_URL . '/assets/front/lib/labelauty.min.js', array('jquery'));
			wp_enqueue_script( 'rem-match-height', REM_URL . '/assets/front/lib/jquery.matchheight-min.js', array('jquery'));
			wp_enqueue_script( 'rem-tooltip', REM_URL . '/assets/front/lib/tooltip.js', array('jquery'));
			wp_enqueue_style( 'rem-select2-css', REM_URL . '/assets/admin/css/select2.min.css' );
            wp_enqueue_script( 'rem-select2-js', REM_URL . '/assets/admin/js/select2.min.js' , array('jquery'));				
            $images_limit = rem_get_option('gallery_images_limit', 0);
            $images_limit = apply_filters('rem_gallery_images_limit', $images_limit);

            $videos_limit = rem_get_option('gallery_videos_limit', 0);
            $videos_limit = apply_filters('rem_gallery_videos_limit', $videos_limit);

            // If Map is enabled
            if (rem_get_option('single_property_map', 'enable') == 'enable') {

                $def_lat = rem_get_option('default_map_lat', '-33.890542'); 
                $def_long = rem_get_option('default_map_long', '151.274856');
                $zoom_level = rem_get_option('maps_zoom_level', '18');
                $map_type = rem_get_option( 'maps_type', 'roadmap');
                $maps_api = apply_filters( 'rem_maps_api', 'AIzaSyBbpbij9IIXGftKhFLMHOuTpAbFoTU_8ZQ');
                $drag_icon = apply_filters( 'rem_maps_drag_icon', REM_URL.'/assets/images/pin-drag.png' );
				if (get_post_meta( $_GET['property_id'], 'rem_property_latitude', true ) != '') {
					$def_lat = get_post_meta( $_GET['property_id'], 'rem_property_latitude', true );
				}

				if (get_post_meta( $_GET['property_id'], 'rem_property_longitude', true ) != '') {
					$def_long = get_post_meta( $_GET['property_id'], 'rem_property_longitude', true );
				}

                if (rem_get_option('use_map_from', 'leaflet') == 'leaflet') {
                    wp_enqueue_style( 'rem-leaflet-css', REM_URL . '/assets/front/leaflet/leaflet.css');
                    wp_enqueue_script( 'rem-leaflet-js', REM_URL . '/assets/front/leaflet/leaflet.js', array('jquery'));
                    wp_enqueue_style( 'rem-leaflet-geo-css', 'https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css');
                    wp_enqueue_script( 'rem-leaflet-geo-js', 'https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js');                    
                } else {
	                if (is_ssl()) {
	                    wp_enqueue_script( 'rem-edit-property-map', 'https://maps.googleapis.com/maps/api/js?key='.$maps_api.'&libraries=places');
	                } else {
	                    wp_enqueue_script( 'rem-edit-property-map', 'http://maps.googleapis.com/maps/api/js?key='.$maps_api.'&libraries=places');
	                }
                }                
                $localize_vars = array(
                	'use_map_from' => rem_get_option('use_map_from', 'leaflet'),
                    'def_lat' => $def_lat,
                    'def_long' => $def_long,
                    'zoom_level' => $zoom_level,
                    'map_type' => $map_type,
                    'leaflet_styles' => rem_get_leaflet_provider(rem_get_option('leaflet_style')),
                    'maps_api' => $maps_api,
                    'drag_icon' => $drag_icon,
                    'images_limit' => $images_limit,
                    'videos_limit' => $videos_limit,
                    'images_limit_message' => __( 'Maximum Images limit is: ', 'real-estate-manager' ),
                    'videos_limit_message' => __( 'Maximum Videos limit is: ', 'real-estate-manager' ),
                    'maps_styles' => stripcslashes(rem_get_option('maps_styles')),
                    'success_message' => __( 'Successful', 'real-estate-manager' ),
                    'nonce_states' => wp_create_nonce('rem-nonce-states'),
                );
            }

			wp_enqueue_script( 'rem-create-pro', REM_URL . '/assets/front/js/create-property.js', array('jquery'));
            if (isset($localize_vars)) {
                wp_localize_script( 'rem-create-pro', 'rem_property_vars', $localize_vars );
            } else {
                $localize_vars = array(
                    'def_lat' => 'disable',
                    'images_limit' => $images_limit,
                    'videos_limit' => $videos_limit,
                    'images_limit_message' => __( 'Maximum Images limit is: ', 'real-estate-manager' ),
                    'videos_limit_message' => __( 'Maximum Videos limit is: ', 'real-estate-manager' ),
                    'success_message' => __( 'Successful', 'real-estate-manager' ),
                );                
                wp_localize_script( 'rem-create-pro', 'rem_property_vars', $localize_vars );
            }

			ob_start();
				$property_individual_cbs = $rem_ob->get_all_property_features();
				$in_theme = get_stylesheet_directory().'/rem/shortcodes/edit-property.php';
				if (file_exists($in_theme)) {
					include $in_theme;
				} else {
					include REM_PATH. '/shortcodes/edit-property.php';
				}
			return ob_get_clean();
		} else {
			return apply_filters( 'the_content', $content );
		}		
	}

	function manage_properties($attrs, $content = ''){
		extract( shortcode_atts( array(
			'role' => 'administrator',
			'admin' => 'disable'
		), $attrs ) );
		$user_is_admin = $admin == 'enable' && current_user_can('administrator') ? true : false;
		if (is_user_logged_in()) {
			$user = wp_get_current_user();
			if ( in_array( $role, (array) $user->roles ) || $user_is_admin ) {
			    							
	        rem_load_bs_and_fa();
	        rem_load_basic_styles();
	        wp_enqueue_script( 'sweet-alerts', REM_URL . '/assets/admin/js/sweetalert.min.js' , array('jquery'));
	        wp_enqueue_script( 'rem-my-pro', REM_URL . '/assets/front/js/manage-properties.js', array('jquery'));
	        wp_enqueue_style( 'datatable', 'https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css' );
	        wp_enqueue_script( 'datatable', 'https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js', array('jquery') );
	        wp_enqueue_style( 'rem-myproperties-css', REM_URL . '/assets/front/css/my-properties.css' );
	        $localize_vars = array(
	        	'ajaxurl' => admin_url( 'admin-ajax.php' ),
	        	'confirm' => __( 'Are you sure to delete this property?', 'real-estate-manager' ),
	        	'yes_txt' => __( 'Yes', 'real-estate-manager' ),
	        	'no_txt' => __( 'No', 'real-estate-manager' ),
	        	'done_txt' => __( 'Done', 'real-estate-manager' ),
	        );
	        wp_localize_script( 'rem-my-pro', 'rem_vars', $localize_vars );	        

			ob_start();
				$in_theme = get_stylesheet_directory().'/rem/shortcodes/manage-properties.php';
				if (file_exists($in_theme)) {
					include $in_theme;
				} else {
					include REM_PATH. '/shortcodes/manage-properties.php';
				}
			return ob_get_clean();
			} else {
				return apply_filters( 'the_content', $content );
			}
		} else {
			return apply_filters( 'the_content', $content );
		}
	}	
	function rem_get_shortcode_query_args($attrs){

		extract( shortcode_atts( array(
		    'order' 	=> 'ASC',
		    'orderby' 	=> 'date',
		    'posts' 	=> 10,
		    'purpose'  	=> '',
		    'status'  	=> '',
		    'author'  	=> '',
		    'type'  	=> '',
		    'tags'  	=> '',
		    'cats'  	=> '',
		    'meta'  	=> '',
		    'lang'  	=> 'disable',
		    'orderby_custom'  	=> '',
		    'not_available'  	=> 'enable',
		    'features'  	=> '',
		    'ids'  	=> '',
		    'exclude'  	=> '',
		    'total_properties'  	=> '',
            'show_childs'      => 'enable',
            'post_status'      => 'publish',
		), $attrs ) );

		$args = array(
			'order'       => $order,
			'orderby'     => $orderby,
			'post_status' => $post_status,
			'post_type'   => 'rem_property',
			'posts_per_page'         => ($total_properties == '') ? $posts : $total_properties,
		);

		if ($show_childs == 'disable') {
		    $args['post_parent'] = 0;
		}

        if ($ids != '') {
            $args['post__in'] = explode(',', $ids);
        }

		if ($lang != 'disable') {
		    $args['lang'] = $lang;
		}

		if ($exclude != '') {
		    $args['post__not_in'] = explode(',', $exclude);
		}

		if ($orderby == 'price') {
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = 'rem_property_price';
		}

		if ($orderby_custom != '') {
            $args['orderby'] = 'meta_value';
            $args['meta_key'] = 'rem_'.$orderby_custom;
		}

		if (isset($_GET['sort_by']) && $_GET['sort_by'] != '') {
			$sort_op = explode("-", $_GET['sort_by']);
			$args['order'] = strtoupper($sort_op[1]);
			$args['orderby'] = $sort_op[0];
	        if ($sort_op[0] == 'price') {
	            $args['orderby'] = 'meta_value_num';
	            $args['meta_key'] = 'rem_property_price';
	        }
	        if (isset($sort_op[2]) && $sort_op[2] == 'custom') {
	            $args['orderby'] = 'meta_value';
	            $args['meta_key'] = $sort_op[0];
	        }
		}

		if ($author != '') {
			if ($author == 'current' && is_user_logged_in()) {
		        $current_user = wp_get_current_user();
				$args['author'] = $current_user->ID;
			} else {
				$args['author'] = $author;
			}
		}

	    if ($purpose != '') {
	        $args['meta_query'][] = array(
	            array(
	                'key'     => 'rem_property_purpose',
	                'value'   => $purpose,
	                'compare' => 'IN',
	            ),
	        );
	    }
	    if ($status != '') {
	        $args['meta_query'][] = array(
	            array(
	                'key'     => 'rem_property_status',
	                'value'   => $status,
	                'compare' => 'IN',
	            ),
	        );
	    }
	    if ($type != '') {
	        $args['meta_query'][] = array(
	            array(
	                'key'     => 'rem_property_type',
	                'value'   => $type,
	                'compare' => 'IN',
	            ),
	        );
	    }
	    if ($features != '') {
	    	$features = explode(",", $features);
	    	foreach ($features as $feature) {
		        $args['meta_query'][] = array(
		            array(
		                'key'     => 'rem_property_detail_cbs',
		                'value'   => $feature,
		                'compare' => 'LIKE',
		            ),
		        );
	    	}
	    }
	    if ($tags != '') {
	    	$p_tags = array_map('trim', explode(',', $tags));
	        $args['tax_query'] = array(
				array(
					'taxonomy' => 'rem_property_tag',
					'field'    => 'name',
					'terms'    => $p_tags,
				),
	        );
	    }
	    if ($cats != '') {
	    	$p_cats = array_map('trim', explode(',', $cats));
	        $args['tax_query'] = array(
				array(
					'taxonomy' => 'rem_property_cat',
					'field'    => 'name',
					'terms'    => $p_cats,
				),
	        );
	    }
		if ($meta != '') {
			$meta_data = explode(",", $meta);
			foreach ($meta_data as $single_meta) {
				$m_k_v = explode("|", $single_meta);
			    if (isset($m_k_v[1]) && $m_k_v[1] != '' && strpos($m_k_v[1], '*') == false) {
			        if (strpos($m_k_v[1], '!') !== false) {
			        	$args['meta_query'][] = array(
				            array(
				                'key'     => 'rem_'.trim($m_k_v[0]),
				                'value'   => ltrim($m_k_v[1],"!"),
				                'compare' => 'NOT LIKE',
				            ),
				        );
			        } elseif (strpos($m_k_v[1], '#') !== false) {
			        	$args['meta_query'][] = array(
			        	    array(
			        	        'key'     => 'rem_'.trim($m_k_v[0]),
			        	        'value'   => ltrim($m_k_v[1],"#"),
			        	        'compare' => '=',
			        	    ),
			        	);			        	
			        } else {
				        $args['meta_query'][] = array(
				            array(
				                'key'     => 'rem_'.trim($m_k_v[0]),
				                'value'   => trim($m_k_v[1]),
				                'compare' => 'LIKE',
				            ),
				        );
			        }
			    }
			    if (isset($m_k_v[1]) && $m_k_v[1] != '' && strpos($m_k_v[1], '*') != false) {
			    	$m_k_v_and = explode("*", $m_k_v[1]);

			    	$meta_query_arr = array();

			    	foreach ($m_k_v_and as $meta_value) {
						$meta_query_arr[] = array(
			                'key'     => 'rem_'.trim($m_k_v[0]),
			                'value'   => trim($meta_value),
			                'compare' => 'LIKE',
			            );
			    	}
			    	$meta_query_arr['relation'] = 'OR';
			        $args['meta_query'][] = $meta_query_arr;
			    }
				
			}
		}
		if ($not_available == 'disable') {
	        $args['meta_query'][] = array(
	            array(
	                'key'     => 'rem_property_status',
	                'value'   => 'Not Available',
	                'compare' => 'NOT LIKE',
	            ),
	        );
		}

		return $args;
	}

	function list_properties($attrs, $content = ''){
		extract( shortcode_atts( array(
		    'style' 		=> '1',
		    'listing_style' 	=> '',
		    'images_height' 	=> '',
		    'class'  		=> 'col-sm-12',
		    'pagination'  	=> 'enable',
		    'masonry'  		=> '',
		    'top_bar'  		=> 'disable',
		    'grid_style'  	=> '2',
		    'grid_style_col'  	=> 'col-sm-4',
		    'list_style'  	=> '1',
		    'list_style_col'  	=> 'col-sm-12',
		    'nearest_properties'  	=> 'disable',
		    'ajax'  		=> 'disable',
		), $attrs ) );

		$args = $this->rem_get_shortcode_query_args($attrs);

		$class = $class.' m-item';

		// Elementor Fix (Elementor doesnt work for the style attributes in the shortcodes)
		$style = ($listing_style != '') ? $listing_style : $style ;

		if (isset($_GET['list_style']) && $_GET['list_style'] == 'list') {
			$style = $list_style;
			$class = $list_style_col.' m-item';
		}

		if (isset($_GET['list_style']) && $_GET['list_style'] == 'grid') {
			$style = $grid_style;
			$class = $grid_style_col.' m-item';
		}

        rem_load_bs_and_fa();
        rem_load_basic_styles();
        if ($masonry == 'enable') {
        	wp_enqueue_script( 'jquery-masonry' );
        }

        // Imagesfill and Loaded
        wp_enqueue_script( 'rem-imagefill-js', REM_URL . '/assets/front/lib/imagefill.min.js', array('jquery'));   
        wp_enqueue_script( 'rem-imagesloaded-js', REM_URL . '/assets/front/lib/imagesloaded.min.js', array('jquery'));
        
        // Page Specific
        wp_enqueue_style( 'rem-archive-property-css', REM_URL . '/assets/front/css/archive-property.css' );
        wp_enqueue_script( 'rem-tooltip', REM_URL . '/assets/front/lib/tooltip.js', array('jquery'));
        wp_enqueue_script( 'rem-archive-property-js', REM_URL . '/assets/front/js/archive-property.js', array('jquery'));
		
	    if ($pagination == 'enable') {
	    	if (is_front_page()) {
	    		$paged = ( get_query_var('page') ) ? get_query_var('page') : 1;
	    	} else {
				$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
	    	}
	    	if (isset($attrs['paged'])) {
	    		$paged = $attrs['paged'];
				$args['paged'] = $attrs['paged'];
				$args['offset '] = $attrs['posts'];
	    	} else {
				$args['paged'] = $paged;
	    	}
	    }

		$args = apply_filters( 'rem_list_porperties_args_before_render', $args );

		ob_start();

			if($nearest_properties == 'enable'){
				?>
				<script>
				    if (navigator.geolocation) {
				        navigator.geolocation.getCurrentPosition(wcpSetPosition);
				    }
					function wcpSetPosition(position) {
						var href = window.location.href;
						if (href.indexOf('lat') == -1) {
							window.location.href = href += '/?lat='+position.coords.latitude+'&long='+position.coords.longitude;
						}
					}    
				</script>
				<?php
			}
			if ($nearest_properties == 'enable' && isset($_GET['lat']) && isset($_GET['long'])) {
				$args['posts_per_page'] = -1;
				$the_query = new WP_Query( $args );
				$in_theme = get_stylesheet_directory().'/rem/shortcodes/list/nearby.php';
				if (file_exists($in_theme)) {
					include $in_theme;
				} else {
					include REM_PATH. '/shortcodes/list/nearby.php';
				}
			} else {
				$the_query = new WP_Query( $args );
				$in_theme = get_stylesheet_directory().'/rem/shortcodes/list/list.php';
				if (file_exists($in_theme)) {
					include $in_theme;
				} else {
					include REM_PATH. '/shortcodes/list/list.php';
				}
			}

			
		return ob_get_clean();
	}

	function display_carousel($attrs, $content = ''){
		extract( shortcode_atts( array(
	        'style' 	=> '1',
	        'listing_style' 	=> '',
	        'slidestoshow'  	=> '1',
	        'slidestoscroll'  	=> '1',
	        'speed'  	=> '2000',
	        'autoplay'  	=> 'disable',
	        'autoplayspeed'  	=> '2000',
	        'arrows'  	=> 'disable',
	        'arrows_style'  	=> '1',
	        'dots'  	=> 'disable',
	        'nearest_properties' 	=> 'disable',
		), $attrs ) );

		if($style == '1'){
			$attrs['slidestoshow'] = '1';
		}

		$style = ($listing_style != '') ? $listing_style : $style ;

	    $data_attr = '';
	    if(is_array($attrs)){
	        foreach ($attrs as $p_name => $p_val) {
	            if ($p_val != '') {
	                $data_attr .= ' data-'.$p_name.' = '.$p_val;
	            }
	        }
	    }

        rem_load_bs_and_fa();
        rem_load_basic_styles();

        // Imagesfill and Loaded
        wp_enqueue_script( 'rem-imagefill-js', REM_URL . '/assets/front/lib/imagefill.min.js', array('jquery'));   
        wp_enqueue_script( 'rem-imagesloaded-js', REM_URL . '/assets/front/lib/imagesloaded.min.js', array('jquery'));   
        
        // Carousel
        wp_enqueue_style( 'rem-carousel-css', REM_URL . '/assets/front/lib/slick.css' );
        wp_enqueue_script( 'rem-carousel-js', REM_URL . '/assets/front/lib/slick.min.js', array('jquery'));

        // Page Specific
        wp_enqueue_style( 'rem-archive-property-css', REM_URL . '/assets/front/css/archive-property.css' );
        wp_enqueue_script( 'rem-custom-carousel-js', REM_URL . '/assets/front/js/carousel.js', array('jquery'));

		$args = $this->rem_get_shortcode_query_args($attrs);

	    $args = apply_filters( 'rem_carousel_porperties_args_before_render', $args );

		ob_start();

			if($nearest_properties == 'enable'){
				?>
				<script>
				    if (navigator.geolocation) {
				        navigator.geolocation.getCurrentPosition(wcpSetPosition);
				    }
					function wcpSetPosition(position) {
						var href = window.location.href;
						if (href.indexOf('lat') == -1) {
							window.location.href = href += '/?lat='+position.coords.latitude+'&long='+position.coords.longitude;
						}
					}    
				</script>
				<?php
			}
			if ($nearest_properties == 'enable' && isset($_GET['lat']) && isset($_GET['long'])) {
				$args['posts_per_page'] = -1;
				$the_query = new WP_Query( $args );
				$in_theme = get_stylesheet_directory().'/rem/shortcodes/carousel/nearby.php';
				if (file_exists($in_theme)) {
					include $in_theme;
				} else {
					include REM_PATH. '/shortcodes/carousel/nearby.php';
				}
			} else {
				// The Loop
				$the_query = new WP_Query( $args );
				$in_theme = get_stylesheet_directory().'/rem/shortcodes/carousel/carousel.php';
				if (file_exists($in_theme)) {
					include $in_theme;
				} else {
					include REM_PATH. '/shortcodes/carousel/carousel.php';
				}
			}

		return ob_get_clean();
	}

    /**
     * It displays search results from widgets
     */
    function display_search_results($attrs, $content = ''){
		extract( shortcode_atts( array(
	        'order' 	=> 'ASC',
	        'orderby' 	=> 'date',
		), $attrs ) );
		
        rem_load_bs_and_fa();
        rem_load_basic_styles();
        wp_enqueue_style( 'rem-archive-property-css', REM_URL . '/assets/front/css/archive-property.css' );

        wp_enqueue_script( 'rem-imagefill-js', REM_URL . '/assets/front/lib/imagefill.min.js', array('jquery'));   
        wp_enqueue_script( 'rem-imagesloaded-js', REM_URL . '/assets/front/lib/imagesloaded.min.js', array('jquery'));

        wp_enqueue_script( 'rem-search-results', REM_URL . '/assets/front/js/search-results.js', array('jquery', 'jquery-masonry'));

    	ob_start();
    	if (isset($_GET['simple_search'])) {
			$in_theme = get_stylesheet_directory().'/rem/shortcodes/search-results-simple.php';
			if (file_exists($in_theme)) {
				include $in_theme;
			} else {
				include REM_PATH. '/shortcodes/search-results-simple.php';
			}
    	} else {
			$in_theme = get_stylesheet_directory().'/rem/shortcodes/search-results.php';
			if (file_exists($in_theme)) {
				include $in_theme;
			} else {
				include REM_PATH. '/shortcodes/search-results.php';
			}
    	}
    	return ob_get_clean();
    }

    function display_maps($attrs){

		if ( class_exists('Elementor\Plugin') && \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			return __( 'Live Preview is not available in Elementor edit mode but will work when visiting this page.', 'real-estate-manager' );
		}
		    	
    	$default_icon = rem_get_option('maps_property_image', REM_URL . '/assets/images/maps/cottage-pin.png');
    	$default_icon_h = rem_get_option('maps_property_image_hover', REM_URL . '/assets/images/maps/cottage-hover-pin.png');
		extract( shortcode_atts( array(
			'load_heading' 		=> 'Loading Maps',
			'load_desc' 		=> 'Please Wait...',
			'btn_bg_color' 		=> (isset($attrs['btn_bg_color'])) ? $attrs['btn_bg_color'] : rem_get_option('buttons_background_color'),
			'btn_text_color' 	=> (isset($attrs['btn_text_color'])) ? $attrs['btn_text_color'] : rem_get_option('buttons_text_color'),
			'btn_bg_color_hover' => (isset($attrs['btn_bg_color_hover'])) ? $attrs['btn_bg_color_hover'] : rem_get_option('buttons_background_color_hover'),
			'btn_text_color_hover' => (isset($attrs['btn_text_color_hover'])) ? $attrs['btn_text_color_hover'] : rem_get_option('buttons_text_color_hover'),
			'loader_color' => (isset($attrs['loader_color'])) ? $attrs['loader_color'] : rem_get_option('rem_main_color'),
			'type_bar_bg_color' => '',
			'water_color' 		=> '',
			'fill_color' 		=> '',
			'poi_color' 		=> '',
			'poi_color_hue' 	=> '',
			'roads_lightness' 	=> '',
			'lines_lightness'	=> '',
			'nearest_properties'=> 'disable',
			'map_height'=> '',
			
			'type_filtering' 	=> 'disable',
			'filter_by_key' 	=> 'property_type',
			'filter_options' 	=> 'House,Duplex,Apartment',
			'filter_bg' 	=> '',

			'use_map_from'	=> '',
			'def_lat'	=> '',
			'def_long'	=> '',
			'auto_center'	=> 'enable',
			'map_zoom'	=> '',
			'map_id'	=> 'leafletmaps',
			'leaflet_styles'	=> '',
			'search_query'	=> 'enable',
			'total_properties'	=> '10',
			
			'icons_by_meta'	=> 'property_purpose',
			'icons_data'	=> 'sell|'.$default_icon.'|'.$default_icon_h.',rent|'.$default_icon.'|'.$default_icon_h,
			'my_location_icon'	=> rem_get_option('maps_my_location_image', REM_URL. '/assets/images/maps/you-are-here.png'),
			'circle_icon'	=> rem_get_option('maps_circle_image', REM_URL. '/assets/images/maps/m1.png'),
		), $attrs ) );

		if ($use_map_from == '') {
			$use_map_from = rem_get_option('use_map_from', 'leaflet');
		}

		if ($leaflet_styles == '') {
			$leaflet_styles = rem_get_leaflet_provider(rem_get_option('leaflet_style'));
		}

		$icons_array = explode(",", $icons_data);
		$map_icons = array();

		foreach ($icons_array as $icon_meta) {
			$icon_meta_arr = explode("|", $icon_meta);
			$map_icons[trim($icon_meta_arr[0])] = array(
				'static' => trim($icon_meta_arr[1]),
				'hover' => trim($icon_meta_arr[2]),
			);
		}

		// Fetching Properties and creating array
		$all_properties = array();
		$args = $this->rem_get_shortcode_query_args($attrs);

	    if ($search_query == 'enable' && isset($_REQUEST['search_property'])) {
	    	$args = rem_get_search_query($_REQUEST);
	    }

	    $args = apply_filters( 'rem_maps_properties_args_before_render', $args );

		ob_start();

		if($nearest_properties == 'enable'){
			?>
			<script>
			    if (navigator.geolocation) {
			        navigator.geolocation.getCurrentPosition(wcpSetPosition);
			    }
				function wcpSetPosition(position) {
					var href = window.location.href;
					if (href.indexOf('lat') == -1) {
						window.location.href = href += '/?lat='+position.coords.latitude+'&long='+position.coords.longitude;
					}
				}    
			</script>
			<?php
		}
		if ($nearest_properties == 'enable' && isset($_GET['lat']) && isset($_GET['long'])) {
			$args['posts_per_page'] = -1;
			$the_query = new WP_Query( $args );
			$in_theme = get_stylesheet_directory().'/rem/shortcodes/map/nearby.php';
			if (file_exists($in_theme)) {
				include $in_theme;
			} else {
				include REM_PATH. '/shortcodes/map/nearby.php';
			}
		} else {
			$the_query = new WP_Query( $args );
			$in_theme = get_stylesheet_directory().'/rem/shortcodes/map/map.php';
			if (file_exists($in_theme)) {
				include $in_theme;
			} else {
				include REM_PATH. '/shortcodes/map/map.php';
			}
		}

		return ob_get_clean();
    }
    function display_agents_on_map($attrs){

		if ( class_exists('Elementor\Plugin') && \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			return __( 'Live Preview is not available in Elementor edit mode but will work when visiting this page.', 'real-estate-manager' );
		}
		    	
    	$default_icon = rem_get_option('maps_property_image', REM_URL . '/assets/images/maps/cottage-pin.png');
    	$default_icon_h = rem_get_option('maps_property_image_hover', REM_URL . '/assets/images/maps/cottage-hover-pin.png');
		extract( shortcode_atts( array(
			'load_heading' 		=> 'Loading Maps',
			'load_desc' 		=> 'Please Wait...',
			'btn_bg_color' 		=> (isset($attrs['btn_bg_color'])) ? $attrs['btn_bg_color'] : rem_get_option('buttons_background_color'),
			'btn_text_color' 	=> (isset($attrs['btn_text_color'])) ? $attrs['btn_text_color'] : rem_get_option('buttons_text_color'),
			'btn_bg_color_hover' => (isset($attrs['btn_bg_color_hover'])) ? $attrs['btn_bg_color_hover'] : rem_get_option('buttons_background_color_hover'),
			'btn_text_color_hover' => (isset($attrs['btn_text_color_hover'])) ? $attrs['btn_text_color_hover'] : rem_get_option('buttons_text_color_hover'),
			'loader_color' => (isset($attrs['loader_color'])) ? $attrs['loader_color'] : rem_get_option('rem_main_color'),
			'type_bar_bg_color' => '',
			'water_color' 		=> '',
			'fill_color' 		=> '',
			'poi_color' 		=> '',
			'poi_color_hue' 	=> '',
			'roads_lightness' 	=> '',
			'lines_lightness'	=> '',
			'map_height'=> '',
			'circle_icon'	=> rem_get_option('maps_circle_image', REM_URL. '/assets/images/maps/m1.png'),

			'filter_bg' 	=> '',

			'use_map_from'	=> '',
			'def_lat'	=> '',
			'def_long'	=> '',
			'auto_center'	=> 'enable',
			'map_zoom'	=> '',
			'map_id'	=> 'leafletmaps',
			'leaflet_styles'	=> '',

			'orderby'      => '',
			'order'        => '',
			'meta_key'     => '',
			'meta_value'   => '',
			'total_agents'	=> '',
			'ids'			=> '',
			'active_map_pin'=> '',
			'hover_map_pin' => '',
			'box_style' => '1',
		), $attrs ) );

		if ($use_map_from == '') {
			$use_map_from = rem_get_option('use_map_from', 'leaflet');
		}

		if ($leaflet_styles == '') {
			$leaflet_styles = rem_get_leaflet_provider(rem_get_option('leaflet_style'));
		}

		// Fetching Agents and creating array
		$all_agents = array();

        $args = array(
            'role'         => 'rem_property_agent',
            'orderby'      => $orderby,
            'order'        => $order,
            'meta_key'     => $meta_key,
            'meta_value'   => $meta_value,
            'number'       => $total_agents,
        );


        if ($ids != '') {
            $args['include'] = explode(",", $ids);
        }

	    $args = apply_filters( 'rem_maps_agents_args_before_render', $args );
        
		$agents = get_users( $args );
		
		ob_start();
		$in_theme = get_stylesheet_directory().'/rem/shortcodes/map/agents-map.php';
		if (file_exists($in_theme)) {
			include $in_theme;
		} else {
			include REM_PATH. '/shortcodes/map/agents-map.php';
		}

		return ob_get_clean();
    }

    function list_agents($attrs){
		extract( shortcode_atts( array(
			'ids' 		=> '',
			'columns' 	=> 'col-sm-4',
			'orderby' 	=> 'login',
			'order' 	=> 'ASC',
			'meta_key' 	=> '',
			'style' 	=> '1',
			'meta_value' 	=> '',
			'masonry' 	=> 'enable',
			'total' 	=> '10',
		), $attrs ) );

		$args = array(
			'role'         => 'rem_property_agent',
			'orderby'      => $orderby,
			'order'        => $order,
			'meta_key'     => $meta_key,
			'meta_value'   => $meta_value,
			'number'   	   => $total,
		);

		if ($ids != '') {
			$args['include'] = explode(",", $ids);
		}
		
		$agents = get_users( $args );
        rem_load_bs_and_fa();
        rem_load_basic_styles();
        wp_enqueue_script( 'rem-imagesloaded-js', REM_URL . '/assets/front/lib/imagesloaded.min.js', array('jquery'));
        wp_enqueue_script( 'rem-agents-list-js', REM_URL . '/assets/front/js/list-agents.js', array('jquery', 'jquery-masonry'));
		ob_start();
			$the_query = new WP_Query( $args );
			$in_theme = get_stylesheet_directory().'/rem/shortcodes/agents.php';
			if (file_exists($in_theme)) {
				include $in_theme;
			} else {
				include REM_PATH. '/shortcodes/agents.php';
			}
		return ob_get_clean();
    }

    function logout_button($attrs){
		extract( shortcode_atts( array(
			'redirect' 		=> wp_logout_url(home_url()),
			'button_classes' => 'btn btn-default',
			'label' => __( 'Logout', 'real-estate-manager' ),
		), $attrs ) );
		if ($redirect == 'current') {
			global $wp;
			$redirect = home_url( $wp->request );			
		}    	
    	ob_start(); ?>
    		<span class="ich-settings-main-wrap">
				<?php if (is_user_logged_in()) { ?>
					<a href="<?php echo esc_url( $redirect ); ?>" class="<?php echo esc_attr($button_classes); ?>"><?php echo esc_attr($label); ?></a>
				<?php } ?>
    		</span>
    	<?php return ob_get_clean();
    }

    function render_categories($attrs){
    	$args = array(
    		'taxonomy' => 'rem_property_cat',
   		);
    	if (is_array($attrs)) {
	        foreach ($attrs as $key => $value) {
	            if ($key != 'class' && $key != 'images_size' && $key != 'images_height' && $key != 'masonry') {
	                $args[$key] = $value;
	            }
	        }
	    }

		$categories = get_terms( $args );
		rem_load_bs_and_fa();
		rem_load_basic_styles();

        if (isset($attrs['masonry']) && $attrs['masonry'] == 'enable') {
        	wp_enqueue_script( 'jquery-masonry' );
        }
        // Imagesfill and Loaded
        wp_enqueue_script( 'rem-imagefill-js', REM_URL . '/assets/front/lib/imagefill.min.js', array('jquery'));   
        wp_enqueue_script( 'rem-imagesloaded-js', REM_URL . '/assets/front/lib/imagesloaded.min.js', array('jquery'));
        wp_enqueue_script( 'rem-category-js', REM_URL . '/assets/front/js/category.js', array('jquery'));

        wp_enqueue_style( 'rem-categories', REM_URL . '/assets/front/css/categories.css' );

		ob_start();
			$in_theme = get_stylesheet_directory().'/rem/categories.php';
			if (file_exists($in_theme)) {
				include $in_theme;
			} else {
				include REM_PATH. '/shortcodes/categories.php';
			}
		return ob_get_clean();
	}

    function rem_vc_addons_setup(){
    	if (rem_get_option('wpbakery_addons', 'enable') == 'enable') {
	    	include_once REM_PATH. '/shortcodes/page-builders/page-builder-fields.php';
	    	include REM_PATH. '/shortcodes/page-builders/wpbakery/settings.php';
	    	foreach ($shortcodes as $sc) {
				vc_map($sc);
	    	}
    	}
    }

    function display_agent($attrs, $content = ''){
		extract( shortcode_atts( array(
			'author_id' 		=> '1',
		), $attrs ) );
		global $rem_ob;

        rem_load_bs_and_fa();
        rem_load_basic_styles();
        wp_enqueue_style( 'rem-skillbars-css', REM_URL . '/assets/front/lib/skill-bars.css' );

        // Imagesfill and Loaded
        wp_enqueue_script( 'rem-imagefill-js', REM_URL . '/assets/front/lib/imagefill.min.js', array('jquery'));   
        wp_enqueue_script( 'rem-imagesloaded-js', REM_URL . '/assets/front/lib/imagesloaded.min.js', array('jquery'));   
        
        // Carousel
        wp_enqueue_style( 'rem-carousel-css', REM_URL . '/assets/front/lib/slick.css' );
        wp_enqueue_script( 'rem-carousel-js', REM_URL . '/assets/front/lib/slick.min.js', array('jquery'));

        // Page Specific
        wp_enqueue_style( 'rem-archive-property-css', REM_URL . '/assets/front/css/archive-property.css' );
        wp_enqueue_style( 'rem-profile-agent-css', REM_URL . '/assets/front/css/profile-agent.css' );
        wp_enqueue_script( 'rem-profile-agent-js', REM_URL . '/assets/front/js/profile-agent.js', array('jquery'));

		ob_start();
			$in_theme = get_stylesheet_directory().'/rem/shortcodes/agent-profile.php';
			if (file_exists($in_theme)) {
				include $in_theme;
			} else {
				include REM_PATH. '/shortcodes/agent-profile.php';
			}
		return ob_get_clean();
    }

    function my_profile($attrs, $content = ''){
		if (is_user_logged_in()) {
			global $rem_ob;

	        $current_user = wp_get_current_user();
	        $author_id = $current_user->ID;

	        rem_load_bs_and_fa();
	        rem_load_basic_styles();
	        wp_enqueue_style( 'rem-skillbars-css', REM_URL . '/assets/front/lib/skill-bars.css' );

	        // Imagesfill and Loaded
	        wp_enqueue_script( 'rem-imagefill-js', REM_URL . '/assets/front/lib/imagefill.min.js', array('jquery'));   
	        wp_enqueue_script( 'rem-imagesloaded-js', REM_URL . '/assets/front/lib/imagesloaded.min.js', array('jquery'));   
	        
	        // Carousel
	        wp_enqueue_style( 'rem-carousel-css', REM_URL . '/assets/front/lib/slick.css' );
	        wp_enqueue_script( 'rem-carousel-js', REM_URL . '/assets/front/lib/slick.min.js', array('jquery'));

	        // Page Specific
	        wp_enqueue_style( 'rem-archive-property-css', REM_URL . '/assets/front/css/archive-property.css' );
	        wp_enqueue_style( 'rem-profile-agent-css', REM_URL . '/assets/front/css/profile-agent.css' );
	        wp_enqueue_script( 'rem-profile-agent-js', REM_URL . '/assets/front/js/profile-agent.js', array('jquery'));

			ob_start();
				$in_theme = get_stylesheet_directory().'/rem/shortcodes/agent-profile.php';
				if (file_exists($in_theme)) {
					include $in_theme;
				} else {
					include REM_PATH. '/shortcodes/agent-profile.php';
				}
			return ob_get_clean();
		} else {
			if ($content != '') {
				return apply_filters( 'the_content', $content );
			} else {
				return $this->login_agent();
			}
		}

    }

    function edit_agent($attrs, $content = ''){
		if (is_user_logged_in()) {

            rem_load_bs_and_fa();
            rem_load_basic_styles();
            wp_enqueue_media();
            wp_enqueue_style( 'rem-register-css', REM_URL . '/assets/front/css/register-agent.css' );
            
            $current_user = wp_get_current_user();
            $agent_id = $current_user->ID;
            $agent_email = $current_user->user_email;

            $agent_latitude = get_user_meta( $agent_id, 'agent_latitude', true );
            $agent_longitude = get_user_meta( $agent_id, 'agent_longitude', true );

            $rem_registration_vars = array(
                'error_text' => __( 'Error', 'real-estate-manager' ),
                'wait_text' => __( 'Please Wait...', 'real-estate-manager' ),
                'ajaxurl' => admin_url( 'admin-ajax.php' ),
                'success_text' => __( 'Registration Successful', 'real-estate-manager' ),
                'password_mismatch' => __( 'Passwords did not match!', 'real-estate-manager' ),
                'file_size_error' => __( 'Maximum file size allowed is:', 'real-estate-manager' ),
                'file_format_error' => __( 'Allowed formats are:', 'real-estate-manager' ),
            );

            if (rem_get_option('agent_location') == 'enable') {
                $def_lat = $agent_latitude; 
                $def_long = $agent_longitude;
                $zoom_level = rem_get_option('maps_zoom_level', '18');
                $map_type = rem_get_option( 'maps_type', 'roadmap');
                $maps_api = apply_filters( 'rem_maps_api', 'AIzaSyBbpbij9IIXGftKhFLMHOuTpAbFoTU_8ZQ');
                $drag_icon = apply_filters( 'rem_maps_drag_icon', REM_URL.'/assets/images/pin-drag.png' );
                if (rem_get_option('use_map_from', 'leaflet') == 'leaflet') {
                    wp_enqueue_style( 'rem-leaflet-css', REM_URL . '/assets/front/leaflet/leaflet.css');
                    wp_enqueue_script( 'rem-leaflet-js', REM_URL . '/assets/front/leaflet/leaflet.js', array('jquery'));
                    wp_enqueue_style( 'rem-leaflet-geo-css', 'https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css');
                    wp_enqueue_script( 'rem-leaflet-geo-js', 'https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js');
                } else {
                    if (is_ssl()) {
                        wp_enqueue_script( 'rem-agent-map', 'https://maps.googleapis.com/maps/api/js?key='.$maps_api.'&libraries=places');
                    } else {
                        wp_enqueue_script( 'rem-agent-map', 'http://maps.googleapis.com/maps/api/js?key='.$maps_api.'&libraries=places');
                    }
                }

                $rem_registration_vars['use_map_from'] = rem_get_option('use_map_from', 'leaflet');
                $rem_registration_vars['def_lat'] = $def_lat;
                $rem_registration_vars['def_long'] = $def_long;
                $rem_registration_vars['zoom_level'] = $zoom_level;
                $rem_registration_vars['map_type'] = $map_type;
                $rem_registration_vars['leaflet_styles'] = rem_get_leaflet_provider(rem_get_option('leaflet_style'));
                $rem_registration_vars['maps_api'] = $maps_api;
                $rem_registration_vars['drag_icon'] = $drag_icon;
                $rem_registration_vars['maps_styles'] = stripcslashes(rem_get_option('maps_styles'));
            }

            wp_enqueue_script( 'rem-register-agent-js', REM_URL . '/assets/front/js/edit-agent.js', array('jquery'));
            wp_localize_script( 'rem-register-agent-js', 'rem_edit_agent_vars', $rem_registration_vars );

			ob_start();
				$in_theme = get_stylesheet_directory().'/rem/shortcodes/edit-agent.php';
				if (file_exists($in_theme)) {
					include $in_theme;
				} else {
					include REM_PATH. '/shortcodes/edit-agent.php';
				}
			return ob_get_clean();
		} else {
			return apply_filters( 'the_content', $content );
		}
    }

    function change_password_form($attrs, $content = ''){
		if (is_user_logged_in()) {

			extract( shortcode_atts( array(
				'title' => 'Change Your Password',
				'subtitle' => '',
				'clear_sessions' => 'enable',
				'redirect' => '',
			), $attrs ) );

            rem_load_bs_and_fa();
            rem_load_basic_styles();
            wp_enqueue_style( 'rem-password-css', REM_URL . '/assets/front/css/change-password.css' );
            wp_enqueue_script( 'sweet-alerts', REM_URL . '/assets/admin/js/sweetalert.min.js' , array('jquery'));
            wp_enqueue_script( 'rem-change-pass', REM_URL . '/assets/front/js/change-password.js' , array('jquery'));

            $rem_pass_vars = array(
            	'error_text' => __( 'Error', 'real-estate-manager' ),
            	'pass_match' => __( 'New password did not match', 'real-estate-manager' ),
            	'ajax_url' => admin_url( 'admin-ajax.php' ),
            	'wait_text' => __( 'Please Wait...', 'real-estate-manager' ),
            );
            wp_localize_script( 'rem-change-pass', 'rem_pass_vars', $rem_pass_vars );            

			ob_start();
				$in_theme = get_stylesheet_directory().'/rem/shortcodes/change-password.php';
				if (file_exists($in_theme)) {
					include $in_theme;
				} else {
					include REM_PATH. '/shortcodes/change-password.php';
				}
			return ob_get_clean();
		} else {
			return apply_filters( 'the_content', $content );
		}
    }

    function single_property($attrs, $content = ''){
    	$property_id = (isset($attrs['id'])) ? $attrs['id'] : '' ;
    	$sidebar = (isset($attrs['sidebar'])) ? $attrs['sidebar'] : 'disable' ;
    	if (!$property_id) {
			global $wp_query;
    		$property_id = $wp_query->post->ID;    		
    	}
		if ($property_id && get_post_status( $property_id )) {

            rem_load_bs_and_fa();

            rem_load_basic_styles();

            $gallery_type = rem_get_option('gallery_type', 'fotorama');
            $gallery_type = apply_filters( 'rem_single_property_gallery_type', $gallery_type, $property_id);

            if ($gallery_type == 'fotorama') {
                wp_enqueue_style( 'rem-fotorama-css', REM_URL . '/assets/front/lib/fotorama.min.css' );
                wp_enqueue_script( 'rem-photorama-js', REM_URL . '/assets/front/lib/fotorama.min.js', array('jquery'));
            }
            if ($gallery_type == 'slick') {
                wp_enqueue_style( 'rem-carousel-css', REM_URL . '/assets/front/lib/slick.css' );
                wp_enqueue_script( 'rem-carousel-js', REM_URL . '/assets/front/lib/slick.min.js', array('jquery'));
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
            wp_enqueue_script( 'rem-single-property-js', REM_URL . '/assets/front/js/single-property.js', array('jquery'));

            // If Map is enabled
            if (rem_single_property_has_map($property_id)) {
                $property_id = $property_id;
                $latitude = get_post_meta($property_id, 'rem_property_latitude', true);
                $longitude = get_post_meta($property_id, 'rem_property_longitude', true);
                $address = get_post_meta($property_id, 'rem_property_address', true);
                $city = get_post_meta($property_id, 'rem_property_city', true);
                $state = get_post_meta($property_id, 'rem_property_state', true);
                $country = get_post_meta($property_id, 'rem_property_country', true);
                $zoom = rem_get_option( 'maps_zoom_level', 10);
                $map_type = rem_get_option( 'maps_type', 'roadmap');
                $maps_api = apply_filters( 'rem_maps_api', 'AIzaSyBbpbij9IIXGftKhFLMHOuTpAbFoTU_8ZQ');
                $maps_icon_url = apply_filters( 'rem_maps_location_icon', REM_URL . '/assets/images/pin-maps.png', $property_id );
                $load_map_from = ($latitude == '' || $longitude == '') ? 'address' : 'coords' ;
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
                $localize_vars = array(
                    'use_map_from' => rem_get_option('use_map_from', 'leaflet'),
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'zoom' => $zoom,
                    'map_type' => $map_type,
                    'leaflet_styles' => rem_get_leaflet_provider(rem_get_option('leaflet_style')),
                    'address' => implode( ' ', array_filter( array( $address, $city, $state, $country ) ) ),
                    'load_map_from' => $load_map_from,
                    'maps_icon_url' => $maps_icon_url,
                    'maps_styles' => stripcslashes(rem_get_option('maps_styles')),
                );
            }

            wp_enqueue_script( 'rem-single-property-js', REM_URL . '/assets/front/js/single-property.js', array('jquery'));

            if (isset($localize_vars)) {
                wp_localize_script( 'rem-single-property-js', 'rem_property_map', $localize_vars );
            } else {
                $localize_vars = array(
                    'latitude' => 'disable',
                );                
                wp_localize_script( 'rem-single-property-js', 'rem_property_map', $localize_vars );
            }

			ob_start();
				$in_theme = get_stylesheet_directory().'/rem/shortcodes/single-property.php';
				if (file_exists($in_theme)) {
					include $in_theme;
				} else {
					include REM_PATH. '/shortcodes/single-property.php';
				}
			return ob_get_clean();
		} else {
			return __( 'There is no property having ID ', 'real-estate-manager' ).' '.$property_id;
		}
    }

    function rem_user_login_check(){
        if (isset($_REQUEST)) {
            if (isset($_REQUEST['g-recaptcha-response'])) {
                if (!$_REQUEST['g-recaptcha-response']) {
                    $resp = array('status' => 'failed', 'message' => __( 'Please check the captcha form.', 'real-estate-manager' ));
                    echo json_encode($resp); exit;
                } else {
                    $captcha = $_REQUEST['g-recaptcha-response'];
                    $secretKey = rem_get_option('captcha_secret_key', '6LcDhUQUAAAAAGKQ7gd1GsGAkEGooVISGEl3s7ZH');
                    $ip = $_SERVER['REMOTE_ADDR'];
                    $response = wp_remote_post("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
                    $responseKeys = json_decode($response['body'], true);
                    if(intval($responseKeys["success"]) !== 1) {
                        $resp = array('status' => 'failed', 'message' => __( 'There was an error. Please try again after reloading page', 'real-estate-manager' ));
                        echo json_encode($resp); exit;
                    }
                }
            }        	
            global $user;
            $creds = array();
            $creds['user_login'] = $_REQUEST['rem_username'];
            $creds['user_password'] =  $_REQUEST['rem_userpass'];
            $creds['remember'] = (isset($_REQUEST['rememberme'])) ? true : false;
            $user = wp_signon( $creds, true );
            
            if ( is_wp_error($user) ) {

                $resp = array(
                    'status'    => 'failed',
                    'message'   => $user->get_error_message(),
                );
                echo json_encode($resp);
            }
            if ( !is_wp_error($user) ) {
                $resp = array(
                    'status'    => 'success',
                    'message'   => __( 'Successful!', 'real-estate-manager' ),
                );
                wp_set_auth_cookie( $user->ID, true, false );
            	wp_set_current_user( $user->ID );
                echo json_encode($resp);
            }

            die(0);
        }
    }

    function create_property_frontend(){
        if (isset($_REQUEST) && $_REQUEST != '') {
        	$current_user_data = wp_get_current_user();

            // create a preview
            if (isset($_REQUEST['preview_property'])) {

            	// if already has preview, just update
            	$previous_id = (isset($_REQUEST['property_preview_id']) && $_REQUEST['property_preview_id'] != '') ? $_REQUEST['property_preview_id'] : '' ;
            	$property_id = $this->insert_property_in_db($previous_id, $_REQUEST, $current_user_data, 'draft');
                $resp = array(
                    'property_id' => $property_id,
                    'preview_link' => get_preview_post_link($property_id),
                );
                wp_send_json($resp);

            // create from preview (already in draft)
            } elseif (isset($_REQUEST['property_preview_id']) && get_post_field( 'post_author', $_REQUEST['property_preview_id'] ) == $current_user_data->ID) {
        		if(rem_get_option('property_submission_mode') == 'approve'){
        			$property_id = $this->insert_property_in_db($_REQUEST['property_preview_id'], $_REQUEST, $current_user_data, 'pending');
        		} else {
        			$property_id = $this->insert_property_in_db($_REQUEST['property_preview_id'], $_REQUEST, $current_user_data, 'publish');
        		}

        		echo apply_filters( 'rem_redirect_after_property_submit', get_permalink( $property_id ), $_REQUEST );

        	// already created, just update data
            } elseif (isset($_REQUEST['property_id']) && get_post_field( 'post_author', $_REQUEST['property_id'] ) == $current_user_data->ID) {
        		$status = (isset($_REQUEST['accessibility']) && $_REQUEST['accessibility'] != '') ? $_REQUEST['accessibility'] : get_post_status( $_REQUEST['property_id'] ) ;
        		if (isset($_REQUEST['accessibility']) && $_REQUEST['accessibility'] == 'publish') {
        			if($this->property_can_be_published($_REQUEST['property_id'])){
        				$property_id = $this->insert_property_in_db($_REQUEST['property_id'], $_REQUEST, $current_user_data, 'publish');
        			} else {
        				$property_id = $this->insert_property_in_db($_REQUEST['property_id'], $_REQUEST, $current_user_data, 'pending');
        			}
        		} else {
        			$property_id = $this->insert_property_in_db($_REQUEST['property_id'], $_REQUEST, $current_user_data, $status);
        		}
        	    echo apply_filters( 'rem_redirect_after_property_edit', get_permalink( $property_id ), $_REQUEST );

        	// Create a new    
            } else {
            	if(rem_get_option('property_submission_mode') == 'approve'){
            		$property_id = $this->insert_property_in_db('', $_REQUEST, $current_user_data, 'pending');
            	} else {
            		$property_id = $this->insert_property_in_db($_REQUEST['property_id'], $_REQUEST, $current_user_data, 'publish');
            	}
            	echo apply_filters( 'rem_redirect_after_property_submit', get_permalink( $property_id ), $_REQUEST );
            }

        }

        die();
    }

    function property_can_be_published($property_id){
    	if (rem_get_option('property_submission_mode') == 'approve' && get_post_status($property_id) !== 'publish') {
    		return false;
    	}
    	return true;
    }

    function insert_property_in_db($property_id = '', $data = '', $current_user_data = '', $status = 'draft'){
    	$property_data = array(
    	  'post_title'    => wp_strip_all_tags( $data['title'] ),
    	  'post_content'  => $data['content'],
    	  'post_author'   => $current_user_data->ID,
    	  'post_type'   => 'rem_property',
    	  'post_status'   => apply_filters( 'rem_property_publish_status', $status, $current_user_data->ID, $property_id ),
    	);

    	// if already created
    	if ( $property_id != '') {
    	    $property_data['ID'] = $property_id;
    	}
    	
    	$property_id = wp_insert_post( $property_data );

        foreach ($data as $key => $meta) {
            if ($key != 'title' || $key != 'content' || $key != 'rem_property_data' || $key != 'tags') {
                update_post_meta( $property_id, 'rem_'.$key, $meta );
            }

            if ($key == 'rem_property_data') {
                update_post_meta( $property_id, 'rem_property_images', $meta['property_images'] );
                $img_ids = 0;
                foreach ($meta['property_images'] as $imgID => $id) {
                    if ($img_ids == 0) {
                        set_post_thumbnail( $property_id, $imgID );
                    } else {
                    	wp_update_post(
                    	    array(
                    	        'ID' => $imgID, 
                    	        'post_parent' => $property_id
                    	    )
                    	);                  	
                    }
                    $img_ids++;
                }
            }

            if ($key == 'tags') {
                wp_set_post_terms( $property_id, $meta, 'rem_property_tag' );
            }
        }

        if (!isset($data['property_detail_cbs'])) {
            update_post_meta( $property_id, 'rem_property_detail_cbs', '' );
        }
        if (!isset($data['rem_property_data']['property_images'])) {
            update_post_meta( $property_id, 'rem_property_images', '' );
        }
        if (!isset($data['file_attachments'])) {
            update_post_meta( $property_id, 'rem_file_attachments', '' );
        }        

        do_action( "rem_after_property_create_frontend", $property_id, $data );
        
    	return $property_id;
    }

    function rem_save_profile_front(){
        $current_user = wp_get_current_user();
        $agent_id = $current_user->ID;
        if ($agent_id == $_REQUEST['agent_id']) {
            foreach ($_REQUEST as $key => $value) {
                if ($key == 'useremail') {
                    wp_update_user( array(
                        'ID' => $agent_id,
                        'user_email' => $value,
                    ));
                } elseif ($key == 'action') {
                    
                } elseif ($key == 'agent_id') {
                    
                } elseif ($key == 'display_name') {
                    wp_update_user( array(
                        'ID' => $agent_id,
                        'display_name' => $value,
                    ));
                } else {
                	if ($key != 'wp_capabilities') {
                    	update_user_meta( $agent_id, $key, sanitize_text_field( $value ) );
                	}
                }
            }
        }

        echo '<p class="alert alert-success">'.__( "Changes Saved!", 'real-estate-manager' ).'</p>';

        die(0);
    }

    
    function get_distance( $latitude1, $longitude1, $latitude2, $longitude2 ) {  
        $earth_radius = 6371;

        $dLat = deg2rad( $latitude2 - $latitude1 );
        $dLon = deg2rad( $longitude2 - $longitude1 );

        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon/2) * sin($dLon/2);  
        $c = 2 * asin(sqrt($a));  
        $d = $earth_radius * $c;  

        return $d;
    }

    function search_results(){
        if(isset($_REQUEST)){
            extract($_REQUEST);
            include REM_PATH . '/inc/ajax/search-property-ajax.php';
        }

        die(0);
    }

    function rem_search_autocomplete(){
    	if(isset($_REQUEST['field'])){
    		$results  = array();
		    $args = array(
		        'post_type' =>  'rem_property',
		        'post_status' => 'publish',
		        'posts_per_page' => -1
		    );
		    if ($_REQUEST['field'] == 'keywords') {
		    	$args['s'] = $_REQUEST['search'];
		    }
		    $the_query = new WP_Query( $args );
		    if ( $the_query->have_posts() ) :
		    	while ( $the_query->have_posts() ) : $the_query->the_post();
		    			if ($_REQUEST['field'] == 'keywords') {
		    				$value = get_the_title( get_the_id() );
		    			} else {
		                	$value = get_post_meta( get_the_id(), 'rem_'.$_REQUEST['field'], true );
		    			}
		                if (!in_array($value, $results) && strpos(strtolower($value), strtolower($_REQUEST['search'])) !== false) {
		                	$results[] = $value;
		                }
		        endwhile;
		        echo json_encode($results);
		        wp_reset_postdata();

		    else :
		    	echo json_encode($results);
		    endif;		    
    	}
    	die(0);
    }

    function rem_register_agent(){
        if (isset($_REQUEST)) {
            $resp = array();

        	// Checking for Spams
            if (isset($_REQUEST['g-recaptcha-response'])) {
            	if (!$_REQUEST['g-recaptcha-response']) {
                	$resp = array('status' => 'already', 'msg' => __( 'Please check the captcha form.', 'real-estate-manager' ));
                	echo json_encode($resp); exit;
            	} else {
            		$captcha = $_REQUEST['g-recaptcha-response'];
					$secretKey = rem_get_option('captcha_secret_key', '6LcDhUQUAAAAAGKQ7gd1GsGAkEGooVISGEl3s7ZH');
					$ip = $_SERVER['REMOTE_ADDR'];
					$response = wp_remote_post("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
					$responseKeys = json_decode($response['body'], true);
					if(intval($responseKeys["success"]) !== 1) {
                		$resp = array('status' => 'error', 'msg' => __( 'There was an error. Please try again after reloading page.', 'real-estate-manager' ));
                		echo json_encode($resp); exit;
					}
            	}
            }

            // Lets Check if username already exists
            if (username_exists( $_REQUEST['username'] ) || email_exists( $_REQUEST['useremail'] )) {
                $resp = array('status' => 'already', 'msg' => __( 'Username or Email already exists', 'real-estate-manager' ));
            } else {

            	if (rem_get_option('agents_approval', 'manual') == 'auto') {
            		extract($_REQUEST);
		            $agent_id = wp_create_user( $username, $password, $useremail );
	                if ($agent_id) {
			            // WPML Language
			            if (isset($_REQUEST['wpml_user_email_language'])) {
			                update_user_meta( $agent_id, 'icl_admin_language', $_REQUEST['wpml_user_email_language']);
			            }
	                    do_action( 'rem_new_agent_register', $_REQUEST );
	                    $resp = array('status' => 'success', 'msg' => __( 'Registered Successfully, please wait until admin approves.', 'real-estate-manager' ));
	                } else {
	                    $resp = array('status' => 'error', 'msg' => __( 'Error, please try later', 'real-estate-manager' ));
	                }

		            do_action( 'rem_new_agent_approved', $_REQUEST );

		            if ($agent_id) {
		                wp_update_user( array( 'ID' => $agent_id, 'role' => 'rem_property_agent' ) );
			            global $rem_ob;
			            $agent_fields = $rem_ob->get_agent_fields();

			            foreach ($agent_fields as $field) {
			                if (isset($_REQUEST[$field['key']])) {
			                    update_user_meta( $agent_id, $field['key'], $_REQUEST[$field['key']]);
			                }
			            }
			            if (isset($_REQUEST['agent_longitude'])) {
			            	update_user_meta( $agent_id, 'agent_longitude', $_REQUEST['agent_longitude']);
			            }
			            if (isset($_REQUEST['agent_latitude'])) {
			            	update_user_meta( $agent_id, 'agent_latitude', $_REQUEST['agent_latitude']);
			            }
		                // if image uploaded
			            if ( isset($_FILES["rem_agent_meta_image"]) ) { 
			            	require_once( ABSPATH . 'wp-admin/includes/image.php' );
			            	require_once( ABSPATH . 'wp-admin/includes/file.php' );
			            	require_once( ABSPATH . 'wp-admin/includes/media.php' );
			            	$attachment_id = media_handle_upload( 'rem_agent_meta_image', 0 );
				            update_user_meta( $agent_id, 'rem_agent_meta_image', wp_get_attachment_url( $attachment_id ));
				        }

				        if (rem_get_option('auto_login') == 'enable') {
					        wp_set_current_user($agent_id);
					        wp_set_auth_cookie($agent_id);
				        }
		            }

            		
            	} else {
	                $_REQUEST['time'] = current_time( 'mysql' );

	                $previous_users = get_option( 'rem_pending_users' );
	                
	                // if image uploaded
		            if ( isset($_FILES["rem_agent_meta_image"]) ) { 
		            	require_once( ABSPATH . 'wp-admin/includes/image.php' );
		            	require_once( ABSPATH . 'wp-admin/includes/file.php' );
		            	require_once( ABSPATH . 'wp-admin/includes/media.php' );
		            	$attachment_id = media_handle_upload( 'rem_agent_meta_image', 0 );
			            $_REQUEST['rem_agent_meta_image'] = wp_get_attachment_url( $attachment_id );
			        }
	                if ( $previous_users != '' && is_array($previous_users)) {
	                   foreach ($previous_users as $single_user) {
	                       if ($single_user['username'] == $_REQUEST['username'] || $single_user['useremail'] == $_REQUEST['useremail']) {
	                            $resp = array('status' => 'already', 'msg' => __( 'Username or Email already exists', 'real-estate-manager' ));
	                            echo json_encode($resp);
	                            exit;
	                       }
	                   }
	                   $previous_users[] = $_REQUEST;
	                } else {
	                   $previous_users = array($_REQUEST);
	                }

	                if (update_option( 'rem_pending_users', $previous_users )) {
	                    do_action( 'rem_new_agent_register', $_REQUEST );
	                    $resp = array('status' => 'success', 'msg' => __( 'Registered Successfully, please wait until admin approves.', 'real-estate-manager' ));
	                } else {
	                    $resp = array('status' => 'error', 'msg' => __( 'Error, please try later', 'real-estate-manager' ));
	                }
            	}
            }

            wp_send_json( $resp );
        }
    }

    function delete_property(){
    	if (isset($_REQUEST['p_id'])) {
    		$current_user_data = wp_get_current_user();
    		if (get_post_field( 'post_author', $_REQUEST['p_id'] ) == $current_user_data->ID || current_user_can( 'manage_options' )) {
	    		if (rem_get_option('attachment_deletion', 'remain') == 'delete') {
	    			$gallery_images = get_post_meta( $_REQUEST['p_id'], 'rem_property_images', true );
	    			foreach ($gallery_images as $key => $id) {
	    				wp_delete_attachment( $id, false );
	    			}
	    		}
	    		if (rem_get_option('property_deletion', 'delete') == 'trash') {
	    			wp_trash_post( $_REQUEST['p_id'] );
	    		} else {
	    			wp_delete_post( $_REQUEST['p_id'], true );
	    		}
	    		echo __( 'Deleted', 'real-estate-manager' );
    		} else {
	    		echo __( 'Sorry! You can not delete this property.', 'real-estate-manager' );
    		}
    	}
    	die(0);
    }

    function change_password(){
    	if (isset($_REQUEST['old_pass']) && isset($_REQUEST['new_pass'])) {
    		$user = wp_get_current_user();
    		$resp = array('status' => 'error', 'message' => __( 'There is an error', 'real-estate-manager' ), 'title' => __( 'Failed', 'real-estate-manager' ));
    		$auth = wp_authenticate( $user->user_login, $_REQUEST['old_pass'] );
    		if(is_wp_error($auth)) {
    			$resp = array('status' => 'error', 'message' => wp_strip_all_tags($auth->get_error_message()), 'title' => __( 'Failed', 'real-estate-manager' ));
    		} else {
    			wp_set_password( $_REQUEST['new_pass'], $auth->ID );
    			$resp = array('status' => 'success', 'message' => __( 'Password changed for the user', 'real-estate-manager' ).' '.$user->user_login, 'title' => __( 'Success', 'real-estate-manager' ));
    			if (isset($_REQUEST['logoutall']) && $_REQUEST['logoutall'] == 'enable') {
	    			$sessions = WP_Session_Tokens::get_instance( $auth->ID );
	    			$sessions->destroy_all();
    			}
    		}    		
    		wp_send_json( $resp );
    	}
    	die(0);
    }

    function render_registration_field($field){
	    ?>
		<li>
			<span>
				<?php echo rem_wpml_translate($field['title'], 'real-estate-manager-fields'); ?>
				<?php echo (isset($field['required']) && $field['required'] == 'true' ) ? '<span title="'.__( 'Required', 'real-estate-manager' ).'" class="glyphicon glyphicon-asterisk"></span>' : '' ; ?>
			</span>
			<?php switch ($field['type']) {

				case 'text': ?>
					<input type="text" class="form-control" name="<?php echo esc_attr($field['key']); ?>" <?php echo (isset($field['required']) && $field['required'] == 'true') ? 'required' : '' ; ?> />
					<?php break;

				case 'email': ?>
					<input type="email" class="form-control" name="<?php echo esc_attr($field['key']); ?>" <?php echo (isset($field['required']) && $field['required'] == 'true') ? 'required' : '' ; ?> />
					<?php break;

				case 'checkbox': ?>
					<input type="checkbox" name="<?php echo esc_attr($field['key']); ?>" <?php echo (isset($field['required']) && $field['required'] == 'true') ? 'required' : '' ; ?> />
					<?php break;

				case 'select': ?>
					<select class="form-control" name="<?php echo esc_attr($field['key']); ?>" <?php echo (isset($field['required']) && $field['required'] == 'true') ? 'required' : '' ; ?>>
						<?php $options = explode("\n", trim($field['options'])); foreach ($options as $op) {
							echo '<option value="'.esc_attr($op).'">'.esc_attr($op).'</option>';
						} ?>
					</select>
					<?php break;

				case 'password': ?>
					<input type="password" class="form-control" name="<?php echo esc_attr($field['key']); ?>" <?php echo (isset($field['required']) && $field['required'] == 'true') ? 'required' : '' ; ?> />
					<?php break;
				case 'image': ?>
					<?php if (is_user_logged_in()) {  ?>
						<p class="text-center">
							<button type="button" class="btn btn-default upload_image_button" data-title="<?php esc_attr_e( 'Select image', 'real-estate-manager' ); ?>" data-btntext="<?php esc_attr_e( 'Insert', 'real-estate-manager' ); ?>">
								<span class="dashicons dashicons-images-alt2"></span>
								<?php esc_attr_e( 'Upload Images or Videos', 'real-estate-manager' ); ?>
							</button>
						</p>
						<div class="thumbs-prev">

						</div>
					<?php } else {
					if (!empty($field['file_types'])) {
						$types = explode(',', $field['file_types']);
						$file_types = $types;
					} else {
						$file_types = array("png","jpeg");
					}
					$max_size = !empty($field['max_upload_size']) ? $field['max_upload_size'] : '10'; 
					?>
						<p class="text-center">
							<input data-size="<?php echo esc_attr( $max_size ); ?>" data-types='<?php echo json_encode($file_types); ?>' id="<?php echo esc_attr($field['key']); ?>" type="file" accept="image/*" class="form-control" name="<?php echo esc_attr($field['key']); ?>" <?php echo (isset($field['required']) && $field['required'] == 'true') ? 'required' : '' ; ?> />
						</p>
						<div class="upload-response">
							<p><?php echo rem_wpml_translate($field['help'], 'real-estate-manager-fields'); ?></p>
						</div>
						<div class="agent-dp-prev">
							<img src="" alt="">
						</div>
						<div class="clearfix"></div>
					<?php } ?>
					<?php break;

				case 'textarea': ?>
					<textarea name="<?php echo esc_attr($field['key']); ?>" <?php echo (isset($field['required']) && $field['required'] == 'true') ? 'required' : '' ; ?> class="form-control"></textarea>
					<br>
					<p><?php echo rem_wpml_translate($field['help'], 'real-estate-manager-fields'); ?></p>
					<?php break;
				
				default:
					break;
			} ?>
		</li>
	    <?php
    }

    function render_agent_edit_field($field, $agent_id){
    	$field_attrs = apply_filters( 'rem_agent_edit_field_attrs', '',  $field, $agent_id );
	    ?>
		<li>
			<span><?php echo rem_wpml_translate($field['title'], 'real-estate-manager-fields'); ?></span>
			<?php switch ($field['type']) {
				case 'text': ?>
					<?php if ($field['key'] == 'display_name') { $user_info = get_userdata($agent_id); ?>
						<input class="form-control" <?php echo esc_attr($field_attrs); ?> type="text" value="<?php echo esc_attr($user_info->display_name); ?>" name="<?php echo esc_attr($field['key']); ?>" <?php echo (isset($field['required']) && $field['required'] == 'true') ? 'required' : '' ; ?> />
						<i class="icon fas fa-pencil-alt"></i>
					<?php } else { ?>
						<input class="form-control" <?php echo esc_attr($field_attrs); ?> type="text" value="<?php echo get_user_meta( $agent_id, $field['key'], true ); ?>" name="<?php echo esc_attr($field['key']); ?>" <?php echo (isset($field['required']) && $field['required'] == 'true') ? 'required' : '' ; ?> />
						<i class="icon fas fa-pencil-alt"></i>
					<?php } ?>
					<?php break;
				case 'number': ?>
					<input class="form-control" <?php echo esc_attr($field_attrs); ?> type="number" value="<?php echo get_user_meta( $agent_id, $field['key'], true ); ?>" name="<?php echo esc_attr($field['key']); ?>" <?php echo (isset($field['required']) && $field['required'] == 'true') ? 'required' : '' ; ?> />
					<i class="icon fas fa-pencil-alt"></i>
					<?php break;
				case 'email':
					$user_info = get_userdata( $agent_id ); ?>
					<input class="form-control" <?php echo esc_attr($field_attrs); ?> type="email" value="<?php echo esc_attr($user_info->user_email); ?>" name="<?php echo esc_attr($field['key']); ?>" <?php echo (isset($field['required']) && $field['required'] == 'true') ? 'required' : '' ; ?> />
					<i class="icon fas fa-pencil-alt"></i>
					<?php break;
				case 'select': ?>
					<select class="form-control" <?php echo esc_attr($field_attrs); ?> name="<?php echo esc_attr($field['key']); ?>" <?php echo (isset($field['required']) && $field['required'] == 'true') ? 'required' : '' ; ?>>
						<?php
						$options = explode("\n", $field['options']);
						$val = get_user_meta( $agent_id, $field['key'], true );
                        $val = trim($val);
						foreach ($options as $op) {
                            $op = trim($op);
							echo '<option '.selected( $val, $op, false ).' value="'.esc_attr($op).'">'.esc_attr($op).'</option>';
						} ?>
					</select>
					<?php break;
				case 'image': ?>
					<input class="form-control img-url" <?php echo esc_attr($field_attrs); ?> type="text" value="<?php echo get_user_meta( $agent_id, $field['key'], true ); ?>" name="<?php echo esc_attr($field['key']); ?>" <?php echo (isset($field['required']) && $field['required'] == 'true') ? 'required' : '' ; ?> />
					<i data-title="<?php esc_attr_e( 'Choose Picture', 'real-estate-manager' ); ?>" data-btntext="<?php esc_attr_e( 'Add', 'real-estate-manager' ); ?>" class="upload_image_agent icon fa fa-upload"></i>
					<?php break;
				case 'textarea': ?>
					<textarea class="form-control" <?php echo esc_attr($field_attrs); ?> rows="4" name="<?php echo esc_attr($field['key']); ?>" <?php echo (isset($field['required']) && $field['required'] == 'true') ? 'required' : '' ; ?>><?php echo get_user_meta( $agent_id, $field['key'] , true ); ?></textarea>
					<p><?php echo rem_wpml_translate($field['help'], 'real-estate-manager-fields'); ?></p>
					<?php break;
				
				default:
					
					break;
			} ?>
		</li>
	    <?php
    }

    function render_property_field($field, $value = ''){
    	$default_val = ($value != '') ? $value : $field['default'];
    	$default_val = str_replace("\"", "'", $default_val);
    	$columns = apply_filters( 'rem_property_fields_cols', 'col-sm-4 col-xs-12', $field );
	    
	    $show_condition = isset($field['show_condition']) ? $field['show_condition'] : 'true' ; 
		$conditions = isset($field['condition']) ? $field['condition'] : array() ;
		$required = (isset($field['required']) && $field['required'] == 'true' ) ? 'required' : '' ;
		$required_badge = (isset($field['required']) && $field['required'] == 'true' ) ? '<span title="'.__( 'Required', 'real-estate-manager' ).'" class="glyphicon glyphicon-asterisk"></span>' : '' ;
		$dropdown_class = rem_get_option('dropdown_style', 'rem-easydropdown');

		// WPML/Ploylang
		$field_title = rem_wpml_translate($field['title'], 'real-estate-manager-fields');
		$help_text = rem_wpml_translate($field['help'], 'real-estate-manager-fields');
		
		$help_tooltip = (rem_get_option('property_fields_help_text') == 'enable' && $help_text != '') ? '<span title="'.wp_strip_all_tags($help_text).'" class="glyphicon glyphicon-question-sign"></span>' : '' ;
		$help_tooltip = apply_filters( 'property_fields_help_text', $help_tooltip, $field, $value );
	    ?>
		<div class="<?php echo esc_attr($columns); ?> space-form wrap-<?php echo esc_attr($field['key']); ?>" data-condition_status="<?php echo esc_attr($show_condition); ?>" data-condition_bound="<?php echo isset($field['condition_bound']) ? esc_attr($field['condition_bound']) : 'all' ?>" data-condition='<?php echo json_encode($conditions); ?>'>
			<?php 
			switch ($field['type']) {
	            case has_action( "rem_render_property_field_frontend_{$field['key']}" ) :
	                do_action( "rem_render_property_field_frontend_{$field['key']}", $field, $value );
	                break;
				case 'text':
				case 'number':
				case 'shortcode':
				case 'video':
                case 'date': 
                    $max = isset($field['max_value']) ? 'max="'.$field['max_value'].'"' : '';
                    $min = isset($field['min_value']) ? 'min="'.$field['min_value'].'"' : '';
                    $step = ($field['type'] == 'number') ? 'step=".01"' : '';
                    ?>
                    <label for="<?php echo esc_attr($field['key']); ?>" class="rem-field-label">
                        <?php echo esc_attr( $field_title ); ?>
                        <?php echo wp_kses_post($help_tooltip); ?>
                        <?php echo wp_kses_post($required_badge); ?>
                    </label>
                    <input id="<?php echo esc_attr($field['key']); ?>" <?php echo esc_attr($step); ?> <?php echo esc_attr($max); ?> <?php echo esc_attr($min); ?>  <?php echo esc_attr($required); ?> class="form-control" value="<?php echo esc_attr(stripcslashes($default_val)); ?>" type="<?php echo esc_attr($field['type']); ?>" title="<?php echo esc_attr($field['help']); ?>" name="<?php echo esc_attr($field['key']); ?>">
                    <?php break;
				case 'button': ?>
                    <label for="<?php echo esc_attr($field['key']); ?>" class="rem-field-label">
                        <?php echo esc_attr( $field_title ); ?>
                        <?php echo wp_kses_post($help_tooltip); ?>
                        <?php echo wp_kses_post($required_badge); ?>
                    </label>
                    <input id="<?php echo esc_attr($field['key']); ?>"  <?php echo esc_attr($required); ?> class="form-control" value="<?php echo esc_attr(stripcslashes($default_val)); ?>" type="text" title="<?php echo esc_attr($field['help']); ?>" name="<?php echo esc_attr($field['key']); ?>">
                    <?php break;
                    
				case 'checkbox': ?>
					<?php $chkd = (isset($default_val[$field['key']])) ? 'checked' : '' ; ?>
					<input <?php echo esc_attr($chkd); ?> class="labelauty" type="checkbox" name="property_detail_cbs[<?php echo esc_attr($field['key']); ?>]" data-labelauty="<?php echo esc_attr($field['title']); ?>">
					<?php break;
				case 'upload': ?>
					<div class="upload-attachments-wrap">
						<p class="text-center">
							<button type="button"
								class="upload-attachment btn btn-info"
								data-title="<?php esc_attr_e( 'Select attachments for property', 'real-estate-manager' ); ?>"
								data-field_key="<?php echo esc_attr($field['key']); ?>"
								data-max_files="<?php echo (isset($field['max_files'])) ? esc_attr( $field['max_files'] ) : '' ; ?>"
								data-file_type="<?php echo (isset($field['file_type'])) ? esc_attr( $field['file_type'] ) : '' ; ?>"
								data-max_files_msg="<?php echo (isset($field['max_files_msg'])) ? esc_attr( $field['max_files_msg'] ) : '' ; ?>"
								data-btntext="<?php esc_attr_e( 'Add', 'real-estate-manager' ); ?>">
								<span class="dashicons dashicons-paperclip"></span>
								<?php echo esc_attr( $field_title ); ?>
							</button>
						</p>
						<p>
							<?php echo esc_attr($help_text); ?>
						</p>
						<div class="row attachments-prev">
							<?php
								if ($value != '') {
									if (!is_array($value)) {
										$value = explode("\n", $value);
									}
									if (is_array($value)) {
										foreach ($value as $id) {
											$attachment_url = wp_get_attachment_image_src( $id, 'thumbnail', true ); ?>
											<div class="col-sm-3">
												<div class="rem-preview-image">
													<input type="hidden" name="<?php echo esc_attr($field['key']); ?>[<?php echo trim($id); ?>]" value="<?php echo esc_attr($id); ?>">
													<div class="rem-image-wrap">
														<img class="attachment-icon" src ="<?php echo esc_url($attachment_url[0]); ?>">
														<span class="attachment-name"><a target="_blank" href="<?php echo wp_get_attachment_url( $id ); ?>"><?php echo get_the_title( $id ); ?></a></span>
													</div>
													<div class="rem-actions-wrap">
														<a href="javascript:void(0)" class="btn remove-image btn-sm">
															<i class="fa fa-times"></i>
														</a>
													</div>
												</div>
											</div>
										<?php }
									}
								}
							?>
						</div>
					</div>
					<?php break;
				case 'textarea': ?>
					<label class="rem-field-label">
						<?php echo esc_attr($field_title); ?>
						<?php echo wp_kses_post($help_tooltip); ?>
						<?php echo wp_kses_post($required_badge); ?>
					</label>
		            <textarea <?php echo esc_attr($required); ?> id="<?php echo esc_attr($field['key']); ?>" name="<?php echo esc_attr($field['key']); ?>" class="form-control" rows="2"><?php echo stripcslashes($value); ?></textarea>
					<?php break;

                case 'select': ?>
                    <label class="rem-field-label">
                        <?php echo esc_attr($field_title); ?>
                        <?php echo wp_kses_post($help_tooltip); ?>
                        <?php echo wp_kses_post($required_badge); ?>
                    </label>
                    <select <?php echo esc_attr($required); ?> class="<?php echo esc_attr($dropdown_class); ?>" data-settings='{"cutOff": 5}' name="<?php echo esc_attr($field['key']); ?>">
                        <?php if($field['key'] != 'property_featured'){ ?>
                            <option value="">-- <?php echo __( 'Any', 'real-estate-manager' ).' '.rem_wpml_translate($field['title'], 'real-estate-manager-fields'); ?> --</option>
                        <?php } ?>
                        <?php
                            if (is_array($field['options'])) {
                                $options = $field['options'];
                            } else {
                                $options = explode("\n",$field['options']);
                            }
                            foreach ($options as $title) {
                                $title = stripcslashes($title);
                                $selected = ($default_val == $title) ? 'selected' : '' ;
                                echo '<option value="'.esc_attr($title).'" '.esc_attr($selected).'>'.rem_wpml_translate($title, 'real-estate-manager-fields').'</option>';
                            }
                        ?>
                    </select>
                    <?php break;

                case 'countries':
                    $countries_obj   = new REM_Countries();
                    $countries   = $countries_obj->get_countries(); ?>
                    <label class="rem-field-label">
                        <?php echo esc_attr($field_title); ?>
                        <?php echo wp_kses_post($help_tooltip); ?>
                        <?php echo wp_kses_post($required_badge); ?>
                    </label>
                    <select <?php echo esc_attr($required); ?> class="form-control rem-countries-list" data-settings='{"cutOff": 5}' name="<?php echo esc_attr($field['key']); ?>">
                        <option value="">-- <?php echo __( 'Any', 'real-estate-manager' ).' '.rem_wpml_translate($field['title'], 'real-estate-manager-fields'); ?> --</option>
                        <?php
                            foreach ($countries as $code => $title) {
                                $selected = ($default_val == $code) ? 'selected' : '' ;
                                echo '<option value="'.esc_attr($code).'" '.esc_attr($selected).'>'.esc_attr($title).'</option>';
                            }
                        ?>
                    </select>
                    <?php break;

				case 'states': ?>
					<label class="rem-field-label">
						<?php echo esc_attr($field_title); ?>
						<?php echo wp_kses_post($help_tooltip); ?>
						<?php echo wp_kses_post($required_badge); ?>
					</label>
					<select <?php echo esc_attr($required); ?> data-state="<?php echo esc_attr($default_val); ?>" class="form-control rem-states-list" data-settings='{"cutOff": 5}' name="<?php echo esc_attr($field['key']); ?>">
						<option value="">-- <?php echo __( 'Any', 'real-estate-manager' ).' '.rem_wpml_translate($field['title'], 'real-estate-manager-fields'); ?> --</option>
					</select>
					<?php break;

				case 'select2': ?>
					<label class="rem-field-label">
						<?php echo esc_attr($field_title); ?>
						<?php echo wp_kses_post($help_tooltip); ?>
						<?php echo wp_kses_post($required_badge); ?>
					</label>
					<select <?php echo esc_attr($required); ?> class="rem-select2-field" data-settings='{"cutOff": 5}' name="<?php echo esc_attr($field['key']); ?>[]" multiple>
						<?php if($field['key'] != 'property_featured'){ ?>
							<option value="">-- <?php echo __( 'Any', 'real-estate-manager' ).' '.esc_attr($field['title']); ?> --</option>
						<?php } ?>
						<?php
							if (is_array($field['options'])) {
								$options = $field['options'];
							} else {
								$options = explode("\n",$field['options']);
							}
							foreach ($options as $title) {
								$title = stripcslashes($title);
								$selected = (is_array($value) && in_array($title, $value)) ? 'selected' : '' ;
								echo '<option value="'.esc_attr($title).'" '.esc_attr($selected).'>'.rem_wpml_translate($title, 'real-estate-manager-fields').'</option>';
							}
						?>
					</select>
					<?php break;
			
				default:
					
					break;
			} ?>
		</div>
	    <?php
    }

    function get_shortcodes_list(){
    	$shortcodes = array(
    		'agent-profile',
    		'create-property',
    		'edit-agent',
    		'edit-property',
    		'list-agents',
    		'list-properties',
    		'login-agent',
    		'logout-button',
    		'my-profile',
    		'register-agent',
    		'rem-carousel',
    		'rem-maps',
    		'search-property',
    		'search-results',
    		'single-property',
    	);

    	return $shortcodes;
    }

    function get_single_property_widgets(){
		$single_property_widgets = array(
			'agent-details',
			'child-listings',
			'attachments',
			'description',
			'energy-efficiency',
			'features',
			'gallery-images',
			'map',
			'property-field',
			'tags',
			'title',
			'video',
		);
		return $single_property_widgets;
    } 

    function rem_divi_modules_setup(){
		if ( rem_get_option('divi_modules', 'enable') == 'enable' && class_exists('ET_Builder_Module') ) {
			include_once REM_PATH. '/shortcodes/page-builders/page-builder-fields.php';
			include_once REM_PATH. '/shortcodes/page-builders/divi/settings.php';

			$shortcodes = $this->get_shortcodes_list();

			foreach ($shortcodes as $file) {
				if (file_exists(REM_PATH. '/shortcodes/page-builders/divi/'.$file.'.php')) {
					include_once REM_PATH. '/shortcodes/page-builders/divi/'.$file.'.php';
				}
			}
		}
    }

    function rem_elementor_category( $elements_manager ){
		$elements_manager->add_category(
			'real-estate-manager',
			array(
				'title' => __( 'Real Estate Manager', 'real-estate-manager' ),
				'icon' => 'fa fa-home',
			)
		);
		$elements_manager->add_category(
			'single-property-page',
			array(
				'title' => __( 'Single Property Page', 'real-estate-manager' ),
				'icon' => 'fa fa-file',
			)
		);
    }

    function rem_elementor_widgets($widgets_manager){

		if ( rem_get_option('elementor_widgets', 'enable') == 'enable' ) {

            wp_register_style( 'rem-archive-property-css', REM_URL . '/assets/front/css/archive-property.css' );
            wp_register_style( 'rem-carousel-css', REM_URL . '/assets/front/lib/slick.css' );
            wp_register_script( 'rem-carousel-js', REM_URL . '/assets/front/lib/slick.min.js', array('jquery'));
            
            wp_register_script( 'rem-magnific-js', REM_URL . '/assets/front/lib/jquery.magnific-popup.min.js', array('jquery'));
            wp_register_style( 'rem-magnific-css', REM_URL . '/assets/front/lib/magnific-popup.css' );

			wp_register_script( 'rem-elementor-sc', REM_URL . '/shortcodes/page-builders/elementor/script.js', array( 'jquery' ));

			include_once REM_PATH. '/shortcodes/page-builders/page-builder-fields.php';
			include_once REM_PATH. '/shortcodes/page-builders/elementor/settings.php';

			$shortcodes = $this->get_shortcodes_list();

			foreach ($shortcodes as $widget) {
				if (file_exists(REM_PATH. '/shortcodes/page-builders/elementor/'.$widget.'.php')) {
					include_once REM_PATH. '/shortcodes/page-builders/elementor/'.$widget.'.php';
					$class_name = ucwords($widget, '-');
					$class_name = str_replace("-", "_", $class_name);
					$class_name = 'Elementor_REM_'.$class_name.'_Widget';
					if (class_exists($class_name)) {
                        $widgets_manager->register( new $class_name() );
					}
				}
			}
		}

		if ( rem_get_option('elementor_theme_builder', 'enable') == 'enable' && defined('ELEMENTOR_PRO_VERSION') ) {
            rem_load_bs_and_fa();
            rem_load_basic_styles();
            $gallery_type = rem_get_option('gallery_type', 'fotorama');
            $gallery_type = apply_filters( 'rem_single_property_gallery_type', $gallery_type );

            if ($gallery_type == 'fotorama') {
                wp_register_style( 'rem-fotorama-css', REM_URL . '/assets/front/lib/fotorama.min.css' );
                wp_register_script( 'rem-photorama-js', REM_URL . '/assets/front/lib/fotorama.min.js', array('jquery'));
            }
            if ($gallery_type == 'slick') {
                wp_register_style( 'rem-carousel-css', REM_URL . '/assets/front/lib/slick.css' );
                wp_register_script( 'rem-carousel-js', REM_URL . '/assets/front/lib/slick.min.js', array('jquery'));
            }
            if ($gallery_type == 'grid') {
                wp_register_style( 'rem-grid-css', REM_URL . '/assets/front/lib/images-grid.css' );
                wp_register_script( 'rem-grid-js', REM_URL . '/assets/front/lib/images-grid.js', array('jquery'));
            }

            wp_enqueue_style( 'rem-single-property-css', REM_URL . '/assets/front/css/single-property.css' );
           	
			wp_enqueue_style( 'rem-elementor-styles', REM_URL . '/shortcodes/page-builders/elementor/theme-builder/styles.css');
			wp_register_script( 'rem-elementor-scripts', REM_URL . '/shortcodes/page-builders/elementor/theme-builder/scripts.js', array( 'jquery' ));

			$single_property_widgets = $this->get_single_property_widgets();

			foreach ($single_property_widgets as $widget) {
				if (file_exists(REM_PATH. '/shortcodes/page-builders/elementor/theme-builder/'.$widget.'.php')) {
					include_once REM_PATH. '/shortcodes/page-builders/elementor/theme-builder/'.$widget.'.php';
					$class_name = ucwords($widget, '-');
					$class_name = str_replace("-", "_", $class_name);
					$class_name = 'Elementor_REM_'.$class_name.'_Widget';
					if (class_exists($class_name)) {
						\Elementor\Plugin::instance()->widgets_manager->register( new $class_name() );
					}
				}
			}
		}
    }

	/**
	 * Returns single field value
	 * Credits: Sam
	 */
    function rem_property_field($atts){
        $before="";
        $after="";
        $strformat="";
		extract(shortcode_atts(array(
			'property_id' => NULL,
		), $atts));

       	if(!isset($atts['name'])) return;

        $field = "rem_".esc_attr($atts['name']);

        if (isset($atts['strformat'])){
                $strformat = esc_attr($atts['strformat']);
        }
        if (isset($atts['before'])){
                $before = esc_attr($atts['before']);
        }
        if (isset($atts['after'])){
                $after = esc_attr($atts['after']);
        }
        global $post;

        $property_id = (NULL === $property_id) ? $post->ID : $property_id;
        $fvalue = get_post_meta($property_id, $field, true);
           
        if($strformat != ''){
            if ($strformat == 'currency'){
                if (is_numeric($fvalue)){
                    $fvalue = number_format($fvalue,0);
                }
            }
        }
           
		if (function_exists('pll__')) {
			$fvalue = pll__($fvalue);
		}
		if (function_exists('__')) {
			$fvalue = __($fvalue,'real-estate-manager-fields');
		}
           
		if ($field=='rem_property_price'){
			$discount_price = get_post_meta($property_id, 'rem_property_sale_price', true);
	        if ($discount_price != ""){
	            return "<del>" . $before . $fvalue . "</del> ". $before . number_format($discount_price,0) . $after;
	        }
        }

        return $before . $fvalue  . $after;
    }

	function map_box($property_id){
        ob_start();

        $url = get_permalink($property_id);
        $img = get_the_post_thumbnail_url($property_id, 'full');
        $title = get_the_title( $property_id );
        $price = rem_display_property_price($property_id);

        $in_theme = get_stylesheet_directory().'/rem/map-box.php';

        if (file_exists($in_theme)) {
            $file_path = $in_theme;
        } else {
            $file_path = REM_PATH . '/templates/map-box.php';
        }

        if (file_exists($file_path)) {
          include $file_path;
        }

        return ob_get_clean();
	}
    
	function map_agent_box($author_id){
        ob_start();

        $in_theme = get_stylesheet_directory().'/rem/agent-map-box.php';

        if (file_exists($in_theme)) {
            $file_path = $in_theme;
        } else {
            $file_path = REM_PATH . '/templates/agent-map-box.php';
        }

        if (file_exists($file_path)) {
          include $file_path;
        }

        return ob_get_clean();
	}

	function lists_sorting_options(){
		$options = array(
			array(
				'title' => __( 'Sort By Date', 'real-estate-manager' ),
				'value' => 'date-desc',
			),
			array(
				'title' => __( 'Sort By Title', 'real-estate-manager' ),
				'value' => 'title-asc',
			),
			array(
				'title' => __( 'Sort By Price : High to Low', 'real-estate-manager' ),
				'value' => 'price-desc',
			),
			array(
				'title' => __( 'Sort By Price : Low to High', 'real-estate-manager' ),
				'value' => 'price-asc',
			),
		);

		return apply_filters( 'rem_lists_sorting_options', $options );
	}

	function render_top_bar($style){
		$in_theme = get_stylesheet_directory().'/rem/shortcodes/list/top-bar.php';
		if (file_exists($in_theme)) {
			include $in_theme;
		} else {
			include REM_PATH. '/shortcodes/list/top-bar.php';
		}
	}


    function rem_list_properties_ajax(){
        if ( isset( $_REQUEST['args'] ) && $_REQUEST['args'] != '' ) {
            $attrs = '';
            foreach ( $_REQUEST['args'] as $name => $value ) {
                $attrs .= ' ' . esc_attr( $name ) . '="' . esc_attr( $value ) . '"';
            }
            echo do_shortcode( '[rem_list_properties' . $attrs . ' paged="' . esc_attr( $_REQUEST['paged'] ) . '"]' );
        }

        die(0);
    }
}
?>