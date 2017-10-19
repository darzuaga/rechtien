<?php get_template_part('template-parts/header/topbar');?>
<?php global $car_dealer_options;?>
<div class="menu">  
	<!-- menu start -->
	<nav id="menu-1" class="mega-menu">
		<!-- menu list items container -->
		<div class="menu-list-items">
			<div class='menu-inner'>
				<div class="container"> 
					<div class="row"> 
						<!-- menu links -->
						<div class="col-lg-12 col-md-12"> 
							<ul class="menu-logo">
								<li>
									<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
										<?php
										// site-logo
										if( wp_is_mobile()  ) {
											if( isset( $car_dealer_options['logo_type'] ) && $car_dealer_options['logo_type'] == 'image' && !empty( $car_dealer_options['mobile_logo_img']['url'] ) && $car_dealer_options['show_mobile_logo'] ==  'yes') {
											?>
												<img class="site-logo" src="<?php echo esc_url($car_dealer_options['mobile_logo_img']['url']);?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"/>
												<?php
											}
											else if( isset( $car_dealer_options['logo_type'] ) && $car_dealer_options['logo_type'] == 'image' && !empty($car_dealer_options['logo_image']['url'])) {
												?>
												<img class="site-logo" src="<?php echo esc_url($car_dealer_options['logo_image']['url']);?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"/>
												<?php
											}
											else if( isset( $car_dealer_options['logo_type'] ) && $car_dealer_options['logo_type'] == 'text' && !empty( $car_dealer_options['logo_text'] ) ) {
												?>
												<span class="site-logo logo-text"><?php echo esc_html($car_dealer_options['logo_text']); ?></span>
												<?php
											}
											else{
												?>
												<span class="site-logo logo-text"><?php bloginfo( 'name' );?></span>
												<?php
											}
										}else {
											if( isset( $car_dealer_options['logo_type'] ) && $car_dealer_options['logo_type'] == 'image' && !empty( $car_dealer_options['logo_image']['url'] ) ) {
												?>
												<img class="site-logo" src="<?php echo esc_url($car_dealer_options['logo_image']['url']);?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"/>
												<?php
											}
											else if( isset( $car_dealer_options['logo_type'] ) && $car_dealer_options['logo_type'] == 'text' && !empty( $car_dealer_options['logo_text'] ) ) {
												?>
												<span class="site-logo logo-text"><?php echo esc_html($car_dealer_options['logo_text']); ?></span>
												<?php
											}
											else{
												?>
												<span class="site-logo logo-text"><?php bloginfo( 'name' );?></span>
												<?php
											}
										}
										// stickey-logo
										if( wp_is_mobile()  ) {
											if( isset( $car_dealer_options['logo_type'] ) && $car_dealer_options['logo_type'] == 'image' && !empty( $car_dealer_options['mobile_sticky_logo_img']['url'] ) && $car_dealer_options['show_mobile_logo'] ==  'yes') {
												?>
												<img class="sticky-logo" src="<?php echo esc_url($car_dealer_options['mobile_sticky_logo_img']['url']);?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"/>
												<?php
											}
											else if( isset( $car_dealer_options['logo_type'] ) && $car_dealer_options['logo_type'] == 'image' && !empty($car_dealer_options['sticky_logo_img']['url'])) {
												?>
												<img class="sticky-logo" src="<?php echo esc_url($car_dealer_options['sticky_logo_img']['url']);?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"/>
												<?php
											}
											else if( isset( $car_dealer_options['logo_type'] ) && $car_dealer_options['logo_type'] == 'image' && !empty($car_dealer_options['logo_image']['url'])) {
												?>
												<img class="sticky-logo" src="<?php echo esc_url($car_dealer_options['logo_image']['url']);?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"/>
												<?php
											}
											else if( isset( $car_dealer_options['logo_type'] ) && $car_dealer_options['logo_type'] == 'text' && !empty( $car_dealer_options['logo_text'] ) ) {
												?>
												<span class="sticky-logo sticky-logo-text"><?php echo esc_html($car_dealer_options['logo_text']); ?></span>
												<?php
											}
											else{
												?>
												<span class="sticky-logo sticky-logo-text"><?php bloginfo( 'name' );?></span>
												<?php
											}
										} 
										else {
											if( isset( $car_dealer_options['logo_type'] ) && $car_dealer_options['logo_type'] == 'image' && !empty( $car_dealer_options['sticky_logo_img']['url'] ) ) {
												?>
												<img class="sticky-logo" src="<?php echo esc_url($car_dealer_options['sticky_logo_img']['url']);?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"/>
												<?php
											} else if ( isset( $car_dealer_options['logo_type'] ) && $car_dealer_options['logo_type'] == 'image' && !empty( $car_dealer_options['logo_image']['url'] ) ){
												?>
												<img class="sticky-logo" src="<?php echo esc_url($car_dealer_options['logo_image']['url']);?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"/>
												<?php
											} else if( isset( $car_dealer_options['logo_type'] ) && $car_dealer_options['logo_type'] == 'text' && !empty( $car_dealer_options['logo_text'] ) ) {
												?>
												<span class="sticky-logo sticky-logo-text"><?php echo esc_html($car_dealer_options['logo_text']); ?></span>
												<?php
											} else {
												?>
												<span class="sticky-logo sticky-logo-text"><?php bloginfo( 'name' );?></span>
												<?php
											}
											
										}
										?>
									</a>
									<?php
									$description = get_bloginfo( 'description', 'display' );
									$site_description = ( isset($car_dealer_options['site_description']) )? $car_dealer_options['site_description'] : 0;
									if ( ($site_description && $description) || ($site_description && is_customize_preview()) ) : ?> 
										<p class="site-description"><?php echo esc_attr($description); /* WPCS: xss ok. */ ?></p>
									<?php endif; 
									/* Mobile view icons */
									if(wp_is_mobile()){
									?>
									<div class="mobile-icons-trigger">
								    <?php
                                    $show_search = ( isset($car_dealer_options['show_search']) )? $car_dealer_options['show_search'] : 1;
                                    $show_cart   = ( isset($car_dealer_options['cart_icon']) ) ? $car_dealer_options['cart_icon'] : 'yes';
                                	if( $show_search == 1 ){
                                		?>
                                		<div class="mobile-searchform-wrapper">
                                			<div class="search">
												<a class="search-btn not_click" href="javascript:void(0);"> </a>
											</div>
                                		</div>
                                		<?php
                                	}
                                	if( $show_cart == 'yes' ){
                                		?>
                                		<div class="mobile-cart-wrapper">
                                			<?php get_template_part('woocommerce/minicart-ajax' );?>
                                		</div>
                                		<?php
                                	}
									?>
										<div class="menu-item menu-item-compare" <?php if(!isset($_COOKIE['cars']) || empty($_COOKIE['cars'])) { ?> style="display:none" <?php }?>>
											<a class="" href="javascript:void(0)">
												<span class="compare-items">
													<i class="fa fa-exchange"></i>
												</span>
												<span class="compare-details count">0</span>
											</a>
										</div>
									</div>
									<?php get_template_part('template-parts/header/menu-elements/search-mobile' ); 
										// WooCommerce
										if ( class_exists( 'woocommerce' ) ) {
										?>
										<div class="widget_shopping_cart_content hidden-xs">
											<?php 
												ob_start();
												woocommerce_mini_cart();
												$mini_cart = ob_get_clean();
												echo $mini_cart;
											?>
										</div>
									<?php
										}
									}
									?>
								</li>
							</ul>
							<!-- menu links -->
							<?php cardealer_primary_menu();?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</nav>
	<!-- menu end -->
</div>