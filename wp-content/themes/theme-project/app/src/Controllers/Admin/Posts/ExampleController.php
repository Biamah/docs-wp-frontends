<?php
namespace MyApp\Controllers\Admin\Posts;

/**
 * Controller to CPT Example. Add here all logical to this post type
 */
class ExampleController extends AbstractPostTypeController {

	public function __construct() {
		$this->slug       = 'myapp-example';
		$this->singular   = __( 'Example', 'myapp' );
		$this->plural     = __( 'Examples', 'myapp' );
	}

	/**
	 * Customize the register_post_type() params to register the post_type
	 *
	 * @param array $args
	 * @return void
	 */
	public function register_post_type( $args = array() ) {
		parent::register_post_type( array(
			'menu_position' => 5,
			'menu_icon'     => 'dashicons-admin-post',
		) );
	}
}
