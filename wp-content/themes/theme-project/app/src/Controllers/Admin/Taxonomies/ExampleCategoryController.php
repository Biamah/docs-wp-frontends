<?php
namespace MyApp\Controllers\Admin\Taxonomies;

use MyApp\Controllers\Admin\Posts\ExampleController;

/**
 * Controller to Category Example taxonomy. Add here all logical to this taxonomy
 */
class ExampleCategoryController extends AbstractTaxonomyController {

    /**
     * Class construct, define here the protected attributes from AbstractTaxonomyController class
     */
	public function __construct() {
		$this->slug       = 'myapp-category-example';
		$this->singular   = __( 'Category Example', 'myapp' );
		$this->plural     = __( 'Categories Example', 'myapp' );
		$this->post_types = array( ExampleController::get_instance()->get_slug() );
	}

    /**
     * Regsiter the taxonomy. If necessary, customize the $args to parent method
     *
     * @param array $args
     * @return void
     */
	public function register_taxonomy( $args = array() ) {
		parent::register_taxonomy( $args );
	}
}
