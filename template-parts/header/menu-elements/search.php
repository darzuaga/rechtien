<?php
global $cardealer_options;

$search_placeholder_text= ( isset($cardealer_options['search_placeholder_text']) ) ? $cardealer_options['search_placeholder_text'] : esc_html__('Search...', 'cardealer');
$search_content_type    = ( isset($cardealer_options['search_content_type']) ) ? $cardealer_options['search_content_type'] : 'all';
?>
<form role="search" method="get" id="menu-searchform" name="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) );?>">
	<div class="search">
		<a class="search-btn not_click" href="javascript:void(0);"> </a>
		<div class="search-box not-click">
			<input type="text" value="<?php echo esc_attr(get_search_query());?>" name="s" id="menu-s"  placeholder="<?php echo esc_attr($search_placeholder_text);?>" class="not-click"/>
			<i class="fa fa-search"></i>
            <div class="cardealer-auto-compalte"><ul></ul></div>            
		</div>
	</div>
	<?php
	if( $search_content_type != 'all' ){
		?>
		<input type="hidden" name="post_type" value="<?php echo esc_attr($search_content_type);?>"/>
		<?php
	}
	?>
</form>