<?php
global $car_dealer_options;
$class = "";$layout='';
if (isset($car_dealer_options['cars-details-layout']) && $car_dealer_options['cars-details-layout'] == 3){
    $class  = '-full';
    $layout = $car_dealer_options['cars-details-layout'];
}
?>
<div class="slider-slick">
<?php if(function_exists('get_field')){?>
	<div id="cars-image-gallery" class="my-gallery">
		<div class="slider slider-for<?php echo esc_attr($class)?> detail-big-car-gallery">
		<?php
		$i = 0;
        $images = get_field('car_images');
        if( isset($images) && !empty($images) ){
            foreach( $images as $image ): ?>
				<figure>
					  <img src="<?php echo esc_url($image['sizes']['car_single_slider']); ?>" class="img-responsive ps-car-listing" id="<?php echo esc_attr('pscar-'.$i++)?>" alt="<?php echo esc_attr($image['alt']);?>"/>
				</figure>
            <?php endforeach;
        }else{
            echo cardealer_get_cars_image('large');
        }?>
		</div>
    </div>
    <?php if($layout == ''){?>
    <div class="slider slider-nav">
        <?php
        $images = get_field('car_images');
        if( $images ):?>
            <?php foreach( $images as $image ): ?>
                <img class="img-responsive" src="<?php echo esc_url($image['sizes']['car_thumbnail']); ?>" alt="<?php echo esc_attr($image['alt']);?>">
            <?php endforeach; ?>
        <?php endif;?>
    </div>
    <?php }
}?>
</div>