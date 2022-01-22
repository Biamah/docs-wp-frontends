<?php
namespace MyApp\Controllers\Admin\Taxonomies;

/**
 * Abstract class to implement default logic in Taxonomies
 * 
 * Uses Singleton pattern to instantiate the inherited classes.
 */
class AbstractTaxonomyController {

    /**
     * Singleton instance
     *
     * @var array
     */
    private static $_instances = array();

    /**
	 * Taxonomy slug. Used in register_taxonomy
	 *
	 * @var string
	 */
	protected $slug;

    /**
     * Custom Post Types to the taxonomy. Used in register_taxonomy
     *
     * @var string|array
     */
    protected $post_types;

    /**
	 * Taxonomy Singular Name. Used in Labels of register_taxonomy
	 *
	 * @var string
	 */
    protected $singular;

    /**
	 * Taxonomy Plural Name. Used in Labels of register_taxonomy
	 *
	 * @var string
	 */
    protected $plural;

    /**
     * Class construct. Do nothing here
     */
    public function __construct () {}

    /**
     * Singleton get unique instance
     *
     * @return object A inherited class object
     */
    final public static function get_instance() {
        self::$_instances[ static::class ] = self::$_instances[ static::class ] ?? new static();

        return self::$_instances[ static::class ];
    }

    /**
     * Register taxonomy with default options.
     * 
     * Use the $args to customize the default options in inherited classes
     *
     * @param array $args register_taxonomy arguments
     * @return void
     */
	public function register_taxonomy( $args = array() ) {
        $defaults = array(
            'labels'            => $this->_get_taxonomy_labels(),
            'public'            => true,
            'show_ui'           => true,
            'hierarchical'      => true,
            'show_admin_column' => true,
            'show_in_rest'      => true,
            'capabilities'      => myapp_get_all_taxonomy_capabilities_mapped( strtolower( $this->slug . 's' ) ),
        );

        $args = wp_parse_args( $args, $defaults );
	    
        register_taxonomy( $this->slug, $this->post_types, $args );
	}

    /**
     * Add taxonomy capabilities to Administrator and Editor WordPress roles
     *
     * @return void
     */
	public function add_custom_capabilities() {
        myapp_add_capabilities_to_role( 'administrator', myapp_get_all_taxonomy_capabilities_mapped( strtolower( $this->slug . 's' ) ) );
        myapp_add_capabilities_to_role( 'editor', myapp_get_all_taxonomy_capabilities_mapped( strtolower( $this->slug . 's' ) ) );
    }

    /**
     * Returns the taxonomy slug
     *
     * @return string
     */
    public function get_slug() {
        return $this->slug;
    }

    /**
     * Returns the taxonomy plural name
     *
     * @return string
     */
    public function get_plural_name() {
        return $this->plural;
    }

    /**
     * Get the labels customized for the Taxonomy
     *
     * @return void
     */
    private function _get_taxonomy_labels() {
        return array(
            'name'                       => $this->plural,
            'singular_name'              => $this->singular,
            'search_items'               => sprintf( __( "Search %s", 'myapp' ), $this->plural ),
            'popular_items'              => sprintf( __( "Popular %s", 'myapp' ), $this->plural ),
            'all_items'                  => sprintf( __( "All %s", 'myapp' ), $this->plural ),
            'parent_item'                => sprintf( __( "Parent %s", 'myapp' ), $this->singular ),
            'parent_item_colon'          => sprintf( __( "Parent: %s", 'myapp' ), $this->singular ),
            'edit_item'                  => sprintf( __( "Edit %s", 'myapp' ), $this->singular ),
            'view_item'                  => sprintf( __( "View %s", 'myapp' ), $this->singular ),
            'update_item'                => sprintf( __( "Update %s", 'myapp' ), $this->singular ),
            'add_new_item'               => sprintf( __( "Add New %s", 'myapp' ), $this->singular ),
            'new_item_name'              => sprintf( __( "New %s Name", 'myapp' ), $this->singular ),
            'separate_items_with_commas' => sprintf( __( "Separate %s with commas", 'myapp' ), $this->plural ),
            'add_or_remove_items'        => sprintf( __( "Add or remove %s", 'myapp' ), $this->plural ),
            'choose_from_most_used'      => sprintf( __( "Choose from the most used %s", 'myapp' ), $this->plural ),
            'not_found'                  => sprintf( __( "No %s found", 'myapp' ), $this->plural ),
            'no_terms'                   => sprintf( __( "No %s", 'myapp' ), $this->plural ),
            'filter_by_item'             => sprintf( __( "Filter by %s", 'myapp' ), $this->singular ),
            'items_list_navigation'      => sprintf( __( "%s list navigation", 'myapp' ), $this->plural ),
            'items_list'                 => sprintf( __( "%s list", 'myapp' ), $this->plural ),
            'most_used'                  => sprintf( __( "Most Used %s", 'myapp' ), $this->plural ),
            'back_to_items'              => sprintf( __( "Back to %s", 'myapp' ), $this->plural ),
            'item_link'                  => sprintf( __( "%s Link", 'myapp' ), $this->singular ),
            'item_link_description'      => sprintf( __( "A link to a %s", 'myapp' ), $this->singular ),
        );
    }
}