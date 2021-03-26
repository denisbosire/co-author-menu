<?php
/*
Based on the excellent integration work of Jean Galea 
https://github.com/jgalea/genesis-coauthors-plus/blob/master/genesis-coauthors.php
*/

/** Add guest author without user profile functionality via the following functions */

/**
 * Post Authors Post Link Shortcode
 * 
 * @param array $atts
 * @return string $authors
 */
function co_post_authors_post_link_shortcode( $atts ) {
 
	$atts = shortcode_atts( array( 
		'between'      => null,
		'between_last' => null,
		'before'       => null,
		'after'        => null
	), $atts );
 
	$authors = function_exists( 'coauthors_posts_links' ) ? coauthors_posts_links( $atts['between'], $atts['between_last'], $atts['before'], $atts['after'], false ) : $atts['before'] . get_author_posts_url() . $atts['after'];
	return $authors;
}
add_shortcode( 'post_authors_post_link', 'co_post_authors_post_link_shortcode' );

/**
 * List Authors in Genesis Post Info
 *
 * @param string $info
 * @return string $info
 */
function co_post_info( $info ) {
	$info = '[post_authors_post_link before="by "]';
	return $info;
}
add_filter( 'genesis_post_info', 'co_post_info' );

// Remove Genesis Author Box and load our own

add_action( 'init', 'cam_coauthors_init' );

function cam_coauthors_init() {
	remove_action( 'genesis_after_post', 'genesis_do_author_box_single' );
	add_action( 'genesis_after_post', 'cam_author_box', 1 );
}
 
/**
 * Load Author Boxes
 *
 * @author Jean Galea
 */
function cam_author_box() {
 
	if( !is_single() )
		return;
 
	if( function_exists( 'get_coauthors' ) ) {
		
		$authors = get_coauthors();
		
		foreach( $authors as $author )
			cam_do_author_box( 'single', $author );
			
	} else {
		cam_do_author_box( 'single', get_the_author_ID() );	
	}
}
 
/**
 * Display Author Box
 * Modified from Genesis to use data from get_coauthors() function
 *
 * @author Jean Galea
 */
function cam_do_author_box( $context = '', $author ) {
 
	if( ! $author ) 
		return;

	$gravatar_size = apply_filters( 'genesis_author_box_gravatar_size', 70, $context );
	$gravatar      = get_avatar( $author->user_email , $gravatar_size );
	$title         = apply_filters( 'genesis_author_box_title', sprintf( '<strong>%s %s</strong>', __( 'About', 'genesis' ), $author->display_name  ), $context );
	$description   = wpautop( $author->description );

	/** The author box markup, contextual */
	$pattern = $context == 'single' ? '<div class="author-box"><div>%s %s<br />%s</div></div><!-- end .authorbox-->' : '<div class="author-box">%s<h1>%s</h1><div>%s</div></div><!-- end .authorbox-->';

	echo apply_filters( 'genesis_author_box', sprintf( $pattern, $gravatar, $title, $description ), $context, $pattern, $gravatar, $title, $description );	

}