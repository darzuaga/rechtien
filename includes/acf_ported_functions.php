<?php
/*
*  cardealer_acf_maybe_get
*
*  This function will return a var if it exists in an array
*
*  @type	function
*  @date	9/12/2014
*  @since	5.1.5
*
*  @param	$array (array) the array to look within
*  @param	$key (key) the array key to look for. Nested values may be found using '/'
*  @param	$default (mixed) the value returned if not found
*  @return	$post_id (int)
*/

function cardealer_acf_maybe_get( $array, $key, $default = null ) {
	
	// vars
	$keys = explode('/', $key);
	
	
	// loop through keys
	foreach( $keys as $k ) {
		
		// return default if does not exist
		if( !isset($array[ $k ]) ) {
			
			return $default;
			
		}
		
		
		// update $array
		$array = $array[ $k ];
		
	}
	
	
	// return
	return $array;
	
}


/*
*  cardealer_acf_get_attachment
*
*  This function will return an array of attachment data
*
*  @type	function
*  @date	5/01/2015
*  @since	5.1.5
*
*  @param	$post (mixed) either post ID or post object
*  @return	(array)
*/

function cardealer_acf_get_attachment( $post ) {
	
	// post
	$post = get_post($post);
	
    
	// bail early if no post
	if( !$post ) return false;
	
	
	// vars
	$thumb_id = 0;
	$id = $post->ID;
	$a = array(
		'ID'			=> $id,
		'id'			=> $id,
		'title'       	=> $post->post_title,
		'filename'    	=> wp_basename( $post->guid ),
		'url'			=> wp_get_attachment_url( $id ),
		'alt'			=> get_post_meta($id, '_wp_attachment_image_alt', true),
		'author'		=> $post->post_author,
		'description'	=> $post->post_content,
		'caption'		=> $post->post_excerpt,
		'name'			=> $post->post_name,
		'date'			=> $post->post_date_gmt,
		'modified'		=> $post->post_modified_gmt,
		'mime_type'		=> $post->post_mime_type,
		'type'			=> cardealer_acf_maybe_get( explode('/', $post->post_mime_type), 0, '' ),
		'icon'			=> wp_mime_type_icon( $id )
	);
	
	
	// video may use featured image
	if( $a['type'] === 'image' ) {
		
		$thumb_id = $id;
		$src = wp_get_attachment_image_src( $id, 'full' );
		
		$a['url'] = $src[0];
		$a['width'] = $src[1];
		$a['height'] = $src[2];
		
		
	} elseif( $a['type'] === 'audio' || $a['type'] === 'video' ) {
		
		// video dimentions
		if( $a['type'] == 'video' ) {
			
			$meta = wp_get_attachment_metadata( $id );
			$a['width'] = cardealer_acf_maybe_get($meta, 'width', 0);
			$a['height'] = cardealer_acf_maybe_get($meta, 'height', 0);
		
		}
		
		
		// feature image
		if( $featured_id = get_post_thumbnail_id($id) ) {
		
			$thumb_id = $featured_id;
			
		}
						
	}
	
	
	// sizes
	if( $thumb_id ) {
		
		// find all image sizes
		if( $sizes = get_intermediate_image_sizes() ) {
			
			$a['sizes'] = array();
			
			foreach( $sizes as $size ) {
				
				// url
				$src = wp_get_attachment_image_src( $thumb_id, $size );
				
				// add src
				$a['sizes'][ $size ] = $src[0];
				$a['sizes'][ $size . '-width' ] = $src[1];
				$a['sizes'][ $size . '-height' ] = $src[2];				
			}			
		}		
	}
	return $a;
	
}