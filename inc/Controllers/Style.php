<?php # -*- coding: utf-8 -*-

namespace tf\TextModules\Controllers;

use tf\TextModules\Models\Style as Model;

/**
 * Class Style
 *
 * @package tf\TextModules\Controller
 */
class Style {

	/**
	 * @var Model
	 */
	private $model;

	/**
	 * Constructor. Set up the properties.
	 *
	 * @param Model           $model     Model.
	 */
	public function __construct( Model $model ) {

		$this->model = $model;
	}

	/**
	 * Wire up all functions.
	 *
	 * @return void
	 */
	public function initialize() {

		add_action( 'admin_print_scripts-edit.php', array( $this->model, 'enqueue' ) );
		add_action( 'admin_print_scripts-post.php', array( $this->model, 'enqueue' ) );
	}

}
