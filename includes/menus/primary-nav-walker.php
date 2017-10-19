<?php
/**
 * Custom walker to build main navigation menu
 *
 * Adds classes for enhanced styles and support for mobile off-canvas menu.
 *
 * @since Car Dealer 1.0
 */
class CarDealer_Walker_Primary_Nav_Menu extends Walker_Nav_Menu {
	// add classes to ul sub-menus
	function start_lvl( &$output, $depth = 0, $args = Array() ) {
		
		// depth dependent classes
		$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent
		$display_depth = ( $depth + 1 ); // because it counts the first submenu as 0
		$classes[] = 'sub-menu';
		$classes[] = 'drop-down-multilevel';
		$classes[] = 'effect-fade';
		$classes[] = ( $display_depth % 2 ? 'menu-odd' : 'menu-even' );
		$classes[] = 'menu-depth-' . $display_depth;
		if( !empty($args->left) ){
			$classes[] = 'left-side';
		}
		$class_names = implode( ' ', $classes );

		// build html
		$output .= "\n" . $indent . '<ul class="' . esc_attr($class_names) . '">' . "\n";
	}

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		global $wp_query;
		
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$class_names = $value = '';

		// set li classes
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		if ( !isset($args->has_children )){
			$classes[] = 'menu-item-no-children';
		}else{
			$classes[] = 'hoverTrigger';
		}

		// combine the class array into a string
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';

		// set li id
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

		// set outer li and its attributes
		$output .= $indent . '<li' . $id . $value . $class_names .'>';

		// set link attributes
		$attributes  = '';
		$attributes .= ! empty( $item->target )    ? ' target="' . esc_attr( $item->target ) . '"'  : '';
		$attributes .= ! empty( $item->xfn )       ? ' rel="' . esc_attr( $item->xfn ) . '"'        : '';
		$attributes .= ! empty( $item->url )       ? ' href="' . esc_url( $item->url ) . '"'       : '';

		// Add menu button links to items with children
		if ( isset($args->has_children) ) {
			$menu_pull_link = '';
		} else {
			$menu_pull_link = '';
		}

		$item_output = @$args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= @$args->link_before . apply_filters( 'the_title', @$item->title, @$item->ID ) . @$args->link_after;
		
		if ( isset($args->has_children ) && $args->has_children!='') {
			if( $depth == 0 ){
				$item_output .= '<i class="fa fa-angle-down fa-indicator"></i>';
			}else{
				if( in_array('left-side', $classes) ){
					$item_output .= '<i class="fa fa-angle-left fa-indicator"></i>';
					$args->left = true;
				}else{
					$item_output .= '<i class="fa fa-angle-right fa-indicator"></i>';
					$args->left = false;
				}
			}
		}
		$item_output .= '</a>';
		$item_output .= @$menu_pull_link.@$args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}

	function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {

		//Set custom arg to tell if item has children
		$id_field = $this->db_fields['id'];
		if ( is_object( $args[0] ) ) {
			$args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
		}

		return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}
}