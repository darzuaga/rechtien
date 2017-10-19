<?php
global $car_dealer_options, $cardealer_blog_layout;

$layout_sr = 0;

$grid_size = ( !empty($car_dealer_options['masonry_size']) ) ? $car_dealer_options['masonry_size'] : 2 ;
$cardealer_blog_sidebar = ( !empty($car_dealer_options['blog_sidebar']) ) ? $car_dealer_options['blog_sidebar'] : 'right_sidebar' ;
if( $cardealer_blog_sidebar != 'full_width' ){
	$grid_size = 2;
}
?>
<div class="masonry-main masnary-blog-<?php echo esc_attr($grid_size);?>-columns">
	<div class="isotope-2 masonry columns-<?php echo esc_attr($grid_size);?>">
		<div class="grid-sizer"></div>
		<?php
		// Start the loop.
		while ( have_posts() ){
			the_post();
			
			$layout_sr++;
			?>
			<div class="masonry-item">
				<?php
				$part_1 = "template-parts/blog/$cardealer_blog_layout/content";
				$part_2 = get_post_format();
				locate_template("$part_1-$part_2.php");
				locate_template("$part_1.php");
				if( ($part_2 && locate_template("$part_1-$part_2.php") != '') || (locate_template("$part_1.php") != '') ) {
					get_template_part( $part_1, $part_2 );
				} else { 
					get_template_part( "template-parts/blog/classic/content", get_post_format() );
				}
				?>
			</div>
			<?php
		}
		// End the loop.
		?>
	</div>
</div>