<?php # -*- coding: utf-8 -*-

namespace tf\TextModules\Models;

/**
 * Class PostType
 *
 * @package tf\TextModules\Models
 */
class PostType {

	/**
	 * @var string
	 */
	private $post_type;

	/**
	 * Constructor. Set up the properties.
	 */
	public function __construct() {

		/**
		 * Filter the post type.
		 *
		 * @param string $post_type Post type.
		 */
		$this->post_type = apply_filters( 'text_modules_post_type', 'text_module' );
	}

	/**
	 * Return the post type slug.
	 *
	 * @return string
	 */
	public function get_post_type() {

		return $this->post_type;
	}

	/**
	 * Register the post type.
	 *
	 * @wp-hook wp_loaded
	 *
	 * @return void
	 */
	public function register() {

		$labels = array(
			'name'               => _x( 'Text Modules', 'Post type general name', 'text-modules' ),
			'singular_name'      => _x( 'Text Module', 'Post type singular name', 'text-modules' ),
			'menu_name'          => _x( 'Text Modules', 'Post type menu name', 'text-modules' ),
			'name_admin_bar'     => _x( 'Text Module', 'Post type admin bar name', 'text-modules' ),
			'all_items'          => __( 'All Text Modules', 'text-modules' ),
			'add_new'            => _x( 'Add New', 'Add new post', 'text-modules' ),
			'add_new_item'       => __( 'Add New Text Module', 'text-modules' ),
			'edit_item'          => __( 'Edit Text Module', 'text-modules' ),
			'new_item'           => __( 'New Text Module', 'text-modules' ),
			'view_item'          => __( 'View Text Module', 'text-modules' ),
			'search_items'       => __( 'Search Text Modules', 'text-modules' ),
			'not_found'          => __( 'No text modules found.', 'text-modules' ),
			'not_found_in_trash' => __( 'No text modules found in Trash.', 'text-modules' ),
			'parent_item_colon'  => '',
		);
		/**
		 * Filter the post type labels.
		 *
		 * @param array $labels Post type labels.
		 */
		$labels = apply_filters( 'text_modules_post_type_labels', $labels );

		$description = __( '', 'text-modules' );
		/**
		 * Filter the post type description.
		 *
		 * @param string $description Post type description.
		 */
		$description = apply_filters( 'text_modules_post_type_description', $description );

		$supports = array(
			'title',
			'editor',
		);
		/**
		 * Filter the post type supports.
		 *
		 * @param array $supports Post type supports.
		 */
		$supports = apply_filters( 'text_modules_post_type_supports', $supports );

		$args = array(
			'labels'              => $labels,
			'description'         => $description,
			'public'              => TRUE,
			'hierarchical'        => FALSE,
			'exclude_from_search' => TRUE,
			'publicly_queryable'  => FALSE,
			'show_ui'             => TRUE,
			'show_in_nav_menus'   => FALSE,
			'menu_icon'           => 'dashicons-text',
			'supports'            => $supports,
			'rewrite'             => FALSE,
		);
		/**
		 * Filter the post type args.
		 *
		 * @param array $args Post type args.
		 */
		$args = apply_filters( 'text_modules_post_type_args', $args );

		register_post_type( $this->post_type, $args );
	}

}
