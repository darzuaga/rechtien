<?php
if ( class_exists( 'woocommerce' ) ) {
	ob_start();
	woocommerce_mini_cart();
	$mini_cart = ob_get_clean();
	if( cardealer_woocommerce_version_check( '2.5' ) ){
		$cart_url = wc_get_cart_url();
	} else {
		$cart_url = WC()->cart->get_cart_url();
	}
	?>
	<a class="cart-contents cart-mobile-content" href="<?php echo esc_url( $cart_url );?>">
		<span class="woo-cart-items"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span><span class="woo-cart-details count"><?php echo WC()->cart->get_cart_contents_count();?></span>
	</a>
	<?php
	if( !wp_is_mobile()){
		?>
		<div class="widget_shopping_cart_content hidden-xs"><?php echo $mini_cart;?></div>
		<?php
	}
}
?>