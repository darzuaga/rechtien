<?php global $car_dealer_options;

if( is_single() ){
	$blog_metas = isset($car_dealer_options['single_metas']) ? $car_dealer_options['single_metas'] : '';
	if( empty($blog_metas) ){
		$blog_metas = array (
			'date'      => '1',
			'author'    => '1',
			'categories'=> '1',
			'tags'      => '1',
			'comments'  => '1',
		);
	}
}else{
	$blog_metas = isset($car_dealer_options['blog_metas']) ? $car_dealer_options['blog_metas'] : '' ;
	if( empty($blog_metas) ){
		$blog_metas = array (
			'date'      => '1',
			'author'    => '1',
			'categories'=> '1',
			'tags'      => '1',
			'comments'  => '1',
		);
	}
}
?>
<div class="entry-meta">
	<?php
    if(!empty($blog_metas))
        echo "<ul>";
	foreach( $blog_metas as $blog_meta_k => $blog_meta_v ){
		if( $blog_meta_k == 'author' && !empty($blog_meta_v) ){
			echo sprintf( '<li><span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author"><i class="fa fa-user"></i> %3$s</a></span></li>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_attr( sprintf( esc_html__( 'View all posts by %s', 'cardealer' ), get_the_author() ) ),
				get_the_author()
			);
		}
		if( $blog_meta_k == 'comments' && !empty($blog_meta_v) && comments_open() ){
		      echo "<li>";
			comments_popup_link( '<i class="fa fa-comments-o"></i> <span class="leave-comment">'.esc_html__( 'No comments', 'cardealer' ).'</span>', '<i class="fa fa-comments-o"></i> <span class="leave-comment">'.esc_html__( '1 Comment', 'cardealer' ).'</span>', '<i class="fa fa-comments-o"></i> <span class="leave-comment">'.esc_html__( '% Comments', 'cardealer' ).'</span>' );
            echo "</li>";
		}
		
		$category_list_args = array(
			'sep'    => ', ',
			'after'  => '',
		);
		$category_list = get_the_category_list( trim( $category_list_args['sep'] ) . ' ' );
		if( $blog_meta_k == 'categories' && !empty($blog_meta_v) && !empty($category_list) ){
			?>
			<li><span class="entry-meta-categories"><i class="fa fa-folder-open"></i>&nbsp;<?php echo $category_list;?></span></li>
			<?php
		}
		
		if( $blog_meta_k == 'tags' && !empty($blog_meta_v) ){
			echo '<li><span class="entry-meta-tags">'.get_the_tag_list( '<i class="fa fa-tags"></i>', ', ' ).'</span></li>';
		}
		if( $blog_meta_k == 'date' && !empty($blog_meta_v) ){
			echo sprintf( '<li><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s"><i class="fa fa-calendar"></i> %4$s</time></a></li>',
				esc_url( get_permalink() ),
				esc_attr( get_the_time() ),
				esc_attr( get_the_date( 'c' ) ),
				esc_html( get_the_date() )
			);
		}
	}
    if(!empty($blog_metas))
        echo "</ul>";
	edit_post_link( '<i class="fa fa-pencil"></i> ' . esc_html__( 'Edit', 'cardealer' ), '', '' );
	?>
</div>