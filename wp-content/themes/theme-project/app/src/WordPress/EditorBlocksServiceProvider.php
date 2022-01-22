<?php

namespace MyApp\WordPress;

use WPEmerge\ServiceProviders\ServiceProviderInterface;

/**
 * Register gutenberg blocks.
 */
class EditorBlocksServiceProvider implements ServiceProviderInterface
{
	protected $blocks_directory = 'views/blocks/';
	protected $block_category   = 'fuerzastudio';

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
		add_filter( 'block_categories', [$this, 'registerCategories'], 10, 2 );
		add_action( 'acf/init', [$this, 'registerBlocks'] );
	}

	public function registerCategories( $categories ) {
		return array_merge(
			[
				[
					'slug'  => $this->block_category,
					'title' => __( 'Fuerza Studio', 'my_app' )
				]
			],
			$categories
		);
	}

	public function registerBlocks() {
		if ( ! function_exists( 'acf_register_block' ) ) {
			return;
		}

		$block_files = $this->getBlockFiles();

		foreach ( $block_files as $block_file ) {
			$default_settings = $this->getDefaultBlockSettings( $block_file['slug'] );
			$block_settings = $this->getBlockSettings( $block_file );
			$final_settings = array_merge( $default_settings, array_filter( $block_settings ) ); // array_filter removes empty strings
			acf_register_block( $final_settings );
		}
	}

	public function getBlockFiles() {
		// Set the directory blocks are stored in.
		$blocks_directory     = $this->blocks_directory;
		$stylesheet_directory = get_stylesheet_directory();
		$path                 = "$stylesheet_directory/$blocks_directory";

		// Bail if it's not a directory
		if ( ! is_dir( $path ) ) {
			return;
		}

		// Get templates directory iterator.
		$dir = new \DirectoryIterator( locate_template( $blocks_directory ) );
		// Loop through found templates and set up data.
		$files = [];

		foreach ( $dir as $file_info ) {
			if ( $file_info->isDot() ) {
				continue;
			}

			$files[] = $this->getBlockFile( $file_info );
		}

		return $files;
	}

	public function getBlockFile( $file_info ) {
		// Strip the file extension to get the slug.
		$slug = str_replace( '.php', '', $file_info->getFilename() );

		// Locate the template.
		$blocks_directory = $this->blocks_directory;
		$file_path        = locate_template( "$blocks_directory/${slug}.php" );

		return [
			'slug' => $slug,
			// Get header info from the found template file(s).
			'file_headers' => get_file_data(
				$file_path,
				[
					'title'       => 'Title',
					'description' => 'Description',
					'category'    => 'Category',
					'icon'        => 'Icon',
					'keywords'    => 'Keywords',
					'mode'        => 'Mode',
					'post_types'  => 'PostTypes',
				]
			)
		];
	}

	public function getDefaultBlockSettings( $slug ) {
		$title = ucfirst( str_replace( '-', ' ', $slug ) );

		return [
			'name'            => $slug,
			'title'           => $title,
			'description'     => $title . ' block',
			'category'        => $this->block_category,
			'icon'            => 'format-image',
			'keywords'        => array_merge( [ $this->block_category ], explode( '-', $slug ) ),
			'mode'            => 'auto',
			'render_callback' => [ $this, 'renderBlock' ],
		];
	}

	public function getBlockSettings( $block_file ) {
		$block_settings = [
			'name'            => $block_file['slug'],
			'title'           => $block_file['file_headers']['title'],
			'description'     => $block_file['file_headers']['description'],
			'category'        => $block_file['file_headers']['category'],
			'icon'            => $block_file['file_headers']['icon'],
			'keywords'        => $block_file['file_headers']['keywords'] ? explode( ' ', $block_file['file_headers']['keywords'] ) : '',
			'mode'            => $block_file['file_headers']['mode'],
			'render_callback' => [ $this, 'renderBlock' ],
		];

		// If the PostTypes header is set in the template, restrict this block to those types.
		if ( ! empty( $block_file['file_headers']['post_types'] ) ) {
			$block_settings['post_types'] = explode( ' ', $block_file['file_headers']['post_types'] );
		}

		return $block_settings;
	}

	public function renderBlock( $block, $content = '', $is_preview = false, $post_id = 0 ) {
		$block   = $this->getBlockDataForRendering( $block, $content, $is_preview, $post_id );
		$slug    = $block['slug'];
		$context = [
			'block'      => $block,
			'content'    => $content,
			'is_preview' => $is_preview,
			'post_id'    => $post_id,
		];
		$fields_context     = function_exists( 'get_fields' ) ? ( get_fields() ?: [] ) : [];
		$default_context    = array_merge( $context, $fields_context );
		$additional_context = $this->getBlockContext( $default_context );

		$blocks_directory    = $this->blocks_directory;
		$block_template_path = $blocks_directory . $slug;

		// Render the block.
		\MyApp::render(
			$block_template_path,
			array_merge(
				$default_context,
				$additional_context
			)
		);
	}

	public function getBlockDataForRendering( $block, $content = '', $is_preview = false, $post_id = 0 ) {
		// Determine page slug.
		$page_slug = get_post_field( 'post_name', $post_id );
		// Set up the block slug to be useful.
		$slug = str_replace( 'acf/', '', $block['name'] );
		// Get the class defined through the UI.
		$block_class = isset( $block['className'] ) ? $block['className'] : '';

		// Set up the block data.
		$block['slug'] = $slug;
		$block['classes'] = implode(
			' ',
			[
				'c-block',
				'b-'. $slug,
				'b-'. $slug . '--page-' . $page_slug,
				$block_class,
				'align' . $block['align'],
			]
		);

		// Update ID last after all block data is up to date.
		$block['id'] = $this->createBlockId( $block );

		return $block;
	}

	public function createBlockId( $block ) {
		$slug    = $block['slug'];
		$counter = 'block-id-index-' . $slug;

		if ( ! isset( $GLOBALS[ $counter ] ) || empty( $GLOBALS[ $counter ] ) ) {
			$GLOBALS[ $counter ] = 1;
		} else {
			$GLOBALS[ $counter ] += 1;
		}

		$index = $GLOBALS[ $counter ];

		return "$slug-$index";
	}

	public function getBlockContext( $default_context ) {
		$composer_class = '\\MyApp\\ViewComposers\\Blocks\\' . my_app_kebab_to_pascal( $default_context['block']['slug'] ) . 'Block';

		if ( ! class_exists( $composer_class ) ) {
			return [];
		}

		$composer = new $composer_class( $default_context );

		return array_merge(
			$composer->getContext( $default_context ),
			[ 'composer' => $composer ]
		);
	}
}
