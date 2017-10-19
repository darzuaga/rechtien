<?php
add_action( 'after_setup_theme', 'cardealer_welcome_screen_do_activation_redirect', 11 );
function cardealer_welcome_screen_do_activation_redirect() {
	global $pagenow;
	
	// Bail if no activation redirect
    if ( get_transient( '_cardealer_welcome_screen_activation_redirect' ) === false || get_transient( '_cardealer_welcome_screen_activation_redirect' ) === '' ) {
		return;
	}
	
	// Delete the redirect transient
	delete_transient( '_cardealer_welcome_screen_activation_redirect' );

	// Bail if activating from network, or bulk
	if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
		return;
	}
	
	if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {
		wp_redirect(admin_url("themes.php?page=cardealer-welcome"));
	}
}

add_action('admin_menu', 'cardealer_welcome_screen_pages');
function cardealer_welcome_screen_pages() {
	$themedata = wp_get_theme('cardealer');
	add_theme_page(
		sprintf( esc_html__( 'Welcome to %s', 'cardealer'), $themedata->Name),
		esc_html__('cardealer', 'cardealer'),
		'read',
		'cardealer-welcome',
		'cardealer_welcome_screen_content'
	);
}

function cardealer_welcome_screen_content() {
	$themedata = wp_get_theme('cardealer');
	?>
	<div class="wrap cardealer-welcome">
		<h1><?php echo sprintf( esc_html__( 'Welcome to %s', 'cardealer'), $themedata->Name);?></h1>
		<hr>
		<div class="cardealer-welcome-content">
			<?php include(CARDEALER_PATH . '/includes/welcome-content.php');?>
			<p><?php echo esc_html__( 'Please ensure all plugin are installed and activated. Click below to proceed.', 'cardealer' );?></p>
			<?php
			$url = '';
			if( !cardealer_tgmpa_setup_status() ){
				$url = admin_url( 'themes.php?page=theme-plugins' );
			}else{
				$url = admin_url( 'themes.php?page=cardealer' );
			}
			if( !empty($url) ){
				?>
				<div class="cardealer-welcome-content">
					<a href="<?php echo esc_url($url);?>" class="button button-primary"><?php echo esc_html__( 'Proceed', 'cardealer' );?></a>
				</div>
				<?php
			}
			?>
		</div>
		<div class="cardealer-welcome-badge <?php echo esc_attr( cardealer_welcome_logo() ? 'cardealer-welcome-badge-with-logo' : 'cardealer-welcome-badge-without-logo' );?>">
			<div class="wp-badge"><?php
				if( !cardealer_welcome_logo() ){
					echo esc_html($themedata->Name);
				}
			?></div>
			<div class="cardealer-welcome-badge-version">
				<?php echo sprintf( esc_html__('Version %s','cardealer'), $themedata->version );?>
			</div>
		</div>
	</div>
	<?php
}

add_action( 'admin_head', 'cardealer_welcome_screen_remove_menus' );
function cardealer_welcome_screen_remove_menus() {
	remove_submenu_page( 'themes.php', 'cardealer-welcome' );
}

function cardealer_welcome_screen_enqueue_scripts(){
	$welcome_logo = cardealer_welcome_logo();
	if( !$welcome_logo ){
		$welcome_logo = '';
	}
		$welcome_logo_css = "
.cardealer-welcome .cardealer-welcome-badge .wp-badge {
	background-image: url(\"$welcome_logo\");
}";
	wp_add_inline_style( 'cardealer-admin-style', $welcome_logo_css );
}
add_action( 'admin_enqueue_scripts', 'cardealer_welcome_screen_enqueue_scripts' );

function cardealer_welcome_logo(){
	$welcome_logo = CARDEALER_URL . '/images/admin/logo.png';
	$welcome_logo_path = CARDEALER_PATH . '/images/admin/logo.png';
	if( file_exists($welcome_logo_path) && getimagesize($welcome_logo) !== false ) {
		return $welcome_logo;
	}else{
		return false;
	}
}

function cardealer_welcome_init() {
	// Set transient for welcome loader.
	set_transient( '_cardealer_welcome_screen_activation_redirect', true, 30 );
}
add_action( 'after_setup_theme', 'cardealer_welcome_init' );