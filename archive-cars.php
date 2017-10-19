<?php
/**
 * The Template for displaying cars listings
 *
 */
get_header();

get_template_part('template-parts/content','intro');
?>
<section <?php post_class('product-listing page-section-ptb'); ?>>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="cars-top-filters-box">

                    <div class="cars-top-filters-box-left">
                        <?php cardealer_get_price_filters();?>
                        <div class="price">
                            <button id="pgs_price_filter_btn" class="button"><?php esc_html_e( 'Filter', 'cardealer' )?></button>
                        </div>
                    </div>
					
                    <div class="cars-top-filters-box-right">
                        <?php cardealer_cars_catalog_ordering();
                        echo cardealer_get_catlog_view();
                        ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <?php
            /*
             * Custome left-sidebar
             */
             cardealer_get_car_catlog_sidebar_left();
            ?>
            <div <?php cardealer_cars_content_class()?>>
                <?php
                $getlayout = cardealer_get_cars_list_layout_style();            	
            	$flag = false;
                if(isset($getlayout) && $getlayout == "view-grid-full"){
            	   $flag = true;
                } elseif(isset($getlayout) && $getlayout == "view-list-full"){
            	   $flag = true;		
            	}else{
                    if ( is_active_sidebar( 'listing-cars' ) ){
                        global $wp_registered_widgets;
                        $widgets = get_option('sidebars_widgets', array());
                        $widgets = $widgets['listing-cars'];
                        foreach ($widgets as $widget) {
                            if($wp_registered_widgets[$widget]['classname'] == 'cars_filters'){
                                $flag = false;
                                break;
                            }else{
                                $flag = true;
                            }
                        }
                    }else{
                        $flag = true;
                    }
                }
                if($flag){
                    ?>
                    <div class="sorting-options-main">
                        <div class="sort-filters-box">
                            <?php cardealer_get_all_filters();?>
                        </div>
                    </div>
                    <?php
                }
                $cars_grid = isset($_COOKIE['cars_grid']) ? $_COOKIE['cars_grid'] : '';
                $cars_grid = isset($_REQUEST['cars_grid']) ? $_REQUEST['cars_grid'] : $cars_grid;
                if($cars_grid == ''){
                    $cars_grid = cardealer_get_cars_catlog_style();
                }

                if($cars_grid == 'yes'){?>
					<div class="row">
				<?php }
				
					if(have_posts()){ ?>
							<div class="all-cars-list-arch">
								<?php
								while ( have_posts() ) : the_post();
									get_template_part('template-parts/cars/content','cars');
								endwhile; // end of the loop.
								?>
							</div>
						<?php
					} else {
						echo '<div class="all-cars-list-arch"><div class="col-sm-12"><div class="alert alert-warning">No result were found matching your selection.</div></<div></<div>';
					}
				if($cars_grid == 'yes'){ ?>
					</div>
				<?php }
				
                if(have_posts()){
                    get_template_part('template-parts/cars/pagination');
                }
                ?>
            </div>
            <?php
            /**
             * Custome right-sidebar
             * */
             cardealer_get_car_catlog_sidebar_right();
            ?>
         </div>
    </div>
</section>
<!--.product-listing-->
<?php get_footer(); ?>