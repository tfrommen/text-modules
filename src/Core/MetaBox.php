<?php # -*- coding: utf-8 -*-

namespace tfrommen\TextModules\Core;

use tfrommen\TextModules\Asset\Asset;

/**
 * Meta box model.
 *
 * @package tfrommen\TextModules\Core
 * @since   2.0.0
 */
class MetaBox {

	/**
	 * @var string
	 */
	private $post_type;

	/**
	 * @var Shortcode
	 */
	private $shortcode;

	/**
	 * @var Asset
	 */
	private $style;

	/**
	 * Constructor. Sets up the properties.
	 *
	 * @since 2.0.0
	 *
	 * @param Shortcode $shortcode Shortcode model.
	 * @param Asset     $style     Style model.
	 * @param string    $post_type Optional. Post type name. Defaults to empty string.
	 */
	public function __construct( Shortcode $shortcode, Asset $style, $post_type = '' ) {

		$this->shortcode = $shortcode;

		$this->style = $style;

		$this->post_type = $post_type ? (string) $post_type : ( new PostType() )->get_post_type();
	}

	/**
	 * Adds the meta box for the according post types.
	 *
	 * @since   2.0.0
	 * @wp-hook add_meta_boxes
	 *
	 * @param string $post_type Post type slug.
	 *
	 * @return bool Whether or not the meta box was added successfully.
	 */
	public function add( $post_type ) {

		if ( $post_type !== $this->post_type ) {
			return false;
		}

		add_meta_box(
			'text_modules_shortcode_meta_box',
			esc_html_x( 'Shortcode', 'Shortcode meta box title', 'text-modules' ),
			[ $this, 'render' ],
			$post_type,
			'side',
			'core'
		);

		return true;
	}

	/**
	 * Renders the HTML.
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public function render() {

		echo $this->shortcode->get_shortcode();
	}
}
