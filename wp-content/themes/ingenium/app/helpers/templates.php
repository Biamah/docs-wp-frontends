<?php
/**
 * Templates helpers.
 *
 * @package MyApp
 */

/**
 * Loads a template part into a template.
 *
 */
function my_app_template( $view, $context = [] ) {
	return \MyApp::render( $view, $context );
}
