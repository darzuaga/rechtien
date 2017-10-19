<?php
/*
 * Single Team Page Template
 */
get_header(); ?>

<?php get_template_part('template-parts/content','intro'); ?>

<?php
while ( have_posts() ) : the_post();
	$facebook  = get_post_meta(get_the_ID(),'facebook',true);
	$twitter   = get_post_meta(get_the_ID(),'twitter',true);
	$dribbble  = get_post_meta(get_the_ID(),'dribbble',true);
	$vimeo     = get_post_meta(get_the_ID(),'vimeo',true);
	$pinterest = get_post_meta(get_the_ID(),'pinterest',true);
	$behance   = get_post_meta(get_the_ID(),'behance',true);
	$linkedin  = get_post_meta(get_the_ID(),'linkedin',true);
	?>
	<section class="our-team white-bg page-section-pt">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-md-4 col-sm-4">
					<?php the_post_thumbnail('cardealer-team-thumb',array('class'=>'img-responsive')); ?>			
				</div>
				<div class="col-lg-8 col-md-8 col-sm-8">
					<div class="custom-content-4">
						<div class="clearfix">
							<div class="title pull-left">
								<h2 class="text-blue"><?php the_title(); ?></h2>
								<span><?php echo get_post_meta(get_the_ID(),'designation',true); ?></span>
							</div>
							<div class="social">
								<ul>
									<?php if($facebook):?>
										<li><a href="<?php echo esc_url($facebook);?>"><i class="fa fa-facebook"></i> </a></li>
									<?php endif;?>
									<?php if($twitter):?>
										<li><a href="<?php echo esc_url($twitter);?>"><i class="fa fa-twitter"></i> </a></li>
									<?php endif;?>
									<?php if($dribbble):?>
										<li><a href="<?php echo esc_url($dribbble);?>"><i class="fa fa-dribbble"></i> </a></li>
									<?php endif;?>
									<?php if($vimeo):?>
										<li><a href="<?php echo esc_url($vimeo);?>"><i class="fa fa-vimeo"></i> </a></li>
									<?php endif;?>
									<?php if($pinterest):?>
										<li><a href="<?php echo esc_url($pinterest);?>"><i class="fa fa-pinterest-p"></i> </a></li>
									<?php endif;?>
									<?php if($behance):?>
										<li><a href="<?php echo esc_url($behance);?>"><i class="fa fa-behance"></i> </a></li>
									<?php endif;?>
									<?php if($linkedin):?>
										<li><a href="<?php echo esc_url($linkedin);?>"><i class="fa fa-linkedin"></i> </a></li>
									<?php endif;?>
								</ul>
							</div>
						</div>
						<div class="clearfix">
							<?php the_content(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<?php
	if(function_exists('have_rows')){
		?>
		<section class="our-activities page-section-pt">
			<div class="container">
				<div class="row">		
					<div class="col-sm-6">
						<?php
						if( have_rows('skills') ) {
							$skills_title = get_post_meta(get_the_ID(),'skills_title',true);
							if( empty( $skills_title ) ){
								$skills_title = esc_html__('Powerful Skills','cardealer');
							}
							?>
							<!-- Powere Ful Skills-->
							<div class="skills-2">
								<h3><?php echo esc_html($skills_title);?></h3>
								<ul>
									<?php
									while( have_rows('skills') ) {
										the_row();
										
										// vars
										$skill = get_sub_field('skill');
										$percent = get_sub_field('percent');
										if( ! empty( $skill ) && ! empty( $percent ) ){
											?>
											<li>
												<?php echo esc_html($skill);?>
												<div class="bar_container">
													<span data-bar="{ &quot;color&quot;: &quot;#00a9da&quot; }" class="bar" style="background-color: rgb(0, 169, 218); width: <?php echo esc_attr($percent);?>%;">
														<span class="pct" style="color: rgb(0, 169, 218); opacity: 1;"><?php echo esc_attr($percent)."%";?></span>
													</span>
												</div>
											</li>
											<?php
										}
									}
									?>
								</ul>
							</div>
							<?php
						}
						?>
					</div>
					<div class="col-sm-6">
						<?php
						if( have_rows('expertises') ) {
							$expertise_title = get_post_meta(get_the_ID(),'expertise_title',true);
							if( empty( $expertise_title ) ){
								$expertise_title = esc_html__('Areas of Expertise','cardealer');
							}
							?>
							<div class="team-expertise">
								<h3><?php echo esc_html($expertise_title);?></h3>
								<ul>
									<?php
									while( have_rows('expertises') ) {
										the_row();
										
										// vars
										$expertise = get_sub_field('expertise');
										if( ! empty( $skill ) && ! empty( $percent ) ){
											?>
											<li><?php echo esc_html($expertise);?></li>
											<?php
										}
									}
									?>
								</ul>
							</div>
							<?php
						}
						?>
					</div>
				</div>
			</div>
		</section>
		<?php
	}
	/* check have_rows function exists*/
	
endwhile; // end of the loop.
?>

<?php get_footer(); ?>