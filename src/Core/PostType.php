<?php # -*- coding: utf-8 -*-

namespace tfrommen\TextModules\Core;

/**
 * Post type model.
 *
 * @package tfrommen\TextModules\Core
 * @since   2.0.0
 */
class PostType {

	/**
	 * @var string
	 */
	private $post_type;

	/**
	 * Constructor. Sets up the properties.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {

		/**
		 * Filters the post type.
		 *
		 * @since 2.0.0
		 *
		 * @param string $post_type Post type.
		 */
		$this->post_type = (string) apply_filters( 'text_modules_post_type', 'text_module' );
	}

	/**
	 * Returns the post type slug.
	 *
	 * @since 2.0.0
	 *
	 * @return string Post type slug.
	 */
	public function get_post_type() {

		return $this->post_type;
	}

	/**
	 * Registers the post type.
	 *
	 * @since   2.0.0
	 * @wp-hook wp_loaded
	 *
	 * @return void
	 */
	public function register() {

		/**
		 * Filters the post type labels.
		 *
		 * @since 2.0.0
		 *
		 * @param string[] $labels Post type labels.
		 */
		$labels = (array) apply_filters( 'text_modules_post_type_labels', [
			'name'                  => _x( 'Text Modules', 'Post type general name', 'text-modules' ),
			'singular_name'         => _x( 'Text Module', 'Post type singular name', 'text-modules' ),
			'menu_name'             => _x( 'Text Modules', 'Post type menu name', 'text-modules' ),
			'name_admin_bar'        => _x( 'Text Module', 'Post type admin bar name', 'text-modules' ),
			'all_items'             => __( 'All Text Modules', 'text-modules' ),
			'add_new'               => _x( 'Add New', 'Add new post', 'text-modules' ),
			'add_new_item'          => __( 'Add New Text Module', 'text-modules' ),
			'edit_item'             => __( 'Edit Text Module', 'text-modules' ),
			'new_item'              => __( 'New Text Module', 'text-modules' ),
			'view_item'             => __( 'View Text Module', 'text-modules' ),
			'search_items'          => __( 'Search Text Modules', 'text-modules' ),
			'not_found'             => __( 'No text modules found.', 'text-modules' ),
			'not_found_in_trash'    => __( 'No text modules found in Trash.', 'text-modules' ),
			'parent_item_colon'     => '',
			'filter_items_list'     => __( 'Filter text modules list', 'text-modules' ),
			'items_list_navigation' => __( 'Text modules list navigation', 'text-modules' ),
			'items_list'            => __( 'Text modules list', 'text-modules' ),
		] );

		/**
		 * Filters the post type supports.
		 *
		 * @since 2.0.0
		 *
		 * @param string[] $supports Post type supports.
		 */
		$supports = (array) apply_filters( 'text_modules_post_type_supports', [
			'title',
			'editor',
		] );

		/**
		 * Filters the post type args.
		 *
		 * @since 2.0.0
		 *
		 * @param array $args Post type args.
		 */
		$args = (array) apply_filters( 'text_modules_post_type_args', [
			'labels'              => $labels,
			'public'              => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'show_ui'             => true,
			'show_in_nav_menus'   => false,
			'menu_icon'           => 'dashicons-text',
			'hierarchical'        => false,
			'supports'            => $supports,
			'rewrite'             => false,
		] );

		register_post_type( $this->post_type, $args );
	}
}
