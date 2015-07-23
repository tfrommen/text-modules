<?php # -*- coding: utf-8 -*-

namespace tf\TextModules\Controllers;

use tf\TextModules\Views\MetaBox as View;

/**
 * Class MetaBox
 *
 * @package tf\TextModules\Controllers
 */
class MetaBox {

	/**
	 * @var View
	 */
	private $view;

	/**
	 * Constructor. Set up the properties.
	 *
	 * @param View $view View.
	 */
	public function __construct( View $view ) {

		$this->view = $view;
	}

	/**
	 * Wire up all functions.
	 *
	 * @return void
	 */
	public function initialize() {

		add_action( 'add_meta_boxes', array( $this->view, 'add' ) );
	}

}
