<article id="post-<?php the_ID(); ?>" <?php post_class('entry-content'); ?>>    
	<?php
    the_content( sprintf(
		wp_kses( __( 'Continue reading <span class="screen-reader-text">"%s"</span>', 'cardealer' ), array( 'span' => array( 'class' => array(), ), ) ),
		get_the_title()
	) );	
	?>
</article><!-- #post -->
