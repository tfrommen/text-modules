<?php # -*- coding: utf-8 -*-

namespace tf\TextModules\Models;

/**
 * Class TextModulesPage
 *
 * @package tf\TextModules\Models
 */
class TextModulesPage {

	/**
	 * @var array
	 */
	private $columns;

	/**
	 * Constructor. Set up the properties.
	 *
	 * @param array $columns Columns.
	 */
	public function __construct( array $columns ) {

		$this->columns = $columns;
	}

	/**
	 * Customize the posts columns.
	 *
	 * @wp-hook manage_{$post_type}_posts_columns
	 *
	 * @param array $columns Posts columns.
	 *
	 * @return array
	 */
	public function manage_posts_columns( $columns ) {

		unset( $columns[ 'date' ] );

		foreach ( $this->columns as $name => $title ) {
			$columns[ $name ] = $title;
		}

		return $columns;
	}

}
