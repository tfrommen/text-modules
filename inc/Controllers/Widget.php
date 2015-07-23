<?php # -*- coding: utf-8 -*-

namespace tf\TextModules\Controllers;

use tf\TextModules\Widget as Model;

/**
 * Class Widget
 *
 * @package tf\TextModules\Controllers
 */
class Widget {

	/**
	 * @var Model
	 */
	private $model;

	/**
	 * Constructor. Set up the properties.
	 *
	 * @param Model $model Model.
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

		add_action( 'widgets_init', array( $this->model, 'register' ) );
	}

}
