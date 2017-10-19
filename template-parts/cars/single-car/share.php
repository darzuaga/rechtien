<?php
/**
 * Single Car Share
 * 
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $car_dealer_options;

$facebook_share   = isset($car_dealer_options['facebook_share']) ? $car_dealer_options['facebook_share'] : ''; 
$twitter_share   = isset($car_dealer_options['twitter_share']) ? $car_dealer_options['twitter_share'] : ''; 
$linkedin_share   = isset($car_dealer_options['linkedin_share']) ? $car_dealer_options['linkedin_share'] : ''; 
$google_plus_share   = isset($car_dealer_options['google_plus_share']) ? $car_dealer_options['google_plus_share'] : ''; 
$pinterest_share   = isset($car_dealer_options['pinterest_share']) ? $car_dealer_options['pinterest_share'] : '';

if(empty($facebook_share) && empty($twitter_share) && empty($linkedin_share) && empty($google_plus_share) && empty($pinterest_share)){
	return;
}
?>
<div class="details-social details-weight share">    
        <h5 class="uppercase"><?php esc_html_e('Share :','cardealer');?></h5>
        <ul class="single-share-box mk-box-to-trigger">
            <?php         
            if($facebook_share){?>
            <li>                    
                <a href="#" data-title="<?php echo get_the_title()?>" data-url="<?php echo get_permalink()?>" class="facebook-share"><i class="fa fa-facebook"></i></a>
            </li>                
            <?php }
            if($twitter_share){?>
                <li><a href="#"  data-title="<?php echo get_the_title()?>" data-url="<?php echo get_permalink()?>" class="twitter-share"><i class="fa fa-twitter"></i></a></li>
            <?php }?>
            <?php 
            if($linkedin_share){?>
                <li><a href="#" data-title="<?php echo get_the_title()?>" data-url="<?php echo get_permalink()?>" class="linkedin-share"><i class="fa fa-linkedin"></i></a></li>                
            <?php }?>                
            <?php 
            if($google_plus_share){?>
                <li><a href="#" data-title="<?php echo get_the_title()?>" data-url="<?php echo get_permalink()?>" class="googleplus-share"><i class="fa fa-google-plus"></i></a></li>               
            <?php }?>
            <?php 
            if($pinterest_share){?>
                <li><a href="#" data-title="<?php echo get_the_title()?>" data-url="<?php echo get_permalink()?>" data-image="<?php echo cardealer_get_single_image_url()?>" class="pinterest-share"><i class="fa fa-pinterest"></i></a></li>               
            <?php }?>          
        </ul>	
</div><!--.share-->  
