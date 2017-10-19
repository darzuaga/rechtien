<?php
/**
 * 
 * */
global $car_dealer_options;
if( !isset($car_dealer_options['pdf_brochure_status']) || $car_dealer_options['pdf_brochure_status'] != 1 ){
    return;
}
  
$file_id = get_post_meta(get_the_ID(), 'pdf_file', $single = true);
if(!isset($file_id) || empty($file_id)){
    return;
} 
if(!wp_attachment_is( 'pdf', $file_id )){
    return;    
}    
$pdf_file_url = wp_get_attachment_url( $file_id ); 
?>
<li><a href="<?php echo esc_url($pdf_file_url)?>" download><i class="fa fa-file-pdf-o"></i><?php echo esc_html__('PDF Brochure', 'cardealer');?></a></li>