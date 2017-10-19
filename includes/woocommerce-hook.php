<?php
if ( !class_exists( 'WooCommerce' ) ) {
    return;
}
/*
* Minicart on header via Ajax
*/
if( cardealer_woocommerce_version_check( '2.7.0' ) ){
	add_filter('woocommerce_add_to_cart_fragments', 'cardealer_add_to_cart_fragment', 100);
} else {
	add_filter('add_to_cart_fragments', 'cardealer_add_to_cart_fragment', 100);
}
function cardealer_add_to_cart_fragment( $fragments ) {
	// Menu Cart
	ob_start();
	?>
	<div class="menu-item-woocommerce-cart-wrapper">
		<?php
		get_template_part('woocommerce/minicart-ajax' );
		?>
	</div>
	<?php
	$menu_cart = ob_get_clean();
	
	// Mobile Cart
	ob_start();
	?>
	<div class="mobile-cart-wrapper">
		<?php get_template_part('woocommerce/minicart-ajax' );?>
	</div>
	<?php
	$mobile_cart = ob_get_clean();	
	$fragments['.menu-item-woocommerce-cart-wrapper'] = $menu_cart;
	$fragments['.mobile-cart-wrapper'] = $mobile_cart;
	
	return $fragments;
}
/*
 * Remove default woocommerce_before_main_content
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 ); 

function cardealer_show_related_products(){
    global $car_dealer_options;    
    if(isset($car_dealer_options['show_related_products']) && $car_dealer_options['show_related_products']  == "no"){                
        remove_action('woocommerce_after_single_product_summary','woocommerce_output_related_products',20);         
    }    
}
add_action('init','cardealer_show_related_products');

// function to check woocommerce version
function cardealer_woocommerce_version_check( $version = '2.7.0' ) {
	if ( class_exists( 'WooCommerce' ) ) {
		global $woocommerce;
		if( version_compare( $woocommerce->version, $version, ">=" ) ) {
			return true;
		}
	}
	return false;
}
?>