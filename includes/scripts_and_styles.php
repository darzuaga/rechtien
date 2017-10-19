<?php
/*
Register Google fonts for cardealer.
*/
function cardealer_google_fonts_url() {
	global $car_dealer_options;
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';
	
	$font_family = array();
	// body fonts
	if( !empty($car_dealer_options['opt-typography-body']['font-family']) ) {
		$font_family[] = $car_dealer_options['opt-typography-body']['font-family'];
	}
	// heading fonts
	for( $h_tag=1; $h_tag<= 6; $h_tag++ ){
		if( isset( $car_dealer_options['opt-typography-h'.$h_tag] ) && !empty( $car_dealer_options['opt-typography-h'.$h_tag] ) ){
			array_push( $font_family, $car_dealer_options['opt-typography-h'.$h_tag]['font-family'] );
		}
	}
	$font_family = array_unique( $font_family ); // remove duplicate fonts
	
	foreach( $font_family as $font ){
		if ( 'off' !== _x( 'on', $font.' font: on or off', 'cardealer' ) ) {
			$fonts[] = $font.':400,300,400italic,600,600italic,700,700italic,800,800italic,300italic';
		}
	}
	
	if( empty( $font_family ) ) {
		/* translators: If there are characters in your language that are not supported by Open+Sans, translate this to 'off'. Do not translate into your own language. */
		if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'cardealer' ) ) {
			$fonts[] = 'Open Sans:400,300,400italic,600,600italic,700,700italic,800,800italic,300italic';		
		}
		/* translators: If there are characters in your language that are not supported by Raleway, translate this to 'off'. Do not translate into your own language. */
		if ( 'off' !== _x( 'on', 'Lato font: on or off', 'cardealer' ) ) {
			$fonts[] = 'Lato:400,100,100italic,300,300italic,400italic,700,700italic,900,900italic';
		}
	}
	
	if ( $fonts ) { 
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}
	return $fonts_url;
}
/*
 * Add script and style on front side
 */
function cardealer_load_style_script(){
	global $car_dealer_options,$post;
	$google_key = cardealer_get_google_api_key();    
	/* register Theme style */
	wp_enqueue_style( 'cardealer-google-fonts'     , cardealer_google_fonts_url(), array(), '1.0.0' );// Google Fonts
	wp_register_style( 'bootstrap'                 , CARDEALER_URL.'/css/bootstrap.min.css');    
	wp_register_style( 'font-awesome-theme'        , CARDEALER_URL.'/css/font-awesome.min.css' );
    wp_register_style( 'cardealer-flaticon'        , CARDEALER_URL.'/css/flaticon.min.css');
	wp_register_style( 'jquery-ui'                 , CARDEALER_URL.'/css/jquery-ui/jquery-ui.min.css');
	wp_register_style( 'cardealer-external'        , CARDEALER_URL.'/css/plugins-css.min.css');
	wp_register_style( 'cardealer-mega_menu'       , CARDEALER_URL.'/css/mega-menu/mega_menu.min.css');
	wp_register_style( 'cardealer-timepicker'      , CARDEALER_URL.'/css/timepicker/jquery.timepicker.css');
	wp_register_style( 'cardealer-main'            , CARDEALER_URL.'/css/style.css');
	wp_register_style( 'cardealer-woocommerce'     , CARDEALER_URL.'/css/woocommerce.css', array('woocommerce-general')); 
	wp_register_style( 'cardealer-responsive'      , CARDEALER_URL.'/css/responsive.css');    
    wp_register_style( 'cardealer-slick'           , CARDEALER_URL.'/css/slick/slick.css');
    wp_register_style( 'cardealer-slick-theme'     , CARDEALER_URL.'/css/slick/slick-theme.css');    
    wp_register_style( 'cardealer-css-nice-select' , CARDEALER_URL.'/css/nice-select.min.css');
	wp_register_style( 'photoswipe-css'            , CARDEALER_URL.'/css/photoswipe/photoswipe.min.css');
	wp_register_style( 'default-skin'              , CARDEALER_URL.'/css/photoswipe/default-skin/default-skin.min.css');
	wp_register_style( 'magnific-popup'            , CARDEALER_URL.'/css/magnific-popup/magnific-popup.min.css');
	
	/*enqueue Theme style */		
	wp_enqueue_style( 'font-awesome-theme' );
    wp_enqueue_style( 'cardealer-flaticon' );
	wp_enqueue_style( 'bootstrap' );
	wp_enqueue_style( 'cardealer-mega_menu' );
	wp_enqueue_style( 'cardealer-main' );
	wp_enqueue_style( 'cardealer-responsive' );
	
	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_style( 'cardealer-woocommerce' );
    }
    /* Add custom CSS */
	if(isset($car_dealer_options['custom_css'])){
		$custom_css = trim(strip_tags($car_dealer_options['custom_css']));
		if( !empty($custom_css) ){
			wp_add_inline_style( 'cardealer-main', $custom_css );
		}
	}
	wp_enqueue_style( 'cardealer-css-nice-select' );
	wp_enqueue_style( 'cardealer-external' );
	wp_enqueue_style( 'cardealer-timepicker' );
	wp_enqueue_style( 'jquery-ui' );
	wp_enqueue_style( 'magnific-popup' );
	wp_enqueue_style( 'photoswipe-css' );
	wp_enqueue_style( 'default-skin' );
	wp_enqueue_style( 'wp-mediaelement' ); 
	
	
    /*register SCripts */ 
	wp_register_script( 'bootsrap'                        , CARDEALER_URL.'/js/bootstrap.min.js'                               , array(), false, true );
	wp_register_script( 'cardealer-external'              , CARDEALER_URL.'/js/plugins-jquery.min.js'                              , array(),false, true );
	wp_register_script( 'cardealer-js-appear'             , CARDEALER_URL.'/js/jquery.appear.js'                               , array(), false, true );	
	wp_register_script( 'magnific-popup'                  , CARDEALER_URL.'/js/magnific-popup/jquery.magnific-popup.min.js'                 , array(), false, true );
	wp_register_script( 'countTo-js'                      , CARDEALER_URL.'/js/counter/jquery.countTo.min.js'                      , array(), false, true );
	wp_register_script( 'cardealer-countdown'             , CARDEALER_URL.'/js/countdown/jquery.downCount.min.js'                  , array(), false, true );
	wp_register_script( 'cardealer-timepicker'            , CARDEALER_URL.'/js/timepicker/jquery.timepicker.js'                , array(), false, true );
	wp_register_script( 'cardealer-mega_menu'             , CARDEALER_URL.'/js/mega-menu/mega_menu.min.js'                         , array(), false, true );
	wp_register_script( 'isotope'                         , CARDEALER_URL.'/js/isotope/isotope.pkgd.min.js'                    , array(), false, true );
    wp_register_script( 'cardealer-nice-select'           , CARDEALER_URL.'/js/jquery.nice-select.min.js'                          , array(), false, true );
    wp_register_script( 'jquery-dotdotdot'                , CARDEALER_URL.'/js/jquery.dotdotdot.min.js'                        , array(), false, true );
    
    
    wp_register_script( 'cardealer-google-maps-apis'      , 'https://maps.googleapis.com/maps/api/js?key='.$google_key                        , array(), false, true );    
    wp_register_script( 'cardealer-google-recaptcha-apis' , 'https://www.google.com/recaptcha/api.js?onload=doCaptcha&render=explicit'        , array(), false, true );
    wp_register_script( 'cardealer-google-maps-script'    , CARDEALER_URL.'/js/map/map.js'                                     , array(), false, true );
    wp_register_script( 'cardealer-print-script'          , CARDEALER_URL.'/js/print/print.js'                                 , array(), false, true );
    wp_register_script( 'cars_customs'                    , CARDEALER_URL.'/js/cars_customs.js'                                , array(), false, true );
	wp_register_script( 'cardealer-js'                    , CARDEALER_URL.'/js/custom.js'                                      , array( 'jquery' ), false, true );
    
	wp_register_script( 'cardealer-cookie'                 , CARDEALER_URL.'/js/cookie/cookies.min.js'						      , array(), false, true );
	wp_register_script( 'photoswipe-js'                 , CARDEALER_URL.'/js/photoswipe/photoswipe.min.js'						      , array(), false, true );
	wp_register_script( 'photoswipe-ui-default'                 , CARDEALER_URL.'/js/photoswipe/photoswipe-ui-default.min.js'						      , array(), false, true );
    wp_localize_script( 'cars_customs', 'cars_price_slider_params', array(
    	'currency_symbol' 	=> cardealer_get_cars_currency_symbol(),
    	'currency_pos'      => cardealer_get_cars_currency_placement(),
    	'min_price'			=> isset( $_GET['min_price'] ) ? esc_attr( $_GET['min_price'] ) : '',
    	'max_price'			=> isset( $_GET['max_price'] ) ? esc_attr( $_GET['max_price'] ) : '',
        'cars_form_url'     => get_post_type_archive_link('cars')   
    ) );
    
    wp_localize_script( 'cars_customs', 'cars_year_range_slider_params', array(    	
    	'is_year_range_active' => cardealer_is_year_range_active(),        
        'min_year'			=> isset( $_GET['min_year'] ) ? esc_attr( $_GET['min_year'] ) : '',
    	'max_year'			=> isset( $_GET['max_year'] ) ? esc_attr( $_GET['max_year'] ) : '',           
    ) );
    
	wp_localize_script( 'cardealer-js', 'cardealer_obj', array(
    	'site_url' 	=> site_url(),
        'cars_url'  => site_url('cars/')           	    	
    ) );    
    wp_register_script( 'slick-js'                    , CARDEALER_URL.'/js/slick/slick.min.js'                             , array( 'jquery' ), false, true );    
	
    wp_enqueue_script( 'jquery-ui-datepicker');
	wp_enqueue_script( 'cardealer-countdown' );
	wp_enqueue_script( 'bootsrap' );	
	wp_enqueue_script( 'cardealer-js-appear' );
	wp_enqueue_script( 'magnific-popup' );
	wp_enqueue_script( 'countTo-js' );
	wp_enqueue_script( 'cardealer-external' );
	wp_enqueue_script( 'cardealer-timepicker' );
    wp_enqueue_script( 'cardealer-nice-select' );
    wp_enqueue_script( 'jquery-dotdotdot' );
	wp_enqueue_script( 'cardealer-cookie' );
	wp_enqueue_script( 'photoswipe-js' );
	wp_enqueue_script( 'photoswipe-ui-default' );
	
	/* enqueue if video is selected from theme options header background settings OR video widget is active */	
	$enable_custom_banner = isset($post) ? get_post_meta($post->ID,'enable_custom_banner', true) : '';
	$banner_type = isset($post) ? get_post_meta($post->ID,'banner_type', true) : '';
	
	if(( $enable_custom_banner && !empty($banner_type) && $banner_type == 'video') || (!empty($car_dealer_options['banner_type']) && $car_dealer_options['banner_type'] == 'video'))
	{
		if(function_exists('is_plugin_active') && !is_plugin_active('js_composer/js_composer.php')){
		wp_register_script( 'youtube_iframe_api_js', '//www.youtube.com/iframe_api' );
		wp_enqueue_script( 'youtube_iframe_api_js' );
		}else{
			wp_enqueue_script( 'vc_youtube_iframe_api_js' );
		}		
	}
	
	// Localize the script with new data
	$translation_array = array(
		'ajaxurl' => admin_url('admin-ajax.php'),
	);
	/****************************************
	  Code for Sticky Header Options Starts
	*****************************************/	
	// Sticky Top Bar
	if( isset( $car_dealer_options['sticky_topbar'] ) && $car_dealer_options['sticky_topbar'] == 'on' && isset( $car_dealer_options['top_bar'] ) && $car_dealer_options['top_bar'] == true )
		$translation_array['sticky_topbar'] = true;
	else
		$translation_array['sticky_topbar'] = false;
	// Script for Mobile
	if( isset($car_dealer_options['sticky_header']) && ($car_dealer_options['sticky_header'] == true ) && isset($car_dealer_options['sticky_header_mobile']) && ($car_dealer_options['sticky_header_mobile'] == true) )
		$translation_array['sticky_header_mobile'] = true;
	else
		$translation_array['sticky_header_mobile'] = false;
	// Script for Desktop
	if( isset( $car_dealer_options['sticky_header'] ) && ($car_dealer_options['sticky_header'] == true ))
		$translation_array['sticky_header_desktop'] = true;
	else
		$translation_array['sticky_header_desktop'] = false;
	/****************************************
	  Code for Sticky Header Options Ends
	*****************************************/	
	wp_localize_script( 'cardealer-js', 'cardealer_js', $translation_array );
	// Enqueued script with localized data.
	wp_enqueue_script( 'cardealer-js' );    
    wp_enqueue_script( 'jquery-ui-core' );
    wp_enqueue_script( 'jquery-ui-slider' );
	wp_enqueue_script( 'jquery-ui-sortable' );
    wp_enqueue_script( 'jquery-ui-autocomplete' );
    
    wp_enqueue_script( 'slick-js' );
	wp_enqueue_script('cardealer-mega_menu');
	wp_enqueue_script('isotope');
	wp_enqueue_script('wp-mediaelement');
	
	// Captcha js script
	$captcha_sitekey = cardealer_get_goole_api_keys('site_key');
	$captcha_secret_key = cardealer_get_goole_api_keys('secret_key');
	if( isset($captcha_secret_key) && !empty($captcha_secret_key) && isset($captcha_sitekey) && !empty($captcha_sitekey) ){
		wp_localize_script( 'cardealer-js', 'goole_captcha_api_obj', array(
			'google_captcha_site_key' 	=> $captcha_sitekey,
			'google_captcha_secret_key' => $captcha_secret_key
		) );
		if( is_single() && get_post_type()=='cars' ){
			wp_enqueue_script( 'cardealer-google-recaptcha-apis' );
		}
	}
	
	// Add custom Javascript
	if( isset($car_dealer_options['custom_js']) && !empty($car_dealer_options['custom_js']) ){
		$custom_js = $car_dealer_options['custom_js'];
		$custom_js = trim(strip_tags($custom_js));
		if( !empty($custom_js) ){
			wp_add_inline_script( 'cardealer-js', $custom_js );
		}
	}
	/* Preloader Theme Options */
	// Add custom Css for Preloader Theme Options
	if( isset($car_dealer_options['preloader']) && $car_dealer_options['preloader'] == 1 ){
		if( isset($car_dealer_options['preloader_css']) && $car_dealer_options['preloader_img'] == 'code' ){
			$preloader_css = trim(strip_tags($car_dealer_options['preloader_css']));
			if( !empty($preloader_css) ){
				wp_add_inline_style( 'cardealer-main', $preloader_css );
			}
		}
	}
		
	// Add custom Javascript for Preloader Theme Options
	if( isset($car_dealer_options['preloader']) && $car_dealer_options['preloader'] == 1 ) { 
		if( isset($car_dealer_options['preloader_js']) && !empty($car_dealer_options['preloader_js']) && $car_dealer_options['preloader_img'] == 'code' ){
			$preloader_js = $car_dealer_options['preloader_js'];
			$preloader_js = trim(strip_tags($preloader_js));
			if( !empty($preloader_js) ){ 
				$loader = array(
					'loader_theme_set' => true,
				);
				wp_localize_script( 'cardealer-js', 'cardealer_options_js', $loader );
				wp_enqueue_script( 'cardealer-js' );
				wp_add_inline_script( 'cardealer-js', $preloader_js );
			}
		}
	}
    if( is_single() && get_post_type()=='cars' ){
        wp_enqueue_style( 'cardealer-slick' );
        wp_enqueue_style( 'cardealer-slick-theme' );
        wp_enqueue_script('cardealer-google-maps-apis');
        wp_enqueue_script('cardealer-google-maps-script');
        wp_enqueue_script('cardealer-print-script');
    }
        wp_enqueue_script('cars_customs');        
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
/*
 * Add script and style in wp-admin side
 */ 
add_action( 'admin_enqueue_scripts', 'cardealer_admin_enqueue_scripts' );
function cardealer_admin_enqueue_scripts($hook){
	// Javascript
	wp_register_script( 'cardealer_admin_js', CARDEALER_URL.'/js/admin.js', array('jquery') );
	wp_enqueue_script('cardealer_admin_js');
	// CSS
	wp_register_style( 'cardealer-css-jqueryui', CARDEALER_URL.'/css/jquery-ui/jquery-ui.min.css');
	wp_register_style( 'font-awesome'         , CARDEALER_URL.'/css/font-awesome.min.css' );
    wp_register_style( 'cardealer-flaticon'      , CARDEALER_URL.'/css/flaticon.css');
	wp_register_style( 'cardealer-admin-style' , CARDEALER_URL.'/css/admin_style.css' );
	wp_enqueue_style( 'cardealer-css-jqueryui' );
	wp_enqueue_style( 'font-awesome' );
    wp_enqueue_style( 'cardealer-flaticon' );
	wp_enqueue_style( 'cardealer-admin-style' );
}