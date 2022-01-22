<?php
namespace MyApp\WordPress;

use WPEmerge\ServiceProviders\ServiceProviderInterface;

use MyApp\Controllers\Admin\Posts\ExampleController;

use MyApp\Controllers\Admin\Taxonomies\ExampleCategoryController;

/**
 * Register Post Types and Taxonomies
 */
class ContentTypesServiceProvider implements ServiceProviderInterface {
	/**
	 * {@inheritDoc}
	 */
	public function register( $container ) {
		// Nothing to register.
	}

	/**
	 * {@inheritDoc}
	 */
	public function bootstrap( $container ) {
		add_action( 'init', array( &$this, 'register_post_types' ) );
		add_action( 'init', array( &$this, 'register_taxonomies' ) );
		add_action( 'after_switch_theme', array( &$this, 'add_capabilities' ) );
		add_filter( 'enter_title_here', array( &$this, 'customize_enter_title_text' ), 10, 2 );
	}

	/**
	 * Register project custom post types.
	 *
	 * @return void
	 */
	public function register_post_types() {
		ExampleController::get_instance()->register_post_type();
	}

	/**
	 * Register project custom taxonomies
	 *
	 * @return void
	 */
	public function register_taxonomies() {
		ExampleCategoryController::get_instance()->register_taxonomy();
	}

	/**
	 * Add the capabilities for each custom post type created. Uses the CPT Controllers to define specific capabilites
	 *
	 * @return void
	 */
	public function add_capabilities() {
		ExampleController::get_instance()->add_custom_capabilities();

		ExampleCategoryController::get_instance()->add_custom_capabilities();
	}

	/**
	 * Customize the placeholder for the 'Add title' field on add new post screen.
	 * 
	 * This uses 'enter_title_here' wordpress filter and runs in all post types, cause this, 
	 * we did a smart code to use the CPT Controllers to define what is the correct text.
	 *
	 * @param string $text
	 * @param WP_Post $post
	 * @return string The text to display
	 */
    public function customize_enter_title_text( $text, $post ) {
        $class = 'MyApp\Controllers\Admin\Posts\\' . ucfirst( str_replace( 'myapp-', '', $post->post_type ) ) . 'Controller';

		if ( ! class_exists( $class ) or ! method_exists( $class, 'get_instance' ) or ! method_exists( $class, 'get_enter_title_text' ) )
			return $text;
		
		return $class::get_instance()->get_enter_title_text();
    }
}
