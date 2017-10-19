<?php
if( !function_exists('cardealer_single_nav') ){
function cardealer_single_nav(){
	$prev_post = get_previous_post();
	$next_post = get_next_post();
	?>
	<div class="port-navigation clearfix">
		<?php
		if (!empty( $prev_post )){
			if( has_post_thumbnail($prev_post->ID) ){
				$prev_post_thumb_data   = wp_get_attachment_image_src( $prev_post_thumb_id = get_post_thumbnail_id( $prev_post->ID ), 'cardealer-post_nav' );
				$prev_post_thumb_url    = $prev_post_thumb_data['0'];
			}
			?>
			<div class="port-navigation-left pull-left">
				<div class="tooltip-content-3" data-original-title="<?php echo esc_attr($prev_post->post_title);?>" data-toggle="tooltip" data-placement="right">
					<a href="<?php echo esc_url(get_permalink( $prev_post->ID )); ?>">
						<div class="port-photo pull-left">
							<?php if( has_post_thumbnail($prev_post->ID) ): ?>
								<img src="<?php echo esc_url($prev_post_thumb_url);?>" alt="<?php echo esc_attr(get_the_title($prev_post->ID));?>">
							<?php else:
								echo esc_html__('Previous Post','cardealer');
							endif;?>
						</div>
						<div class="port-arrow">
							<i class="fa fa-angle-left"></i>
						</div>
					</a>
				</div>
			</div>
			<?php
		}
		if (!empty( $next_post )){
			if( has_post_thumbnail($next_post->ID) ){
				$next_post_thumb_id = get_post_thumbnail_id( $next_post->ID );
				$next_post_thumb_data   = wp_get_attachment_image_src( $next_post_thumb_id = get_post_thumbnail_id( $next_post->ID ), 'cardealer-post_nav' );
				$next_post_thumb_url    = $next_post_thumb_data['0'];
			}
			?>
			<div class="port-navigation-right pull-right">
				<div class="tooltip-content-3" data-original-title="<?php echo esc_attr($next_post->post_title);?>" data-toggle="tooltip" data-placement="left">
					<a href="<?php echo esc_url(get_permalink( $next_post->ID )); ?>">
						<div class="port-arrow pull-left">
							<i class="fa fa-angle-right"></i>
						</div>
						<div class="port-photo">
							<?php if( has_post_thumbnail($next_post->ID) ):?>
								<img src="<?php echo esc_url($next_post_thumb_url);?>" alt="<?php echo esc_attr(get_the_title($next_post->ID));?>">
							<?php else:
								echo esc_html__('Next Post','cardealer');
							endif; ?>
						</div>
					</a>
					<div class="clearfix"></div>
				</div>
			</div>
			<?php
		}
		?>
	</div>
	<?php
}
}

// Bootstrap pagination function
function cardealer_wp_bs_pagination($pages = '', $range = 4){
	$showitems = ($range * 2) + 1;
	global $paged;
	if(empty($paged)) $paged = 1;
	if($pages == ''){
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if(!$pages){
			$pages = 1;
		}
	}

	if(1 != $pages){
        echo '<div class="text-center">';
        echo '<nav><ul class="pagination">';
		if($paged > 1) echo "<li><a href='".esc_url(get_pagenum_link($paged - 1))."' aria-label='Previous'>&laquo;<span class='hidden-xs'> </span></a></li>";

		for ($i=1; $i <= $pages; $i++)
		{
			if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
			{
				echo ($paged == $i)? "<li class=\"active\"><span>".$i." <span class=\"sr-only\">(current)</span></span>
    </li>":"<li><a href='".esc_url(get_pagenum_link($i))."'>".$i."</a></li>";
			}
		}

		if ($paged < $pages) echo "<li><a href=\"".esc_url(get_pagenum_link($paged + 1))."\"  aria-label='Next'><span class='hidden-xs'> </span>&raquo;</a></li>";
		
		echo "</ul></nav>";
		echo "</div>";
	}
}

function cardealer_footer_copyright(){
	global $car_dealer_options;
	$footer_copyright = sprintf( wp_kses( __( 'Copyright &copy; <span class="copy_year">%1$s</span>, <a href="%2$s" title="%3$s">%4$s</a> All Rights Reserved.', 'cardealer' ), array(
				'a'     => array(
					'href'  => array(),
					'title' => array(),
					'class' => array(),
					'target'=> array(),
				),
				'br'    => array(),
				'em'    => array(),
				'strong'=> array(),
				'span'  => array(
					'class' => array(),
				),
			)
		),
		date('Y'),
		esc_url( home_url( '/' ) ),
		esc_attr( get_bloginfo( 'name', 'display' ) ),
		esc_html( get_bloginfo( 'name', 'display' ) )
	);
	
	if( isset( $car_dealer_options['footer_copyright'] ) && !empty( $car_dealer_options['footer_copyright'] ) ){
		$footer_copyright = $car_dealer_options['footer_copyright'];
		$footer_copyright = do_shortcode( $footer_copyright );
	}
	
	// Filter before copyright content
	$footer_copyright_before = apply_filters( 'cardealer_footer_copyright_before', '' );
	
	// Filter after copyright content
	$footer_copyright_after = apply_filters( 'cardealer_footer_copyright_after', '' );
	
	$footer_copyright = $footer_copyright_before . $footer_copyright . $footer_copyright_after;
	
	echo $footer_copyright;
}