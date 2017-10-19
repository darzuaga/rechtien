<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="blog-entry">
    	<?php 
    	// check if the post has a Post Thumbnail assigned to it.
    	if ( has_post_thumbnail() ) {
    		?>
    		<div class="blog-entry-image hover-direction clearfix blog">    			
				<img alt="" src="<?php the_post_thumbnail_url( 'cardealer-blog-thumb' ) ;?>" class="img-responsive">
    		</div>
    		<?php
    	}
		
		if( !is_single() ) {
    	?>
    	<div class="entry-title">
    		<i class="fa fa-file-text-o"></i> <?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );?>
    	</div>
		<?php
		}
		get_template_part( 'template-parts/entry_meta' );?>
    	
    	<div class="entry-content">
    		<?php
    		if( is_single() ){			
    			the_content();
    			wp_link_pages( array(
    				'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages', 'cardealer' ) . ':</span>',
    				'after'       => '</div>',
    				'link_before' => '<span class="page-number">',
    				'link_after'  => '</span>',
    			) );
    		}else{
    			the_excerpt();
    		}
    		?>
    	</div>
    	
    	<?php get_template_part( 'template-parts/entry_footer' );?>
	</div>
</article><!-- #post-## -->