<?php
/**
 * 
 * */
 global $car_dealer_options;
if(isset($car_dealer_options['print_status']) && !$car_dealer_options['print_status']){
    return;
}
 ?>
<li id="cardealer-print-btn"><a href="#"><i class="fa fa-print"></i><?php echo esc_html__('Print', 'cardealer');?></a></li>