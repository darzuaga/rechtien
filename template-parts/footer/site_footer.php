<?php
global $car_dealer_options;
do_action( 'cardealer_before_footer' );

$footer_class = array();
$footer_class[] = 'footer bg-2 bg-overlay-black-90';
$footer_class=array_merge($footer_class,cardealer_footer_class());   /* get the footer classes from base functions */
$footer_class = implode(' ', $footer_class);
?>
<footer id="footer" class="<?php echo esc_attr($footer_class);?>">
	<?php do_action('cardealer_before_footer_inner'); ?>
    <div class="container">
	<?php
	if( isset($car_dealer_options['show_footer_top']) && $car_dealer_options['show_footer_top'] == 'yes') {
		if( isset($car_dealer_options['social_icon_list']) && !empty($car_dealer_options['social_icon_list']) ) {?>
			<div class="social-full">
				<?php
					$socialIcons = $car_dealer_options['social_icon_list']['Icons to Add'];
					unset($socialIcons['placebo']);
					foreach( $socialIcons as $key => $icon ) {
						echo '<a class="'. esc_attr($key) .'" href="'. esc_attr($car_dealer_options[$key.'_url']) .'" target="_blank">'. esc_html($icon) .'<i class="fa fa-'. esc_attr( str_replace('_', '-', $key) ). '"></i> </a>';
					}
				?>
			</div>
			<?php
		}
	}
		
    if(is_active_sidebar('sidebar-footer-1') || is_active_sidebar('sidebar-footer-2') || is_active_sidebar('sidebar-footer-3') || is_active_sidebar('sidebar-footer-4')) { ?>
        <div class="row">
            <?php 			
			$footer_cols = 1;
			$classes = array('col-lg-12 col-md-12 col-sm-12');
			if( isset($car_dealer_options['footer_column_layout']) ) {
				switch( $car_dealer_options['footer_column_layout'] ) {
					case 'two-columns':
						$footer_cols = 2;
						$classes = array('col-lg-6 col-md-6 col-sm-6');
					break;
					case 'three-columns':
						$footer_cols = 3;
						$classes = array('col-lg-4 col-md-4 col-sm-4');
					break;
					case 'four-columns':
						$footer_cols = 4;
						$classes = array('col-lg-3 col-md-3 col-sm-6');
					break;
					case '8-4-columns':
						$footer_cols = 2;
						$classes = array('col-lg-8 col-md-8 col-sm-7', 'col-lg-4 col-md-4 col-sm-5');
					break;
					case '4-8-columns':
						$footer_cols = 2;
						$classes = array('col-lg-4 col-md-4 col-sm-5', 'col-lg-8 col-md-8 col-sm-7');
					break;
					case '6-3-3-columns':
						$footer_cols = 3;
						$classes = array('col-lg-6 col-md-6 col-sm-6', 'col-lg-3 col-md-3 col-sm-3', 'col-lg-3 col-md-3 col-sm-3');
					break;
					case '3-3-6-columns':
						$footer_cols = 3;
						$classes = array('col-lg-3 col-md-3 col-sm-3', 'col-lg-3 col-md-3 col-sm-3', 'col-lg-6 col-md-6 col-sm-6');
					break;
					case '8-2-2-columns':
						$footer_cols = 3;
						$classes = array('col-lg-8 col-md-8 col-sm-8', 'col-lg-2 col-md-2 col-sm-2', 'col-lg-2 col-md-2 col-sm-2');
					break;
					case '2-2-8-columns':
						$footer_cols = 3;
						$classes = array('col-lg-2 col-md-2 col-sm-2', 'col-lg-2 col-md-2 col-sm-2', 'col-lg-8 col-md-8 col-sm-8');
					break;
					case '6-2-2-2-columns':
						$footer_cols = 4;
						$classes = array('col-lg-6 col-md-6 col-sm-6', 'col-lg-2 col-md-2 col-sm-2', 'col-lg-2 col-md-2 col-sm-2', 'col-lg-2 col-md-2 col-sm-2');
					break;
					case '2-2-2-6-columns':
						$footer_cols = 4;
						$classes = array('col-lg-2 col-md-2 col-sm-2', 'col-lg-2 col-md-2 col-sm-2', 'col-lg-2 col-md-2 col-sm-2', 'col-lg-6 col-md-6 col-sm-6');
					break;
				}
			}
			for( $col = 1; $col <= $footer_cols; $col++ ) {
				if(is_active_sidebar('sidebar-footer-'.$col)) { 
					if(!isset($classes[$col - 1]))
						$classes[$col - 1] = $classes[0];
					?>
                  <div class="<?php echo esc_attr($classes[$col - 1]);?>">
                        <?php dynamic_sidebar('sidebar-footer-'.$col); ?>
                  </div>
                <?php }
			}
			?>			
        </div>
    <?php
    }
   
	get_template_part('template-parts/footer/additionalsidebar');    //show bottom copyright
	do_action('cardealer_after_footer_inner');
	?>
    </div>
	<!-- BOOTOM COPYRIGHT SECTION START -->
	<?php if(isset($car_dealer_options['enable_copyright_footer']) && $car_dealer_options['enable_copyright_footer']=='yes') {?>
	<div class="copyright-block">
		<div class="container">
			<div class="row">				
				<div class="col-lg-6 col-md-6 pull-left">
					<?php
						if(isset($car_dealer_options['footer_text_left']))
							echo do_shortcode($car_dealer_options['footer_text_left']);
				   ?>
				</div>
				<div class="col-lg-6 col-md-6 pull-right">
					<?php
						if(isset($car_dealer_options['footer_text_right']))
							echo do_shortcode($car_dealer_options['footer_text_right']);
					?>
				</div>
			</div>
		</div>	
	</div>
<?php }	?>
	<!-- BOOTOM COPYRIGHT SECTION END -->
</footer>
<?php do_action('cardealer_after_footer');?>