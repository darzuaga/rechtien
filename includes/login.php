<?php
/*
 * Add script and style in login screen.
 */ 
add_action( 'login_enqueue_scripts', 'cardealer_login_enqueue_scripts' );
function cardealer_login_enqueue_scripts(){
	global $car_dealer_options;
	
	wp_enqueue_style( 'cardealer-login-css', CARDEALER_URL.'/css/login_style.css', false );
	
	if( isset( $car_dealer_options['login_logo'] ) && !empty($car_dealer_options['login_logo']) && isset( $car_dealer_options['login_logo']['url'] ) && !empty($car_dealer_options['login_logo']['url']) ){
		$login_logo_option = $car_dealer_options['login_logo'];
		if( is_array($login_logo_option) && isset($login_logo_option['url']) && getimagesize($login_logo_option['url']) !== false ){
			$login_logo = $login_logo_option['url'];
		}
		if( !empty( $login_logo ) ){
			$login_logo = esc_url($login_logo);
			$cardealer_login_custom_css = "
				body.login{
					background-image:url('". CARDEALER_URL ."/images/login-body-bg.png');
				}
				#login{
					background-color:#ffffff;
					border: 1px solid #f9f9f9;
					-webkit-box-shadow: 0 3px 23px rgba(0,0,0,0.1); -ms-box-shadow: 0 3px 23px rgba(0,0,0,0.1); box-shadow: 0 3px 23px rgba(0,0,0,0.1);
					padding:0;
					width: 480px;
					 position: relative;
				    top: 48%;
				    -webkit-transform: translateY(-50%); -ms-transform: translateY(-50%); transform: translateY(-50%);
				}
				#login #login_error, #login .message {padding: 10px; background: #00a0d2; color: #ffffff; border-left: 0px; text-align: center;}
				#login #login_error{border-bottom: 5px solid #dc3232;}
				#login #login_error a{color: #ffffff;}
				body.login form{
					margin-top: 0px;
				}
				.login h1{
					background-color:#f9fafb;
					padding: 20px 0;
				}
				#login h1 a, .login h1 a {
					background-image: url({$login_logo}); 
					background-position: center center; 
					background-size: contain; 
					width: 260px; 
					height: 100px;
					margin-bottom:0;
				} 
				#loginform{
					background-color: #ffffff;
					padding: 45px 40px 50px;
				}
				#loginform label .input{font-size:18px; padding:10px 15px; margin-top:8px;}
				#loginform .forgetmenot{
				    display: block; float: none; margin-bottom: 15px;
				}
				#login form p.submit{float: left;}
				#login form p.submit #wp-submit{height: 40px; line-height: 40px; padding: 0 35px 10px; text-transform: uppercase; font-size: 14px;}

				#login #nav{float: left; padding: 0; margin-top: 16px;}
				#login #backtoblog{float: right; padding: 0;}

				@media (max-width: 500px){
					#login{width: 280px;}
					#loginform{padding: 20px 20px 25px;}
				}

				";
			wp_add_inline_style( 'cardealer-login-css', $cardealer_login_custom_css );
		}
	}
}

/**
 * Change logo link from wordpress.org to your site
 *
 * @since Car Dealer 1.0
 */
function cardealer_login_url() {
	return esc_url( home_url( '/' ) );
}
add_filter( 'login_headerurl', 'cardealer_login_url' );

/**
 * Change alt text on logo to show your site name
 *
 * @since Car Dealer 1.0
 */
function cardealer_login_title() {
	return get_option( 'blogname' );
}
add_filter( 'login_headertitle', 'cardealer_login_title' );