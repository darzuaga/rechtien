<article id="post-<?php the_ID(); ?>" <?php post_class('entry-content'); ?>>    
	<?php
	the_content( sprintf(
		wp_kses( __( 'Continue reading <span class="screen-reader-text">"%s"</span>', 'cardealer' ), array( 'span' => array( 'class' => array(), ), ) ),
		get_the_title()
	) );
	wp_link_pages( array(
		'before'    => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages', 'cardealer' ) . ':</span>',
		'after'     => '</div>',
		'link_before' => '<span class="page-number">',
		'link_after'  => '</span>',
	) );
	?>
</article><!-- #post -->
