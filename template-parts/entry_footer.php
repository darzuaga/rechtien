<?php 
global $car_dealer_options;

$facebook_share   = isset($car_dealer_options['facebook_share']) ? $car_dealer_options['facebook_share'] : '' ; 
$twitter_share   = isset($car_dealer_options['twitter_share']) ? $car_dealer_options['twitter_share'] : '' ; 
$linkedin_share   = isset($car_dealer_options['linkedin_share']) ? $car_dealer_options['linkedin_share'] : '' ; 
$google_plus_share   = isset($car_dealer_options['google_plus_share']) ? $car_dealer_options['google_plus_share'] : '' ; 
$pinterest_share   = isset($car_dealer_options['pinterest_share']) ? $car_dealer_options['pinterest_share'] : '' ; 

if(is_single() && (!has_tag() &&  $facebook_share=='' && $twitter_share=='' && $linkedin_share=='' && $google_plus_share=='' && $pinterest_share=='')){
	return;
}?>

<div class="entry-share clearfix">
    <?php
    if (is_single()) {
        ?>
        <div class="tags-2 pull-left clearfix">            
            <?php the_tags('<h5>' . esc_html__('Tags', 'cardealer') . ':</h5><ul><li>', '</li><li>', '</li></ul>'); ?>
        </div>
        <?php
    } else {
        ?>   
        <a href="<?php echo esc_url(get_permalink()); ?>" class="button pull-left">
            <span><?php esc_html_e('Read More', 'cardealer'); ?></span>            
        </a>
        <?php
    }	
	if(!empty($facebook_share) || !empty($twitter_share) || !empty($linkedin_share) || !empty($google_plus_share) || !empty($pinterest_share)):
    ?>
    <div class="share pull-right">
        <a href="#" class="share-button">
            <i class="fa fa-share-alt"></i>
        </a>
        <ul class="single-share-box mk-box-to-trigger">
            <?php if($facebook_share){?>
                <li>                    
                    <a href="#" class="facebook-share" data-title="<?php echo esc_attr(get_the_title())?>" data-url="<?php echo esc_url(get_permalink())?>"><i class="fa fa-facebook"></i></a>
                </li>                
            <?php }
            if($twitter_share){?>
                <li><a href="#"  data-title="<?php echo esc_attr(get_the_title())?>" data-url="<?php echo esc_url(get_permalink())?>" class="twitter-share"><i class="fa fa-twitter"></i></a></li>
            <?php }?>
            <?php 
            if($linkedin_share){?>
                <li><a href="#" data-title="<?php echo esc_attr(get_the_title())?>" data-url="<?php echo esc_url(get_permalink())?>" class="linkedin-share"><i class="fa fa-linkedin"></i></a></li>                
            <?php }?>                
            <?php 
            if($google_plus_share){?>
                <li><a href="#" data-title="<?php echo esc_attr(get_the_title())?>" data-url="<?php echo esc_url(get_permalink());?>" class="googleplus-share"><i class="fa fa-google-plus"></i></a></li>               
            <?php }?>
            <?php 
            if($pinterest_share){?>
                <li><a href="#" data-title="<?php echo esc_attr(get_the_title())?>" data-url="<?php echo esc_url(get_permalink());?>" data-image="<?php the_post_thumbnail_url('full')?>" class="pinterest-share"><i class="fa fa-pinterest"></i></a></li>               
            <?php }?>
        </ul>        
    </div>
	<?php endif;?>
</div>

<?php
if (!is_single()) {
    ?>
    <hr>
    <?php
}
?>