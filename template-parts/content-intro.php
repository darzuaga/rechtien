<?php
global $car_dealer_options;
$postId = is_home()? get_option( 'page_for_posts' ) : get_the_ID();

/*** THEME OPTIONS START ***/
// breadcrumb full width
if( isset( $car_dealer_options['header_type'] ) && in_array( $car_dealer_options['header_type'], [ 'light-fullwidth', 'transparent-fullwidth' ] ) && isset( $car_dealer_options['breadcrumb_full_width'] )  && $car_dealer_options['breadcrumb_full_width'] == true )
	$container_class = 'container-fluid';
else
	$container_class = 'container';
// mobile breadcrumb
( isset( $car_dealer_options['breadcrumbs_on_mobile'] ) && $car_dealer_options['breadcrumbs_on_mobile'] == true)? $mobile_breadcrumb_class = '' : $mobile_breadcrumb_class = 'breadcrumbs-hide-mobile';
// Titlebar Alignment
$titlebar_view = ( isset($car_dealer_options['titlebar_view']) ) ? $car_dealer_options['titlebar_view'] : 'default';
if( function_exists('get_field') ){
	$page_specific_title_alignment = get_field('enable_title_alignment', $postId);
	if($page_specific_title_alignment) {
		$titlebar_view	= get_field('title_alignment', $postId);	//get the title alignment
		$titlebar_view	= ($titlebar_view) ? $titlebar_view : "left";	//set left default
	}
}
$title_alignment = 'left';
if( $titlebar_view == 'center' ){
	$title_alignment = 'center';
} elseif ( $titlebar_view == 'right' ){
	$title_alignment = 'right';
}


$hide_header_banner = get_post_meta($postId,'hide_header_banner',true);

/*Background Video options*/
if( isset($post) ) {
	if( !is_home() ) {
		$postId = $post->ID;
	}
}
	
$enable_custom_banner = isset($post) ? get_post_meta($postId,'enable_custom_banner', true) : '';
if( $enable_custom_banner ){
	$banner_type = get_post_meta($postId,'banner_type', true);
	$video_type = get_post_meta($postId,'banner_video_type_bg_custom', true);
	if($banner_type == 'video')
	{
			$video_link = get_post_meta($postId,'banner_video_bg_custom', true);
	}
}else{
	$banner_type = isset($car_dealer_options['banner_type']) ? $car_dealer_options['banner_type'] : '' ;
	$video_type = isset($car_dealer_options['video_type']) ? $car_dealer_options['video_type'] : '' ;
	if(!empty($video_type)){
		if($video_type=='youtube' && !empty($car_dealer_options['youtube_video']))
			$video_link = $car_dealer_options['youtube_video'];
		else if( !empty($car_dealer_options['vimeo_video']) )
			$video_link = $car_dealer_options['vimeo_video'];
		else
			$video_link = '';
	}else{
		$video_link = '';
	}
}
/*** THEME OPTIONS END ***/	

if( !empty( $hide_header_banner ) && ( is_search() ) ){
	$hide_header_banner = false;
}

// Return if page banner is set to hide.
if( $hide_header_banner ){
	return;
}
?>
<section class="inner-intro header_intro <?php cardealer_intro_class();?>" <?php if($banner_type=='video' && $video_type=='youtube'): ?> data-youtube-video-bg="<?php echo esc_attr($video_link);?>" <?php endif;?>>
	<?php if($banner_type=='video' && $video_type=='vimeo'): /* Only Vimeo Video */?>
		<div class="intro_header_video-bg  vc_video-bg vimeo_video_bg">
			<?php echo wp_oembed_get($video_link,array('width'=>'500','height'=>'280'));?>
		</div>
	<?php endif;?>
	<div class="<?php echo esc_attr($container_class); ?>">
			<?php
			$title = get_the_title();
			$subtitle = '';
			
			$show_on_front     	= get_option( 'show_on_front' );
			$page_on_front     	= get_option( 'page_on_front' );
			$page_for_posts_id 	= get_option( 'page_for_posts' );
			
			if(is_singular()){
				if(get_post_type()=='cars'){
				    $title = esc_html__('Car Details','cardealer');
                    $cars_details_title = (isset($car_dealer_options['cars-details-title']))?$car_dealer_options['cars-details-title']:'';
                    if(isset($cars_details_title) && !empty($cars_details_title)){
                        $title = $cars_details_title;
                    }
				}
                $subtitle = get_post_meta(get_the_ID(),'subtitle',true);
			}elseif( is_home() ){
				$blog_title = isset($car_dealer_options['blog_title']) ? $car_dealer_options['blog_title'] : '' ;
				$blog_subtitle = isset($car_dealer_options['blog_subtitle']) ? $car_dealer_options['blog_subtitle'] : '';
				
				if( $show_on_front == 'posts' ){
					$title = esc_html__( 'Blog', 'cardealer' );
					if( !empty($blog_title) ){
						$title = $blog_title;
					}
					if( !empty($blog_subtitle) ){
						$subtitle = $blog_subtitle;
					}
				}elseif( $show_on_front == 'page' ){
					$page_for_posts_data = get_post($page_for_posts_id);
					$title = $page_for_posts_data->post_title;
					$subtitle_meta = get_post_meta($page_for_posts_id,'subtitle', true);
					if( !empty($subtitle_meta) ){
						$subtitle = $subtitle_meta;
					}elseif( empty($subtitle_meta) && !empty($blog_subtitle) ){
						$subtitle = $blog_subtitle;
					}
				}
			}elseif( is_archive() ){
				if ( is_day() ){
					$title = esc_html__( 'Daily Archives', 'cardealer' );
					$subtitle = sprintf( esc_html__( 'Date: %s', 'cardealer' ), '<span>' . get_the_date() . '</span>' );
				}elseif ( is_month() ){
					$title = esc_html__( 'Monthly Archives', 'cardealer' );
					$subtitle = sprintf( esc_html__('Month: %s', 'cardealer' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'cardealer' ) ) . '</span>' );
				}elseif ( is_year() ){
					$title = esc_html__( 'Yearly Archives', 'cardealer' );
					$subtitle = sprintf( esc_html__( 'Year: %s', 'cardealer' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'cardealer' ) ) . '</span>' );
				}elseif ( is_category() ){
					$title = esc_html__( 'Category Archives', 'cardealer' );
					$subtitle = sprintf( esc_html__( 'Category Name: %s', 'cardealer' ), '<span>' . single_cat_title( '', false ) . '</span>' );
				}elseif ( is_tag() ){
					$title = esc_html__( 'Tag Archives', 'cardealer' );
					$subtitle = sprintf( esc_html__( 'Tag Name: %s', 'cardealer' ), '<span>' . single_tag_title( '', false ) . '</span>' );
				}elseif ( is_author() ){					
					$title = esc_html__('Author Archives', 'cardealer' );
					$subtitle = sprintf( esc_html__( 'Author Name: %s', 'cardealer' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' );
				}elseif(is_archive() && get_post_type()=='post'){
                    $title = esc_html__( 'Archives', 'cardealer' );
                } else{
					$queried_object = get_queried_object();
					
                    if( $queried_object->name == 'cars' ){
                        $page  = get_page_by_path( 'cars' );
                        $page_title = get_the_title( $page );
                        $cars_listing_title = (isset($car_dealer_options['cars-listing-title']))?$car_dealer_options['cars-listing-title']:'';
                        if(isset($page_title) && !empty($page_title)){
                            $title = $page_title;
                        }elseif(isset($cars_listing_title) && !empty($cars_listing_title)){
                            $title = $cars_listing_title;
                        } else {
                            $title =  post_type_archive_title( '', false );
                        }
                    }else {
                        $title =  post_type_archive_title( '', false );
                    }
                }
			}elseif( is_search() ){
				$title = esc_html__( 'Search', 'cardealer' );
				$subtitle = '';
			}elseif( is_404() ){
				$title = esc_html__( '404 error', 'cardealer' );
				$subtitle = '';
			}

            if( function_exists('is_shop')){
				if(is_shop()){
					if(apply_filters('woocommerce_show_page_title' , true)){
						add_filter( 'woocommerce_show_page_title' , 'woo_hide_page_title' );
						function woo_hide_page_title() {
							return false;
						}
					}
				}
			}
			global $cardealer_title, $cardealer_subtitle;
			$cardealer_title = $title;
			$cardealer_subtitle = $subtitle;
			do_action( 'cardealer_before_title' );
			?>
			<div class="row intro-title title-<?php echo esc_attr($title_alignment); ?>">
				<?php
					if( $titlebar_view == 'title_l_bread_r' ) echo '<div class="col-sm-6 text-left">';
					elseif( $titlebar_view == 'bread_l_title_r' ) echo '<div class="col-sm-6 text-right col-sm-push-6">';
					?>
						<h1 class="text-orange"><?php echo esc_html($cardealer_title);?></h1>
						<?php
                        if(isset($cardealer_subtitle) && !empty($cardealer_subtitle)){?>
                            <p class="text-orange">
    						<?php
    							printf (
    								wp_kses(
    									$cardealer_subtitle,
    									array(
    										'span'=> array( 'style'=> array(), 'class'=> array()),
    										'a'=> array( 'href'=> array(), 'class'=> array(), 'title'=> array(), 'rel'=> array())
    									)
    								)
    							);
    						?>
    						</p>
                            <?php
                        }
					if( $titlebar_view == 'title_l_bread_r' ) echo '</div><div class="col-sm-6 text-right">';
					elseif( $titlebar_view == 'bread_l_title_r' ) echo '</div><div class="col-sm-6 text-left col-sm-pull-6">';
				?>
			<?php
			if( function_exists( 'bcn_display_list' )
				&& ( !is_home() || ( is_home() && $show_on_front == 'page' && ( $page_on_front != 0 || $page_on_front == 0 ) ) )
				&& isset( $car_dealer_options['display_breadcrumb'] )
				&& !empty( $car_dealer_options['display_breadcrumb'] )
			){
				?>
    				<ul class="page-breadcrumb <?php echo esc_attr($mobile_breadcrumb_class);?>" typeof="BreadcrumbList" vocab="http://schema.org/">
    					<?php bcn_display_list();?>
    				</ul>
				<?php
			}
			if( $titlebar_view == 'title_l_bread_r' || $titlebar_view == 'bread_l_title_r' ) echo '</div>';
			?>
			</div>
	</div>
</section>