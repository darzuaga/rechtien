<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="potenzaglobalsolutions.com" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php do_action( 'cardealer_head_before' );?>
	<?php wp_head(); ?>    
</head>
<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">
<?php
	global $hide_header_banner;
	$hide_header_banner = get_post_meta(get_the_ID(),'hide_header_banner',true);
	if( !empty( $hide_header_banner ) && ( is_search() ) ){
		$hide_header_banner = false;
	}
	do_action( 'cardealer_page_before' );
?>	
	<!-- Main Body Wrapper Element -->
	<div id="page" class="hfeed site page-wrapper <?php echo ( $hide_header_banner && !is_front_page() )? 'header-hidden' : ''; ?>">
		
		<!-- preloader -->
		<?php cardealer_display_loader(); ?>
		
		<!-- header -->
		<?php get_template_part('template-parts/header/site_header'); ?>
		<div class="wrapper" id="main">