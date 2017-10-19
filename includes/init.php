<?php
/**
 * Clean up wp_head() output
 *
 * This function is called in cardealer_init_theme().
 *
 * @since Car Dealer 1.0
 */
function cardealer_init_theme() {
	add_action( 'init', 'cardealer_head_cleanup' );                                // launching operation cleanup
	add_filter( 'the_generator', 'cardealer_rss_version' );                        // remove WP version from RSS
	add_action( 'wp_enqueue_scripts', 'cardealer_load_style_script', 9 );             // enqueue base scripts and styles
	cardealer_theme_support();                                                     // launching this stuff after theme setup
	cardealer_add_image_sizes();                                                   // add additional image sizes
	add_action( 'widgets_init', 'cardealer_register_sidebars' );                   // adding sidebars to Wordpress (these are created in functions.php)
	add_filter( 'get_search_form', 'cardealer_wpsearch' );                         // adding the search form
	add_filter( 'the_content', 'cardealer_filter_ptags_on_images' );               // cleaning up random code around images	
	
	// Hide Revolution Slider notice
	update_option('revslider-valid-notice', 'false');
	
	// Set transient for welcome loader.
	set_transient( '_cardealer_welcome_screen_activation_redirect', true, 30 );
}
add_action( 'after_setup_theme', 'cardealer_init_theme' );
/**
 * Remove WP version from scripts
 *
 * This function is called in cardealer_head_cleanup().
 *
 * @since Car Dealer 1.0
 */
function cardealer_head_cleanup() {
	add_filter( 'style_loader_src', 'cardealer_remove_wp_ver_css_js', 9999 );           // remove WP version from css
	add_filter( 'script_loader_src', 'cardealer_remove_wp_ver_css_js', 9999 );          // remove WP version from scripts
}

/**
 * Remove WP version from RSS
 *
 * This function is called in cardealer_rss_version().
 *
 * @since Car Dealer 1.0
 */
function cardealer_rss_version() {
	return '';
}

function cardealer_remove_wp_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) ) {
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}

// remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
function cardealer_filter_ptags_on_images($content){
	return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}


/**
 * Search Form
 *
 * Call using get_search_form().
 *
 * @since Car Dealer 1.0
 */ 
function cardealer_wpsearch( $form ) {    
	$form = '<form role="search" method="get" id="searchform" class="clearfix" action="' . esc_url( home_url( '/' ) ) . '" >
	<label class="screen-reader-text" for="s">' . esc_html__('Search for:', 'cardealer') . '</label>
	   <input type="text" value="' . get_search_query() . '" name="s" id="s" class="cardealer-default-search" placeholder="'.esc_attr__( 'Search...', 'cardealer' ).'" />
	   <input type="submit" id="searchsubmit" value="'. esc_attr__('Go','cardealer') .'" />
       <div class="cardealer-auto-compalte-default"><ul></ul></div>	
    </form>';
	return $form;
}// end cardealer_wpsearch()