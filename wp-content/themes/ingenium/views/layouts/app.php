<?php
/**
 * Base layout.
 *
 * Render a full width layout without sidebars.
 * @link https://docs.wpemerge.com/#/framework/views/layouts
 *
 * @package MyApp
 */

\MyApp::render( 'header' );

\MyApp::layoutContent();

\MyApp::render( 'footer' );
