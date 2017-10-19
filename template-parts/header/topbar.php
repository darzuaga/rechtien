<?php
global $car_dealer_options, $cardealer_header_settings; 
$topbar_layout = isset($car_dealer_options['topbar_layout_data']) ? $car_dealer_options['topbar_layout_data'] : ''; 
$topbar_layout_left = '';
$topbar_layout_right = '';

if(wp_is_mobile()) {
	// Script to disable Top Bar in Mobile if disabled from Admin
	if( !isset( $car_dealer_options['top_bar'] ) || ($car_dealer_options['top_bar'] != true) || !isset( $car_dealer_options['top_bar_mobile'] ) || ($car_dealer_options['top_bar_mobile'] != true ) )
		return;
} else {
	// Script to disable Top Bar in Desktop if disabled from Admin
	if( !isset( $car_dealer_options['top_bar'] ) || ( $car_dealer_options['top_bar'] != true ) )
		return;
}


if( isset($topbar_layout['Left']) && !empty($topbar_layout['Left']) && is_array($topbar_layout['Left']) ){
	foreach( $topbar_layout['Left'] as $topbar_layout_k => $topbar_layout_v){
		$topbar_layout_content = cardealer_layout_content($topbar_layout_k, 'topbar');
		
		$topbar_item_classes = array();
		$topbar_item_classes[] = 'topbar_item';
		$topbar_item_classes[] = 'topbar_item_type-'.$topbar_layout_k;
		$topbar_item_classes = implode(' ', $topbar_item_classes);
		
		if( !empty($topbar_layout_content) ){
			$topbar_layout_left .= '<li class="'.$topbar_item_classes.'">';
			$topbar_layout_left .= $topbar_layout_content;
			$topbar_layout_left .= '</li>';
		}
	}
}
if( isset($topbar_layout['Right']) && !empty($topbar_layout['Right']) && is_array($topbar_layout['Right']) ){
	foreach( $topbar_layout['Right'] as $topbar_layout_k => $topbar_layout_v){
		$topbar_layout_content = cardealer_layout_content($topbar_layout_k, 'topbar');
		
		$topbar_item_classes = array();
		$topbar_item_classes[] = 'topbar_item';
		$topbar_item_classes[] = 'topbar_item_type-'.$topbar_layout_k;
		$topbar_item_classes = implode(' ', $topbar_item_classes);
		
		if( !empty($topbar_layout_content) ){
			$topbar_layout_right .= '<li class="'.$topbar_item_classes.'">';
			$topbar_layout_right .= $topbar_layout_content;
			$topbar_layout_right .= '</li>';
		}
	}
}
if( !empty($topbar_layout_left) || !empty($topbar_layout_right) ){
?>
	<div class="topbar">
		<div class="<?php echo ( ($cardealer_header_settings['header_type'] == 'light-fullwidth' || $cardealer_header_settings['header_type'] == 'transparent-fullwidth') ) ? 'container-fluid' : 'container';?>">
			<div class="row">
				<div class="col-lg-6 col-sm-6">
					<?php					
					if( !empty($topbar_layout_left) ){
						?>
						<div class="topbar-left text-left">
							<ul class="list-inline">
								<?php echo $topbar_layout_left;?>
							</ul>
						</div>
						<?php
					}
					?>
				</div>
				<div class="col-lg-6 col-sm-6">
					<?php					
					if( !empty($topbar_layout_right) ){
						?>
						<div class="topbar-right text-right">
							<ul class="list-inline">
								<?php echo $topbar_layout_right;?>
							</ul>
						</div>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<?php
}