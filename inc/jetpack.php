<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package lowermedia_one_page_theme
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function lowermedia_one_page_theme_infinite_scroll_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'content',
		'footer'    => 'page',
	) );
}
add_action( 'after_setup_theme', 'lowermedia_one_page_theme_infinite_scroll_setup' );
