<?php # -*- coding: utf-8 -*-

namespace tf\TextModules;

use tf\TextModules\Controllers;

/**
 * Class Plugin
 *
 * @package tf\TextModules
 */
class Plugin {

	/**
	 * @var string
	 */
	private $file;

	/**
	 * Constructor. Set up the properties.
	 *
	 * @param string $file Main plugin file.
	 */
	public function __construct( $file ) {

		$this->file = $file;
	}

	/**
	 * Initialize the plugin.
	 *
	 * @return void
	 */
	public function initialize() {

		$text_domain = new Models\TextDomain( $this->file );
		$text_domain->load();

		$post_type = new Models\PostType();
		$post_type_controller = new Controllers\PostType( $post_type );
		$post_type_controller->initialize();

		$columns = array(
			'slug'      => _x( 'Slug', 'Slug posts column title', 'text-modules' ),
			'shortcode' => _x( 'Shortcode', 'Shortcode posts column title', 'text-modules' ),
		);
		$text_modules_page = new Models\TextModulesPage( $columns );
		$shortcode = new Models\Shortcode( $post_type );
		$shortcode_posts_column_view = new Views\ShortcodePostsColumn( $columns, $shortcode );
		$shortcode_controller = new Controllers\Shortcode(
			$shortcode,
			$text_modules_page,
			$shortcode_posts_column_view,
			$post_type
		);
		$shortcode_controller->initialize();

		$widget = new Widget();
		$widget_controller = new Controllers\Widget( $widget );
		$widget_controller->initialize();

		if ( is_admin() ) {
			$meta_box_view = new Views\MetaBox( $post_type, $shortcode );
			$meta_box_controller = new Controllers\MetaBox( $meta_box_view );
			$meta_box_controller->initialize();

			$style = new Models\Style( $this->file, $post_type );
			$style_controller = new Controllers\Style( $style );
			$style_controller->initialize();
		}
	}

}
