<?php
$cars_grid = isset($_COOKIE['cars_grid']) ? $_COOKIE['cars_grid'] : '';
$cars_grid = isset($_REQUEST['cars_grid']) ? $_REQUEST['cars_grid'] : $cars_grid;
if($cars_grid == ''){
    $cars_grid = cardealer_get_cars_catlog_style();
}
if(isset($_COOKIE['cars']) && !empty($_COOKIE['cars']))
	$carInCompare = json_decode($_COOKIE['cars']);

if($cars_grid == 'yes'){
    /**
    * Grid view layout    
    */
    ?>    
    <div <?php cardealer_grid_view_class()?>>
        <div class="car-item gray-bg text-center <?php echo cardealer_cars_loop();?>">
            <div class="car-image">            
                <?php                        
                $id = get_the_ID();
                echo cardealer_get_cars_condition($id);
                echo cardealer_get_cars_status($id);
                echo cardealer_get_cars_image('car_catalog_image',$id);
				?>                    
                <div class="car-overlay-banner">
                    <ul> 
                        <li><a href="<?php echo get_the_permalink($id);?>" data-toggle="tooltip" title="View"><i class="fa fa-link"></i></a></li>
						<?php
							if(isset($carInCompare) && !empty($carInCompare) && in_array($id, $carInCompare))
							{
								$cars = json_decode($_COOKIE['cars']);
								if($cars)
								?>
								<li><a href="javascript:void(0)" data-toggle="tooltip" title="Compare" class="compare_pgs compared_pgs" data-id="<?php echo esc_attr($id);?>"><i class="fa fa-check"></i></a></li> 
							<?php
							} else {
							?>
								<li><a href="javascript:void(0)" data-toggle="tooltip" title="Compare" class="compare_pgs" data-id="<?php echo esc_attr( $id );?>"><i class="fa fa-exchange"></i></a></li>
							<?php
							}
							$images = cardealer_get_images_url('car_catalog_image',$id); 
							if(!empty($images)){?>	
							<li class="pssrcset"><a href="javascript:void(0)" data-toggle="tooltip" title="Gallery" class="psimages" data-image="<?php echo implode(", ",$images); ?>"><i class="fa fa-expand" ></i></a></li>
							<?php }?>
					</ul>
                </div>
                <?php cardealer_get_cars_list_attribute($id);?>
            </div>                                               
            <div class="car-content">                
                <a href="<?php echo get_the_permalink()?>"><?php the_title()?></a>
                <div class="separator"></div>
                <?php cardealer_car_price_html($id);
                cardealer_get_vehicle_review_stamps($id);
                ?>                            
            </div>
        </div>
    </div>  
<?php } else { ?>
    <div class="car-grid">
        <div class="row">
            <div <?php cardealer_list_view_class_1()?>>
                <div class="car-item gray-bg text-center">
                    <div class="car-image">
                        <?php                        
                        $id = get_the_ID();
                        $args = array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'all');
                        $terms = wp_get_post_terms( get_the_ID(), 'car_condition' ,$args);
                        $class = '';
                        if(isset($terms)&&!empty($terms)){
                            if(preg_match('(new|New)', $terms[0]->name) === 1) {
                                $class = 'new';    
                            }elseif(preg_match('(used|Used)', $terms[0]->name) === 1) {
                                $class = 'used';
                            }else {
                                $class = 'certified';
                            }                            
                            ?>                            
                            <span class="label car-condition <?php echo esc_attr( $class );?>"><?php echo esc_html($terms[0]->name);?></span>
                            <?php
                        }
                        echo cardealer_get_cars_status($id);
                        echo cardealer_get_cars_image('car_catalog_image',$id);?>					
                        <div class="car-overlay-banner">
                            <ul> 
                                <li><a href="<?php echo get_the_permalink();?>" data-toggle="tooltip" title="View"><i class="fa fa-link"></i></a></li>
                                <?php
									if(isset($carInCompare) && !empty($carInCompare) && in_array($id, $carInCompare))
									{
										$cars = json_decode($_COOKIE['cars']);
										if($cars)
									?>
										<li><a href="javascript:void(0)" data-toggle="tooltip" title="Compare" class="compare_pgs compared_pgs" data-id="<?php echo esc_attr( $id );?>"><i class="fa fa-check"></i></a></li> 
									<?php
									} else {
									?>
										<li><a href="javascript:void(0)" data-toggle="tooltip" title="Compare" class="compare_pgs" data-id="<?php echo esc_attr( $id );?>"><i class="fa fa-exchange"></i></a></li>
									<?php
									}
									$images = cardealer_get_images_url('car_catalog_image',$id); 
									if(!empty($images)){?>	
									<li class="pssrcset"><a href="javascript:void(0)" data-toggle="tooltip" title="Gallery" class="psimages" data-image="<?php echo implode(", ",$images); ?>"><i class="fa fa-expand" ></i></a></li>
									<?php }?>
                            </ul>
                        </div>
                    </div>                    
                </div>
            </div>
            <div <?php cardealer_list_view_class_2()?>>
                <div class="car-details">
                    <div class="car-title">
                        <a href="<?php echo get_the_permalink()?>"><?php the_title();?></a>
                        <p><?php echo get_the_excerpt();?></p>
                    </div>
                    <?php cardealer_car_price_html(get_the_ID());?>  
                    <a class="button red pull-right" href="<?php echo get_the_permalink();?>">Details</a>
                    <?php cardealer_get_cars_list_attribute();?> 
                </div>
            </div>
        </div>
    </div>    
<?php }?>