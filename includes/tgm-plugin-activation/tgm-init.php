<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */
require_once ( CARDEALER_PATH.'/includes/tgm-plugin-activation/core/class-tgm-plugin-activation.php' );

add_action( 'tgmpa_register', 'cardealer_register_required_plugins' );


/*
 * Array of plugin arrays. Required keys are name and slug.
 * If the source is NOT from the .org repo, then source is also required.
 */
function cardealer_tgmpa_plugin_list(){

	return apply_filters( 'tgmpa_plugin_list', array(
		array(
			'name'              => esc_html( 'Car Dealer - Helper Library', 'cardealer' ),
			'slug'              => 'cardealer-helper-library',
			'source'            => CARDEALER_PATH . '/includes/plugins/cardealer-helper-library.zip',
			'required'          => true,
			'force_activation'  => false,
			'force_deactivation'=> false,
			'version'           => '1.0.3'
		),
		array(
			'name'              => esc_html( 'Visual Composer', 'cardealer' ),
			'slug'              => 'js_composer',
			'source'            => CARDEALER_PATH . '/includes/plugins/js_composer.zip',
			'required'          => true,
			'force_activation'  => false,
			'force_deactivation'=> false,
			'version'           => '5.3',
		),
		array(
			'name'              => esc_html( 'Slider Revolution', 'cardealer' ),
			'slug'              => 'revslider',
			'source'            => CARDEALER_PATH . '/includes/plugins/revslider.zip',
			'required'          => true,
			'force_activation'  => false,
			'force_deactivation'=> false,
			'version'           => '5.4.6.2',
		),
		array(
			'name'              => esc_html( 'Redux Framework', 'cardealer' ),
			'slug'              => 'redux-framework',
			'required'          => true,
		),
		array(
			'name'              => esc_html( 'Advanced Custom Fields PRO', 'cardealer' ),
			'slug'              => 'advanced-custom-fields-pro',
			'source'            => CARDEALER_PATH . '/includes/plugins/advanced-custom-fields-pro.zip',
			'required'          => true,
			'force_activation'  => false,
			'force_deactivation'=> false,
			'version'           => '5.6.1'
		),
		array(
			'name'              => esc_html( 'Breadcrumb NavXT', 'cardealer' ),
			'slug'              => 'breadcrumb-navxt',
			'required'          => true,
		),
		array(
			'name'              => esc_html( 'Contact Form 7', 'cardealer' ),
			'slug'              => 'contact-form-7',
			'required'          => true,
		),
		array(
			'name'              => esc_html( 'WooCommerce', 'cardealer' ),
			'slug'              => 'woocommerce',
			'required'          => false,
		),
		array(
			'name'              => esc_html( 'Max Mega Menu', 'cardealer' ),
			'slug'              => 'megamenu',
			'required'          => false,
		),
		array(
			'name'              => esc_html( 'BuddyPress', 'cardealer' ),
			'slug'              => 'buddypress',
			'required'          => false,
		),
		array(
			'name'              => esc_html( 'bbPress', 'cardealer' ),
			'slug'              => 'bbpress',
			'required'          => false,
		),
		array(
			'name'              => esc_html( 'MailChimp for WordPress', 'cardealer' ),
			'slug'              => 'mailchimp-for-wp',
			'required'          => false,
		),
		array(
			'name'              => esc_html( 'Envato Market', 'cardealer' ),
			'slug'              => 'envato-market',
			'source'            => CARDEALER_PATH . '/includes/plugins/envato-market.zip',
			'required'          => false,
			'force_activation'  => false,
			'force_deactivation'=> false,
		)
	));
}


/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function cardealer_register_required_plugins() {
	$plugins = cardealer_tgmpa_plugin_list();
	$tgmpa_id = 'cardealer'.'_recommended_plugins';

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => $tgmpa_id,           // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                  // Default absolute path to bundled plugins.
		'menu'         => 'theme-plugins',     // Menu slug.
		'parent_slug'  => 'themes.php',        // Parent menu slug.
		'capability'   => 'edit_theme_options',// Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                // Show admin notices or not.
		'dismissable'  => true,                // If false, a user cannot dismiss the nag message.
		'is_automatic' => false, 			   // Automatically activate plugins after installation or not.
	);
	tgmpa( $plugins, $config );
}

/*
 * cardealer_tgmpa_setup_status()
 * Returns plugin activation status
 */
function cardealer_tgmpa_setup_status(){
	
	$pluginy = cardealer_tgmpa_plugins_data();
	
	$cardealer_tgmpa_plugins_data_all = $pluginy['all'];
	foreach( $cardealer_tgmpa_plugins_data_all as $cardealer_tgmpa_plugins_data_k => $cardealer_tgmpa_plugins_data_v ){
		if( !$cardealer_tgmpa_plugins_data_v['required'] ){
			unset($cardealer_tgmpa_plugins_data_all[$cardealer_tgmpa_plugins_data_k]);
		}
	}
	
	if( count($cardealer_tgmpa_plugins_data_all) > 0 ){
		return false;
	}else{
		return true;
	}
}

/*
 * cardealer_tgmpa_plugins_data()
 * Returns plugin activation list
 */
function cardealer_tgmpa_plugins_data(){
	$plugins = cardealer_tgmpa_plugin_list();
	
	$tgmpax = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
	foreach ( $plugins as $plugin ) {
		call_user_func( array( $tgmpax, 'register' ), $plugin );
	}
	$pluginx = $tgmpax->plugins;
	
	$pluginy = array(
		'all'      => array(), // Meaning: all plugins which still have open actions.
		'install'  => array(),
		'update'   => array(),
		'activate' => array(),
	);

	foreach ( $tgmpax->plugins as $slug => $plugin ) {
		if ( $tgmpax->is_plugin_active( $slug ) && false === $tgmpax->does_plugin_have_update( $slug ) ) {
			// No need to display plugins if they are installed, up-to-date and active.
			continue;
		} else {
			$pluginy['all'][ $slug ] = $plugin;

			if ( ! $tgmpax->is_plugin_installed( $slug ) ) {
				$pluginy['install'][ $slug ] = $plugin;
			} else {
				if ( false !== $tgmpax->does_plugin_have_update( $slug ) ) {
					$pluginy['update'][ $slug ] = $plugin;
				}

				if ( $tgmpax->can_plugin_activate( $slug ) ) {
					$pluginy['activate'][ $slug ] = $plugin;
				}
			}
		}
	}
	return $pluginy;
}

/*
* Function for update Car Dealer Helper Plugin
* Make entry in database for fresh installation so It will comapare and do not ask for update
*/
add_action( 'admin_head', 'cardealer_set_default_cdhl_plugin_version' );
function cardealer_set_default_cdhl_plugin_version(){
	global $pagenow;
	
	// return if not on themes.php
	if( $pagenow != 'themes.php' ) return;	
	
	$plugin = 'cardealer-helper-library';	
	if( get_option( 'cdhl_version') === false ){
		
		$do_version_entry = false;
		
		/* 
		* Installing from TGMPA
		*/
		
		// Single installation
		if( (isset($_GET['tgmpa-install']) && $_GET['tgmpa-install'] == 'install-plugin') && (isset($_GET['plugin']) && $_GET['plugin'] == $plugin) ){
			$do_version_entry = true;
		}
		else if( ( isset( $_POST['action'] ) || isset( $_POST['action2'] ) ) && ( $_POST['action'] == 'tgmpa-bulk-install' ||  $_POST['action2'] == 'tgmpa-bulk-install' ) ) { // Bulk installation
			
			$plugins_to_install = $_POST['plugin'];
			if( in_array( $plugin, $plugins_to_install ) ){ // check if specified plugin is available in bulk install
				$do_version_entry = true;
			}
		}
		
		// Perform default verion entry if cardealer-helper-library plugin is found.
		if( $do_version_entry == true ){
			update_option( 'cdhl_version', '0.0.0' );
		}			
	}
}