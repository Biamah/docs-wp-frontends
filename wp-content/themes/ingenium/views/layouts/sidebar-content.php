<?php
/**
 * Sidebar + Content layout.
 *
 * Render a layout with the Sidebar at the left side and the Content on the right side.
 * @link https://docs.wpemerge.com/#/framework/views/layouts
 *
 * @package MyApp
 */

\MyApp::render( 'header' );

if ( ! is_singular() ) {
	my_app_the_title( '<h2 class="post-title">', '</h2>' );
}

\MyApp::render( 'sidebar' );

\MyApp::layoutContent();

\MyApp::render( 'footer' );
