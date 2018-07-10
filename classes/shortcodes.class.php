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
		add_shortcode( 'rem_simple_search', array($this, 'simple_search_property') );
		add_shortcode( 'rem_agent_login', array($this, 'login_agent') );
		add_shortcode( 'rem_create_property', array($this, 'create_property') );
		add_shortcode( 'rem_edit_property', array($this, 'edit_property') );
		add_shortcode( 'rem_my_properties', array($this, 'my_properties') );
		add_shortcode( 'rem_list_properties', array($this, 'list_properties') );
		add_shortcode( 'rem_search_results', array($this, 'display_search_results') );
		add_shortcode( 'rem_carousel', array($this, 'display_carousel') );
		add_shortcode( 'rem_maps', array($this, 'display_maps') );
		add_shortcode( 'rem_agent_profile', array($this, 'display_agent') );
		add_shortcode( 'rem_my_profile', array($this, 'my_profile') );
		add_shortcode( 'rem_agent_edit', array($this, 'edit_agent') );
		add_shortcode( 'rem_property', array($this, 'single_property') );
		add_shortcode( 'rem_list_agents', array($this, 'list_agents') );
		add_shortcode( 'rem_agent_logout', array($this, 'logout_button') );

        /***********************************************************************************************/
        /* Shortcodes button in editor and WP Bakery Page Builder Support */
        /***********************************************************************************************/

		add_action('admin_init', array($this, 'shortcode_button'));
		add_action( 'vc_before_init', array($this, 'rem_integrateWithVC' ) );

        /***********************************************************************************************/
        /* AJAX Callbacks */
        /***********************************************************************************************/

        // Agent Login
        add_action( 'wp_ajax_rem_user_login', array($this, 'rem_user_login_check' ) );
        add_action( 'wp_ajax_nopriv_rem_user_login', array($this, 'rem_user_login_check' ) );

        // Create Property Frontend
        add_action( 'wp_ajax_rem_create_pro_ajax', array($this, 'create_property_frontend' ) );
        
        // Saving Agent Profile Frontend
        add_action( 'wp_ajax_rem_save_profile_front', array($this, 'rem_save_profile_front' ) );
        
        // Search Property Frontend
        add_action( 'wp_ajax_rem_search_property', array($this, 'search_results' ) );
        add_action( 'wp_ajax_nopriv_rem_search_property', array($this, 'search_results' ) );

        // Register New Agent
        add_action( 'wp_ajax_nopriv_rem_agent_register', array($this, 'rem_register_agent' ) );

        // Divi Settings
        // add_action('et_builder_ready', array($this, 'rem_divi_modules_setup' ));
	}

	function register_agent($attrs, $content = ''){
		if (!is_user_logged_in()) {

			extract( shortcode_atts( array(
				'redirect' => '',
			), $attrs ) );

            rem_load_bs_and_fa();
            rem_load_basic_styles();
            wp_enqueue_style( 'rem-register-css', REM_URL . '/assets/front/css/register-agent.css' );
            wp_enqueue_script( 'rem-register-agent-js', REM_URL . '/assets/front/js/register-agent.js', array('jquery'));
			
			ob_start();
				include REM_PATH. '/shortcodes/register-agent.php';
			return ob_get_clean();
		} else {
			return apply_filters( 'the_content', $content );
		}
	}

	function search_property($attrs, $content = ''){

		extract( shortcode_atts( array(
			'fields_to_show' => 'property_address,search,property_type,property_country,property_purpose,property_price',
			'columns' => '6',
			'search_btn_text' => __( 'Search', 'real-estate-manager' ),
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
		), $attrs ) );
		
        rem_load_bs_and_fa();
        rem_load_basic_styles();
        wp_enqueue_style( 'rem-archive-property-css', REM_URL . '/assets/front/css/archive-property.css' );
        
        wp_enqueue_style( 'rem-nouislider-css', REM_URL . '/assets/front/lib/nouislider.min.css' );
        wp_enqueue_style( 'rem-easydropdown-css', REM_URL . '/assets/front/lib/easydropdown.css' );
        wp_enqueue_style( 'rem-labelauty-css', REM_URL . '/assets/front/lib/labelauty.css' );
        wp_enqueue_script( 'rem-labelauty', REM_URL . '/assets/front/lib/labelauty.min.js', array('jquery'));
        wp_enqueue_script( 'rem-easy-drop', REM_URL . '/assets/front/lib/jquery.easydropdown.min.js', array('jquery'));
        wp_enqueue_script( 'rem-nouislider-drop', REM_URL . '/assets/front/lib/nouislider.all.min.js', array('jquery'));
        wp_enqueue_script( 'rem-match-height', REM_URL . '/assets/front/lib/jquery.matchheight-min.js', array('jquery'));

        wp_enqueue_script( 'rem-imagefill-js', REM_URL . '/assets/front/lib/imagefill.min.js', array('jquery'));   
        wp_enqueue_script( 'rem-imagesloaded-js', REM_URL . '/assets/front/lib/imagesloaded.min.js', array('jquery'));
        
        wp_enqueue_style( 'rem-search-css', REM_URL . '/assets/front/css/search-property.css' );

        $script_settings = array(
            'price_min'         => rem_get_option('minimum_price', '350'),
            'price_max'         => rem_get_option('maximum_price', '45000'), 
            'price_min_default' => rem_get_option('default_minimum_price', '7000'), 
            'price_max_default' => rem_get_option('default_maximum_price', '38500'), 
            'price_step'        => rem_get_option('price_step', '10'),
            'currency_symbol'   => rem_get_currency_symbol(),
            'thousand_separator'=> rem_get_option('thousand_separator', ''),
            'decimal_separator' => rem_get_option('decimal_separator', ''),
            'decimal_points'    => rem_get_option('decimal_points', '0'),
        );
        wp_enqueue_script( 'rem-search-script', REM_URL . '/assets/front/js/search-property.js', array('jquery', 'jquery-masonry'));
        wp_localize_script( 'rem-search-script', 'rem_ob', $script_settings );

		ob_start();
			include REM_PATH . '/shortcodes/search-property.php';
		return ob_get_clean();
	}

	function simple_search_property($attrs, $content = ''){
		extract( shortcode_atts( array(
			'placeholder' => 'Type to Search...',
			'width' => '450px',
			'border_color' => '#E4E4E4',
			'results_page' => '#',
			'search_icon' => '<i class="glyphicon glyphicon-search"></i>',
		), $attrs ) );
        rem_load_bs_and_fa();
        rem_load_basic_styles();
		ob_start();
			include REM_PATH . '/shortcodes/simple-search.php';
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

			extract( shortcode_atts( array(
				'heading' => 'Login Here',
				'redirect' => '',
			), $attrs ) );
			ob_start();
				include REM_PATH. '/shortcodes/login.php';
			return ob_get_clean();
		}
	}

	function create_property($attrs, $content = ''){
		if (is_user_logged_in()) {
			extract( shortcode_atts( array(
				'style' => '',
			), $attrs ) );

			global $rem_ob;
	        wp_enqueue_media();
			rem_load_bs_and_fa();
			rem_load_basic_styles();
			wp_enqueue_style( 'rem-admin-css', REM_URL . '/assets/admin/css/admin.css' );

			wp_enqueue_style( 'rem-easydropdown-css', REM_URL . '/assets/front/lib/easydropdown.css' );
			wp_enqueue_style( 'rem-labelauty-css', REM_URL . '/assets/front/lib/labelauty.css' );
			wp_enqueue_script( 'rem-labelauty', REM_URL . '/assets/front/lib/labelauty.min.js', array('jquery'));
			wp_enqueue_script( 'rem-easy-drop', REM_URL . '/assets/front/lib/jquery.easydropdown.min.js', array('jquery'));
			wp_enqueue_script( 'rem-match-height', REM_URL . '/assets/front/lib/jquery.matchheight-min.js', array('jquery'));

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
                    'maps_api' => $maps_api,
                    'drag_icon' => $drag_icon,
                    'maps_styles' => stripcslashes(rem_get_option('maps_styles')),
                );
            }

			wp_enqueue_script( 'rem-create-pro', REM_URL . '/assets/front/js/create-property.js', array('jquery'));

            if (isset($localize_vars)) {
                wp_localize_script( 'rem-create-pro', 'rem_edit_property_map', $localize_vars );
            } else {
                $localize_vars = array(
                    'def_lat' => 'disable',
                );                
                wp_localize_script( 'rem-create-pro', 'rem_edit_property_map', $localize_vars );
            }

			ob_start(); ?>
		<?php
			$property_individual_cbs = $rem_ob->get_all_property_features();
			include REM_PATH. '/shortcodes/create-property.php';
			return ob_get_clean();
		} else {
			return apply_filters( 'the_content', $content );
		}		
	}

	function edit_property($attrs, $content = ''){
		$current_user_data = wp_get_current_user();
		if (is_user_logged_in() && isset($_GET['property_id']) && get_post_field( 'post_author', $_REQUEST['property_id'] ) == $current_user_data->ID) {
			extract( shortcode_atts( array(
				'style' => '',
			), $attrs ) );

			global $rem_ob;
	        wp_enqueue_media();
			rem_load_bs_and_fa();
			rem_load_basic_styles();
			wp_enqueue_style( 'rem-admin-css', REM_URL . '/assets/admin/css/admin.css' );

			wp_enqueue_style( 'rem-easydropdown-css', REM_URL . '/assets/front/lib/easydropdown.css' );
			wp_enqueue_style( 'rem-labelauty-css', REM_URL . '/assets/front/lib/labelauty.css' );
			wp_enqueue_script( 'rem-labelauty', REM_URL . '/assets/front/lib/labelauty.min.js', array('jquery'));
			wp_enqueue_script( 'rem-easy-drop', REM_URL . '/assets/front/lib/jquery.easydropdown.min.js', array('jquery'));
			wp_enqueue_script( 'rem-match-height', REM_URL . '/assets/front/lib/jquery.matchheight-min.js', array('jquery'));

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
                    'maps_api' => $maps_api,
                    'drag_icon' => $drag_icon,
                    'maps_styles' => stripcslashes(rem_get_option('maps_styles')),
                );
            }

			wp_enqueue_script( 'rem-create-pro', REM_URL . '/assets/front/js/create-property.js', array('jquery'));
            if (isset($localize_vars)) {
                wp_localize_script( 'rem-create-pro', 'rem_edit_property_map', $localize_vars );
            } else {
                $localize_vars = array(
                    'def_lat' => 'disable',
                );                
                wp_localize_script( 'rem-create-pro', 'rem_edit_property_map', $localize_vars );
            }

			ob_start(); ?>
		<?php
			$property_individual_cbs = $rem_ob->get_all_property_features();
			include REM_PATH. '/shortcodes/edit-property.php';
			return ob_get_clean();
		} else {
			return apply_filters( 'the_content', $content );
		}		
	}

	function my_properties($attrs, $content = ''){
		if (is_user_logged_in()) {
			extract( shortcode_atts( array(
				'style' => '',
			), $attrs ) );

	        rem_load_bs_and_fa();
	        rem_load_basic_styles();
	        wp_enqueue_style( 'rem-myproperties-css', REM_URL . '/assets/front/css/my-properties.css' );

			ob_start();
			
			include REM_PATH . '/shortcodes/my-properties.php';
			return ob_get_clean();
		} else {
			return apply_filters( 'the_content', $content );
		}		
	}

	function list_properties($attrs, $content = ''){
		extract( shortcode_atts( array(
	        'order' 	=> 'ASC',
	        'orderby' 	=> 'date',
	        'style' 	=> '1',
	        'posts' 	=> 10,
	        'class'  	=> 'col-sm-12',
	        'purpose'  	=> '',
	        'status'  	=> '',
	        'author'  	=> '',
	        'type'  	=> '',
	        'tags'  	=> '',
	        'pagination'  	=> 'enable',
	        'meta'  	=> '',
	        'masonry'  	=> '',
	        'top_bar'  	=> 'disable',
	        'default_grid_style'  	=> '3',
	        'nearest_porperties'  	=> 'disable',
		), $attrs ) );

		if (isset($_GET['list_style']) && $_GET['list_style'] == 'list') {
			$style = '1';
		}

		if (isset($_GET['list_style']) && $_GET['list_style'] == 'grid') {
			$style = $default_grid_style;
		}

		if($style == '1'){
			$class = 'col-sm-12 m-item';
		} else {
			$class = $class.' m-item';
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
        wp_enqueue_script( 'rem-archive-property-js', REM_URL . '/assets/front/js/archive-property.js', array('jquery'));

		$args = array(
			'order'       => $order,
			'orderby'     => $orderby,			
			'post_type'   => 'rem_property',
			'posts_per_page'         => $posts,
		);

		if ($orderby == 'price') {
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = 'rem_property_price';
		}

		if (isset($_GET['sort_by']) && $_GET['sort_by'] != '') {
			$sort_op = explode("-", $_GET['sort_by']);
			$args['order'] = strtoupper($sort_op[1]);
			$args['orderby'] = $sort_op[0];
	        if ($sort_op[0] == 'price') {
	            $args['orderby'] = 'meta_value_num';
	            $args['meta_key'] = 'rem_property_price';
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
		if ($meta != '') {
			$meta_data = explode(",", $meta);
			foreach ($meta_data as $single_meta) {
				$m_k_v = explode("|", $single_meta);
			    if (isset($m_k_v[1]) && $m_k_v[1] != '' && strpos($m_k_v[1], '*') == false) {
			        $args['meta_query'][] = array(
			            array(
			                'key'     => 'rem_'.trim($m_k_v[0]),
			                'value'   => trim($m_k_v[1]),
			                'compare' => 'LIKE',
			            ),
			        );
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

	    if ($pagination == 'enable') {
	    	if (is_front_page()) {
	    		$paged = ( get_query_var('page') ) ? get_query_var('page') : 1;
	    	} else {
				$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
	    	}
			$args['paged'] = $paged;
	    }
		ob_start();

			if($nearest_porperties == 'enable'){
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
			if ($nearest_porperties == 'enable' && isset($_GET['lat']) && isset($_GET['long'])) {
				$args['posts_per_page'] = -1;
				$the_query = new WP_Query( $args );
				include REM_PATH . '/shortcodes/list/nearby.php';
			} else {
				$the_query = new WP_Query( $args );
				include REM_PATH . '/shortcodes/list/list.php';
			}

			
		return ob_get_clean();
	}

	function display_carousel($attrs, $content = ''){
		extract( shortcode_atts( array(
	        'order' 	=> 'ASC',
	        'orderby' 	=> 'date',
	        'style' 	=> '1',
	        'slidestoshow'  	=> '1',
	        'slidestoscroll'  	=> '1',
	        'speed'  	=> '2000',
	        'autoplay'  	=> 'disable',
	        'autoplayspeed'  	=> '2000',
	        'arrows'  	=> 'disable',
	        'dots'  	=> 'disable',
	        'ids'  	=> '',
	        'meta'  	=> '',
	        'author'  	=> '',
	        'tags'  	=> '',
	        'total_properties' 	=> '10',
	        'nearest_porperties' 	=> 'disable',
		), $attrs ) );
		if($style == '1'){
			$attrs['slidestoshow'] = '1';
		}
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

		$args = array(
			'order'       => $order,
			'orderby'     => $orderby,			
			'post_type'   => 'rem_property',
			'posts_per_page'         => $total_properties,
		);
		if ($author != '') {
			if ($author == 'current' && is_user_logged_in()) {
		        $current_user = wp_get_current_user();
				$args['author'] = $current_user->ID;
			} else {
				$args['author'] = $author;
			}
		}
		if ($meta != '') {
			$meta_data = explode(",", $meta);
			foreach ($meta_data as $single_meta) {
				$m_k_v = explode("|", $single_meta);
			    if (isset($m_k_v[1]) && $m_k_v[1] != '') {
			        $args['meta_query'][] = array(
			            array(
			                'key'     => 'rem_'.trim($m_k_v[0]),
			                'value'   => trim($m_k_v[1]),
			                'compare' => 'LIKE',
			            ),
			        );
			    }
				
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
	    
	    if ($ids != '') {
	        $args['post__in'] = explode(',', $ids);
	    }

		ob_start();

			if($nearest_porperties == 'enable'){
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
			if ($nearest_porperties == 'enable' && isset($_GET['lat']) && isset($_GET['long'])) {
				$args['posts_per_page'] = -1;
				$the_query = new WP_Query( $args );
				include REM_PATH . '/shortcodes/carousel/nearby.php';
			} else {
				// The Loop
				$the_query = new WP_Query( $args );
				include REM_PATH . '/shortcodes/carousel/carousel.php';
			}

		return ob_get_clean();
	}

    /**
     * Create a shortcode button for tinymce
     *
     * @return [type] [description]
     */
    public function shortcode_button(){
        if( current_user_can('edit_posts') &&  current_user_can('edit_pages') ){
            add_filter( 'mce_external_plugins', array($this, 'add_buttons' ));
            add_filter( 'mce_buttons', array($this, 'register_buttons' ));
        }
    }

    /**
     * Add new Javascript to the plugin scrippt array
     *
     * @param  Array $plugin_array - Array of scripts
     *
     * @return Array
     */
    public function add_buttons( $plugin_array )
    {
        $plugin_array['rem_shortcodes'] = REM_URL . '/assets/admin/js/shortcode.js';

        return $plugin_array;
    }

    /**
     * Add new button to tinymce
     *
     * @param  Array $buttons - Array of buttons
     *
     * @return Array
     */
    public function register_buttons( $buttons )
    {
        array_push( $buttons, 'separator', 'rem_shortcodes' );
        return $buttons;
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

        wp_enqueue_script( 'rem-search-results', REM_URL . '/assets/front/js/search-results.js', array('jquery'));

    	ob_start();
    	if (isset($_GET['simple_search'])) {
    		include REM_PATH . '/shortcodes/search-results-simple.php';
    	} else {
    		include REM_PATH . '/shortcodes/search-results.php';
    	}
    	return ob_get_clean();
    }

    function display_maps($attrs){
    	$default_icon = rem_get_option('maps_property_image', REM_URL . '/assets/images/maps/cottage-pin.png');
    	$default_icon_h = rem_get_option('maps_property_image_hover', REM_URL . '/assets/images/maps/cottage-hover-pin.png');
		extract( shortcode_atts( array(
			'load_heading' 		=> 'Loading Maps',
			'load_desc' 		=> 'Please Wait...',
			'ids' 				=> '',
			'total_properties' 	=> '10',
	        'order' 	=> 'ASC',
	        'orderby' 	=> 'date',			
	        'meta' 	=> '',			
	        'tags' 	=> '',		
	        'agent' 	=> '',		
			'btn_bg_color' 		=> '',
			'btn_text_color' 	=> '',
			'btn_bg_color_hover' => '',
			'btn_text_color_hover' => '',
			'loader_color' => '',
			'type_bar_bg_color' => '',
			'water_color' 		=> '',
			'fill_color' 		=> '',
			'poi_color' 		=> '',
			'poi_color_hue' 	=> '',
			'roads_lightness' 	=> '',
			'lines_lightness'	=> '',
			'nearest_porperties'=> 'disable',
			'map_height'=> '',
			
			'type_filtering' 	=> 'disable',
			'filter_by_key' 	=> 'property_type',
			'filter_options' 	=> '',
			'bottom_btn_bg_color'	=> '',
			'bottom_btn_text_color'	=> '',
			'bottom_btn_bg_color_hover'	=> '',
			'bottom_btn_text_color_hover'	=> '',
			'bottom_btn_bg_color_active'	=> '',

			'use_map_from'	=> '',
			'def_lat'	=> '',
			'def_long'	=> '',
			'map_zoom'	=> '',
			
			'icons_by_meta'	=> 'property_purpose',
			'icons_data'	=> 'sell|'.$default_icon.'|'.$default_icon_h.',rent|'.$default_icon.'|'.$default_icon_h,
			'my_location_icon'	=> rem_get_option('maps_my_location_image', REM_URL. '/assets/images/maps/you-are-here.png'),
			'circle_icon'	=> rem_get_option('maps_circle_image', REM_URL. '/assets/images/maps/m1.png'),
		), $attrs ) );

		if ($use_map_from == '') {
			$use_map_from = rem_get_option('use_map_from', 'leaflet');
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

		$args = array(
			'order'       => $order,
			'orderby'     => $orderby,			
			'post_type'   => 'rem_property',
			'posts_per_page'         => $total_properties,
		);

		if ($agent != '') {
			if ($agent == 'current' && is_user_logged_in()) {
		        $current_user = wp_get_current_user();
				$args['author'] = $current_user->ID;
			} else {
				$args['author'] = $agent;
			}
		}

		if ($meta != '') {
			$meta_data = explode(",", $meta);
			foreach ($meta_data as $single_meta) {
				$m_k_v = explode("|", $single_meta);
			    if (isset($m_k_v[1]) && $m_k_v[1] != '') {
			        $args['meta_query'][] = array(
			            array(
			                'key'     => 'rem_'.trim($m_k_v[0]),
			                'value'   => trim($m_k_v[1]),
			                'compare' => 'LIKE',
			            ),
			        );
			    }
				
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
	    if ($ids != '') {
	        $args['post__in'] = explode(',', $ids);
	    }

		ob_start();

		if($nearest_porperties == 'enable'){
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
		if ($nearest_porperties == 'enable' && isset($_GET['lat']) && isset($_GET['long'])) {
			$args['posts_per_page'] = -1;
			$the_query = new WP_Query( $args );
			include REM_PATH . '/shortcodes/map/nearby.php';
		} else {
			// The Loop
			$the_query = new WP_Query( $args );
			include REM_PATH . '/shortcodes/map/map.php';
		}

		return ob_get_clean();
    }

    function list_agents($attrs){
		extract( shortcode_atts( array(
			'ids' 		=> '',
			'columns' 	=> 'col-sm-12',
			'orderby' 	=> 'login',
			'order' 	=> 'ASC',
			'meta_key' 	=> '',
			'meta_value' 	=> '',
			'masonry' 	=> 'enable',
		), $attrs ) );

		$args = array(
			'role'         => 'rem_property_agent',
			'orderby'      => $orderby,
			'order'        => $order,
			'meta_key'     => $meta_key,
			'meta_value'   => $meta_value,
			'masonry'   	=> $masonry,
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
			include REM_PATH . '/shortcodes/agents.php';

		return ob_get_clean();
    }

    function logout_button($attrs){
		extract( shortcode_atts( array(
			'redirect' 		=> wp_logout_url(home_url()),
			'button_classes' => 'btn btn-default',
			'label' => __( 'Logout', 'real-estate-manager' ),
		), $attrs ) );    	
    	ob_start(); ?>
    		<span class="ich-settings-main-wrap">
				<?php if (is_user_logged_in()) { ?>
					<a href="<?php echo esc_url( $redirect ); ?>" class="<?php echo $button_classes; ?>"><?php echo $label; ?></a>
				<?php } ?>
    		</span>
    	<?php return ob_get_clean();
    }

    function rem_integrateWithVC(){
    	global $rem_ob;
		$property_purposes = $rem_ob->get_all_property_purpose();
		$property_types = $rem_ob->get_all_property_types();
		$property_status = $rem_ob->get_all_property_status();

		$all_agents = get_users( 'role=rem_property_agent' );

		$agents_arr = array( 'Administrator' => 1 );
		foreach ($all_agents as $agent) {
			$agents_arr[$agent->display_name] = $agent->ID;
		}

		array_unshift($property_purposes, array('any' => 'Any'));
		array_unshift($property_types, array('any' => 'Any'));
		array_unshift($property_status, array('any' => 'Any'));
    	include REM_PATH. '/shortcodes/vc-settings.php';

    	foreach ($shortcodes as $sc) {
			vc_map($sc);
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
			include REM_PATH . '/shortcodes/agent-profile.php';
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
				include REM_PATH . '/shortcodes/agent-profile.php';
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
            wp_enqueue_script( 'rem-register-agent-js', REM_URL . '/assets/front/js/edit-agent.js', array('jquery'));

			ob_start();
				include REM_PATH . '/shortcodes/edit-agent.php';
			return ob_get_clean();
		} else {
			return apply_filters( 'the_content', $content );
		}
    }

    function single_property($attrs, $content = ''){
		if (isset($attrs['id'])) {

            rem_load_bs_and_fa();

            rem_load_basic_styles();

            // Photorama
            wp_enqueue_style( 'rem-fotorama-css', REM_URL . '/assets/front/lib/fotorama.min.css' );
            wp_enqueue_script( 'rem-photorama-js', REM_URL . '/assets/front/lib/fotorama.min.js', array('jquery'));

            // Imagesfill and Loaded
            wp_enqueue_script( 'rem-imagefill-js', REM_URL . '/assets/front/lib/imagefill.min.js', array('jquery'));   
            wp_enqueue_script( 'rem-imagesloaded-js', REM_URL . '/assets/front/lib/imagesloaded.min.js', array('jquery'));   
            
            // Page Specific
            wp_enqueue_style( 'rem-single-property-css', REM_URL . '/assets/front/css/single-property.css' );
            wp_enqueue_script( 'rem-single-property-js', REM_URL . '/assets/front/js/single-property.js', array('jquery'));

			ob_start(); ?>
				<section id="property-content" class="ich-settings-main-wrap">
					<?php do_action( 'rem_single_property_slider', $attrs['id'] ); ?>
					<?php do_action( 'rem_single_property_contents', $attrs['id'] ); ?>
				</section>
			<?php return ob_get_clean();
		}
    }

    function rem_user_login_check(){
        if (isset($_REQUEST)) {
            extract($_REQUEST);
            global $user;
            $creds = array();
            $creds['user_login'] = $rem_username;
            $creds['user_password'] =  $rem_userpass;
            $creds['remember'] = (isset($rememberme)) ? true : false;
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
                    'message'   => '',
                );
                echo json_encode($resp);
            }

            die(0);
        }
    }

    function create_property_frontend(){

        // print_r($_REQUEST); exit;
        if (isset($_REQUEST) && $_REQUEST != '') {
            extract($_REQUEST);
            $current_user_data = wp_get_current_user();

            // Create post object
            $my_post = array(
              'post_title'    => wp_strip_all_tags( $title ),
              'post_content'  => $content,
              'post_author'   => $current_user_data->ID,
              'post_type'   => 'rem_property',
            );


            if (isset($_REQUEST['property_id']) && get_post_field( 'post_author', $_REQUEST['property_id'] ) == $current_user_data->ID) {
                $my_post['ID'] = $_REQUEST['property_id'];
                $p_status = get_post_status($_REQUEST['property_id']);
	            $my_post['post_status']   = $p_status;
            } else {
	            if (rem_get_option('property_submission_mode') == 'approve') {
	              	$my_post['post_status']   = 'pending';
	            } else {
	              	$my_post['post_status']   = 'publish';
	            }
            }
             
            // Insert the post into the database
            $property_id = wp_insert_post( $my_post );

            foreach ($_REQUEST as $key => $data) {
                if ($key != 'title' || $key != 'content' || $key != 'rem_property_data' || $key != 'tags') {
                    update_post_meta( $property_id, 'rem_'.$key, $data );
                }


                if ($key == 'rem_property_data') {
                    update_post_meta( $property_id, 'rem_property_images', $data['property_images'] );                    
                    foreach ($data['property_images'] as $imgID => $id) {
                        if (!has_post_thumbnail( $property_id )) {
                            set_post_thumbnail( $property_id, $imgID );
                        }
                    }
                }

                if ($key == 'tags') {
                    wp_set_post_terms( $property_id, $data, 'rem_property_tag' );
                }
            }

            if (!isset($_REQUEST['property_detail_cbs'])) {
                update_post_meta( $property_id, 'rem_property_detail_cbs', '' );
            }
            if (!isset($_REQUEST['rem_property_data']['property_images'])) {
                update_post_meta( $property_id, 'rem_property_images', '' );
            }

            // Property id edited
            if (isset($_REQUEST['property_id']) && get_post_field( 'post_author', $_REQUEST['property_id'] ) == $current_user_data->ID) {
            	echo apply_filters( 'rem_redirect_after_property_edit', get_permalink( $property_id ), $_REQUEST );
            	exit;
            }

            echo apply_filters( 'rem_redirect_after_property_submit', get_permalink( $property_id ), $_REQUEST );
        }

        die();
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
                    
                } else {
                    update_user_meta( $agent_id, $key, $value );
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

                $_REQUEST['time'] = current_time( 'mysql' );

                $previous_users = get_option( 'rem_pending_users' );

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

                // var_dump($_REQUEST); exit;
                if (update_option( 'rem_pending_users', $previous_users )) {
                    do_action( 'rem_new_agent_register', $_REQUEST );
                    $resp = array('status' => 'success', 'msg' => __( 'Registered Successfully, please wait until admin approves.', 'real-estate-manager' ));
                } else {
                    $resp = array('status' => 'error', 'msg' => __( 'Error, please try later', 'real-estate-manager' ));
                }
                
            }

            echo json_encode($resp);
            die(0);
        }
    }

    function render_registration_field($field){
	    ?>
		<li>
			<span><?php echo $field['title']; ?></span>
			<?php switch ($field['type']) {

				case 'text': ?>
					<input type="text" class="form-control" name="<?php echo $field['key']; ?>" <?php echo (isset($field['required']) && $field['required'] == 'true') ? 'required' : '' ; ?> />
					<?php break;

				case 'email': ?>
					<input type="email" class="form-control" name="<?php echo $field['key']; ?>" <?php echo (isset($field['required']) && $field['required'] == 'true') ? 'required' : '' ; ?> />
					<?php break;

				case 'password': ?>
					<input type="password" class="form-control" name="<?php echo $field['key']; ?>" <?php echo (isset($field['required']) && $field['required'] == 'true') ? 'required' : '' ; ?> />
					<?php break;

				case 'textarea': ?>
					<textarea name="<?php echo $field['key']; ?>" <?php echo (isset($field['required']) && $field['required'] == 'true') ? 'required' : '' ; ?> class="form-control"></textarea>
					<br>
					<p><?php echo $field['help']; ?></p>
					<?php break;
				
				default:
					break;
			} ?>
		</li>
	    <?php
    }

    function render_agent_edit_field($field, $agent_id){
	    ?>
		<li style="padding-right: 7px;">
			<span><?php echo $field['title']; ?></span>
			<?php switch ($field['type']) {
				case 'text': ?>
					<input type="text" value="<?php echo get_user_meta( $agent_id, $field['key'], true ); ?>" name="<?php echo $field['key']; ?>" <?php echo (isset($field['required'])) ? 'required' : '' ; ?> />
					<i class="icon fas fa-pencil-alt"></i>
					<?php break;
				case 'number': ?>
					<input type="number" value="<?php echo get_user_meta( $agent_id, $field['key'], true ); ?>" name="<?php echo $field['key']; ?>" <?php echo (isset($field['required'])) ? 'required' : '' ; ?> />
					<i class="icon fas fa-pencil-alt"></i>
					<?php break;
				case 'email':
					$user_info = get_userdata( $agent_id ); ?>
					<input type="email" value="<?php echo $user_info->user_email; ?>" name="<?php echo $field['key']; ?>" <?php echo (isset($field['required'])) ? 'required' : '' ; ?> />
					<i class="icon fas fa-pencil-alt"></i>
					<?php break;
				case 'image': ?>
					<input class="img-url" type="text" value="<?php echo get_user_meta( $agent_id, $field['key'], true ); ?>" name="<?php echo $field['key']; ?>" <?php echo (isset($field['required'])) ? 'required' : '' ; ?> />
					<i data-title="<?php _e( 'Choose Picture', 'real-estate-manager' ); ?>" data-btntext="<?php _e( 'Add', 'real-estate-manager' ); ?>" class="upload_image_agent icon fa fa-upload"></i>
					<?php break;
				case 'textarea': ?>
					<textarea rows="4" name="<?php echo $field['key']; ?>" <?php echo (isset($field['required'])) ? 'required' : '' ; ?>><?php echo get_user_meta( $agent_id, $field['key'] , true ); ?></textarea>
					<p><?php echo $field['help']; ?></p>
					<?php break;
				
				default:
					
					break;
			} ?>
		</li>
	    <?php
    }

    function render_property_field($field, $value = ''){
    	$default_val = ($value != '') ? $value : $field['default'];
    	$columns = apply_filters( 'rem_property_fields_cols', 'col-sm-4 col-xs-12', $field );
	    ?>
		<div class="<?php echo $columns; ?> space-form wrap-<?php echo $field['key']; ?>">
			<?php switch ($field['type']) {
				case 'text':
				case 'number':
				case 'date': ?>
					<label for="<?php echo $field['key']; ?>" class="label-p-title"><?php echo $field['title']; ?></label>
					<input id="<?php echo $field['key']; ?>" class="form-control" value="<?php echo $default_val; ?>" type="<?php echo $field['type']; ?>" title="<?php echo $field['help']; ?>" name="<?php echo $field['key']; ?>">
					<?php break;
				case 'checkbox': ?>
					<?php $chkd = (isset($default_val[$field['key']])) ? 'checked' : '' ; ?>
					<input <?php echo $chkd; ?> class="labelauty" type="checkbox" name="property_detail_cbs[<?php echo $field['key']; ?>]" data-labelauty="<?php echo $field['title']; ?>">
					<?php break;
				case 'upload': ?>
			        <div class="input-group">
			            <textarea id="<?php echo $field['key']; ?>" name="<?php echo $field['key']; ?>" class="form-control custom-control place-attachment" rows="2" style="resize:none;"><?php echo stripcslashes($value); ?></textarea>     
			            <span data-title="<?php _e( 'Select attachments for property', 'real-estate-manager' ); ?>" data-btntext="<?php _e( 'Add', 'real-estate-manager' ); ?>" class="upload-attachment input-group-addon btn btn-info"><?php _e( 'Upload', 'real-estate-manager' ); ?></span>
			        </div>
					<?php break;

				case 'select': ?>
					<label class="label-p-title"><?php echo $field['title']; ?></label>
					<select class="dropdown" data-settings='{"cutOff": 5}' name="<?php echo $field['key']; ?>">
						<?php
							if (is_array($field['options'])) {
								$options = $field['options'];
							} else {
								$options = explode("\n",$field['options']);
							}
							foreach ($options as $title) {
								echo '<option value="'.$title.'" '.selected( $default_val, $title ).'>'.$title.'</option>';
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

    function rem_divi_modules_setup(){
		if ( class_exists('ET_Builder_Module') ) {
			include_once REM_PATH. '/shortcodes/divi-settings.php';
			$divi_list_properties = new Divi_REM_List_Properties();
			add_shortcode( 'et_pb_rem_list_properties', array($this, 'list_properties') );
		}
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
}
?>