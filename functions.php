<?php
/**
 * carDealer functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package carDealer
 */
global $cardealer_globals;
$cardealer_globals = array();

/*
 * CONSTANTS & VARIABLES
 */
// Base Paths
if( ! defined( 'CARDEALER_PATH' ) ) {	
	if(version_compare(get_bloginfo('version'),'4.7', '>=')) {		
		define( 'CARDEALER_PATH', get_parent_theme_file_path() );
		define( 'CARDEALER_URL',  get_parent_theme_file_uri() );
	} else {		
		define( 'CARDEALER_PATH', get_template_directory() );
		define( 'CARDEALER_URL',  get_template_directory_uri() );
	}
}
// Includes Paths
if( ! defined( 'CARDEALER_INC_PATH' ) )       define( 'CARDEALER_INC_PATH',       CARDEALER_PATH.'/includes' );
$opt_name = "car-dealer-options";
if( ! defined( 'CARDEALER_THEME_OPTIONS_NAME' ) ) define( 'CARDEALER_THEME_OPTIONS_NAME', 'car-dealer-options' );
/* 
 * Includes
 */
require_once CARDEALER_PATH.'/includes/init.php';                          // Initialization
require_once CARDEALER_PATH.'/includes/scripts_and_styles.php';            // Scripts & Styles
require_once CARDEALER_PATH.'/includes/theme_support.php';                 // Theme Support
require_once CARDEALER_PATH.'/includes/template_tags.php';                 // Template Tags
require_once CARDEALER_PATH.'/includes/sidebars.php';                      // Sidebars
require_once CARDEALER_PATH.'/includes/comments.php';                      // Comments
require_once CARDEALER_PATH.'/includes/menus/menus.php';                   // Menus
require_once CARDEALER_PATH.'/includes/base_functions.php';                // Basic/Required Functions
require_once CARDEALER_PATH.'/includes/cars_functions.php';                // Basic/Required Functions
require_once CARDEALER_PATH.'/includes/maintenance.php';                   // Maintenance Mode
require_once CARDEALER_PATH.'/includes/dynamic_css.php';                   // Dynamic CSS
require_once CARDEALER_PATH.'/includes/acf_ported_functions.php';          // ACF Ported Functions
require_once CARDEALER_PATH.'/includes/login.php';                         // Login Page Settings
require_once CARDEALER_PATH.'/includes/external-lib-fix.php';              // External Library Fixes

if( is_admin() ) {
	require_once CARDEALER_PATH.'/includes/tgm-plugin-activation/tgm-init.php';// TGM Plugin Activation
	require_once CARDEALER_PATH.'/includes/sample-data.php';                   // Sample Data
	require_once CARDEALER_PATH.'/includes/welcome.php';                       // Welcome Screen
}

if ( class_exists( 'WooCommerce' ) ) {
	require_once CARDEALER_PATH.'/includes/woo_functions.php';                 // Woocommerce/Customs Functions
	require_once CARDEALER_PATH.'/includes/woocommerce-hook.php';              // Woocommerce custome hooks
}