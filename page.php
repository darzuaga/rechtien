<?php
/**
 * Default page template to display all pages
 *
 * @package CarDealer
 * @author Potenza Global Solutions
 */

get_header(); ?>

<?php
global $car_dealer_options, $cardealer_page_sidebar;

$cardealer_page_sidebar = isset($car_dealer_options['page_sidebar']) ? $car_dealer_options['page_sidebar'] : '';
if( !isset($cardealer_page_sidebar) || empty($cardealer_page_sidebar) ){
	$cardealer_page_sidebar = 'right_sidebar';
}

$page_layout_custom = get_post_meta(get_the_ID(),'page_layout_custom',true);
if($page_layout_custom){
	$page_sidebar = get_post_meta(get_the_ID(),'page_sidebar',true);
	if( $page_sidebar ){
		$cardealer_page_sidebar = $page_sidebar;
	}
}

$width = 12;

$sidebar_stat = '';

if( $cardealer_page_sidebar == 'left_sidebar' || $cardealer_page_sidebar == 'right_sidebar' ){
	$width_lg = $width-3;
	$width_md = $width-3;
	$width_sm = $width-4;
	$sidebar_stat .= ' with-sidebar';
	$sidebar_stat .= " with-$cardealer_page_sidebar";
}elseif( $cardealer_page_sidebar == 'two_sidebar' ){
	$width_lg = $width_md = $width_sm = 6;
	$sidebar_stat .= ' with-sidebar';
	$sidebar_stat .= " with-$cardealer_page_sidebar";
}else{
	$width_lg = $width_md = $width_sm = $width;
	$sidebar_stat .= 'without-sidebar';
}
?>

<?php get_template_part('template-parts/content','intro'); ?>

<div class="page-section-ptb <?php echo ( cardealer_is_vc_enabled() ) ? ' content-wrapper-vc-enabled' : ' content-wrapper';?>">
	
	<div class="container">
		<div class="row <?php echo esc_attr($sidebar_stat);?>">
			
			<?php if ( ($cardealer_page_sidebar == 'left_sidebar' || $cardealer_page_sidebar == 'two_sidebar') ) { ?>
				<div class="col-lg-3 col-md-3 col-sm-4 sidebar-left">
					<div role="complementary" class="widget-area" id="secondary">
						<?php get_sidebar('left');?>
					</div>
				</div>
			<?php } ?>
			
			<div class="col-lg-<?php echo esc_attr($width_lg);?> col-md-<?php echo esc_attr($width_md);?> col-sm-<?php echo esc_attr($width_sm);?>">
				<div id="primary" class="site-content">
					
					<div id="content" role="main">
	
						<?php while ( have_posts() ) : the_post(); ?>
						
							<?php get_template_part('template-parts/content','page'); ?>
							<?php comments_template( '', true ); ?>
						
						<?php endwhile; // end of the loop. ?>
						
					</div>
					
				</div>
			</div>
			
			<?php if ( ($cardealer_page_sidebar == 'right_sidebar' || $cardealer_page_sidebar == 'two_sidebar') ) { ?>
				<div class="col-lg-3 col-md-3 col-sm-4 sidebar-right">
					<div role="complementary" class="widget-area" id="secondary">
						<?php get_sidebar();?>
					</div>
				</div>
			<?php } ?>
			
		</div>
	</div>
	
</div>

<?php get_footer(); ?>