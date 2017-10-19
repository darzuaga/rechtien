<?php
global $car_dealer_options;

if( ( isset($car_dealer_options['show_footer_bottom']) && $car_dealer_options['show_footer_bottom'] == 'yes' ) ) { 
?>
	<div class="row">
		<?php 
			if(is_active_sidebar('sidebar-footer-5'))
				dynamic_sidebar('sidebar-footer-5');
		?>
	</div>
<?php 
} 
?>