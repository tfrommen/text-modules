<?php # -*- coding: utf-8 -*-

namespace tfrommen\TextModules\TextModulesPage;

use tfrommen\TextModules\Asset\Asset;
use tfrommen\TextModules\Core\Shortcode;

/**
 * Text modules columns model.
 *
 * @package tfrommen\TextModules\TextModulesPage;
 * @since   2.0.0
 */
class Columns {

	/**
	 * @var string[]
	 */
	private $custom_columns;

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
	 */
	public function __construct( Shortcode $shortcode, Asset $style ) {

		$this->shortcode = $shortcode;

		$this->style = $style;

		$this->custom_columns = [
			'shortcode' => esc_html_x( 'Shortcode', 'Shortcode posts column title', 'text-modules' ),
			'slug'      => esc_html_x( 'Slug', 'Slug posts column title', 'text-modules' ),
		];
	}

	/**
	 * Returns the customized posts columns.
	 *
	 * @since   2.0.0
	 * @wp-hook manage_{$post_type}_posts_columns
	 *
	 * @param string[] $columns Posts columns.
	 *
	 * @return string[] Customized posts columns.
	 */
	public function get_posts_columns( array $columns ) {

		unset( $columns['date'] );

		$columns = array_replace( $columns, $this->custom_columns );

		return $columns;
	}

	/**
	 * Renders the HTML for the current text module's Shortcode cell.
	 *
	 * @since   2.0.0
	 * @wp-hook manage_{$post_type}_posts_custom_column
	 *
	 * @param string $column_name Column name.
	 * @param int    $post_id     Post ID.
	 *
	 * @return void
	 */
	public function render( $column_name, $post_id ) {

		if ( ! isset( $this->custom_columns[ $column_name ] ) ) {
			return;
		}

		switch ( $column_name ) {
			case 'shortcode':
				$this->style->enqueue();

				echo $this->shortcode->get_shortcode( $post_id );
				break;

			case 'slug':
				$post = get_post( $post_id );
				if ( isset( $post->post_name ) ) {
					echo $post->post_name;
				}
				break;
		}
	}
}
