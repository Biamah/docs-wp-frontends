<?php
namespace MyApp\Controllers\Admin\Posts;

/**
 * Abstract class to implement default logic in Custom Post Types.
 * 
 * Uses Singleton pattern to instantiate the inherited classes.
 */
class AbstractPostTypeController {

    /**
     * Singleton instance
     *
     * @var array
     */
    private static $_instances = array();

    /**
	 * CPT slug. Used in register_post_type
	 *
	 * @var string
	 */
	protected $slug;

    /**
	 * CPT Singular Name. Used in Labels of register_post_type
	 *
	 * @var string
	 */
    protected $singular;

    /**
	 * CPT Plural Name. Used in Labels of register_post_type
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
     * Register post type with default options.
     * 
     * Use the $args to customize the default options in inherited classes
     *
     * @param array $args register_post_type arguments
     * @return void
     */
	public function register_post_type( $args = array() ) {
        $defaults = array(
            'labels'          => $this->_get_post_type_labels(),
            'public'          => true,
            'show_in_menu'    => true,
            'hierarchical'    => false,
            'supports'        => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
            'capability_type' => array( strtolower( $this->slug ), strtolower( $this->slug . 's' ) ),
            'has_archive'     => true,
            'show_in_rest'    => true,
        );

        $args = wp_parse_args( $args, $defaults );
	    
        register_post_type( $this->slug, $args );
	}

    /**
     * Add post type custom capabilities to Administrator and Editor WordPress roles
     *
     * @return void
     */
	public function add_custom_capabilities() {
        myapp_add_capabilities_to_role( 'administrator', myapp_get_all_post_type_capabilities_mapped( strtolower( $this->slug ), strtolower( $this->slug . 's' ) ) );
        myapp_add_capabilities_to_role( 'editor', myapp_get_all_post_type_capabilities_mapped( strtolower( $this->slug ), strtolower( $this->slug . 's' ) ) );
    }

    /**
     * Customize the enter title field for a custom post type
     *
     * @return void
     */
    public function get_enter_title_text() {
        return sprintf( __( 'Add %s title', 'myapp' ), $this->singular );
    }

    /**
     * Returns the post_type slug
     *
     * @return string
     */
    public function get_slug() {
        return $this->slug;
    }

    /**
     * Returns the post_type plural name
     *
     * @return void
     */
    public function get_plural_name() {
        return $this->plural;
    }

    /**
     * Get the labels customized for the custom post type
     *
     * @return void
     */
    private function _get_post_type_labels() {
        return array(
            'name'                     => $this->plural,
            'singular_name'            => $this->singular,
            'add_new'                  => __( 'Add New', 'myapp' ),
            'add_new_item'             => sprintf( __( "Add new %s", 'myapp' ), $this->singular ),
            'edit_item'                => sprintf( __( "Edit %s", 'myapp' ), $this->singular ),
            'new_item'                 => sprintf( __( "New %s", 'myapp' ), $this->singular ),
            'view_item'                => sprintf( __( "View %s", 'myapp' ), $this->singular ),
            'view_items'               => sprintf( __( "View %s", 'myapp' ), $this->plural ),
            'search_items'             => sprintf( __( "Search %s", 'myapp' ), $this->plural ),
            'not_found'                => sprintf( __( "No %s found", 'myapp' ), $this->plural ),
            'not_found_in_trash'       => sprintf( __( "No %s found in Trash", 'myapp' ), $this->plural ),
            'parent_item_colon'        => sprintf( __( "Parent %s", 'myapp' ), $this->singular ),
            'all_items'                => sprintf( __( "All %s", 'myapp' ), $this->plural ),
            'archives'                 => sprintf( __( "%s Archives", 'myapp' ), $this->singular ),
            'attributes'               => sprintf( __( "%s Attributes", 'myapp' ), $this->singular ),
            'insert_into_item'         => sprintf( __( "Insert into %s", 'myapp' ), $this->singular ),
            'uploaded_to_this_item'    => sprintf( __( "Uploaded to this %s", 'myapp' ), $this->singular ),
            'featured_image'           => sprintf( __( "%s featured image", 'myapp' ), $this->singular ),
            'set_featured_image'       => sprintf( __( "Set %s featured image", 'myapp' ), $this->singular ),
            'remove_featured_image'    => sprintf( __( "Remove %s featured image", 'myapp' ), $this->singular ),
            'use_featured_image'       => sprintf( __( "Use as %s featured image", 'myapp' ), $this->singular ),
            'menu_name'                => $this->plural,
            'filter_items_list'        => sprintf( __( "Filter %s list", 'myapp' ), $this->plural ),
            'filter_by_date'           => sprintf( __( "Filter %s by date", 'myapp' ), $this->plural ),
            'items_list_navigation'    => sprintf( __( "%s list navigation", 'myapp' ), $this->plural ),
            'items_list'               => sprintf( __( "%s list", 'myapp' ), $this->plural ),
            'item_published'           => sprintf( __( "%s published", 'myapp' ), $this->singular ),
            'item_published_privately' => sprintf( __( "%s published privately", 'myapp' ), $this->singular ),
            'item_reverted_to_draft'   => sprintf( __( "%s reverted to draft", 'myapp' ), $this->singular ),
            'item_scheduled'           => sprintf( __( "%s scheduled", 'myapp' ), $this->singular ),
            'item_updated'             => sprintf( __( "%s updated", 'myapp' ), $this->singular ),
            'item_link'                => sprintf( __( "%s link", 'myapp' ), $this->singular ),
            'item_link_description'    => sprintf( __( "A link to a %s", 'myapp' ), $this->singular ),
        );
    }
}