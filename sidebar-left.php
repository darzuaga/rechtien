<?php
if ( is_active_sidebar( 'sidebar-left' ) ){
	dynamic_sidebar( 'sidebar-left' );
}else{
	if( current_user_can('administrator') ){
		?>
		<span><?php echo sprintf( wp_kses( __( 'No widgets added in left sidebar.<br>Click <a href="%s">here</a> to add widgets.', 'cardealer' ),
				array(
					'a' => array(
						'class' => array(),
						'href'  => array(),
					),
					'br' => array(),
				)
			),
			admin_url('widgets.php')
		);
		?></span><?php
	}else{
		echo esc_html__('No widgets founds.', 'cardealer');
	}
}
?>
<span></span> 