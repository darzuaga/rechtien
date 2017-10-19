<?php
/**
* Display cars features list in cars details page
*/
function cardealer_get_cars_attributes($id=null){
    $attributs  = '<ul>';
    $taxonomys = array('car_year','car_make','car_model','car_body_style','car_condition','car_mileage','car_transmission','car_drivetrain','car_engine','car_fuel_type','car_fuel_economy','car_trim','car_exterior_color','car_interior_color','car_stock_number','car_vin_number');
    if($id!=null){
        foreach($taxonomys as $tax){
            $term = wp_get_post_terms( $id, $tax);
            if(!empty($term)){
                $taxonomy_name = get_taxonomy( $term[0]->taxonomy );
                $label = $taxonomy_name->labels->menu_name;
                $attributs .= '<li> <span>'.esc_html($label).'</span> <strong class="text-right">'.esc_html($term[0]->name).'</strong></li>';
            }
        }
    }
    $attributs .= '</ul>';
    echo $attributs;
}


/**
* Display vehicle review stamps
*/
function cardealer_get_vehicle_review_stamps($id=null){
    if($id!=null){
        $args = array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'all');
        $terms = wp_get_post_terms( $id, 'car_vehicle_review_stamps',$args);
        $url = '';$image_url = '';$link = '';$html='';
        foreach($terms as $term){
            if(!empty($term->term_id)){
                $image = get_term_meta($term->term_id,'image');
                $image_url = wp_get_attachment_url( $image[0] );
                $url_arr = get_term_meta($term->term_id,'url');

                if(isset($url_arr[0]) && !empty($url_arr[0])){
                    $url = $url_arr[0];
                    $vin = wp_get_post_terms( $id, 'car_vin_number',$args);
                    if(isset($vin[0]->name) && !empty($vin[0]->name)){
                        $return = str_replace( '{{vin}}', $vin[0]->name, $url );
                        $url = $return;
                    }
                }
                if(!empty($image_url)){
                    if($url != ''){
                        $link .= '<a href="'.esc_url($url).'" target="_blank"><img src="'.esc_url($image_url).'"/></a>';
                    } else {
                        $link .= '<img src="'.esc_url($image_url).'"/>';
                    }
                }
            }
        }
        if($link != ''){
            $html = '<div class="car-vehicle-review-stamps">';
            $html .= $link;
            $html .= '</div>';
        }
        echo $html;
    }
}

/**
* Display cars few features list in card catalog view on hover overlay
*/
function cardealer_get_cars_list_attribute(){
    global $post;
    $year = get_the_terms($post->ID,'car_year');
    $transmission = get_the_terms($post->ID,'car_transmission');
    $mileage = get_the_terms($post->ID,'car_mileage');
    if(empty($car_year)&&empty($transmission)&&empty($mileage)){
        return;
    }
    $car_year='';$car_transmission='';$car_mileage='';
    if(isset($year[0]->name)){
        $car_year = $year[0]->name;
    }
    if(isset($transmission[0]->name)){
        $car_transmission = $transmission[0]->name;
    }
    if(isset($mileage[0]->name)){
        $car_mileage = $mileage[0]->name;
    }


    $cars_grid = isset($_COOKIE['cars_grid']) ? $_COOKIE['cars_grid'] : '';
    $cars_grid = isset($_REQUEST['cars_grid']) ? $_REQUEST['cars_grid'] : $cars_grid;
	
    $type = ''; $trn_cls = ' class="car-transmission-dots" ';
    if($cars_grid != '' && $cars_grid != 'yes'){
		$trn_cls = ' ';
    }

    $attributs  = '<div class="car-list"><ul class="list-inline">';
    $attributs .= '<li><i class="fa fa-calendar"></i> '.esc_html($car_year).'</li>';
    $attributs .= '<li'.$trn_cls.'title="'.esc_html($car_transmission).'"><i class="fa fa-cog"></i> '.esc_html($car_transmission).'</li>';
    $attributs .= '<li><i class="glyph-icon flaticon-gas-station"></i> '.esc_html($car_mileage).'</li>';
    $attributs .= '</ul></div>';
    echo $attributs;
}

/**
* Check filter with ajax or get method
*/
function cardealer_cars_filter_methods(){
    global $car_dealer_options;
	$cars_filter_with = "";
	if(isset($car_dealer_options['cars-filter-with']))
	{
		$cars_filter_with = $car_dealer_options['cars-filter-with'];
	}
    return $cars_filter_with;
}

/**
* Get currenc currency symbol
*/
function cardealer_get_cars_currency_symbol(){
    global $car_dealer_options;
    $currency_symbol = '';
    if(function_exists('cdhl_get_currency_symbols')){
        $currency_code = isset($car_dealer_options['cars-currency-symbol']) ? $car_dealer_options['cars-currency-symbol'] : '';
        $currency_symbol = cdhl_get_currency_symbols($currency_code);
    } else {
        $currency_code = isset($car_dealer_options['cars-currency-symbol']) ? $car_dealer_options['cars-currency-symbol'] : '';
        $currency_symbol = $currency_code;
    }
    return $currency_symbol;
}

/**
* Get currenc currency placement
*/
function cardealer_get_cars_currency_placement(){
    global $car_dealer_options;
	
    $currency_placement = isset($car_dealer_options['cars-currency-symbol-placement']) ? $car_dealer_options['cars-currency-symbol-placement'] : '';
    $placement = "right";
    if($currency_placement == 1){
        $placement = 'left';
    }
    return $placement;
}

/**
* CAR Price formating
*/
function cardealer_car_price_html($class='', $id= null, $tax_label=true){
    global $car_dealer_options, $post;
    $currency_code = (isset($car_dealer_options['cars-currency-symbol']) && !empty($car_dealer_options['cars-currency-symbol']))? $car_dealer_options['cars-currency-symbol'] : '';
	if( function_exists( 'cdhl_get_currency_symbols' ) ){
		$currency_symbol = cdhl_get_currency_symbols($currency_code);
	}else{
		$currency_symbol = '$';
	}

    $symbol_position = (isset($car_dealer_options['cars-currency-symbol-placement']) && !empty($car_dealer_options['cars-currency-symbol-placement']))? $car_dealer_options['cars-currency-symbol-placement'] : '';
    $seperator = (isset($car_dealer_options['cars-disable-currency-separators']) && !empty($car_dealer_options['cars-disable-currency-separators']))? $car_dealer_options['cars-disable-currency-separators'] : '';
    $seperator_symbol = (isset($car_dealer_options['cars-thousand-separator']) && !empty($car_dealer_options['cars-thousand-separator']))? $car_dealer_options['cars-thousand-separator'] : '';
	$decimal_places = (!empty($car_dealer_options['cars-number-decimals']) && is_numeric($car_dealer_options['cars-number-decimals']))? $car_dealer_options['cars-number-decimals'] : 0;
	
    $price_html = '<div class="price car-price '.esc_attr($class).'">';
	$regular_price=0;$sale_price=0;
	$carId = (isset($id) && $id != null)? $id : $post->ID;
	$regular_price = function_exists('get_field')?get_field('regular_price',$carId):get_post_meta($carId,'regular_price', $single= true);
	$sale_price =function_exists('get_field')?get_field('sale_price',$carId):get_post_meta($carId,'sale_price', $single= true);
	
	if( !empty($regular_price) && ( $regular_price > 0 ) )
	{
		$regular_price = (isset($seperator) && $seperator == 1)? number_format($regular_price, $decimal_places, '.', $seperator_symbol) : get_post_meta($carId,'regular_price', $single= true);		
		if($sale_price > 0)
			$price_html .= ($symbol_position == 1)?'<span class="old-price"> '.esc_html($currency_symbol.$regular_price).'</span>':'<span class="old-price"> '.esc_html($regular_price.$currency_symbol).'</span>';
		else
			$price_html .= ($symbol_position == 1)?'<span class="new-price"> '.esc_html($currency_symbol.$regular_price).'</span>':'<span class="new-price"> '.esc_html($regular_price.$currency_symbol).'</span>';
	}
	if($sale_price > 0)
	{
		$sale_price = (isset($seperator) && $seperator == 1)? number_format($sale_price, $decimal_places, '.', $seperator_symbol) : get_post_meta($carId,'sale_price', $single= true);		
	    $price_html .=($symbol_position == 1)?'<span class="new-price"> '.esc_html($currency_symbol.$sale_price).'</span>':'<span class="new-price"> '.esc_html($sale_price.$currency_symbol).'</span>';
    }
	if(is_single()){
		$price_html .= cardealer_get_cars_status($carId);
	}

    if(is_single() && $tax_label == true){
		$price_html .= '<p>'.get_post_meta(get_the_ID(), 'tax_label', $single = true).'<p>';
	}

    $price_html .= '</div>';
    echo $price_html;
}

/**
* CAR Price formating with retur value
*/
function cardealer_get_car_price($class='', $id= null){
    global $car_dealer_options,$post;
    $currency_code = isset($car_dealer_options['cars-currency-symbol']) ? $car_dealer_options['cars-currency-symbol'] : '';
    $currency_symbol = cdhl_get_currency_symbols($currency_code);
    $price_html = '<div class="price car-price '.$class.'">';
        $regular_price=0;$sale_price=0;
		$carId = (isset($id) && $id != null)? $id : $post->ID;
        $regular_price = get_post_meta($carId, 'regular_price', $single = true);
        $regular_price = (int)$regular_price;

        $sale_price = get_post_meta($carId, 'sale_price', $single = true);
		$sale_price = (int)$sale_price;
        if($regular_price > 0 && $sale_price > 0){
            $price_html .= '<span class="old-price"> '.esc_html($currency_symbol.$regular_price).'</span>';
            $price_html .= '<span class="new-price"> '.esc_html($currency_symbol.$sale_price).'</span>';
        } elseif($regular_price == 0 || empty($regular_price) && $sale_price > 0) {
            $price_html .= '<span class="new-price"> '.esc_html($currency_symbol.$sale_price).'</span>';
        } elseif($sale_price == 0 || empty($sale_price) &&  $regular_price > 0) {
            $price_html .= '<span class="new-price"> '.esc_html($currency_symbol.$regular_price).'</span>';
        } else {
            $price_html .= '<span class="new-price"> '.esc_html($currency_symbol).'0.00</span>';
        }
    $price_html .= '</div>';
    return $price_html;
}

/**
* CAR Price array
*/
function cardealer_get_car_price_array($id= null){
    global $car_dealer_options,$post;
    $currency_code = $car_dealer_options['cars-currency-symbol'];
    $currency_symbol = cdhl_get_currency_symbols($currency_code);
    $price_arr = array();
    $regular_price=0;$sale_price=0;
	$carId = (isset($id) && $id != null)? $id : $post->ID;
    $regular_price = get_post_meta($carId, 'regular_price', $single = true);
    $regular_price = (int)$regular_price;
    $sale_price = get_post_meta($carId, 'sale_price', $single = true);
	$sale_price = (int)$sale_price;
    if($regular_price > 0 && $sale_price > 0){
        $price_arr = array(
            'currency_symbol' => $currency_symbol,
            'regular_price' => $regular_price,
            'sale_price' => $sale_price,
        );
    } elseif($regular_price == 0 || empty($regular_price) && $sale_price > 0) {
        $price_arr = array(
            'currency_symbol' => $currency_symbol,
            'regular_price' => 0,
            'sale_price' => $sale_price,
        );
    } elseif($sale_price == 0 || empty($sale_price) &&  $regular_price > 0) {
        $price_arr = array(
            'currency_symbol' => $currency_symbol,
            'regular_price' => $regular_price,
            'sale_price' => 0,
        );
    } else {
        $price_arr = array(
            'currency_symbol' => $currency_symbol,
            'regular_price' => 0,
            'sale_price' => 0,
        );
    }
    return $price_arr;
}

/**
* Set template on search cars in cars catalog page
*/
function cardealer_template_chooser($template){
  global $wp_query;
  if( $wp_query->is_search && is_post_type_archive( 'cars' ) )
  {
    return locate_template('archive-cars.php');  //  redirect to archive-search.php
  }
  return $template;
}
add_filter('template_include', 'cardealer_template_chooser');

/**
* Default cars placeholder image
*/
function cardealer_get_carplaceholder($size=""){
    $url = CDHL_URL;
    $url .= 'images/carplaceholder.jpg';
    if($size != '' ){
        if($size === "car_thumbnail"){
            $meta = 'width="190" height="138"';
        }elseif($size === "car_catalog_image"){

            if(is_post_type_archive( 'cars' ) && !wp_is_mobile()){
                $col = cardealer_get_grid_column();
                $getlayout = cardealer_get_cars_list_layout_style();
                if(isset($getlayout) && !empty($getlayout)){
                    if($getlayout == "view-grid-full"){
                        $col = 3;
                	}
                    if($getlayout == "view-list-left"){
                		$col = 3;		
                	} elseif( $getlayout == "view-list-right" ) {
                		$col = 3;
                	} elseif($getlayout == "view-list-full"){
                		$col = 3;		
                	}    	
                }

                if($col == 4){
                    $meta = 'width="187" height="134"';
                } else {
                    $meta = 'width="265" height="190"';
                }
            } else {
                $meta = 'width="265" height="190"';
            }


        }elseif($size === "car_list_thumbnail"){
            $meta = 'width="110" height="79"';
        }elseif($size === "large" || $size === "car_single_image"){
            $meta = 'class="img-responsive"';
        }elseif($size === "car_tabs_image"){
            $meta = 'class="img-responsive"';
        }elseif($size === "cardealer-50x50"){
            $meta = 'width="50" height="50"';
        }
        else{
            $meta = 'width="265" height="190"';
        }
    }
    return '<img src="'.esc_url($url).'" '.$meta.' alt="carplaceholder"/>';
}


/**
* Get cars status
*/
function cardealer_get_cars_status($carId = null){
    $html = '';$car_status = '';
	if(function_exists('get_field'))
	{
		$car_status = get_field('car_status',$carId);
		if(isset($car_status)&&!empty($car_status)){
			if($car_status == 'sold'){
				$html = '<span class="label car-status '.$car_status.'">'.esc_html__('SOLD','cardealer').'</span>';
			}
		}	
	}
    return $html;
}
/**
* Get cars condition
*/
function cardealer_get_cars_condition($id = null){
    $html = '';
    $args = array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'all');
    $terms = wp_get_post_terms( $id, 'car_condition' ,$args);
    if(isset($terms)&&!empty($terms)){
        if(preg_match('(new|New)', $terms[0]->name) === 1) {
            $class = 'new';
        }elseif(preg_match('(used|Used)', $terms[0]->name) === 1) {
            $class = 'used';
        }else {
            $class = 'certified';
        }
        $html = '<span class="label car-condition '.esc_attr($class).'">'.esc_html($terms[0]->name).'</span>';
    }
    return $html;
}

/**
* Get cars images
*/
function cardealer_get_cars_image($car_size='car_catalog_image' ,$id = null){
    if(empty($car_size)){
        $car_size='car_catalog_image';
    }
    global $post;
	$carId = ( isset($id) && $id != null)? $id : $post->ID;
	$img = cardealer_get_carplaceholder($car_size);
	if(function_exists('get_field'))
	{
		$images = get_field('car_images', $carId);		
		if( isset($images) && !empty($images) ){			
            $img = '<img class="img-responsive" src="'.esc_url($images[0]['sizes'][$car_size]).'" alt="'.esc_attr($images[0]['alt']).'" width="'.esc_attr($images[0]['sizes'][$car_size.'-width']).'" height="'.esc_attr($images[0]['sizes'][$car_size.'-height']).'"/>';
		}
	}
    return $img;
}

function cardealer_get_single_image_url($car_size='car_catalog_image' ,$id = null){
	global $post;	
	$url = CDHL_URL;
    $url .= 'images/carplaceholder.jpg';
	
	if(function_exists('get_field'))
	{
		$car_images = get_field('car_images', $post->ID);
		if(!empty($car_images)){
			$url = $car_images[0]['url'];
		}
	}
	return $url;
}

function cardealer_get_images_url($car_size='car_catalog_image' ,$id = null){
	global $post;	
	$url = NULL;
    if(function_exists('get_field'))
	{
		$car_images = get_field('car_images', $post->ID);
		$url = array();
		if(!empty($car_images)){
			foreach($car_images as $car_image)
			{
				$url[] = $car_image['url'];
			}
		}
	}
	return $url;
}

/*
 *
 */
 if ( ! function_exists( 'cardealer_get_price_filters' ) ) :
function cardealer_get_price_filters () {
	$pgs_min_price = isset( $_GET['min_price'] ) ? esc_attr( $_GET['min_price'] ) : '';
	$pgs_max_price = isset( $_GET['max_price'] ) ? esc_attr( $_GET['max_price'] ) : '';

	// Find min and max price in current result set
	$prices = cardealer_get_car_filtered_price();
	$min    = floor( $prices->min_price );
	$max    = ceil( $prices->max_price );

	if ( $min === $max ) {
		return;
	}

    $html='';
    $html .= '<div class="price_slider_wrapper">';                		
        $html .= '<div class="price-slide">';
            $html .= '<div class="price">';
                $html .= '<input type="hidden" id="pgs_min_price" name="min_price" value="' . esc_attr( $pgs_min_price ) . '" data-min="' . esc_attr( $min ) . '" />';
                $html .= '<input type="hidden" id="pgs_max_price" name="max_price" value="' . esc_attr( $pgs_max_price ) . '" data-max="' . esc_attr( $max ) . '" />';

                $html .= '<label for="dealer-slider-amount">'.esc_html__('Price Range','cardealer').'</label>';
                $html .= '<input type="text" id="dealer-slider-amount" readonly="" class="amount" value="" />';
                $html .= '<div id="slider-range"></div>';
            $html .= '</div>';
        $html .= '</div>';
	$html .= '</div>';
    echo $html;
 }
 endif;

 /*
 *
 */
if ( ! function_exists( 'cardealer_get_year_range_filters' ) ) :
function cardealer_get_year_range_filters ($cfb='') {
	
    $pgs_year_range_min = isset( $_GET['min_year'] ) ? esc_attr( $_GET['min_year'] ) : '';
	$pgs_year_range_max = isset( $_GET['max_year'] ) ? esc_attr( $_GET['max_year'] ) : '';


	// Find min and max price in current result set
	$year_range = (function_exists('cardealer_get_year_range')) ? cardealer_get_year_range() : '';
	$yearmin    = floor( $year_range['min_year'] );
    $yearmax    = ceil( $year_range['max_year'] );

	if ( $yearmin === $yearmax ) {
		return;
	}
    $html='';
    $html .= '<div class="year_range_slider_wrapper">';                		
        $html .= '<div class="year-range-slide">';
            $html .= '<div class="year_range">';
                $html .= '<input type="hidden" id="pgs_year_range_min" name="min_year" value="' . esc_attr( $pgs_year_range_min ) . '" data-yearmin="' . esc_attr( $yearmin ) . '" />';
                $html .= '<input type="hidden" id="pgs_year_range_max" name="max_year" value="' . esc_attr( $pgs_year_range_max ) . '" data-yearmax="' . esc_attr( $yearmax ) . '" />';

                $html .= '<label for="dealer-slider-year-range">'.esc_html__('Year Range','cardealer').'</label>';
                $html .= '<input type="text" id="dealer-slider-year-range" readonly="" class="amount" value="" />';
                $html .= '<div id="slider-year-range" data-cfb="'.$cfb.'"></div>';
            $html .= '</div>';
        $html .= '</div>';
	$html .= '</div>';
    return $html;
 }
 endif;

/**
 * Check year rang slider is active for listing page
 */
if ( ! function_exists( 'cardealer_is_year_range_active' ) ) :
function cardealer_is_year_range_active(){
    $year_rang_slider =true;
    global $car_dealer_options;
    $cars_year_rang = (isset($car_dealer_options['cars-year-range-slider']))?$car_dealer_options['cars-year-range-slider']:'no';
    if($cars_year_rang == 'no'){
        $year_rang_slider = false;
    }
    return $year_rang_slider;
}
endif;


/**
 * Get filtered min price for current list.
 * @return int
 */
function cardealer_get_car_filtered_price() {
	global $wpdb;

    // Current site prefix
    $tbprefix = $wpdb->prefix;
    $sql   = "SELECT ";
    $sql  .= " min( FLOOR( price_meta.meta_value ) ) as min_price,";
    $sql  .= " max( CEILING( price_meta.meta_value ) ) as max_price";
    $sql  .= " FROM ".$tbprefix."posts";
    $sql  .= " LEFT JOIN ".$tbprefix."postmeta as price_meta ON ".$tbprefix."posts.ID = price_meta.post_id";
    $sql  .= " INNER JOIN ".$tbprefix."postmeta ON (".$tbprefix."posts.ID = ".$tbprefix."postmeta.post_id )"; 	
    $sql  .= " WHERE ".$tbprefix."posts.post_type IN ('cars')";
    $sql  .= " AND ".$tbprefix."posts.post_status = 'publish'";
    $sql  .= " AND price_meta.meta_key IN ('sale_price','regular_price')";
	return $wpdb->get_row( $sql );

}


/**
 * Get filtered year range.
 * @return int
 */
function cardealer_get_year_range() {
	global $wpdb;

	
    $terms = get_terms(array(
        'taxonomy' => 'car_year',
        'hide_empty' => false,
    ));

    $taxonomy_name = get_taxonomy( 'car_year');
	$data = array();
	if( !empty($taxonomy_name) ){
		$slug= $taxonomy_name->rewrite['slug'];
		$label = $taxonomy_name->labels->menu_name;
		
		if(!empty($terms)){
			$year_arr = array();
			foreach($terms as $tdata){
				$year_arr[] = $tdata->slug;
			}
			$first = reset($year_arr);
			$last = end($year_arr);
			$data = array(
				'min_year' => $first,
				'max_year' => $last,
			);
		}
	}
    return $data;
}

/**
* Add layout style in cookie
*/
function cardealer_get_cars_list_layout_style(){
    global $car_dealer_options;
    $getlayout = "";
    $getlayout = (isset($car_dealer_options['cars-lay-style']) && !empty($car_dealer_options['cars-lay-style']))?$car_dealer_options['cars-lay-style']:'view-grid-left';
    if(isset($_REQUEST['lay_style']) && !empty($_REQUEST['lay_style'])){
        $getlayout = $_REQUEST['lay_style'];
    } elseif(isset($_COOKIE['lay_style']) && !empty($_COOKIE['lay_style'])){
        $getlayout = $_COOKIE['lay_style'];
    }
    return $getlayout;
}

function cardealer_get_cars_catlog_style(){
    $getlayout = cardealer_get_cars_list_layout_style();
    if(isset($getlayout) && $getlayout  == "view-grid-left"){
		return 'yes';
	} elseif(isset($getlayout) && $getlayout == "view-grid-full"){
		return 'yes';
	} elseif(isset($getlayout) && $getlayout== "view-grid-right"){
		return 'yes';
    } elseif(isset($getlayout) && $getlayout == "view-list-left"){
		return 'no';
    } elseif(isset($getlayout) && $getlayout == "view-list-full"){
		return 'no';
    } elseif(isset($getlayout) && $getlayout == "view-list-right"){
		return 'no';	
	}
}

/**
*
*/
function cardealer_cars_content_class(){
    $left_class = 3;
    $right_class = 3;
    global $car_dealer_options;
    $getlayout = cardealer_get_cars_list_layout_style();
    if(isset($getlayout) && !empty($getlayout)){
        if($getlayout == "view-grid-left"){
    		$content_class = 12 - $right_class;		
    	} elseif( $getlayout == "view-grid-right" ) {
    		$content_class = 12 - $right_class;
    	} elseif($getlayout == "view-grid-full"){
    		$content_class = 12;		
    	} elseif( $getlayout == "view-list-left" ) {
    		$content_class = 12 - $left_class;
    	} elseif( $getlayout == "view-list-right" ) {
    		$content_class = 12 - $left_class;
    	} elseif($getlayout == "view-list-full"){
    		$content_class = 12;		
    	} else {
    		$content_class = 12;
    	}
    	$classes = array('content' );
    	$classes[] = 'col-lg-'.$content_class.' col-md-'.$content_class .' col-sm-'.$content_class;
        echo 'class="' . join( ' ', $classes ) . '"';
    	
    } 

}


/**
*
*/
function cardealer_get_grid_column(){
    global $car_dealer_options;
    $col = 3;$classes = array();$getlayout = "";
    if(isset($car_dealer_options['cars-col-sel']) && !empty($car_dealer_options['cars-col-sel'])){
        $col = $car_dealer_options['cars-col-sel'];
    }

    $getlayout = cardealer_get_cars_list_layout_style();
    if(isset($getlayout) && !empty($getlayout)){
        if($getlayout == "view-grid-full"){
            $col = 4;
    	}
        if($getlayout == "view-list-left"){
    		$col = 4;		
    	} elseif( $getlayout == "view-list-right" ) {
    		$col = 4;
    	} elseif($getlayout == "view-list-full"){
    		$col = 4;		
    	}    	
    }
    return $col;
}

/**
*
*/
function cardealer_grid_view_class(){
    global $car_dealer_options,$cars_loop;
    $classes = array();
    $columns = cardealer_get_grid_column();
    if($columns == 3)$col = 4;
    if($columns == 4)$col = 3;
    $getlayout = cardealer_get_cars_list_layout_style();
    if(isset($getlayout) && !empty($getlayout)){
        if($getlayout == "view-grid-left"){
    		$classes[] = 'col-lg-'.$col.' col-md-'.$col.' col-sm-'.$col.' col-xs-6';		
    	} elseif( $getlayout == "view-grid-right" ) {
    		$classes[] = 'col-lg-'.$col.' col-md-'.$col.' col-sm-'.$col.' col-xs-6';
    	} elseif($getlayout == "view-grid-full"){
    		$classes[] = 'col-lg-3 col-md-3 col-sm-3 col-xs-6';		
    	}    	
        echo 'class="' . join( ' ', $classes ) . '"';
    	
    } 
}


function cardealer_cars_loop(){
    global $cars_loop;
    $cars_loop['loop']    = ! empty( $cars_loop['loop'] ) ? $cars_loop['loop'] + 1   : 1;
    $col = cardealer_get_grid_column();
    $cars_loop['columns'] = max( 1, ! empty( $cars_loop['columns'] ) ? $cars_loop['columns'] : $col );
    if ( 0 === ( $cars_loop['loop'] - 1 ) % $cars_loop['columns'] || 1 === $cars_loop['columns'] ) {
		return 'first';
	} elseif ( 0 === $cars_loop['loop'] % $cars_loop['columns'] ) {
		return 'last';
	} else {
		return '';
	}
}

/**
*
*/
function cardealer_list_view_class_1(){
    $classes = array();
    global $car_dealer_options;
    $getlayout = cardealer_get_cars_list_layout_style();

    if(isset($getlayout) && !empty($getlayout)){
        if($getlayout == "view-list-left"){
    		$classes[] = 'col-lg-4 col-md-4 col-sm-4';		
    	} elseif( $getlayout == "view-list-right" ) {
    		$classes[] = 'col-lg-4 col-md-4 col-sm-4';
    	} elseif($getlayout == "view-list-full"){
    		$classes[] = 'col-lg-3 col-md-4 col-sm-6';		
    	}    	
        echo 'class="' . join( ' ', $classes ) . '"';
    	
    } 
}

/**
*
*/
function cardealer_list_view_class_2(){
    global $car_dealer_options;
    $classes = array();

    $getlayout = cardealer_get_cars_list_layout_style();
    if(isset($getlayout) && !empty($getlayout)){
        if($getlayout == "view-list-left"){
    		$classes[] = 'col-lg-8 col-md-8 col-sm-8';			
    	} elseif( $getlayout == "view-list-right" ) {
    		$classes[] = 'col-lg-8 col-md-8 col-sm-8';	
    	} elseif($getlayout == "view-list-full"){
    		$classes[] = 'col-lg-9 col-md-8 col-sm-6';	
    	}    	
        echo 'class="' . join( ' ', $classes ) . '"';
    	
    } 
}

/**
*
*/
function cardealer_get_cars_details_page_sidebar_position(){
    global $car_dealer_options;
    $details_page_sidebar = "left";
    if(isset($car_dealer_options['cars-details-page-sidebar']) && !empty($car_dealer_options['cars-details-page-sidebar'])){
        $details_page_sidebar = $car_dealer_options['cars-details-page-sidebar'];
    }
    return $details_page_sidebar;
}

/**
*
*/
function cardealer_cars_sidebar_class($custom_class="sidebar"){
    global $car_dealer_options;
    $left_class = 9;
    $right_class = 9;

    $getlayout = cardealer_get_cars_list_layout_style();
    if(isset($getlayout) && !empty($getlayout)){
        if($getlayout == "view-grid-left"){
    		$content_class = 12 - $right_class;		
    	} elseif( $getlayout == "view-grid-right" ) {
    		$content_class = 12 - $right_class;
    	} elseif($getlayout == "view-grid-full"){
    		$content_class = 12;		
    	} elseif( $getlayout == "view-list-left" ) {
    		$content_class = 12 - $left_class;
    	} elseif( $getlayout == "view-list-right" ) {
    		$content_class = 12 - $left_class;
    	} elseif($getlayout == "view-list-full"){
    		$content_class = 12;		
    	} else {
    		$content_class = 9;
    	}
    	$classes = array( $custom_class );
    	$classes[] = 'col-lg-'.$content_class.' col-md-'.$content_class .' col-sm-'.$content_class;
    	echo 'class="' . join( ' ', $classes ) . '"';
    } 
}


/**
*
*/
function cardealer_get_car_catlog_sidebar_left(){

    global $car_dealer_options;
    $getlayout = cardealer_get_cars_list_layout_style();

    if(isset($getlayout) && !empty($getlayout)){
        if($getlayout == "view-grid-left"){
    		if(is_active_sidebar('listing-cars') ){
                ?>
                <aside id="sleft" <?php cardealer_cars_sidebar_class();?>>
                	<div class="listing-sidebar">
                        <?php dynamic_sidebar('listing-cars'); ?>
                    </div>
                </aside>
                <?php
            }		
    	}  elseif($getlayout == "view-grid-full"){
    	   return;			
    	} elseif( $getlayout == "view-list-left" ) {
    		if(is_active_sidebar('listing-cars') ){
                ?>
                <aside id="sleft" <?php cardealer_cars_sidebar_class();?>>
                	<div class="listing-sidebar">
                        <?php dynamic_sidebar('listing-cars'); ?>
                    </div>
                </aside>
                <?php
            }
    	} elseif($getlayout == "view-list-full"){
    		return;		
    	}
    }
}

/**
*
*/
function cardealer_get_car_catlog_sidebar_right(){
    global $car_dealer_options;
    $getlayout = cardealer_get_cars_list_layout_style();
    if(isset($getlayout) && !empty($getlayout)){
        if($getlayout == "view-list-right"){
    		if(is_active_sidebar('listing-cars')){
                ?>
                <aside id="sleft" <?php cardealer_cars_sidebar_class();?>>
                	<div class="listing-sidebar">
                        <?php dynamic_sidebar('listing-cars'); ?>
                    </div>
                </aside>
                <?php
            }		
    	}  elseif($getlayout == "view-grid-full"){
    	   return;			
    	} elseif( $getlayout == "view-grid-right" ) {
    		if(is_active_sidebar('listing-cars')){
                ?>
                <aside id="sleft" <?php cardealer_cars_sidebar_class();?>>
                	<div class="listing-sidebar">
                        <?php dynamic_sidebar('listing-cars'); ?>
                    </div>
                </aside>
                <?php
            }
    	} elseif($getlayout == "view-list-full"){
    		return;		
    	}
    }
}

/**
*
*/
function cardealer_get_catlog_view(){
    $cars_grid = isset($_COOKIE['cars_grid']) ? $_COOKIE['cars_grid'] : 1;
	$grid_sel = ( $cars_grid == 1 ) ? 'sel-active' : '';
	$list_sel = ( $cars_grid == 0 ) ? 'sel-active' : '';
    global $car_dealer_options;
    $theme_color = isset($car_dealer_options['site_color_scheme_custom']['color'])?$car_dealer_options['site_color_scheme_custom']['color'] : '';

    $getlayout = cardealer_get_cars_list_layout_style();
    $class1 = (isset($getlayout) && $getlayout  == "view-grid-left") ? "style='background-color:$theme_color'" : '';
    $class2 = (isset($getlayout) && $getlayout == "view-grid-full") ?  "style='background-color:$theme_color'" : '';
    $class3 = (isset($getlayout) && $getlayout== "view-grid-right")?  "style='background-color:$theme_color'" : '';
    $class4 = (isset($getlayout) && $getlayout == "view-list-left") ?  "style='background-color:$theme_color'" : '';
    $class5 = (isset($getlayout) && $getlayout == "view-list-full") ?  "style='background-color:$theme_color'" : '';
    $class6 = (isset($getlayout) && $getlayout == "view-list-right")?  "style='background-color:$theme_color'" : '';

    $html = '';
    $html .= '<div class="grid-view change-view-button">';
        $html .= '<div class="view-icon">';

            $html .= '<a class="catlog-layout view-grid" data-id="view-grid-left" href="javascript:void(0)"><span '.$class1.'><i class="view-grid-left"></i></span></a>';
            $html .= '<a class="catlog-layout view-grid" data-id="view-grid-full" href="javascript:void(0)"><span '.$class2.'><i class="view-grid-full"></i></span></a>';
            $html .= '<a class="catlog-layout view-grid" data-id="view-grid-right" href="javascript:void(0)"><span '.$class3.'><i class="view-grid-right"></i></span></a>';
            $html .= '<a class="catlog-layout view-list" data-id="view-list-left" href="javascript:void(0)"><span '.$class4.'><i class="view-list-left"></i></span></a>';
            $html .= '<a class="catlog-layout view-list" data-id="view-list-full" href="javascript:void(0)"><span '.$class5.'><i class="view-list-full"></i></span></a>';
            $html .= '<a class="catlog-layout view-list" data-id="view-list-right" href="javascript:void(0)"><span '.$class6.'><i class="view-list-right"></i></span></a>';
			
        $html .= '</div>';
    $html .= '</div><!--.grid-view-->';
    echo $html;
}


/**
*
*/
if ( ! function_exists( 'cardealer_cars_catalog_ordering' ) ) :
function cardealer_cars_catalog_ordering () {
    global $wp,$car_dealer_options;
	parse_str($_SERVER['QUERY_STRING'], $params);
	$query_string = '?'.$_SERVER['QUERY_STRING'];

	// replace it with theme option
	if(isset($car_dealer_options['cars-per-page'])) {
		$per_page = $car_dealer_options['cars-per-page'];
	} else {
		$per_page = 12;
	}

    $pob = !empty($params['cars_orderby']) ? $params['cars_orderby'] : '';
    $po = !empty($params['cars_order'])  ? $params['cars_order'] : 'desc';	
	$pc = !empty($params['cars_pp']) ? $params['cars_pp'] : $per_page;
    $html = '';
        $html .= '<div class="selected-box">';
                $html .= '<select name="cars_pp" id="pgs_cars_pp">';
                    $html .= '<option value="'.esc_attr($per_page).'" '.(( $pc == $per_page) ? 'selected': '' ).'>'.esc_attr($per_page).'</option>';
                    $html .= '<option value="'.( esc_attr($per_page*2) ).'" '.(( $pc == $per_page*2) ? 'selected': '' ).'>'.( esc_attr($per_page*2) ).'</option>';
                    $html .= '<option value="'.( esc_attr($per_page*3) ).'" '.(( $pc == $per_page*3) ? 'selected': '' ).'>'.( esc_attr($per_page*3) ).'</option>';
                    $html .= '<option value="'.( esc_attr($per_page*4) ).'" '.(( $pc == $per_page*4) ? 'selected': '' ).'>'.( esc_attr($per_page*4) ).'</option>';
                    $html .= '<option value="'.( esc_attr($per_page*5) ).'" '.(( $pc == $per_page*5) ? 'selected': '' ).'>'.( esc_attr($per_page*5) ).'</option>';
                $html .= '</select>';
        $html .= '</div>';
        $html .= '<div class="selected-box">';
            $html .= '<div class="select">';
                $html .= '<select class="select-box" name="cars_orderby" id="pgs_cars_orderby">';
                    $html .= '<option value="">'.esc_html__('Sort by ', 'cardealer').esc_html__('Default', 'cardealer').' </option>';
                    $html .= '<option value="'.esc_attr('name').'" '.(( $pob == 'name') ? 'selected': '' ).'>'.esc_html__('Sort by ', 'cardealer').esc_html__('Name', 'cardealer').' </option>';
                    $html .= '<option value="'.esc_attr('sale_price').'" '.(( $pob == 'sale_price') ? 'selected': '' ).'>'.esc_html__('Sort by ', 'cardealer').esc_html__('Price', 'cardealer').' </option>';
                    $html .= '<option value="'.esc_attr('date').'" '.(( $pob == 'date') ? 'selected': '' ).'>'.esc_html__('Sort by ', 'cardealer').esc_html__('Date', 'cardealer').' </option>';
                $html .= '</select>';
            $html .= '</div>';
        $html .= '</div>';
        if($po == 'asc'):
            $html .= '<div class="cars-order text-right"><a id="pgs_cars_order" data-order="desc" data-current_order="asc" href="javascript:void(0)"><i class="fa fa-arrow-up"></i></a></div>';
        endif;
    	if($po == 'desc'):
    	   $html .= '<div class="cars-order text-right"><a id="pgs_cars_order" data-order="asc" data-current_order="desc" href="javascript:void(0)"><i class="fa fa-arrow-down"></i></a></div>';
    	endif;

        $getlayout = "";
        $getlayout = cardealer_get_cars_list_layout_style();
        if(isset($getlayout) && $getlayout== "view-list-full" || isset($getlayout) && $getlayout == "view-grid-full" ){
            $html .= '<div class="pgs_cars_search_box"><button class="pgs_cars_search_btn not_click"><i class="fa fa-search"></i></button>';
            $html .= '<div class="pgs_cars_search search" style="display:none;">';
                $html .= '<input type="search" id="pgs_cars_search" class="form-control search-form placeholder" value="'.esc_attr(get_search_query()).'" name="s" placeholder="'.esc_attr__( 'Search...', 'cardealer' ).'" />';
                $html .= '<button class="search-button" id="pgs_cars_search_btn" value="Search" type="submit"><i class="fa fa-search"></i></button>';
                $html .= '<div class="auto-compalte-list"><ul></ul></div>';
            $html .= '</div></div>';
        }
	echo $html;
}
endif;

function cardealer_get_taxonomys_array(){
    return $taxonomys = array('car_year','car_make','car_model','car_body_style','car_mileage','car_fuel_type','car_fuel_economy','car_trim','car_transmission','car_condition','car_drivetrain','car_engine','car_exterior_color','car_interior_color','car_stock_number','car_vin_number','car_features_options');
}

function cardealer_get_all_taxonomy_with_terms(){
    $attributs=array();
    $taxonomys = cardealer_get_taxonomys_array();
    foreach($taxonomys as $tax){
        $terms = get_terms(array(
            'taxonomy' => $tax,
            'hide_empty' => false,
        ));

        $taxonomy_name = get_taxonomy( $tax);
        $slug= $taxonomy_name->rewrite['slug'];
        $label = $taxonomy_name->labels->menu_name;
        if(!empty($terms)){
            foreach($terms as $tdata){
                $attributs[$slug]['terms'][] = $tdata->slug;
                $attributs[$slug]['label'] = $label;
                $attributs[$slug]['slug'] = $slug;
            }
        }else {
            $attributs[$slug]['label'] = $label;
            $attributs[$slug]['slug'] = $slug;
        }
    }
    return $attributs;
}

/**
 * Pass arguments on cars listing page
 */
function cardealer_cars_get_catalog_ordering_args($wp_query) {
    
    global $wp_query,$car_dealer_options;
	
	if ( !is_admin() && $wp_query->is_main_query() && is_post_type_archive('cars') ) {
		
		parse_str($_SERVER['QUERY_STRING'], $params);
        
        $pgs_min_price = isset( $params['min_price'] ) ? esc_attr( $params['min_price'] ) : 0;
		$pgs_max_price = isset( $params['max_price'] ) ? esc_attr( $params['max_price'] ) : 0;
		if($pgs_min_price > 0  || $pgs_max_price > 0 ){
			$prices = cardealer_get_car_filtered_price();
			$min    = floor( $prices->min_price );
			$max    = ceil( $prices->max_price );
			
			if($min != $pgs_min_price || $max != $pgs_max_price){
			   $args['meta_query'][] = array(
										'key'     => 'final_price',
										'value'   => array( $pgs_min_price, $pgs_max_price ),
										'compare' => 'BETWEEN',
										'type'    => 'NUMERIC',
									);
			}
		}
		/* Don't want to show sold car on car listing page */
		if( isset($car_dealer_options['car_no_sold']) && $car_dealer_options['car_no_sold'] == 0 ){
			$args['meta_query'][] =
				array(
					'key'     => 'car_status',
					'value'   => 'sold',
					'compare' => '!='
				);			
			
		}
		/* Set meta query*/
		if( !empty($args['meta_query']) ){
			$wp_query->set('meta_query', $args['meta_query']);
		}
		
		/* Check Year range option enable from backend */
		if( isset($car_dealer_options['cars-year-range-slider']) && $car_dealer_options['cars-year-range-slider'] == 'yes' ){
			$year_range = cardealer_get_year_range();			
			$yearmin    = $year_range['min_year'];
			$yearmax    = $year_range['max_year'];
			$pgs_min_year = isset( $params['min_year'] ) ? esc_attr( $params['min_year'] ) : 0;
			$pgs_max_year = isset( $params['max_year'] ) ? esc_attr( $params['max_year'] ) : 0;
			$year_rang_qur = array();
			if( !empty($year_range) && ( $pgs_min_year > 0  || $pgs_max_year > 0 ) ){
				if($yearmin != $pgs_min_year || $yearmax != $pgs_max_year){
				   $terms = get_terms(array(
						'taxonomy' => 'car_year',
						'hide_empty' => false,
					));										
					$quryear = array();					
					if(!empty($terms)){
						foreach($terms as $tdata){
							if(($tdata->slug >= $pgs_min_year) && ($tdata->slug <= $pgs_max_year)){
								$quryear[] = $tdata->slug;
							}									
						}
					}
					$year_rang_qur = array('relation' => 'AND');
					$year_rang_qur['tax_query'][] = array(
						'taxonomy' => 'car_year',
						'field'    => 'slug',
						'terms'    => $quryear,
					);
					$wp_query->set('tax_query', $year_rang_qur);
					
				}										
			}
		}
        
        if( isset($params['car_mileage']) && !empty($params['car_mileage']) ){
            
            $mileage_terms = array();
            $get_car_mileage = $params['car_mileage'];
            $terms = get_terms(array(
                'taxonomy' => 'car_mileage',
                'hide_empty' => false,
            ));
            foreach($terms as $tdata){
                $mileage = $tdata->slug;                
                if(is_numeric($mileage) && is_numeric($get_car_mileage)){
                    if($mileage < $get_car_mileage){
                        $mileage_terms[] = $tdata->slug;
                    }
                }
            }                        
            if(!empty($mileage_terms)){
                $car_mileage_args = array(                    
                    array(            
                        'taxonomy'  => 'car_mileage',
                        'field'     => 'slug',
                        'terms'     => $mileage_terms,                    
                    )
                );                
                unset($wp_query->query_vars['car_mileage']);                
                $wp_query->set('tax_query', $car_mileage_args);
            }            
        }        		
        $wp_query->set('post_type', array('cars'));

		
		$pob = !empty($params['cars_orderby']) ? $params['cars_orderby'] : '';
		$order = !empty($params['cars_order'])  ? $params['cars_order'] : 'desc';		
		switch($pob) {
			case 'name':			
				$orderby = 'title';			
			break;
			case 'sale_price':
				$orderby = 'meta_value_num';
				$wp_query->set('meta_key', 'final_price');
				$wp_query->set('type', 'NUMERIC');            			
			break;
			case 'date':
				$orderby = 'date (post_date)';			
			break;				
			default:
				$orderby = 'date (post_date)';			
			break;
		}
		$wp_query->set('orderby', $orderby);
        $wp_query->set('order', $order);
		
		
		/* set number of car on car listing page */
		if(isset($car_dealer_options['cars-per-page']) && !empty($car_dealer_options['cars-per-page'])) {
			$per_page = $car_dealer_options['cars-per-page'];
		}
		if(isset($params['cars_pp']) && !empty($params['cars_pp'])){
		   $per_page = $params['cars_pp'];
		}
        $wp_query->set( 'posts_per_page', $per_page );		
        //return $wp_query;
    }
}
add_action( 'pre_get_posts', 'cardealer_cars_get_catalog_ordering_args' );


function cardealer_set_tex_query_array($taxonomys,$post){
    $mileage_terms = array();
	$arg = array();
    foreach($taxonomys as $tax){
        if(isset($post[$tax]) &&  $post[$tax] != ''){    	
	       foreach($post as $key => $val){
	           if($key == $tax){
                    if($key == 'car_mileage'){
                        $terms = get_terms(array(
                            'taxonomy' => 'car_mileage',
                            'hide_empty' => false,
                        ));
                        foreach($terms as $tdata){
                            $mileage = $tdata->slug;
                            $post_mileage = $post[$tax];
                            if(is_numeric($mileage) && is_numeric($post_mileage)){
                                if($mileage < $post[$tax]){
                                    $mileage_terms[] = $tdata->slug;
                                }
                            }
                        }

                        $arg[] = array(
                			'taxonomy' => $tax,
                			'field'    => 'slug',
                			'terms'    => $mileage_terms,
                		);
                    } else {
                        $arg[] = array(
                			'taxonomy' => $tax,
                			'field'    => 'slug',
                			'terms'    => array($post[$tax]),
                		);
                    }
	           }

	       }    	
        }
    }
    $year_rang_slider = cardealer_is_year_range_active();
    if($year_rang_slider){

        $year_range = cardealer_get_year_range();
    	$yearmin    = $year_range['min_year'];
    	$yearmax    = $year_range['max_year'];
        $pgs_min_year = isset( $post['min_year'] ) ? esc_attr( $post['min_year'] ) : 0;
    	$pgs_max_year = isset( $post['max_year'] ) ? esc_attr( $post['max_year'] ) : 0;
        $year_rang_qur = array();
        if($pgs_min_year >0  || $pgs_max_year > 0 ){

            if($yearmin != $pgs_min_year || $yearmax != $pgs_max_year){

               $terms = get_terms(array(
                    'taxonomy' => 'car_year',
                    'hide_empty' => false,
                ));
                $quryear = array();
                $taxonomy_name = get_taxonomy( 'car_year');
                $slug= $taxonomy_name->rewrite['slug'];
                $label = $taxonomy_name->labels->menu_name;
                if(!empty($terms)){
                    foreach($terms as $tdata){
                        if(($tdata->slug >= $pgs_min_year) && ($tdata->slug <= $pgs_max_year)){
                            $quryear[] = $tdata->slug;
                        }

                    }
                }
                $arg['tax_query'][] = array(
        			'taxonomy' => 'car_year',
        			'field'    => 'slug',
        			'terms'    => $quryear,
                    'operator' => 'IN',
        		);

            }
        }
    }
    return $arg;
}

/**
*
*/
function cardealer_get_all_filters(){
    $taxonomys = cardealer_get_filters_taxonomy();
    $get_arg=array();
    $get_url_terms = array();
    foreach($taxonomys as $tax){
        if(isset($_GET[$tax]) &&  $_GET[$tax] != ''){
            if(isset($_GET['car_mileage']) && !empty($_GET['car_mileage'])){
                $get_arg[] = array(
        			'taxonomy' => $tax,
        			'field'    => 'slug',
        			'terms'    => array($_GET[$tax]),
                    'compare' => '<',
                    'type'    => 'NUMERIC',
        		);
            } else {
                $get_arg[] = array(
        			'taxonomy' => $tax,
        			'field'    => 'slug',
        			'terms'    => array($_GET[$tax]),
        		);
            }

        }

    }

    $year_range = cardealer_get_year_range();
	$yearmin    = $year_range['min_year'];
	$yearmax    = $year_range['max_year'];
    $pgs_min_year = isset( $_GET['min_year'] ) ? esc_attr( $_GET['min_year'] ) : 0;
	$pgs_max_year = isset( $_GET['max_year'] ) ? esc_attr( $_GET['max_year'] ) : 0;
    $year_rang_qur = array();
    if($pgs_min_year >0  || $pgs_max_year > 0 ){

        if($yearmin != $pgs_min_year || $yearmax != $pgs_max_year){

           $terms = get_terms(array(
                'taxonomy' => 'car_year',
                'hide_empty' => false,
            ));
            $quryear = array();
            $taxonomy_name = get_taxonomy( 'car_year');
            $slug= $taxonomy_name->rewrite['slug'];
            $label = $taxonomy_name->labels->menu_name;
            if(!empty($terms)){
                foreach($terms as $tdata){
                    if(($tdata->slug >= $pgs_min_year) && ($tdata->slug <= $pgs_max_year)){
                        $quryear[] = $tdata->slug;
                    }

                }
            }
            $get_arg['tax_query'][] = array(
    			'taxonomy' => 'car_year',
    			'field'    => 'slug',
    			'terms'    => $quryear,
                'operator' => 'IN',
    		);

        }
    }


    $attributs = cardealer_new_get_all_filters($get_arg);
    echo $attributs;
}

/**
*
*/
function cardealer_new_get_all_filters($get_arg){
    $taxonomys = cardealer_get_filters_taxonomy();
    $args = cardealer_make_filter_wp_query($_GET);
    $result_filter = array();

    $filter_query_args = array_replace($args, array('posts_per_page' => -1));
    $filter_query = new WP_Query( $filter_query_args );
    $tot_result = $filter_query->post_count;
	if($filter_query->have_posts()){
        while ( $filter_query->have_posts() ) : $filter_query->the_post();
            if(isset($get_arg) && !empty($get_arg) && $tot_result > 0){
                foreach($taxonomys as $tax){

                    $args = array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'all');
                    $terms = wp_get_post_terms( get_the_ID(), $tax ,$args);

                    foreach($terms as $tdata){
                        if($tdata->taxonomy == $tax){
                            $result_filter[$tax][] = array(
                                'term_id' => $tdata->term_id,
                                'slug' => $tdata->slug,
                                'name' => $tdata->name,
                                'taxonomy' => $tdata->taxonomy,
                            );
                        }
                    }
                }
            }
        endwhile;
        wp_reset_postdata();
    }
    $attributs = '<div class="cars-total-vehicles">';
        $attributs .= '<span class="stripe"><strong><span class="number_of_listings">'.esc_html($tot_result).'</span> ';
        $attributs .= '<span class="listings_grammar">'.esc_html__('Vehicles Matching','cardealer').'</span></strong></span>';

        $attributs .= '<ul class="stripe-item filter margin-bottom-none" data-all-listings="All Listings">';
        foreach($_GET as $gkey => $gval){
            if(in_array($gkey,$taxonomys)){
                $taxonomy_name = get_taxonomy( $gkey);
                $label = $taxonomy_name->labels->menu_name;
                $attributs .= '<li id="stripe-item-'.esc_attr($gkey).'" data-type="'.esc_attr($gkey).'" style="display: inline-block;"><a href="javascript:void(0)"><i class="fa fa-times-circle"></i> '.esc_html($label).' :  <span data-key="'.esc_attr($gval).'">'.esc_html($gval).'</span></a></li>';
            }
        }
        $attributs .= '</ul>';
    $attributs .= '</div>';
    $attributs .= '<div class="listing_sort">';

    $attributs  .= '<div class="sort-filters">';
    $t=1;

    $is_year_range_active = cardealer_is_year_range_active();
    if($is_year_range_active){
        $year_range_filters = cardealer_get_year_range_filters('');
        $attributs  .= $year_range_filters;
        $key = array_search ('car_year', $taxonomys);
        unset($taxonomys[$key]);
    }


    foreach($taxonomys as $tax){

        $taxonomy_name = get_taxonomy( $tax);
        $label = $taxonomy_name->labels->menu_name;
        $attributs  .= '<select data-tax="'.esc_attr($label).'" data-id="'.esc_attr($tax).'" id="sort_'.esc_attr($tax).'" name="'.esc_attr($tax).'" class="select-sort-filters">';
        $attributs .= '<option value="">'.esc_html($label).'</option>';
        if(isset($get_arg) && !empty($get_arg)){
            $newarr = array();
			

            if(!empty($result_filter[$tax])){
				foreach($result_filter[$tax] as $term_data){
						$selected="";
						if($tax != 'car_mileage'){
							if(isset($_GET[$tax]) &&  $_GET[$tax] != ''){
								if($_GET[$tax] === $term_data['slug']){
									$selected = "selected='selected'";
								}
							}
							
							if(!in_array($term_data['slug'],$newarr)){
								$attributs .= '<option value="'.$term_data['slug'].'" '.$selected.'>'.$term_data['name'].'</option>';
								$newarr[]=$term_data['slug'];
							}
						}else {
							$mileage_array = array('10000','20000','30000','40000','50000','60000','70000','80000','90000','100000');
							if($tax == 'car_mileage' && $t==1){
								foreach($mileage_array as $mileage){
									$selected='';
									if(isset($_GET['car_mileage']) && $_GET['car_mileage'] == $mileage){
										$selected = "selected=''";
									}									
                                    $attributs .= '<option value="'.esc_attr($mileage).'" '.esc_attr($selected).'>&lt; '.esc_html($mileage).'</option>';
								}
								$t++;
							}
						}
				}
			}
        } else {
            $terms = get_terms(array(
                'taxonomy' => $tax,
                'hide_empty' => false,
            ));

            foreach($terms as $tdata){
                if($tax != 'car_mileage'){
                    $selected="";
                    if(isset($_GET[$tax]) &&  $_GET[$tax] != ''){
                        if($_GET[$tax] == $tdata->slug){
                            $selected = "selected=''";
                        }
                    }
                    $attributs .= '<option value="'.esc_attr($tdata->slug).'" '.esc_attr($selected).'>'.esc_html($tdata->name).'</option>';
                } else {
                    $mileage_array = array('10000','20000','30000','40000','50000','60000','70000','80000','90000','100000');
                    if($tax == 'car_mileage' && $t==1){
                        foreach($mileage_array as $mileage){
                            $selected='';
                            if(isset($_GET['car_mileage']) && $_GET['car_mileage'] == $mileage){
                                $selected = "selected=''";
                            }
                            $attributs .= '<option value="'.esc_attr($mileage).'" '.esc_attr($selected).'>&lt; '.esc_html($mileage).'</option>';
                        }
                        $t++;
                    }
                }
            }
        }
        $attributs  .= '</select>';
    }
    $attributs.='<div class=""><a class="button" href="javascript:void(0);" id="reset_filters">'.esc_html__('Reset','cardealer').'</a></div>';
    $attributs  .= '</div>';
    $attributs.='<span class="filter-loader"></span></div>';
    return $attributs;
}

function cardealer_get_filters_taxonomy(){
    return $taxonomys = array('car_year','car_make','car_model','car_body_style','car_condition','car_mileage','car_transmission','car_drivetrain','car_engine','car_fuel_economy','car_exterior_color');
}

function cardealer_make_filter_wp_query($request_method){

    $tax_query_arry = array();
    $taxonomys = cardealer_get_filters_taxonomy();
    if(isset($request_method['selected_attr']) && !empty($request_method['selected_attr'])){
        $taxonomys = explode(',', $request_method['selected_attr']);;
    }

    $tax_query_arry = cardealer_set_tex_query_array($taxonomys,$request_method);
    $data_html='';$pagination_html='';$cars_orderby="date (post_date)";$data_order="asc";

    global $car_dealer_options;
    parse_str($_SERVER['QUERY_STRING'], $params);
    $per_page = 12;$cars_order = "date (post_date)";
    if(isset($car_dealer_options['cars-per-page'])) {
		$per_page = $car_dealer_options['cars-per-page'];
	}
    if(isset($request_method['cars_pp']) && !empty($request_method['cars_pp'])){
	   $per_page = $request_method['cars_pp'];
	}

    if(isset($request_method['cars_order']) && !empty($request_method['cars_order'])){
	   $data_order = $request_method['cars_order'];
	}
    $paged = isset( $request_method['paged'] ) ? (int) $request_method['paged'] : 1;
    $args=array(
        'post_type' => 'cars',
		'post_status' => 'publish',
		'posts_per_page' => $per_page,
        'order' => $data_order,
        'paged' => $paged,
	);

	
	if(isset($request_method['cars_orderby']) && !empty($request_method['cars_orderby'])){
	   $cars_orderby = $request_method['cars_orderby'];
	}
    if(isset($cars_orderby) && !empty($cars_orderby)){
        if($cars_orderby == "sale_price"){
            $args['orderby']  = 'meta_value_num';
            $args['meta_key'] = 'final_price';            
        } else {
            $args['orderby'] = $cars_orderby;
        }

    }
    if(isset($request_method['s']) && !empty($request_method['s'])){
        $args['s'] = $request_method['s'];
    }

    if(isset($tax_query_arry) && !empty($tax_query_arry)){

        $args['tax_query'] = array('relation' => 'AND');
    	
        foreach( $tax_query_arry as $k => $val){
           $args['tax_query'][$k] = $val;
        }
    }

	/* Set Price meta query  */
    $pgs_min_price = isset( $request_method['min_price'] ) ? esc_attr( $request_method['min_price'] ) : 0;
	$pgs_max_price = isset( $request_method['max_price'] ) ? esc_attr( $request_method['max_price'] ) : 0;
    if($pgs_min_price >0  || $pgs_max_price > 0 ){
		$prices = cardealer_get_car_filtered_price();
		$min    = floor( $prices->min_price );
		$max    = ceil( $prices->max_price );
        if($min != $pgs_min_price || $max != $pgs_max_price){
           $args['meta_query'][] = array(
								'key'     => 'final_price',
								'value'   => array( $pgs_min_price, $pgs_max_price ),
								'compare' => 'BETWEEN',
								'type'    => 'NUMERIC',
							);        	
        }
    }
	
	/* Don't want to show sold car on car listing page */
	if( isset($car_dealer_options['car_no_sold']) && $car_dealer_options['car_no_sold'] == 0 ){
		$args['meta_query'][] =
			array(
				'key'     => 'car_status',
				'value'   => 'sold',
				'compare' => '!='
			);			
		
	}
    return $args;
}
function cardealer_cars_filter_query(){
    $attributs = cardealer_get_all_filters_with_ajax();
    echo json_encode($attributs);
    exit();
}
add_action('wp_ajax_cardealer_cars_filter_query','cardealer_cars_filter_query');
add_action('wp_ajax_nopriv_cardealer_cars_filter_query','cardealer_cars_filter_query');
function cardealer_get_all_filters_with_ajax(){
    $taxonomys = cardealer_get_filters_taxonomy();
	$result_filter = array();
	$pagination_html = $data_html = '';
    $data_order="asc";
    $args = cardealer_make_filter_wp_query($_POST);
    if(isset($_POST['cars_order']) && !empty($_POST['cars_order'])){
	   $data_order = $_POST['cars_order'];
	}
    $paged = isset( $_POST['paged'] ) ? (int) $_POST['paged'] : 1;    
    $query = new WP_Query( $args );
    /**
     * CFT used for custom filter box
     * */    
    if($query->have_posts()){
        while ( $query->have_posts() ) : $query->the_post();
            ob_start();
            get_template_part('template-parts/cars/content','cars');
            $datahtml = ob_get_clean();
            $data_html .= $datahtml;
        endwhile;
        wp_reset_postdata();
        $pagination_html = cardealer_cars_pagination_ajax($query,$paged);
    }else {
        $data_html = '<div class="col-sm-12"><div class="alert alert-warning">No result were found matching your selection.</div></<div>';
    }

    if(!isset($_POST['cfb'])){
        $attributs='<div class="listing_sort">';
    }
    if(isset($_POST['cfb']) && $_POST['cfb'] == 'yes'){
        $attributs="";
    }

    $filter_query_args = array_replace($args, array('posts_per_page' => -1));
    $tax_query_arry = cardealer_set_tex_query_array($taxonomys,$_POST);
    $filter_query = new WP_Query( $filter_query_args );
    $tot_result = $filter_query->post_count;
    if($filter_query->have_posts()){
        while ( $filter_query->have_posts() ) : $filter_query->the_post();
            foreach($taxonomys as $tax){
                if(isset($tax_query_arry) && !empty($tax_query_arry)){
                    $args = array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'all');
                    $terms = wp_get_post_terms( get_the_ID(), $tax ,$args);

                    foreach($terms as $tdata){

                        if($tdata->taxonomy == $tax){
                            $result_filter[$tax][] = array(
                                'post_id' => get_the_ID(),
                                'term_id' => $tdata->term_id,
                                'slug' => $tdata->slug,
                                'name' => $tdata->name,
                                'taxonomy' => $tdata->taxonomy,
                            );
                        }
                    }
                }

            }
        endwhile;
        wp_reset_postdata();
    }
    $cardealer_ganerate_filter_box = cardealer_ganerate_filter_box($taxonomys,$tax_query_arry,$result_filter);

    $html='';
    if($data_order == 'asc'):
        $html .= '<a id="pgs_cars_order" data-order="desc" data-current_order="asc" href="javascript:void(0)"><i class="fa fa-arrow-up"></i></a>';
    endif;
	if($data_order == 'desc'):
	   $html .= '<a id="pgs_cars_order" data-order="asc" data-current_order="desc" href="javascript:void(0)"><i class="fa fa-arrow-down"></i></a>';
	endif;
    if(!isset($_POST['cfb'])){
        $attributs.='<div class="submit-filters-btn"><a class="button" href="javascript:void(0);" id="submit_all_filters">'.esc_html__('Submit','cardealer').'</a></div>';
        $attributs.='<div class=""><a class="button" href="javascript:void(0);" id="reset_filters">'.esc_html__('Reset All Filters','cardealer').'</a></div>';
        $attributs.='<span class="filter-loader"></span></div>';
        $data = array(
            'status' => 'success',
            'all_filters' => $cardealer_ganerate_filter_box,
            'data_html' => $data_html,
            'pagination_html' => $pagination_html,
            'order_html' => $html,
            'tot_result' => $tot_result
        );
    } else {
        $data = array(
            'status' => 'success',
            'all_filters' => $cardealer_ganerate_filter_box,
        );
    }
    return $data;
}




function cardealer_ganerate_filter_box($taxonomys,$tax_query_arry=array(),$result_filter=array()){
    /**
     * IF Request from custom search box Widgets
     */
    $result_data = array();

    /**
     * CFB used for custom filter box
     * */
    if(isset($_POST['cfb']) && $_POST['cfb'] == 'yes'){
        $attributs = "";
        foreach($taxonomys as $tax){
            $taxonomy_name = get_taxonomy( $tax);
            $label = $taxonomy_name->labels->menu_name;
            // Check filter array set
            if(isset($tax_query_arry) && !empty($tax_query_arry)){
                $newarr = array();
                foreach($result_filter[$tax] as $term_data){
                        if($tax == 'car_mileage'){
                            $mileage_array = array('10000','20000','30000','40000','50000','60000','70000','80000','90000','100000');
                            if($tax == 'car_mileage' && $t==1){
                                foreach($mileage_array as $mileage){
                                    $result_data[$tax][] = array(
                                        $mileage => '&lt; '.$mileage,
                                    );
                                }
                                $t++;
                            }
                        }else{
                            $selected="";
                            if(isset($_POST[$tax]) &&  $_POST[$tax] != ''){
                                if($_POST[$tax] === $term_data['slug']){
                                    $selected = "selected='selected'";

                                }
                            }
                            if(!in_array($term_data['slug'],$newarr)){
                                $newarr[]=$term_data['slug'];
                                $result_data[$tax][] = array(
                                    $term_data['slug'] => $term_data['name'],
                                );
                            }
                        }
                }
            } else {
                // When not set any filter
                $terms = get_terms(array(
                    'taxonomy' => $tax,
                    'hide_empty' => false,
                ));
                foreach($terms as $tdata){
                    $selected="";
                    if(isset($_POST[$tax]) &&  $_POST[$tax] != ''){
                        if($_POST[$tax] == $tdata->slug){
                            $selected = "selected=''";
                        }
                    }

                    $result_data[$tax][] = array(
                        $tdata->slug => $tdata->name,
                    );
                }

            }
        }

    } else {

        /**
         * Without CFB
         * */
        $tot_count = count($taxonomys);
        $i=0;$t=1;
        foreach($taxonomys as $tax){
            $flg = 0;
            if(isset($tax_query_arry) && !empty($tax_query_arry)){
                $newarr = array();
				if( isset($result_filter[$tax]) ) {
					foreach($result_filter[$tax] as $term_data){
                        if($tax == 'car_mileage'){
                            $mileage_array = array('10000','20000','30000','40000','50000','60000','70000','80000','90000','100000');
                            if($tax == 'car_mileage' && $t==1){
                                foreach($mileage_array as $mileage){
                                    $result_data[$tax][] = array(
                                        $mileage => '&lt; '.$mileage,
                                    );
                                }
                                $t++;
                            }
                        }else{
                            $selected="";
                            if(isset($_POST[$tax]) &&  $_POST[$tax] != ''){
                                if($_POST[$tax] === $term_data['slug']){
                                    $selected = "selected='selected'";

                                }
                            }
                            if(!in_array($term_data['slug'],$newarr)){
                                $newarr[]=$term_data['slug'];
                                $result_data[$tax][] = array(
                                    $term_data['slug'] => $term_data['name'],
                                );
                            }
                        }
					}
				}
            } else {
                $terms = get_terms(array(
                    'taxonomy' => $tax,
                    'hide_empty' => false,
                ));
                foreach($terms as $tdata){
                    $selected="";
                    if(isset($_POST[$tax]) &&  $_POST[$tax] != ''){
                        if($_POST[$tax] == $tdata->slug){
                            $selected = "selected=''";
                        }
                    }

                    $result_data[$tax][] = array(
                        $tdata->slug => $tdata->name,
                    );
                }

            }
        }

    }
	if( isset( $_POST['current_attr'] ) && isset( $result_data[$_POST['current_attr']] ) ){
		unset($result_data[$_POST['current_attr']]);
	}
    return $result_data;
}

function cardealer_cars_pagination_ajax( $query ,$paged ) {	
	$big = 999999999; // need an unlikely integer
	$pages = paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, $paged ),
			'total' => $query->max_num_pages,
			'type'  => 'array',
			'prev_next'   => true,
			'prev_text'    => esc_html__('&larr; Prev', 'cardealer'),
			'next_text'    => esc_html__('Next &rarr;', 'cardealer')
		)
	);
    $pagination='';
    $html = '';
	if( is_array( $pages ) ) {
		$paged = ( $paged == 0 ) ? 1 : $paged;
		$pagination .= '<ul class="pagination">';
		foreach ( $pages as $page ) {
			$pagination .= "<li>$page</li>";
		}
		$pagination .= '</ul>';		
	}
    $html .= $pagination;
    return $html;
}


/**
* Menu search box auto complate search
*/
add_action('wp_ajax_pgs_auto_complate_search','cardealer_auto_complate_search');
add_action('wp_ajax_nopriv_pgs_auto_complate_search','cardealer_auto_complate_search');
function cardealer_auto_complate_search(){



    global $car_dealer_options;
    $posttype = 'cars';
    if($car_dealer_options['search_content_type'] == 'all'){
        $posttype = 'any';
    }else{
        $posttype = $car_dealer_options['search_content_type'];
    }
    $args=array(
        'post_type' => esc_attr($posttype),
		'post_status' => 'publish',
		'posts_per_page' => -1,
	);

    if(isset($_POST['search']) && !empty($_POST['search'])){
        $args['s'] = $_POST['search'];
    }

    $query = new WP_Query( $args );
    $data = array();
    if($query->have_posts()){
        while ( $query->have_posts() ) : $query->the_post();
            $pid = get_the_ID();
            $car_img = '';$class="no-image";
            $ptype = get_post_type($pid);
            if($ptype == 'cars'){
                $image = cardealer_get_cars_image('cardealer-50x50',$pid);
                $car_img = '<div class="search-result-image">'.$image.'</div>';
                $class="";
            }else{
                if(has_post_thumbnail($pid)){
                    $thmb = get_the_post_thumbnail($pid,'cardealer-50x50');
                    $car_img = '<div class="search-result-image">'.$thmb.'</div>';
                    $class="";
                }
            }
            $data[] = array(
                'status' => true,
                'image' => $car_img,
                'link_url' => get_the_permalink(),
                'title' => '<div class="search-result-name '.$class.'">'.get_the_title().'</div>',
                'msg' => '',
            );
        endwhile;
        wp_reset_postdata();
    } else {
        $data[] = array(
            'status' => false,
            'image' => '',
            'link_url' => '',
            'title' => '',
            'msg' => '<div class="search-result-name">'.esc_html__( 'No Results' ).'</div>'
        );
    }
    echo json_encode($data);
    exit();
}


/**
* List page search box auto complate search filters and sidebar area
*/
add_action('wp_ajax_pgs_cars_list_search_auto_compalte','cars_list_search_auto_compalte');
add_action('wp_ajax_nopriv_pgs_cars_list_search_auto_compalte','cars_list_search_auto_compalte');
function cars_list_search_auto_compalte(){
    if(isset($_POST['search']) && !empty($_POST['search'])){
        $data = array();
        $search = trim($_POST['search']);
        $_GET['s'] = $search;
        $args = cardealer_make_filter_wp_query($_GET);
        $filter_query_args = array_replace($args, array('posts_per_page' => -1));
        $filter_query = new WP_Query( $filter_query_args );
        $query = new WP_Query( $args );
        if($query->have_posts()){
            while ( $query->have_posts() ) : $query->the_post();
                $pid = get_the_ID();
                $car_img = '';$class="no-image";
                $ptype = get_post_type($pid);
                if($ptype == 'cars'){
                    $image = cardealer_get_cars_image('cardealer-50x50',$pid);
                    $car_img = '<div class="search-result-image">'.$image.'</div>';
                    $class="";
                }else{
                    if(has_post_thumbnail($pid)){
                        $thmb = get_the_post_thumbnail($pid,'cardealer-50x50');
                        $car_img = '<div class="search-result-image">'.$thmb.'</div>';
                        $class="";
                    }
                }

                $data[] = array(
                    'status' => true,
                    'image' => $car_img,
                    'link_url' => get_the_permalink(),
                    'title' => '<div class="search-result-name '.$class.'">'.get_the_title().'</div>',
                    'msg' => '',
                );
            endwhile;
            wp_reset_postdata();
        } else {
            $data[] = array(
                'status' => false,
                'image' => '',
                'link_url' => '',
                'title' => '',
                'msg' => '<div class="search-result-name">'.esc_html__( 'No Results' ).'</div>'
            );
        }
    } else {
        $data[] = array(
            'status' => false,
            'image' => '',
            'link_url' => '',
            'title' => '',
            'msg' => '<div class="search-result-name">'.esc_html__( 'No Results' ).'</div>'
        );
    }
    echo json_encode($data);

    exit();
}

function cardealer_validate_google_captch($captcha){
    $secret_key = cardealer_get_goole_api_keys('secret_key');
	if( empty( $secret_key ) )
		return array('success' => true);
    $response = wp_remote_get( "https://www.google.com/recaptcha/api/siteverify?secret=".$secret_key."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR'], array("timeout" => 30) );
	return json_decode( $response['body'], true );
}
function cardealer_get_goole_api_keys($key_type=''){
    global $car_dealer_options;
    if($key_type == "site_key"){
        $key = (isset($car_dealer_options['google_captcha_site_key']) && !empty($car_dealer_options['google_captcha_site_key']))?$car_dealer_options['google_captcha_site_key']:'';
    }
    if($key_type == "secret_key"){
        $key = (isset($car_dealer_options['google_captcha_secret_key']) && !empty($car_dealer_options['google_captcha_secret_key']))?$car_dealer_options['google_captcha_secret_key']:'';
    }
    return $key;
}

/**
*	Photo swipe popup for cars
*/
function cardealer_photoswipe(){
	?>
	<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="pswp__bg"></div>
		<div class="pswp__scroll-wrap">
			<div class="pswp__container">
				<div class="pswp__item"></div>
				<div class="pswp__item"></div>
				<div class="pswp__item"></div>
			</div>
			<div class="pswp__ui pswp__ui--hidden">
				<div class="pswp__top-bar">
					<div class="pswp__counter"></div>
					<button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
					<button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
					<button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
					
					<div class="pswp__preloader">
						<div class="pswp__preloader__icn">
						  <div class="pswp__preloader__cut">
							<div class="pswp__preloader__donut"></div>
						  </div>
						</div>
					</div>
				</div>
				<div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
					<div class="pswp__share-tooltip"></div>
				</div>
				<button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
				</button>
				<button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
				</button>
				<div class="pswp__caption">
					<div class="pswp__caption__center"></div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
add_action('wp_footer', 'cardealer_photoswipe');

add_action('admin_init','cardealer_remove_metabox');
function cardealer_remove_metabox(){
    remove_meta_box( 'tagsdiv-car_year' ,'cars' ,'side' );
    remove_meta_box( 'tagsdiv-car_make' ,'cars' ,'side' );
    remove_meta_box( 'tagsdiv-car_model' ,'cars' ,'side' );
    remove_meta_box( 'tagsdiv-car_body_style' ,'cars' ,'side' );
    remove_meta_box( 'tagsdiv-car_condition' ,'cars' ,'side' );
    remove_meta_box( 'tagsdiv-car_mileage' ,'cars' ,'side' );
    remove_meta_box( 'tagsdiv-car_transmission' ,'cars' ,'side' );
    remove_meta_box( 'tagsdiv-car_drivetrain' ,'cars' ,'side' );
    remove_meta_box( 'tagsdiv-car_engine' ,'cars' ,'side' );
    remove_meta_box( 'tagsdiv-car_fuel_economy' ,'cars' ,'side' );
    remove_meta_box( 'tagsdiv-car_exterior_color' ,'cars' ,'side' );
    remove_meta_box( 'tagsdiv-car_interior_color' ,'cars' ,'side' );
    remove_meta_box( 'tagsdiv-car_stock_number' ,'cars' ,'side' );
    remove_meta_box( 'tagsdiv-car_vin_number' ,'cars' ,'side' );
    remove_meta_box( 'tagsdiv-car_fuel_type' ,'cars' ,'side' );
    remove_meta_box( 'tagsdiv-car_trim' ,'cars' ,'side' );
    remove_meta_box( 'tagsdiv-car_features_options' ,'cars' ,'side' );
    remove_meta_box( 'car_vehicle_review_stampsdiv' ,'cars' ,'side' );
}