<?php
/**
 * Related Cars
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $car_dealer_options;
$data_item=3;
if(isset($car_dealer_options['cars-details-layout']) && $car_dealer_options['cars-details-layout'] == 2){
    $data_item=4;
}
$sidebar_position = cardealer_get_cars_details_page_sidebar_position();
if($sidebar_position == 'no'){
    $data_item=4;
}
$args=array(
    'post_type' => 'cars',
    'posts_status' => 'publish',
    'posts_per_page' => 10,
    'post__not_in' => array(get_the_ID())									
);
$terms = get_the_terms( get_the_ID(), 'car_make');
if(isset($terms) && !empty($terms)){
    $cars_cat_slug = $terms[0]->slug;
    $args['tax_query'] = array(                    
        array(
            'taxonomy' => 'car_make',
            'field'    => 'slug',
            'terms'    => $cars_cat_slug,
        ) 
    );    
} 
 // Compare Cars
if(isset($_COOKIE['cars']) && !empty($_COOKIE['cars']))
	$carInCompare = json_decode($_COOKIE['cars']);
$loop = new WP_Query( $args );
$tot_result = 0;$nav_arrow = false;
$tot_result = $loop->post_count;
if($tot_result > 4){
    $nav_arrow = true;    
}
if($loop->have_posts()){
    ?>
    <div class="feature-car">
        <h3><?php esc_html_e('Related Vehicle','cardealer')?></h3>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="owl-carousel" data-nav-arrow="<?php echo esc_attr($nav_arrow);?>" data-nav-dots="false" data-items="<?php echo esc_attr($data_item)?>" data-md-items="3" data-sm-items="3" data-xs-items="2" data-xx-items="1" data-space="20">
                    <?php                
                    while ( $loop->have_posts() ) : $loop->the_post();
                        ?>
                        <div class="item">
                            <div class="car-item gray-bg text-center">
                                <div class="car-image">
                                    <?php echo cardealer_get_cars_image('car_catalog_image')?>                                
                                    <div class="car-overlay-banner">
                                        <ul> 
                                            <li><a href="<?php echo esc_url(get_the_permalink());?>" data-toggle="tooltip" title="View"><i class="fa fa-link"></i></a></li>                                            
                                            <?php
    											if(isset($carInCompare) && !empty($carInCompare) && in_array(get_the_ID(), $carInCompare))
    											{
    												$cars = json_decode($_COOKIE['cars']);
    											?>
    												<li><a href="javascript:void(0)" class="compare_pgs compared_pgs" data-id="<?php echo get_the_ID();?>" data-toggle="tooltip" title="Compare"><i class="fa fa-check"></i></a></li> 
    											<?php
    											} else {
    											?>
    												<li><a href="javascript:void(0)" class="compare_pgs" data-id="<?php echo get_the_ID();?>" data-toggle="tooltip" title="Compare"><i class="fa fa-exchange"></i></a></li>
    											<?php
    											}
    										?>
                                        </ul>
                                    </div>
                                    <?php cardealer_get_cars_list_attribute(get_the_ID());?>
                                </div>                                                        
                                <div class="car-content">                                
                                    <a href="<?php echo get_the_permalink()?>"><?php the_title()?></a>
                                    <div class="separator"></div>
                                    <?php cardealer_car_price_html('',get_the_ID(),false);?>                            
                                </div>                        
                            </div>
                        </div>
                        <?php    
                    endwhile;                
                    ?>                
                </div>
            </div>
        </div>
    </div>
    <?php
}
wp_reset_postdata();