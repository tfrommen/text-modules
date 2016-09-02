<?php # -*- coding: utf-8 -*-

namespace tfrommen\TextModules;

use tfrommen\TextModules\Asset\Style;
use tfrommen\TextModules\Core\MetaBox;
use tfrommen\TextModules\Core\PluginData;
use tfrommen\TextModules\Core\PostType;
use tfrommen\TextModules\Core\Shortcode;
use tfrommen\TextModules\Widget\FormView;
use tfrommen\TextModules\Widget\Widget;

/**
 * Main plugin class.
 *
 * @package tfrommen\TextModules
 * @since   2.0.0
 */
class Plugin {

	/**
	 * @var string
	 */
	private $file;

	/**
	 * @var PostType
	 */
	private $post_type;

	/**
	 * @var Shortcode
	 */
	private $shortcode;

	/**
	 * Constructor. Sets up the properties.
	 *
	 * @since 2.0.0
	 *
	 * @param string $file Main plugin file.
	 */
	public function __construct( $file ) {

		$this->file = (string) $file;
	}

	/**
	 * Initializes the plugin.
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public function initialize() {

		$plugin_data = new PluginData( $this->file, [
			'version'     => 'Version',
			'text_domain' => 'Text Domain',
		] );

		( new Update\FallbackVersionUpdater( $plugin_data ) )->update();

		( new L10n\TextDomain( $plugin_data ) )->load();

		$this->post_type = new PostType();
		add_action( 'wp_loaded', [ $this->post_type, 'register' ] );

		$this->shortcode = new Shortcode( $this->post_type->get_post_type() );
		add_action( 'init', [ $this->shortcode, 'add' ] );

		add_action( 'widgets_init', function () {

			( new Widget() )->register();
		} );

		if ( is_admin() ) {
			$this->initialize_admin();

			return;
		}

		$this->initialize_front_end();
	}

	/**
	 * Wires up all admin-specific functions.
	 *
	 * @return void
	 */
	private function initialize_admin() {

		$post_type = $this->post_type->get_post_type();

		$style = new Style( $this->file );

		$text_modules_columns = new TextModulesPage\Columns( $this->shortcode, $style );
		add_action( "manage_{$post_type}_posts_columns", [ $text_modules_columns, 'get_posts_columns' ] );
		add_action( "manage_{$post_type}_posts_custom_column", [ $text_modules_columns, 'render_column' ], 10, 2 );

		add_action( 'add_meta_boxes', [ new MetaBox( $this->shortcode, $style, $post_type ), 'add' ] );

		add_action( Widget::ACTION . '_form', [ new FormView(), 'render' ], 10, 2 );
	}

	/**
	 * Wires up all front-end-specific functions.
	 *
	 * @return void
	 */
	private function initialize_front_end() {

		add_action( Widget::ACTION, [ new FormView( $this->shortcode ), 'render' ], 10, 3 );
	}
}
