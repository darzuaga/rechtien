<?php
global $car_dealer_options, $cardealer_header_settings;

do_action( 'cardealer_before_header' );

$cardealer_header_settings = array();
$cardealer_header_settings['header_type']           = 'defualt';

$header_classes = array(
	'defualt'                   => 'defualt',
	'light'                     => 'light',
	'transparent-fullwidth'     => 'transparent-fullwidth',
	'light-fullwidth'           => 'light-fullwidth',
	'logo-center'               => 'logo-center',
	'logo-right'                => 'logo-right',
    'boxed'                     => 'boxed',
);

$header_class = array();

// Header Style
if( isset($car_dealer_options['header_type']) && !empty($car_dealer_options['header_type']) ){
	if( array_key_exists( $car_dealer_options['header_type'], $header_classes ) ){
		$cardealer_header_settings['header_type'] = $car_dealer_options['header_type'];
		$header_class[] = $header_classes[$car_dealer_options['header_type']];
	}else{
		$cardealer_header_settings['header_type'] = 'defualt';
		$header_class[] = 'defualt';
	}
}else{
	$header_class[] = 'transparent';
	$cardealer_header_settings['header_type'] = 'defualt';
}
if(isset($car_dealer_options['header_color_settings']) && $car_dealer_options['header_color_settings'] == 'default')
	$header_class[] = 'default-header';

$header_class = implode(' ', $header_class);
?>
<header id="header" class="<?php echo esc_attr($header_class);?>">
	<?php
	do_action('cardealer_before_header_inner');
	get_template_part('template-parts/header/header_type/'.$cardealer_header_settings['header_type']);
	do_action('cardealer_after_header_inner');
	?>
</header>
<?php do_action('cardealer_after_header');?>