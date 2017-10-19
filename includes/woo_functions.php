<?php
if ( !class_exists( 'WooCommerce' ) ) {    
    return;
}

add_filter('loop_shop_columns', 'cardealer_loop_columns');
if (!function_exists('cardealer_loop_columns')) {	
    function cardealer_loop_columns() {
        global $car_dealer_options;        
		$pro_col_sel = 4;
        if(isset($car_dealer_options['wc_product_list_column']) && !empty($car_dealer_options['wc_product_list_column'])){
            $pro_col_sel = $car_dealer_options['wc_product_list_column'];    
        }        
        return $pro_col_sel; // 3 products per row
	}
}
function cardealer_loop_columns_class(){
    $column = cardealer_loop_columns();
    echo 'columns-'.$column;    
}

// Set products per page theme option for woocommerce
add_filter('loop_shop_per_page','cardealer_set_products_per_pages');
function cardealer_set_products_per_pages($products_per_page){
	global $car_dealer_options; 
	if(isset($car_dealer_options['products_per_pages']) && $car_dealer_options['products_per_pages']!=''){
		$products_per_page = $car_dealer_options['products_per_pages'];
	}
return $products_per_page;
}


function cardealer_get_column_related_products(){
    global $car_dealer_options;
    $column_related_products = 4;
    if(isset($car_dealer_options['column_related_products']) && !empty($car_dealer_options['column_related_products'])){
        $column_related_products = $car_dealer_options['column_related_products']; 
    }
    return $column_related_products;      
}

function cardealer_get_related_products_show(){
    global $car_dealer_options;
    $related_products_show = 4;
    if((isset($car_dealer_options['related_products_show']) && !empty($car_dealer_options['related_products_show']))){
        $related_products_show = $car_dealer_options['related_products_show'];    
    }
    return $related_products_show;
}
?>