<?php
include(realpath(CARDEALER_PATH.'/includes/menus').'/primary-nav-walker.php');
include(realpath(CARDEALER_PATH.'/includes/menus/max-mega-menu/').'/maxmegamenu.php');
function cardealer_primary_menu(){
	if ( has_nav_menu( 'primary-menu' ) ) :
		
		// Fetch menu details and check whether mega menu data is found or not.
		$menu_args = array(
			'theme_location'=> 'primary-menu',
			'menu_id'       => 'primary-menu',
			'menu_class'    => 'menu-links',
			'container'     => 'ul',
			'walker'        => new CarDealer_Walker_Primary_Nav_Menu()
		);		
		wp_nav_menu( $menu_args );
	endif;
}

// Add "Cart" to nav menus
add_filter( 'wp_nav_menu_items',  'cardealer_add_cart_to_wp_menu'  , 10, 2 );
function cardealer_add_cart_to_wp_menu($items, $args){
	global $car_dealer_options;
	
	// WooCommerce specific: check if woocommerce cart object is actually loaded	
	if( 'primary-menu' !== $args->theme_location || ( isset($car_dealer_options['cart_icon']) && $car_dealer_options['cart_icon']=="no" ) ) {
		return $items;
	}
	
	// Top Navigation Area Only
	if ( ( isset( $ajax ) && $ajax ) || ( property_exists( $args, 'theme_location' ) && $args->theme_location === 'primary-menu' ) ) {
	
		// WooCommerce
		if ( class_exists( 'woocommerce' ) ) {
			$css_class = 'menu-item menu-item-type-cart menu-item-type-woocommerce-cart';
			
			// Is this the cart page?
			if ( is_cart() ) {
				$css_class .= ' current-menu-item';
			}
			
			$items .= '<li class="' . esc_attr( $css_class ) . '">';
				$items .= '<div class="menu-item-woocommerce-cart-wrapper">';
				
					ob_start();
					get_template_part('woocommerce/minicart-ajax' );
					$items .= ob_get_clean();
				
				$items .= '</div>';
			$items .= '</li>';
		}		
	}
	return $items;
}

// Add "Search Form" to nav menus
function cardealer_add_compare_to_wp_menu ( $items, $args ) {
	global $car_dealer_options;
	
	if( 'primary-menu' !== $args-> theme_location || wp_is_mobile() ) {
		return $items;
	}
	
	$compareClass = "";
	if(!isset($_COOKIE['cars']) || empty(json_decode($_COOKIE['cars']))) { 
		$compareClass = esc_attr(' style=display:none');
	}
	
	$compare_items = '<li class="menu-item menu-item-compare"'. $compareClass .'>';
        $compare_items .= '<a class="" href="javascript:void(0)">';
            $compare_items .= '<span class="compare-items"><i class="fa fa-exchange"></i></span><span class="compare-details count">0</span>';
        $compare_items .= '</a>';
	$compare_items .= '</li>';	
	
    return $items . $compare_items;
}
add_filter( 'wp_nav_menu_items','cardealer_add_compare_to_wp_menu', 10, 2 );


// Add "Search Form" to nav menus
function cardealer_add_search_to_wp_menu ( $items, $args ) {
	global $car_dealer_options;
	
	if( 'primary-menu' !== $args -> theme_location ) {
		return $items;
	}
		
	if( isset($car_dealer_options['show_search']) && $car_dealer_options['show_search'] != 1 ){
		return $items;
	}
	
	if(!isset($car_dealer_options['search_placeholder_text']))
	{
		$car_dealer_options['search_placeholder_text'] = '';
	}

	$search_items = '<li class="menu-item menu-item-search">';
		$search_items .= '<form role="search" method="get" id="menu-searchform" name="searchform" class="searchform" action="'.esc_url( home_url( '/' ) ).'">';
			$search_items .= '<div class="search">';
				$search_items .= '<a class="search-btn not_click" href="javascript:void(0);"> </a>';
				$search_items .= '<div class="search-box not-click">';
				if(!empty($car_dealer_options['search_content_type']) &&  $car_dealer_options['search_content_type'] != 'all' )
					$search_items .= '<input type="hidden" name="post_type" value="'. esc_attr($car_dealer_options['search_content_type']) .'" />';
					$search_items .= '<input type="text" value="'.esc_attr(get_search_query()).'" name="s" id="menu-s"  placeholder="'. $car_dealer_options['search_placeholder_text'] .'" class="not-click"/>';
					$search_items .= '<i class="fa fa-search"></i>';
                    $search_items .= '<div class="cardealer-auto-compalte"><ul></ul></div>';
				$search_items .= '</div>';
			$search_items .= '</div>';
		$search_items .= '</form>';
	$search_items .= '</li>';	
	
    return $items . $search_items;
}
add_filter( 'wp_nav_menu_items','cardealer_add_search_to_wp_menu', 10, 2 );

// Add "Burger" to nav menus
function cardealer_add_burger_to_wp_menu ( $items, $args ) {
	global $car_dealer_options;
	
	if( 'primary-menu' !== $args -> theme_location ) {
		return $items;
	}
		
	if( !empty($car_dealer_options['header_type']) && $car_dealer_options['header_type'] != 'burger' && $car_dealer_options['header_type'] != 'burger-left' ){
		return $items;
	}

	$burger_items = '<li class="menu-item menu-item-burger-toggle">';
		$burger_items .= '<div id="menu-toggle">';
			$burger_items .= '<div id="menu-icon">';
				$burger_items .= '<span></span>';
				$burger_items .= '<span></span>';
				$burger_items .= '<span></span>';
				$burger_items .= '<span></span>';
				$burger_items .= '<span></span>';
				$burger_items .= '<span></span>';
			$burger_items .= '</div>';
		$burger_items .= '</div>';
	$burger_items .= '</li>';
	
	if( !empty($car_dealer_options['header_type']) && $car_dealer_options['header_type'] == 'burger-left' ){
		return $burger_items . $items;
	}else{
		return $items . $burger_items;
	}
}
add_filter( 'wp_nav_menu_items','cardealer_add_burger_to_wp_menu', 10, 2 );

/**
 * Add first and last menu classes
 *
 * This now works with nested uls.
 *
 * @since Car Dealer 1.0
 */
function cardealer_first_last_menu_classes( $objects, $args ) {

	// Add first/last classes to nested menu items.
	$ids        = array();
	$parent_ids = array();
	$top_ids    = array();

	if ( ! empty( $objects ) ) {

		foreach ( $objects as $i => $object ) {
			// If there is no menu item parent, store the ID and skip over the object.
			if ( 0 == $object->menu_item_parent ) {
				$top_ids[ $i ] = $object;
				continue;
			}

			// Add first item class to nested menus.
			if ( ! in_array( $object->menu_item_parent, $ids ) ) {
				$objects[ $i ]->classes[] = 'first-item';
				$ids[] = $object->menu_item_parent;
			}

			// If we have just added the first menu item class, skip over adding the ID.
			if ( in_array( 'first-item', $object->classes ) ) {
				continue;
			}

			// Store the menu parent IDs in an array.
			$parent_ids[ $i ] = $object->menu_item_parent;
		}

		// Remove any duplicate values and pull out the last menu item.
		$sanitized_parent_ids = array_unique( array_reverse( $parent_ids, true ) );

		// Loop through the IDs and add the last menu item class to the appropriate objects.
		foreach ( $sanitized_parent_ids as $i => $id ) {
			$objects[ $i ]->classes[] = 'last-item';
		}

		// Finish it off by adding classes to the top level menu items.
		$objects[1]->classes[] = 'first-item'; // We can be assured 1 will be the first item in the menu. :-)
		$keys = array_keys( $top_ids );
		$objects[end( $keys )]->classes[] = 'last-item';

		// Return the menu objects.
		return $objects;
	}
}
add_filter( 'wp_nav_menu_objects', 'cardealer_first_last_menu_classes', 10, 2 );