<?php
//get the FAQ type
$pgs_faq_type =  get_post_meta(get_the_ID(),'faq_type',true);
$pgs_faq_type = (empty($pgs_faq_type)) ? 'all' : $pgs_faq_type;
$faq_page_query_base = array(
	'post_type'      => 'faqs',
	'posts_per_page' => -1
);

$faq_categories = get_terms( array(
	'taxonomy'  => 'faq-category',
	'hide_empty'=> true,
	'fields'    => 'ids',
));

if($pgs_faq_type!='all')
	$faq_categories_selected=get_post_meta(get_the_ID(),'select_category',true);

$faq_categories = ( $pgs_faq_type == 'all' ? $faq_categories : $faq_categories_selected );
$faq_page_query_all_tab_taxquery = array(
	'tax_query' => array(
		array(
			'taxonomy' => 'faq-category',
			'field'    => 'term_id',
			'terms'    => $faq_categories,
		),
	)
);

$faq_page_tabs_data_all_tab_query = array_merge($faq_page_query_base, $faq_page_query_all_tab_taxquery);

if($pgs_faq_type=='all'){
	$faq_page_tabs_data[] = array(
		'slug'  => 'all',
		'title' => 'All',
		'query' => $faq_page_tabs_data_all_tab_query,
	);
}
$faq_page_query_term_taxquery = array();$pgs_category_count=0;
if(isset($faq_categories) && !empty($faq_categories)){
    foreach( $faq_categories as $faq_category ){
    	$faq_category_data = get_term_by( 'id', $faq_category, 'faq-category' );
    	if( isset($faq_category_data->term_id) && !empty($faq_category_data->term_id)){
    		$faq_page_query_term_taxquery = array(
    			'tax_query' => array(
    				array(
    					'taxonomy' => 'faq-category',
    					'field'    => 'term_id',
    					'terms'    => array($faq_category_data->term_id),
    				),
    			)
    		);
    		
    		$faq_page_tabs_data[] = array(
    			'slug'  => 'term_'.$faq_category_data->term_id,
    			'title' => $faq_category_data->name,
    			'query' => array_merge($faq_page_query_base, $faq_page_query_term_taxquery)
    		);
    		$pgs_category_count=count($faq_page_tabs_data);
    	}
    }
}
?>
<div id="tabs" class="tabs_wrapper">
	<?php if($pgs_category_count > 1 || $pgs_faq_type=='all') { ?>
	<ul class="tabs text-center">
		<?php
		$faq_page_query_tab_sr = 1;
		foreach( $faq_page_tabs_data as $faq_page_query ){
			?>
			<li data-tabs="tab_<?php echo esc_attr($faq_page_query['slug']);?>" class="<?php echo ( $faq_page_query_tab_sr == 1 ? 'active' : '' );?>"><span aria-hidden="true"></span><?php echo esc_html($faq_page_query['title']);?></li>
			<?php
			$faq_page_query_tab_sr++;
		}
		?>
	</ul>
	<?php } ?>
	<?php
	$faq_page_query_tab_sr = 1;
    if(isset($faq_page_tabs_data) && !empty($faq_page_tabs_data)){
    	foreach( $faq_page_tabs_data as $faq_page_query ){
    		?>
    		<div id="tab_<?php echo esc_attr($faq_page_query['slug']);?>" class="tabcontent accordion">
    			<?php    			
                // The Query
                $faq_query = new WP_Query( $faq_page_query['query'] );                
                if ( $faq_query->have_posts() ) {               	
                	while ( $faq_query->have_posts() ) {
                		$faq_query->the_post();                		
                        ?>
						<div class="accordion-title">
							<a href="#"><?php the_title(); ?></a>
						</div>
						<div class="accordion-content"> 
							<?php the_content(); ?>							
						</div>
						<?php
                    }                	
                	wp_reset_postdata();
                }
    			?>
    		</div>
    		<?php
    		$faq_page_query_tab_sr++;
    	}
    }
	?>
</div> 