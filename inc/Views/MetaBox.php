<?php # -*- coding: utf-8 -*-

namespace tf\TextModules\Views;

use tf\TextModules\Models;

/**
 * Class MetaBox
 *
 * @package tf\TextModules\Views
 */
class MetaBox {

	/**
	 * @var string
	 */
	private $post_type;

	/**
	 * @var Models\Shortcode
	 */
	private $shortcode;

	/**
	 * Constructor. Set up the properties.
	 *
	 * @param Models\PostType  $post_type Post type model.
	 * @param Models\Shortcode $shortcode Shortcode model.
	 */
	public function __construct( Models\PostType $post_type, Models\Shortcode $shortcode ) {

		$this->post_type = $post_type->get_post_type();

		$this->shortcode = $shortcode;
	}

	/**
	 * Add the meta box to the according post types.
	 *
	 * @wp-hook add_meta_boxes
	 *
	 * @param string $post_type Post type slug.
	 *
	 * @return void
	 */
	public function add( $post_type ) {

		if ( $post_type !== $this->post_type ) {
			return;
		}

		$title = _x( 'Shortcode', 'Shortcode meta box title', 'text-modules' );
		add_meta_box(
			'text_modules_shortcode_meta_box',
			$title,
			array( $this, 'render' ),
			$post_type,
			'side',
			'core'
		);
	}

	/**
	 * Render the HTML.
	 *
	 * @return void
	 */
	public function render() {

		echo $this->shortcode->get_shortcode();
	}

}
