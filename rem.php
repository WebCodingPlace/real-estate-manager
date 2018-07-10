<?php
/**
 * Plugin Name: Real Estate Manager - Property Listing and Agent Management
 * Plugin URI: https://webcodingplace.com/real-estate-manager-wordpress-plugin/
 * Description: A Full Featured Property Listing Plugin for Real Estate website with Agents Management System
 * Version: 6.0
 * Author: WebCodingPlace
 * Author URI: https://webcodingplace.com/
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: real-estate-manager
 * Domain Path: /languages
 */

require_once('core.functions.php');
require_once( REM_PATH.'/classes/setup.class.php' );
require_once( REM_PATH.'/classes/shortcodes.class.php');
require_once( REM_PATH.'/classes/hooks.class.php');
require_once( REM_PATH.'/classes/emails.class.php');
require_once( REM_PATH.'/classes/widgets/mortgage-calculator.php');
require_once( REM_PATH.'/classes/widgets/search-properties.php');
require_once( REM_PATH.'/classes/widgets/tags-cloud.php');

/**
 * Iniliatizing main class object for setting up listing system
 */
if( class_exists('WCP_Real_Estate_Management')){
    $rem_ob = new WCP_Real_Estate_Management;
    register_activation_hook( __FILE__, array( 'WCP_Real_Estate_Management', 'rem_activated' ) );
}

/**
 * Initilaizing Shortcodes and WP Bakery Page Builder (Visual Composer) Components 
 */
if( class_exists('REM_Shortcodes')){
    $rem_sc_ob = new REM_Shortcodes;
}

/**
 * Initializing Custom hooks (actions + filters)
 */
if( class_exists('REM_Hooks')){
    $rem_hk_ob = new REM_Hooks;
}

/**
 * Initializing Emails
 */
if( class_exists('REM_Emails_Management')){
    $rem_emails_manager = new REM_Emails_Management;
}

/**
 * WPML
 * registering and translating strings input by users
 */
if( ! function_exists('wcp_wpml_register') ) {
    function wcp_wpml_register($field_value, $domain) {
        $field_name = $domain . ' - ' . sanitize_key($field_value);
        do_action( 'wpml_register_single_string', $domain, $field_name, $field_value );
    }
}

if( ! function_exists('wcp_wpml_translate') ) {
    function wcp_wpml_translate($field_value, $domain) {
        $field_name = $domain . ' - ' . sanitize_key($field_value);
        return apply_filters('wpml_translate_single_string', $field_value, $domain, $field_name );
    }
}
?>