<?php # -*- coding: utf-8 -*-

namespace tf\TextModules\Controllers;

use tf\TextModules\Models\Shortcode as Model;
use tf\TextModules\Models\PostType as PostTypeModel;
use tf\TextModules\Models\TextModulesPage as PageModel;
use tf\TextModules\Views\ShortcodePostsColumn as View;

/**
 * Class Shortcode
 *
 * @package tf\TextModules\Controllers
 */
class Shortcode {

	/**
	 * @var Model
	 */
	private $model;

	/**
	 * @var PageModel
	 */
	private $page;

	/**
	 * @var string
	 */
	private $post_type;

	/**
	 * @var View
	 */
	private $view;

	/**
	 * Constructor. Set up the properties.
	 *
	 * @param Model         $model     Model.
	 * @param PageModel     $page      Text modules page model.
	 * @param View          $view      Shortcode posts column view.
	 * @param PostTypeModel $post_type Post type model.
	 */
	public function __construct(
		Model $model,
		PageModel $page,
		View $view,
		PostTypeModel $post_type
	) {

		$this->model = $model;

		$this->page = $page;

		$this->view = $view;

		$this->post_type = $post_type->get_post_type();
	}

	/**
	 * Wire up all functions.
	 *
	 * @return void
	 */
	public function initialize() {

		global $pagenow;

		$this->model->add();

		$page_base = basename( $pagenow, '.php' );
		if ( in_array( $page_base, array( 'admin-ajax', 'edit' ) ) ) {
			add_action( 'manage_' . $this->post_type . '_posts_columns', array( $this->page, 'manage_posts_columns' ) );

			add_action( 'manage_' . $this->post_type . '_posts_custom_column', array( $this->view, 'render' ), 10, 2 );
		}
	}

}
