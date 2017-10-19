<?php
//add rel and title attribute to next pagination link
function cardealer_get_next_posts_link_attributes($attr){
	$attr = 'rel="next" title="'.esc_attr('View the Next Page', 'cardealer').'"';
	return $attr;
}
add_filter('next_posts_link_attributes', 'cardealer_get_next_posts_link_attributes');

//add rel and title attribute to prev pagination link
function cardealer_get_previous_posts_link_attributes($attr){
	$attr = 'rel="prev" title="'.esc_attr('View the Previous Page', 'cardealer').'"';
	return $attr;
}
add_filter('previous_posts_link_attributes', 'cardealer_get_previous_posts_link_attributes');

/* Custom Backend Footer*/
function cardealer_custom_admin_footer() {
	sprintf(
		wp_kses(
			__('<span id="footer-thankyou">Developed by <a href="$1" target="_blank">TeamWP @Potenza Global Solutions</a></span>.', 'cardealer'),
			array(
				'span' => array(),
				'a'    => array(
					'href'   => array(),
					'target' => array()
				)
			)
		),
		esc_url('http://www.potenzaglobalsolutions.com/')
	);
}
add_filter('admin_footer_text', 'cardealer_custom_admin_footer');

/**
 * Add page title attribute to wp_list_pages link tags
 *
 * @since Car Dealer 1.0
 */
function cardealer_wp_list_pages_filter($output) {
	$output = preg_replace('/<a(.*)href="([^"]*)"(.*)>(.*)<\/a>/','<a$1 title="$4" href="$2"$3>$4</a>',$output);
	return $output;
}
add_filter('wp_list_pages', 'cardealer_wp_list_pages_filter');

/************************************
 * ADMIN CUSTOMIZATION
 * - Set content width
 * - Set image attachment width
 * - Disable default dashboard widgets
 * - Change name of "Posts" in admin menu
 ************************************/
/**
 * Adjust content_width value for image attachment template
 *
 * @since Car Dealer 1.0
 */
function cardealer_content_width() {
	if ( is_attachment() && wp_attachment_is_image() ) {
		$GLOBALS['content_width'] = 810;
	}
}
add_action( 'template_redirect', 'cardealer_content_width' );

add_filter( 'body_class', 'cardealer_body_classes' );
function cardealer_body_classes($classes){
    global $post, $car_dealer_options;
	
	// Sidebar Classes
	if( is_front_page() || is_single() ){
		$cardealer_blog_sidebar = isset($car_dealer_options['blog_sidebar']) ? $car_dealer_options['blog_sidebar'] : '';
		$classes[] = "sidebar-$cardealer_blog_sidebar";
	}elseif( is_page() ){
		$cardealer_page_sidebar = isset($car_dealer_options['page_sidebar']) ? $car_dealer_options['page_sidebar'] : '';
		
		// Page sidebar set inside page
		$page_layout_custom = get_post_meta($post->ID,'page_layout_custom',true);
		if($page_layout_custom){
			$page_sidebar = get_post_meta( $post->ID,'page_sidebar',true);
			if( $page_sidebar ){
				$cardealer_page_sidebar = $page_sidebar;
			}
		}
		
		$classes[] = "sidebar-$cardealer_page_sidebar";
	}
	if( cardealer_is_vc_enabled() ){
		$classes[] = "is_vc_enabled";
	}else{
		$classes[] = "is_vc_disabled";
	}
	
    return $classes;
}
//site logo settings
function cardealer_get_site_logo() {
	global $car_dealer_options;	
	if( isset($car_dealer_options['site-logo']) && isset($car_dealer_options['site-logo']['url']) ) {
		return $car_dealer_options['site-logo']['url'];	
	} else {		
		return false;	
	}
}

//site sticky logo settings
function cardealer_get_site_sticky_logo() {
	global $car_dealer_options;	
	if( isset($car_dealer_options['site-sticky-logo']) && isset($car_dealer_options['site-sticky-logo']['url']) ) {		
		return $car_dealer_options['site-sticky-logo']['url'];	
	} else {		
		return false;	
	}
}

//display loader
function cardealer_display_loader(){
    global $car_dealer_options;
    $preloader = isset($car_dealer_options['preloader']) ? $car_dealer_options['preloader'] : '' ; //get the status of the side bar
	if($preloader){
		$preloader_img = $car_dealer_options['preloader_img'];
		if( isset( $car_dealer_options['preloader_html'] ) && $preloader_img == 'code' ) {
			echo $car_dealer_options['preloader_html'];
		} else {
				if( $preloader_img == 'pre_loader' )
					$imgUrl = CARDEALER_URL . '/images/preloader_img/'. $car_dealer_options['predefined_loader_img'] .'.gif';
				else
					$imgUrl = $car_dealer_options['preloader_image']['url'];
			?>
				<div id="loading">
					<div id="loading-center">
						<img src="<?php echo esc_url($imgUrl);?>" alt="Loader" title="loading...">
					</div>
				</div>
			<?php
			}
		}
}

// Intro Class
function cardealer_intro_class(){
    global $post, $car_dealer_options;

	$header_intro_class = array();
	
	// Set classes from Options
	$banner_type = isset($car_dealer_options['banner_type']) ? $car_dealer_options['banner_type'] : '';
	if( empty($banner_type) ){
		$banner_type = 'image';
	}
	
	$header_intro_class['header_intro_bg'] = 'header_intro_bg-' . $banner_type;
	
	if( $banner_type == 'image'){
		if( !empty($car_dealer_options['banner_image_opacity'])){
			$header_intro_class['header_intro_opacity'] = 'header_intro_opacity';
			$header_intro_class['header_intro_opacity_type'] = 'header_intro_opacity-' . $car_dealer_options['banner_image_opacity'];
		}
	}elseif($banner_type == 'video'){
		if(!empty($car_dealer_options['banner_video_opacity']) ){
			$header_intro_class['header_intro_opacity'] = 'header_intro_opacity';
			$header_intro_class['header_intro_opacity_type'] = 'header_intro_opacity-' . $car_dealer_options['banner_video_opacity'];
		}
	}
	
	if( is_page() || is_home() || is_single() ){
		$post_id = is_home()? get_option( 'page_for_posts' ) : $post->ID;
		
		$enable_custom_banner = get_post_meta($post_id,'enable_custom_banner', true);
		if( $enable_custom_banner ){
			unset($header_intro_class['header_intro_bg']);
			unset($header_intro_class['header_intro_opacity']);
			unset($header_intro_class['header_intro_opacity_type']);
			$banner_type = get_post_meta($post_id,'banner_type', true);
			if( empty($banner_type) ){
				$banner_type = 'image';
			}
			$header_intro_class['header_intro_bg'] = 'header_intro_bg-' . $banner_type;
			
			if( $banner_type && $banner_type == 'image' ){
				$header_intro_class['header_intro_opacity'] = 'header_intro_opacity';
				$background_opacity_color = get_post_meta($post_id,'background_opacity_color', true);
				if( $background_opacity_color ){
					$header_intro_class['header_intro_opacity_type'] = 'header_intro_opacity-' . $background_opacity_color;
				}
			}elseif($banner_type && $banner_type == 'video'){
				$header_intro_class['header_intro_opacity'] = 'header_intro_opacity';
				$video_background_opacity_color = get_post_meta($post_id,'video_background_opacity_color', true);
				if( $video_background_opacity_color ){
					$header_intro_class['header_intro_opacity_type'] = 'header_intro_opacity-' . $video_background_opacity_color;
				}	
			}
		}
	}
	
	$header_intro_class = implode(' ', $header_intro_class);
    echo esc_attr($header_intro_class);
}
/* footer class */
// Intro Class
function cardealer_footer_class(){
    global $post, $car_dealer_options;

	$footer_class = array();
	
	// Set classes from Options
	$banner_type_footer = isset($car_dealer_options['banner_type_footer']) ? $car_dealer_options['banner_type_footer'] : '' ;
	if( empty($banner_type_footer) ){
		$banner_type_footer = 'color';
	}
	
	$footer_class['footer_bg'] = 'footer_bg-' . $banner_type_footer;
	if( $banner_type_footer == 'image' ){
		if( !empty($car_dealer_options['banner_image_opacity_footer']) ){
			$footer_class['header_intro_opacity_footer'] = 'footer_opacity';
			$footer_class['header_intro_opacity_type_footer'] = 'footer_opacity-' . $car_dealer_options['banner_image_opacity_footer'];
		}
	}
	return $footer_class;
}




/**
 * Removes the annoying […] to a Read More link
	*
 * @since Car Dealer 1.0
 * @global post
 */
function cardealer_excerpt_more( $more ) {
	global $post;
	return '&hellip; <a class="read-more" href="'. esc_url(get_permalink( $post->ID )) . '" title="'. esc_html__('Read', 'cardealer') . get_the_title( $post->ID ).'">'. esc_html__('Read more &raquo;', 'cardealer') .'</a>';
} // end cardealer excerpt more function

/**
 * Filter out hard-coded dimensions on all images in WordPress
 *
 * @link https://gist.github.com/4557917
 *
 * @since Car Dealer 1.0
 */
function cardealer_remove_img_dimensions( $html ) {
	// Loop through all <img> tags
	if ( preg_match( '/<img[^>]+>/ims', $html, $matches ) ) {
		foreach ( $matches as $match ) {
			// Replace all occurences of width/height
			$clean = preg_replace( '/(width|height)=["\'\d%\s]+/ims', "", $match );
			// Replace with result within html
			$html = str_replace( $match, $clean, $html );
		}
	}
	return $html;
}
add_filter( 'get_avatar','cardealer_remove_img_dimensions', 10 );

/**
 * Truncate String with or without ellipsis.
 *
 * @param string $string      String to truncate
 * @param int    $maxLength   Maximum length of string
 * @param bool   $addEllipsis if True, "..." is added in the end of the string, default true
 * @param bool   $wordsafe    if True, Words will not be cut in the middle
 *
 * @return string Shotened Text
 */
function cardealer_shortenString($string = '', $maxLength, $addEllipsis = true, $wordsafe = false){
	if( empty($string) ){
		$string;
	}
	$ellipsis = '';
	$maxLength = max($maxLength, 0);
	if (mb_strlen($string) <= $maxLength) {
		return $string;
	}
	if ($addEllipsis) {
		$ellipsis = mb_substr('...', 0, $maxLength);
		$maxLength -= mb_strlen($ellipsis);
		$maxLength = max($maxLength, 0);
	}
	if ($wordsafe) {
		$string = preg_replace('/\s+?(\S+)?$/', '', mb_substr($string, 0, $maxLength));
	} else {
		$string = mb_substr($string, 0, $maxLength);
	}
	if ($addEllipsis) {
		$string .= $ellipsis;
	}
	return $string;
}

function cardealer_get_excerpt_max_charlength($charlength, $excerpt = null) {
	if( empty($excerpt) ){
		$excerpt = get_the_excerpt();
	}
	$charlength++;
	
	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		
		$new_excerpt = '';
		if ( $excut < 0 ) {
			$new_excerpt = mb_substr( $subex, 0, $excut );
		} else {
			$new_excerpt = $subex;
		}
		$new_excerpt .= '[...]';
		return $new_excerpt;
	} else {
		return $excerpt;
	}
}
function cardealer_the_excerpt_max_charlength($charlength, $excerpt = null) {
	$new_excerpt = cardealer_get_excerpt_max_charlength($charlength, $excerpt);
	echo esc_html($new_excerpt);
}

// Check if on login or register page
function cardealer_is_login_page() {
	return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
}

function cardealer_layout_content( $field = '', $context = '' ){
	global $car_dealer_options;
	
	if( empty($field) ){
		return;
	}
	
	if( $field == 'email' ){
		if( isset($car_dealer_options['site_email']) && !empty($car_dealer_options['site_email']) ){
			if( $context == 'topbar' ){
				return '<i class="fa fa-envelope-o"></i> <a href="mailto:' . sanitize_email($car_dealer_options['site_email']).'">'.sanitize_email($car_dealer_options['site_email']).'</a>';
			}else{
				return sanitize_email($car_dealer_options['site_email']);
			}
		}else{
			return;
		}
	}elseif( $field == 'address' ){
		if( isset($car_dealer_options['site_address']) && !empty($car_dealer_options['site_address']) ){
			if( $context == 'topbar' ){
				return '<i class="fa fa-map-marker"></i> '.esc_html($car_dealer_options['site_address']).'</a>';
			}else{
				return esc_html($car_dealer_options['site_address']);
			}
		}else{
			return;
		}
	}elseif( $field == 'promocode' ){
		$element_id = uniqid('cdhl-promo-');
		ob_start();
        ?>
        <div class="top-promocode-box">	
            <div class="promocode-form form-inline" id="<?php echo esc_attr($element_id)?>">
                <input type="hidden" name="action" class="promocode_action" value="validate_promocode"/>
                <input type="hidden" name="promocode_nonce" class="promocode_nonce" value="<?php echo wp_create_nonce("cdhl-promocode-form");?>">
                <div class="form-group">
                    <label for="promocode" class="sr-only">Promocode</label>
                    <input type="text" name="promocode" class="form-control promocode" placeholder="<?php echo esc_html__('Promocode','cardealer')?>">
                </div>
                <button type="button" class="button promocode-btn" data-fid="<?php echo esc_attr($element_id)?>"><?php echo esc_html__('Go','cardealer')?></button>
    			<span class="spinimg"></span>
    			<p class="promocode-msg" style="display:none;"></p>
            </div>
        </div>
        <?php
		return ob_get_clean();
    }elseif( $field == 'phone_number' ){
		if( isset($car_dealer_options['site_phone']) && !empty($car_dealer_options['site_phone']) ){
			if( $context == 'topbar' ){
				return '<i class="fa fa-phone"></i> ' . esc_html($car_dealer_options['site_phone']);
			}else{
				return esc_html($car_dealer_options['site_phone']);
			}
		}else{
			return;
		}
    }elseif( $field == 'contact_timing' ){
		if( isset($car_dealer_options['site_contact_timing']) && !empty($car_dealer_options['site_contact_timing']) ){
			if( $context == 'topbar' ){
				return '<i class="fa fa-clock-o"></i> ' . esc_html($car_dealer_options['site_contact_timing']);
			}else{
				return esc_html($car_dealer_options['site_contact_timing']);
			}
		}else{
			return;
		}
	}elseif( $field == 'login' ){
		$topbar_login_url = wp_login_url( add_query_arg( array(), remove_query_arg(array()) ));
		
		if( isset($car_dealer_options['topbar_custom_login_url']) && !empty($car_dealer_options['topbar_custom_login_url']) ){
			$topbar_login_url = $car_dealer_options['topbar_custom_login_url'];
		}
		
		$topbar_login_url = apply_filters( 'topbar_login_url', $topbar_login_url );
		
		if ( class_exists( 'WooCommerce' ) ) { 
            if( $context == 'topbar' ){			
                if ( is_user_logged_in() ) {
                    return '<a href="'.esc_url(get_permalink( get_option('woocommerce_myaccount_page_id') )).'" ><i class="fa fa-lock"></i> '.esc_html__('My Account','cardealer').'</a>';
                } else {
                    return '<a href="'.esc_url(get_permalink( get_option('woocommerce_myaccount_page_id') )).'" ><i class="fa fa-lock"></i> '.esc_html__('Login','cardealer').'</a>';
                }
    		}else{
    			return esc_url($topbar_login_url);
    		}
        }
	}elseif( $field == 'social_profiles' ){
		$social_profiles = array(
			'facebook_url' => array(
				'key'      => 'facebook',
				'name'     => esc_html__('Facebook', 'cardealer'),
				'icon'     => '<i class="fa fa-facebook"></i>',
			),
			'twitter_url'  => array(
				'key'          => 'twitter',
				'name'         => esc_html__('Twitter', 'cardealer'),
				'icon'         => '<i class="fa fa-twitter"></i>',
			),
			'dribble_url'  => array(
				'key'          => 'Dribbble',
				'name'         => esc_html__('Dribbble', 'cardealer'),
				'icon'         => '<i class="fa fa-dribbble"></i>',
			),
			'vimeo_url'    => array(
				'key'          => 'vimeo',
				'name'         => esc_html__('Vimeo', 'cardealer'),
				'icon'         => '<i class="fa fa-vimeo"></i>',
			),
			'pinterest_url'=> array(
				'key'          => 'pinterest',
				'name'         => esc_html__('Pinterest', 'cardealer'),
				'icon'         => '<i class="fa fa-pinterest"></i>',
			),
			'behance_url'  => array(
				'key'          => 'behance',
				'name'         => esc_html__('Behance', 'cardealer'),
				'icon'         => '<i class="fa fa-behance"></i>',
			),
			'linkedin_url' => array(
				'key'          => 'linkedin',
				'name'         => esc_html__('Linkedin', 'cardealer'),
				'icon'         => '<i class="fa fa-linkedin"></i>',
			),
			'instagram_url' => array(
				'key'          => 'instagram',
				'name'         => esc_html__('Instagram', 'cardealer'),
				'icon'         => '<i class="fa fa-instagram"></i>',
			),
		);
		$social_profiles_temp = $social_profiles;
		foreach( $social_profiles as $social_profile_k => $social_profile_data ){
			if( isset($car_dealer_options[$social_profile_k]) && !empty($car_dealer_options[$social_profile_k]) ){
				$social_profiles_temp[$social_profile_k]['url'] = $car_dealer_options[$social_profile_k];
			}else{
				unset($social_profiles_temp[$social_profile_k]);
			}
		}
		if( empty($social_profiles_temp) ){
			return;
		}
		if( $context == 'topbar' ){
			$social_content = '';
			$social_content_sr = 1;
			foreach( $social_profiles_temp as $social_profile ){
				if( $social_content_sr > 1 ){
					$social_content .= '<li class="topbar_item topbar_item_type-social_profiles">';
				}
				$social_content .= '<a href="' . esc_url($social_profile['url']).'">'.$social_profile['icon'].'</a>';
				if( $social_content_sr < count($social_profiles_temp) ){
					$social_content .= '</li>';
				}
				$social_content_sr++;
			}
			return $social_content;
		}else{
			return $social_profiles_temp;
		}
	}
}

/**
 * Returns array of supported contact form shortcodes.
 *
 * @since 1.0.0
 *
 * global $cardealer_globals
 *
 * return array
 */
function cardealer_contact_form_shortcodes(){
	global $tchl_globals;
	
	if( isset($tchl_globals['contact_form_shortcodes']) && !empty($tchl_globals['contact_form_shortcodes']) ){
		$contact_form_shortcodes = $tchl_globals['contact_form_shortcodes'];
	}else{
		$contact_form_shortcodes = array();
	}
	
	/*
	 * "hooked" to 'pgs_contact_form_shortcodes' using the add_filter() function.
	 * - 'pgs_contact_form_shortcodes' is the filter hook $tag
	 * - $contact_form_shortcodes is the value being filtered
	 */
	$contact_form_shortcodes = $tchl_globals['contact_form_shortcodes'] = apply_filters('pgs_contact_form_shortcodes', $contact_form_shortcodes);
	
	return $contact_form_shortcodes;
}

/**
 * Converts a multidimensional array of CSS rules into a CSS string.
 *
 * @param array $rules
 *   An array of CSS rules in the form of:
 *   array('selector'=>array('property' => 'value')). Also supports selector
 *   nesting, e.g.,
 *   array('selector' => array('selector'=>array('property' => 'value'))).
 *
 * @return string
 *   A CSS string of rules. This is not wrapped in style tags.
 *
 * source : http://www.grasmash.com/article/convert-nested-php-array-css-string
 */
function cardealer_generate_css_properties($rules, $indent = 0) {
	$css = '';
	$prefix = str_repeat('  ', $indent);
	foreach ($rules as $key => $value) {
		if (is_array($value)) {
			$selector = $key;
			$properties = $value;
			
			$css .= $prefix . "$selector {\n";
			$css .= $prefix .cardealer_generate_css_properties($properties, $indent + 1);
			$css .= $prefix . "}\n";
		}
		else {
			$property = $key;
			$css .= $prefix . "$property: $value;\n";
		}
	}
	return $css;
}

// Convert hexdec color string to rgb(a) string
// Source : https://support.advancedcustomfields.com/forums/topic/color-picker-values/
function cardealer_hex2rgba($color = '', $opacity = false) {

	$default = 'rgb(0,0,0)';

	//Return default if no color provided
	if(empty($color))
		  return $default;

	//Sanitize $color if "#" is provided
	if ($color[0] == '#' ) {
		$color = substr( $color, 1 );
	}

	//Check if color has 6 or 3 characters and get values
	if (strlen($color) == 6) {
		$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
	} elseif ( strlen( $color ) == 3 ) {
		$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
	} else {
		return $default;
	}

	//Convert hexadec to rgb
	$rgb =  array_map('hexdec', $hex);

	//Check if opacity is set(rgba or rgb)
	if($opacity){
		if(abs($opacity) > 1)
			$opacity = 1.0;
		$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
	} else {
		$output = 'rgb('.implode(",",$rgb).')';
	}

	//Return rgb(a) color string
	return $output;
}

function cardealer_array_sort_by_column(&$array, $column, $direction = SORT_ASC) {
    $reference_array = array();	
    foreach($array as $key => $row) {
		if(isset($row[$column])){
			$reference_array[$key] = $row[$column];
		}
    }	
	if(sizeof($reference_array) == sizeof($array) ){
		array_multisort($reference_array, $array, $direction);
	}
}

/*
 * Return whether Visual Composer is enabled on a page/post or not.
 *
 * $post_id = numeric post_id
 * return true/false
 */
function cardealer_is_vc_enabled( $post_id = '' ){
	global $post;
	
	if( is_search() || is_404() || empty($post)  ) return;
	
	if( empty( $post_id ) ){
		$post_id = $post->ID;
	}
	$vc_enabled = get_post_meta( $post_id, '_wpb_vc_js_status', true );
	return ($vc_enabled=='true')? true : false;
}

/*
 * Hide page template if Car Dealer helper plugin not activate.
 */
add_filter('theme_page_templates','cardealer_hide_page_templates',10, 1);
function cardealer_hide_page_templates($page_templates){	
	
	if(!is_plugin_active('cardealer-helper-library/cardealer-helper-library.php')){		
		unset($page_templates['templates/faq.php']);
		unset($page_templates['templates/team.php']);
		unset($page_templates['templates/promocode.php']);
	}
	
	if(!is_plugin_active('js_composer/js_composer.php')){
		unset($page_templates['templates/page-vc_compatible.php']);
	}
	
	
	return $page_templates;
}

/***************************************
****** FUNCTION TO GET IMAGE DATA ******
****************************************/
function cardealer_get_attachment_detail( $attachment_id ) {
	$attachment = get_post( $attachment_id );
	return array(
		'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
		'caption' => $attachment->post_excerpt,
		'description' => $attachment->post_content,
		'href' => get_permalink( $attachment->ID ),
		'src' => $attachment->guid,
		'title' => $attachment->post_title
	);
}

/**
 * This function is used to remove size style from tags
 */
add_filter('wp_generate_tag_cloud', 'cardealer_na_tag_cloud',10,1);
function cardealer_na_tag_cloud($string){
   return preg_replace("/style='font-size:.+pt;'/", '', $string);
}

/*
* Function for theme option to check SITE IS OPENED IN MOBILE OR NOT
*/
function cardealer_site_opened_in_mobile() {
	$useragent=$_SERVER['HTTP_USER_AGENT'];
	if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {
		return true;
	} else {
		return false;
	}
}

/*
* Function to add NewsLetter on Comming Soon page
*/
function cardealer_comming_soon_newsletter() {
	global $car_dealer_options;	
	if(function_exists('is_plugin_active') && is_plugin_active('mailchimp-for-wp/mailchimp-for-wp.php')) {
		if( isset( $car_dealer_options['comming_page_newsletter_shortcode'] ) && !empty( $car_dealer_options['comming_page_newsletter_shortcode'] ) )
			$mailchimp_id=$car_dealer_options['comming_page_newsletter_shortcode'];
		else
			return;
		if( !empty($car_dealer_options['newsletter_description']) ) {
		?>
		<div class="row text-center">
			<div class="col-lg-12 col-md-12">
				<p><?php echo $car_dealer_options['newsletter_description']?></p>
			</div>
		</div><?php
		}?>
		<div class="row gray-form no-gutter">
			<div class="col-sm-12">
				<form id="mc4wp-form-1" class="mc4wp-form mc4wp-form-<?php echo esc_attr($mailchimp_id);?> mc4wp-form-submitted mc4wp-form-success" method="post" data-id="<?php echo esc_attr($mailchimp_id);?>" data-name="Comming Soon Newsletter">
					<div class="col-md-offset-3 col-md-6 col-sm-offset-1 col-sm-10 col-xs-12">
                    <div class="col-md-9 col-sm-8 col-xs-12 mc4wp-form-fields" style="padding:0; margin-bottom:5px;">
						<input name="EMAIL" placeholder="Your email address" required="" class="placeholder form-control" type="email">
						<div style="display: none;">
							<input name="_mc4wp_honeypot" value="" tabindex="-1" autocomplete="off" type="text">
						</div>
						<input name="_mc4wp_timestamp" value="<?php echo time();?>" type="hidden">
						<input name="_mc4wp_form_id" value="<?php echo esc_attr($mailchimp_id);?>" type="hidden">
						<input name="_mc4wp_form_element_id" value="mc4wp-form-1" type="hidden">
					</div>
					<div class="col-md-3 col-sm-4 col-xs-12" style="padding:0;">
						<input class="button red btn-block" style="height:44px;" value="<?php esc_html_e('Notify Me','cardealer');?>" type="submit">
					</div></div>
					<div class="col-sm-12 text-center" style="padding:0;"><div class="mc4wp-response"><?php echo mc4wp_form_get_response_html($mailchimp_id);?></div></div>
				</form>
			</div>
		</div>
	<?php
	}
}

/*
* Function for adding given file list
* It accepts two parameters
* extensions: mixed (either array or string - comma separated)
* NOTE : Use this instead of GLOB() ( As glob() is having PHP version issue )
*/
function cardealer_helper_get_file_list( $extensions = '', $path = '' ){

 // Return if any paramater is blank
 if( empty($extensions) || empty($path) ){
  return false;
 }

 // Convert to array if string is provided
 if( !is_array($extensions) ){
  $extensions = array_filter( explode(',', $extensions) );
 }

 // Fix trailing slash if not provided.
 $path = rtrim( $path, '/\\' ) . '/';

 if ( defined( 'GLOB_BRACE' ) ){
  $extensions_with_glob_brace = "{". implode(',',$extensions)."}"; // file extensions pattern
  $files_with_glob = glob( $path."*.{$extensions_with_glob_brace}", GLOB_BRACE );

  return $files_with_glob;
 }else{
  $extensions_without_glob = implode('|',$extensions); // file extensions pattern

  $files_without_glob_all = glob( $path.'*.*' ); // Get all files

  $files_without_glob = array_values( preg_grep("~\.($extensions_without_glob)$~", $files_without_glob_all) ); // Filter files with pattern
  return $files_without_glob;
 }

 return $files;
}

/*
Filter code to add options for Page Layout
*/
function cardealer_wp_body_classes( $classes ) {
	global $car_dealer_options;
	if( wp_is_mobile() ){
		$classes[] = 'device-type-mobile';
	}
	if(!empty($car_dealer_options['page_layout'])){
		$classes[]='site-layout-'.$car_dealer_options['page_layout'];
	}else{
		$classes[] = '';
	}
	return $classes;
}
add_filter( 'body_class', 'cardealer_wp_body_classes' );


/*
*
*/
function cardealer_get_google_api_key(){
    global $car_dealer_options;
    if(isset($car_dealer_options['google_maps_api']) && !empty($car_dealer_options['google_maps_api'])){
        return $car_dealer_options['google_maps_api'];
    }else{
        return;
    }
}

/****ACF map Key****/
function cardealer_acf_init() {    	
	$google_key = cardealer_get_google_api_key();	
	if(isset($google_key) && !empty($google_key)){	
		acf_update_setting('google_api_key', $google_key);
	}
}
add_action('acf/init', 'cardealer_acf_init');

add_filter( 'megamenu_nav_menu_args', 'cardealer_reset_mega_menu', 10, 3 );
function cardealer_reset_mega_menu( $args, $menu_id, $current_theme_location ){

    // Reset menu arguments
    if( isset($_GET['disable-mega']) && $_GET['disable-mega'] == 1 ){

        // Reset Primary Menu
        if( $current_theme_location == 'primary-menu' ){
            $args['theme_location'] = $current_theme_location;
            $args['container']      = 'ul';
            $args['container_id']   = 'menu-wrap-primary';
            $args['container_class']= 'menu-wrap';
            $args['menu_id']        = 'primary-menu';
            $args['menu_class']     = 'menu-links';
            unset($args['walker']);

        }

    }

    return $args;
}

/* for excerpt data limit */
function cardealer_custom_excerpt_length( $length )
{
	global $post;	
	if( isset($post ->post_type) && $post ->post_type == 'teams' )
		return 15;
	else	
		return $length;
	
}
add_filter( 'excerpt_length', 'cardealer_custom_excerpt_length', 999 );

// Add GA tracking code in site footer
add_action('wp_footer', 'cardealer_add_analytics_script');
function cardealer_add_analytics_script()
{
	if( !function_exists('the_field') ) return;
	$tracking_code = the_field('tracking_code', 'option'); 
	if( empty( $tracking_code ) ) echo $tracking_code;
}