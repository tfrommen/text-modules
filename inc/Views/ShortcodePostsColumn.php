<?php # -*- coding: utf-8 -*-

namespace tf\TextModules\Views;

use tf\TextModules\Models\Shortcode as ShortcodeModel;

/**
 * Class ShortcodePostsColumn
 *
 * @package tf\TextModules\Views
 */
class ShortcodePostsColumn {

	/**
	 * @var array
	 */
	private $columns;

	/**
	 * @var ShortcodeModel
	 */
	private $shortcode;

	/**
	 * Constructor. Set up the properties.
	 *
	 * @param array          $columns   Columns.
	 * @param ShortcodeModel $shortcode Shortcode model.
	 */
	public function __construct( array $columns, ShortcodeModel $shortcode ) {

		$this->columns = $columns;
		$this->shortcode = $shortcode;
	}

	/**
	 * Render the HTML for the current text module's Shortcode cell.
	 *
	 * @wp-hook manage_{$post_type}_posts_custom_column
	 *
	 * @param string $column_name Column name.
	 * @param int    $post_id     Post ID.
	 *
	 * @return void
	 */
	public function render( $column_name, $post_id ) {

		if ( ! isset( $this->columns[ $column_name ] ) ) {
			return;
		}

		switch ( $column_name ) {
			case 'shortcode':
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
