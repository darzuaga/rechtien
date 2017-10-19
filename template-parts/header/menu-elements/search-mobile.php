<?php
global $cardealer_options;

$search_placeholder_text= ( isset($cardealer_options['search_placeholder_text']) ) ? $cardealer_options['search_placeholder_text'] : esc_html__('Search...', 'cardealer');
$search_content_type    = ( isset($cardealer_options['search_content_type']) ) ? $cardealer_options['search_content_type'] : 'all';
?>
<form role="search" method="get" id="mobile-searchform" name="searchform"  class="searchform" action="<?php echo esc_url( home_url( '/' ) );?>">
	<div class="search">
		<div class="search-box not-click">
			<input type="text" value="<?php echo esc_attr(get_search_query());?>" name="s" id="mobile-menu-s"  placeholder="<?php echo esc_attr($search_placeholder_text);?>" class="not-click"/>            
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