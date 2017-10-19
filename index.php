<?php 
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package carDealer
 */
get_header(); ?>

<?php
global $car_dealer_options, $cardealer_blog_sidebar, $cardealer_blog_layout, $cardealer_timeline_type;

do_action( 'cardealer_before_blog' );
$cardealer_blog_sidebar = isset($car_dealer_options['blog_sidebar']) ? $car_dealer_options['blog_sidebar'] : '';
if( !isset($cardealer_blog_sidebar) || empty($cardealer_blog_sidebar) ){
	$cardealer_blog_sidebar = 'right_sidebar';
}

$cardealer_blog_layout = isset($car_dealer_options['blog_layout']) ? $car_dealer_options['blog_layout'] : '';
if( !isset($cardealer_blog_layout) || empty($cardealer_blog_layout) ){
	$cardealer_blog_layout = 'classic';
}

// Get Current Page Layout Style
$pageId = get_option( 'page_for_posts' );
if( function_exists('get_field') ){
	$layout_status = get_field('page_layout_custom', $pageId);
	if( isset( $layout_status ) && $layout_status == 1 ) {
		$current_pg_sidebar= get_field('page_sidebar', $pageId); 
		if( !empty( $current_pg_sidebar ) ) $cardealer_blog_sidebar = $current_pg_sidebar;
	}
}

$width = 12;

$section_class = array();
$section_class[] = 'content-wrapper';
$section_class[] = 'blog';
$section_class[] = 'white-bg';
$section_class[] = 'page-section-ptb';

$cardealer_timeline_type = 'default';
$sidebar_stat = '';

if ( ( ($cardealer_blog_sidebar == 'left_sidebar') || ($cardealer_blog_sidebar == 'right_sidebar') ) ){
	$width_lg = $width-3;
	$width_md = $width-3;
	$width_sm = $width-4;
	$sidebar_stat .= ' with-sidebar';
	$sidebar_stat .= " with-$cardealer_blog_sidebar";
	
	if( $cardealer_blog_layout == 'timeline' ){
		$section_class[] = 'timeline-sidebar';
		$cardealer_timeline_type = 'with_sidebar' ;
	}
}else{
	$width_lg = $width_md = $width_sm = $width;
}
if ($cardealer_blog_sidebar == 'two_sidebar') {
	$width_lg = $width-6;
	$width_md = $width-6;
	$width_sm = $width-8;
}
$section_class = implode( ' ', array_filter( array_unique( $section_class ) ) );
if(isset($car_dealer_options['masonry_size'])){
$container_class = !empty($car_dealer_options['masonry_size'] && $car_dealer_options['masonry_size']==4)? 'container-fluid' : 'container';
}else{
$container_class = 'container';
}
?>

<!--inner-intro-->
<?php get_template_part('template-parts/content','intro'); ?>

<div class="<?php echo esc_attr($section_class);?>">
	
	<div class="<?php echo esc_attr($container_class);?>">
		
		<?php get_template_part( 'template-parts/content', 'archive_header' );?>
		
		<div class="row<?php echo esc_attr($sidebar_stat);?>">
			
			<?php if ( ($cardealer_blog_sidebar == 'left_sidebar' || $cardealer_blog_sidebar == 'two_sidebar') ) { ?>
				<div class="col-lg-3 col-md-3 col-sm-4 sidebar-left">
					<div role="complementary" class="widget-area" id="secondary">
						<?php get_sidebar('left');?>
					</div>
				</div>
			<?php } ?>
			
			<div class="col-lg-<?php echo esc_attr($width_lg);?> col-md-<?php echo esc_attr($width_md);?> col-sm-<?php echo esc_attr($width_sm);?>">
				<div class="site-content" id="primary">
					<?php                    
					if ( have_posts() ) {
						
						get_template_part( 'template-parts/blog/'.$cardealer_blog_layout );
						
						if( $cardealer_blog_layout != 'timeline' ){
							if(function_exists("cardealer_wp_bs_pagination")){
								cardealer_wp_bs_pagination();
							}
						}
						// If no content, include the "No posts found" template.
					}else{
						get_template_part( 'template-parts/content', 'none' );
					}
					?>
				</div>
			</div>
			
			<?php if ( ($cardealer_blog_sidebar == 'right_sidebar' || $cardealer_blog_sidebar == 'two_sidebar') ) { ?>
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