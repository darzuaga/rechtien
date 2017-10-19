<?php
/**
 * The template for displaying the footer
 *
 */
global $car_dealer_options;
?>
	</div> <!-- #main .wrapper  -->
	<?php get_template_part('template-parts/footer/site_footer'); 
	
	if(wp_is_mobile()) {
		// Script to disable Top Bar in Mobile if disabled from Admin
		if( isset( $car_dealer_options['back_top_mobile'] ) && $car_dealer_options['back_top_mobile'] == 1 ) {?>
			<div class="car-top"><span><img src="<?php echo esc_url(CARDEALER_URL.'/images/car.png');?>" alt="Top" title="Back to top"/></span></div>
		<?php
		}
	}else if( isset( $car_dealer_options['back_to_top'] ) && $car_dealer_options['back_to_top'] == 1 ){?>		
			<div class="car-top"><span><img src="<?php echo esc_url(CARDEALER_URL.'/images/car.png');?>" alt="Top" title="Back to top"/></span></div>
	<?php }?>
		
</div><!-- #page -->
<?php wp_footer(); ?>
</body>
</html>