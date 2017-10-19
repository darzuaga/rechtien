<?php global $car_dealer_options, $cardealer_header_settings;?>
<!-- .site-header-main -->
<div class="site-header-main mega-menu">
	<div class="<?php echo ( $cardealer_header_settings['header_width'] == 'container' ? 'container' : 'container-fluid' );?>">
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="site-branding">
					<div class="site-title">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
							<img class="logo-type-default" src="<?php echo esc_url(cardealer_get_site_logo());?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"/>
							<img class="logo-type-sticky" src="<?php echo esc_url(cardealer_get_site_sticky_logo());?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"/>
						</a>
					</div>
				</div>
				<div class="site-header-menu menu-links">
					<?php
					if($cardealer_header_settings['header_style'] == 'hamburger'){
						?>
						<div id="hamburger_menu_toggle">
							<div id="hamburger_menu_icon">
								<span></span>
								<span></span>
								<span></span>
								<span></span>
								<span></span>
								<span></span>
							</div>
						</div>
						<?php
					}else{
						?>
						<nav id="site-navigation" class="main-navigation mega-menu">
							<?php cardealer_primary_menu();?>
						</nav>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>