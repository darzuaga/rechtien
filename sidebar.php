<?php
if ( is_active_sidebar( 'sidebar-default' ) ){
	dynamic_sidebar( 'sidebar-default' );
}else{
	if( current_user_can('administrator') ){
		?>
		<span><?php echo sprintf( wp_kses( __( 'No widgets added in default sidebar.<br>Click <a href="%s">here</a> to add widgets.', 'cardealer' ),
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