<?php # -*- coding: utf-8 -*-

namespace tf\TextModules\Models;

/**
 * Class Style
 *
 * @package tf\TextModules\Models
 */
class Style {

	/**
	 * @var string
	 */
	private $file;

	/**
	 * @var string
	 */
	private $post_type;

	/**
	 * Constructor. Set up the properties.
	 *
	 * @param string   $file      Main plugin file.
	 * @param PostType $post_type Post type model.
	 */
	public function __construct( $file, PostType $post_type ) {

		$this->file = $file;

		$this->post_type = $post_type->get_post_type();
	}

	/**
	 * Enqueue the script file.
	 *
	 * @wp-hook admin_print_scripts-edit.php
	 * @wp-hook admin_print_scripts-post.php
	 *
	 * @return void
	 */
	public function enqueue() {

		global $typenow;

		if ( $typenow !== $this->post_type ) {
			return;
		}

		$url = plugin_dir_url( $this->file );
		$infix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		$file = 'assets/css/admin' . $infix . '.css';
		$path = plugin_dir_path( $this->file );
		$version = filemtime( $path . $file );
		wp_enqueue_style(
			'text-modules-admin',
			$url . $file,
			array(),
			$version
		);
	}

}
