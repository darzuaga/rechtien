<?php
/*
 *
 * Bundle Plugins Hack
 * Prevent Visual Composer Redirection after plugin activation
 */
remove_action( 'admin_init', 'vc_page_welcome_redirect', 9999 );

/*
 * http://tgmpluginactivation.com/faq/updating-bundled-visual-composer/
 * https://wpbakery.atlassian.net/wiki/pages/viewpage.action?pageId=524297
 */
add_action( 'vc_before_init', 'cardealer_vcSetAsTheme' );
function cardealer_vcSetAsTheme() {
	vc_set_as_theme();
	
	$vc_supported_cpts = array(
		'page',
		'post',
	);
	vc_set_default_editor_post_types( $vc_supported_cpts );
}

/*
 * Remove the blog from the 404 and search breadcrumb trail
 */
if ( function_exists('bcn_display') ) {
    function cardealer_wpst_override_breadcrumb_trail($trail) {
        if ( is_404() || is_search() ) {
            unset($trail->trail[1]);
            array_keys($trail->trail);
        }
    }
	
    add_action('bcn_after_fill', 'cardealer_wpst_override_breadcrumb_trail');
}

// Hide upgrade notice for bundled plugin acf pro
function cardealer_remove_acfpro_update_($value) {
 global $pagenow;
 if( isset($value->response) && $pagenow!='themes.php'){
  unset( $value->response[ 'advanced-custom-fields-pro/acf.php' ] );
 }
 return $value;
}
add_filter('site_transient_update_plugins', 'cardealer_remove_acfpro_update_');


add_filter('acf/updates/plugin_update', 'cardealer_update_acfpro_plugin', 11,2);
function cardealer_update_acfpro_plugin( $update, $transient){

 if( function_exists('acf_pro_is_license_active') && !acf_pro_is_license_active() && is_object($update) ) {
	$update->package = CARDEALER_PATH . '/includes/plugins/advanced-custom-fields-pro.zip';
 }
 return $update;
}

add_filter('upgrader_package_options', 'cardealer_update_acfpro_package_options');
function cardealer_update_acfpro_package_options($options){
	
	if(!empty($options) && isset($options['hook_extra']['plugin']) && $options['hook_extra']['plugin']== 'advanced-custom-fields-pro/acf.php'){
		$options['package'] = CARDEALER_PATH . '/includes/plugins/advanced-custom-fields-pro.zip';
	}
		
	return $options;
}

// For visual-composer
add_filter('site_transient_update_plugins', 'cardealer_remove_update_notifications');
function cardealer_remove_update_notifications($value) {
 global $pagenow;
 if( isset($value->response) && $pagenow!='themes.php'){
        unset($value->response[ 'js_composer/js_composer.php' ]);
    }
 return $value;
}

/* Contact Form 7 - unload assets */
add_filter( 'wpcf7_load_js', '__return_false' );
add_filter( 'wpcf7_load_css', '__return_false' );

function cardealer_cf7_load_assets() {
	global $post;
	if( is_a( $post, 'WP_Post' ) && ( has_shortcode( $post->post_content, 'contact-form-7' ) || has_shortcode( $post->post_content, 'contact-form' ) )  ) {		
		wpcf7_enqueue_scripts();
		wpcf7_enqueue_styles();
	}
}
add_action( 'wp_enqueue_scripts', 'cardealer_cf7_load_assets');