<?php
/**
 * The template for displaying the footer
 *
 */
global $car_dealer_options;
?>
		</div> <!-- #main .wrapper  -->
		
<!--==== footer -->
<footer class="footer page-section-pt">
	<div class="footer-widget">
		<div class="container"> 
			<div class="row">
				<div class="col-lg-6 col-md-6">
					<p class="text-white"><?php cardealer_footer_copyright();?></p>
				</div>
				<?php
				if( $car_dealer_options['commin_soon_social_icons'] == '1' ) {?>
					<div class="col-lg-6 col-md-6">
					<?php
						if($car_dealer_options['facebook_url'] || $car_dealer_options['twitter_url'] || $car_dealer_options['dribbble_url'] || $car_dealer_options['vimeo_url'] || $car_dealer_options['pinterest_url'] || $car_dealer_options['behance_url'] || $car_dealer_options['linkedin_url']):?>
							<div class="footer-widget-social">
								<ul> 
									<?php if($car_dealer_options['facebook_url']):?>
										<li><a href="<?php echo esc_url($car_dealer_options['facebook_url'])?>" data-tooltip="facebook"><i class="fa fa-facebook"></i></a></li>
									<?php endif;?>
									<?php if($car_dealer_options['twitter_url']):?>
										<li><a href="<?php echo esc_url($car_dealer_options['twitter_url']);?>" data-tooltip="twitter"><i class="fa fa-twitter"></i></a></li>
									<?php endif;?>
									<?php if($car_dealer_options['dribbble_url']):?>
										<li><a href="<?php echo esc_url($car_dealer_options['dribbble_url']);?>" data-tooltip="dribbble"><i class="fa fa-dribbble"></i> </a></li>
									<?php endif;?>
									<?php if($car_dealer_options['vimeo_url']):?>
										<li><a href="<?php echo esc_url($car_dealer_options['vimeo_url']);?>" data-tooltip="Vimeo"><i class="fa fa-vimeo"></i> </a></li>
									<?php endif;?>
									<?php if($car_dealer_options['pinterest_url']):?>
										<li><a href="<?php echo esc_url($car_dealer_options['pinterest_url']);?>" data-tooltip="Pinterest"><i class="fa fa-pinterest-p"></i> </a></li>
									<?php endif;?>
									<?php if($car_dealer_options['behance_url']):?>
										<li><a href="<?php echo esc_url($car_dealer_options['behance_url']);?>" data-tooltip="Behance"><i class="fa fa-behance"></i> </a></li>
									<?php endif;?>
									<?php if($car_dealer_options['linkedin_url']):?>
										<li><a href="<?php echo esc_url($car_dealer_options['linkedin_url']);?>" data-tooltip="Linkedin"><i class="fa fa-linkedin"></i> </a></li>
									<?php endif;?>					
								</ul>
							</div>
					<?php endif; ?>
					</div>
				<?php
				}?>
			</div>
		</div>
	</div>
</footer>
</div>
<!-- page-wrapper ends -->
<?php wp_footer(); ?>
</body>
</html>