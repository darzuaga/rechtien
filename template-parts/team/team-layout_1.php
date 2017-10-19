<section class="our-team white-bg page-section-ptb">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="section-title">
         <span><?php esc_html_e('List of people who matter in our Company','cardealer');?></span>
         <h2><?php esc_html_e('Our team','cardealer');?></h2>
         <div class="separator"></div>
      </div>
      </div>
    </div>
      <div class="row">
      <?php
			
            $args=array('post_type'=>'teams','posts_per_page' => -1,'post_status'=>'publish');
            $teams_query = new WP_Query( $args );                
            if ( $teams_query->have_posts() ) {               	
            	while ( $teams_query->have_posts() ) {
            		$teams_query->the_post();
                    $facebook=get_post_meta(get_the_ID(),'facebook',true);
        			$twitter=get_post_meta(get_the_ID(),'twitter',true);
        			$pinterest=get_post_meta(get_the_ID(),'pinterest',true);
        			$behance=get_post_meta(get_the_ID(),'behance',true);
        			?>
                        <div class="col-lg-3 col-md-3 col-sm-6">
                            <div class="team text-center">
                                <div class="team-image"> 
                                    <?php the_post_thumbnail('cardealer-team-thumb',array('class'=>'img-responsive icon')); ?>
                                    <div class="team-social"> 
                                        <ul>
                                        	<?php if($facebook):?>
                    							<li><a class="icon-1" href="<?php echo esc_url($facebook);?>"><i class="fa fa-facebook"></i></a></li>
                    						<?php endif;?>
                    						<?php if($twitter):?>
                    							<li><a class="icon-2" href="<?php echo esc_url($twitter);?>"><i class="fa fa-twitter"></i></a></li>
                    						<?php endif;?>
                    						<?php if($pinterest):?>
                    							<li><a class="icon-3" href="<?php echo esc_url($pinterest);?>"><i class="fa fa-pinterest-p"></i></a></li>
                    						<?php endif;?>
                    						<?php if($behance):?>
                    							<li><a class="icon-4" href="<?php echo esc_url($behance);?>"><i class="fa fa-behance"></i></a></li>
                    						<?php endif;?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="team-name">
                                    <h5 class="text-black"><?php the_title(); ?></h5>
                                    <span class="text-black"><?php echo get_post_meta(get_the_ID(),'designation',true); ?></span>
                                </div>
                            </div>
                        </div>
        			<?php 
                }
                wp_reset_postdata();
            }
			?>       
      </div> 
    </div>
</section> 