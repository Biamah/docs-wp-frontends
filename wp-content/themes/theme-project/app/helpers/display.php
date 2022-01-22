<?php
/**
 * Helper functions related to display, rendering and manipulating HTML.
 *
 * @package WPEmergeTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Renders the attributes for an HTML tag.
 * The function accepts attributes in associative array,
 * filters out falsy attributes and escapes the attribute values.
 *
 * @param array $attributes List of attributes to render.
 * @return string
 */
function my_app_attributes( array $attributes = array() ) {
	$attributes = array_map(
		function( $name, $value ) {
			// All the falsy attributes should be filtered out except the alt attribute for the images.
			if ( ! boolval( $value ) && ! in_array( $name, array( 'alt' ), true ) ) {
				return false;
			}

			if ( true === $value ) {
				return $name;
			}

			if ( is_callable( $value ) ) {
				$value = $value();
			}

			if ( is_array( $value ) || is_object( $value ) ) {
				$value = wp_json_encode( $value );
			}

			return $name . '="' . esc_attr( $value ) . '"';
		},
		array_keys( $attributes ),
		array_values( $attributes )
	);

	return join( ' ', array_filter( $attributes ) );
}
