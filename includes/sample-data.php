<?php
add_filter( 'cardealer_helper_sample_data_description', 'cardealer_sample_data_descriptions' );
function cardealer_sample_data_descriptions( $description ){
	
	$description .= '<p>' . wp_kses( __( 'You can import pre-defined sample data, as shown on our demo site, from here.', 'cardealer' ),
		array(
			'br'    => array(),
			'strong'=> array(
				'style' => array(),
			),
		)
	) . '</p>';
	
	$description .= '<p>' . wp_kses( __( '<strong style="color:#000">Note</strong>: All pre-defined sample pages are configured using existing data. So, some of the shortcodes will not work if relative data is missing. For example, if testimonials data is not imported/added, testimonials shortcode will not work. So, please ensure all required data is imported/added successfully.', 'cardealer' ),
		array(
			'br'    => array(),
			'strong'=> array(
				'style' => array(),
			),
		)
	) . '</p>';
	
	return $description;
}
?>