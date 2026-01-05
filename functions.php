<?php
/**
 * Your code here.
 *
 */

// Hide author and comments from post meta displayed by presscore_get_posted_on_parts()
if ( ! function_exists( 'child_modify_posted_on_parts' ) ) {
	function child_modify_posted_on_parts( $parts ) {
		if ( isset( $parts['author'] ) ) {
			unset( $parts['author'] );
		}
		if ( isset( $parts['comments'] ) ) {
			unset( $parts['comments'] );
		}
		return $parts;
	}
	add_filter( 'presscore_posted_on_parts', 'child_modify_posted_on_parts', 10 );
}

// Force sidebar to be shown on single post, archive and category pages
if ( ! function_exists( 'child_enable_sidebar_on_single_and_archives' ) ) {
	function child_enable_sidebar_on_single_and_archives() {
		if ( function_exists( 'presscore_config' ) ) {
			if ( is_singular( 'post' ) || is_archive() || is_category() ) {
				presscore_config()->set( 'sidebar_position', 'right' );
			}
		}
	}
	add_action( 'get_header', 'child_enable_sidebar_on_single_and_archives', 15 );
}