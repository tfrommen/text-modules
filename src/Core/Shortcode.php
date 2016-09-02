<?php # -*- coding: utf-8 -*-

namespace tfrommen\TextModules\Core;

use WP_Post;

/**
 * Shortcode model.
 *
 * @package tfrommen\TextModules\Core
 * @since    2.0.0
 */
class Shortcode {

	/**
	 * @var array
	 */
	private $attribute_names = [];

	/**
	 * @var string
	 */
	private $post_type;

	/**
	 * @var string
	 */
	private $shortcode_tag;

	/**
	 * @var bool
	 */
	private $use_slug;

	/**
	 * Constructor. Set up the properties.
	 *
	 * @since 2.0.0
	 *
	 * @param string $post_type Optional. Post type name. Defaults to empty string.
	 */
	public function __construct( $post_type = '' ) {

		$this->post_type = $post_type ? (string) $post_type : ( new PostType() )->get_post_type();

		/**
		 * Filters the 'id' shortcode attribute name.
		 *
		 * @param string $name Attribute name.
		 */
		$this->attribute_names['id'] = (string) apply_filters( 'text_modules_shortcode_id_attribute_name', 'id' );

		/**
		 * Filters the 'slug' shortcode attribute name.
		 *
		 * @param string $name Attribute name.
		 */
		$this->attribute_names['slug'] = (string) apply_filters( 'text_modules_shortcode_slug_attribute_name', 'slug' );

		/**
		 * Filters the shortcode tag.
		 *
		 * @param string $shortcode_tag Shortcode tag.
		 */
		$this->shortcode_tag = (string) apply_filters( 'text_modules_shortcode_tag', 'text_module' );

		/**
		 * Filters if the shortcode (query) should use the post slug instead of the post ID.
		 *
		 * @param bool $use_slug Use slug instead of ID?
		 */
		$this->use_slug = (bool) apply_filters( 'text_modules_shortcode_use_slug', false );
	}

	/**
	 * Adds the shortcode.
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public function add() {

		/**
		 * Filters the shortcode callback.
		 *
		 * @param callable $callback Shortcode callback.
		 */
		$callback = apply_filters( 'text_modules_shortcode_callback', [ $this, 'callback' ] );
		add_shortcode( $this->shortcode_tag, $callback );
	}

	/**
	 * The shortcode callback.
	 *
	 * @since 2.0.0
	 *
	 * @param array $atts Shortcode attributes.
	 *
	 * @return string Shortcode output.
	 */
	public function callback( array $atts ) {

		$args = [
			'post_type'      => $this->post_type,
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'no_found_rows'  => true,
		];

		$name = $this->attribute_names['id'];

		$id = isset( $atts[ $name ] ) ? (int) $atts[ $name ] : 0;
		if ( $id ) {
			$args['p'] = $id;
		}

		$name = $this->attribute_names['slug'];

		$slug = isset( $atts[ $name ] ) ? $atts[ $name ] : '';
		if ( $slug && ( $this->use_slug || ! $id ) ) {
			unset( $args['p'] );

			$args['name'] = $slug;
		}

		if ( ! $id && ! $slug ) {
			return '';
		}

		/**
		 * Filters the shortcode query args.
		 *
		 * @param array $args Shortcode query args.
		 */
		$args = (array) apply_filters( 'text_modules_shortcode_query_args', $args );

		$posts = get_posts( $args );
		if ( ! $posts ) {
			return '';
		}

		$post = reset( $posts );
		if ( ! isset( $post->post_content ) ) {
			return '';
		}

		/**
		 * Filters the shortcode output.
		 *
		 * @param string  $shortcode Shortcode output.
		 * @param array   $atts      Shortcode attributes array.
		 * @param WP_Post $post      Post object.
		 */
		$shortcode = (string) apply_filters( 'text_modules_shortcode_output', $post->post_content, $atts, $post );

		/**
		 * Filters if the shortcode should apply do_shortcode() to the output.
		 *
		 * @param bool $do_shortcode Should the shortcode apply do_shortcode()?
		 */
		if ( apply_filters( 'text_modules_shortcode_apply_do_shortcode', true ) ) {
			$shortcode = do_shortcode( $shortcode );
		}

		return $shortcode;
	}

	/**
	 * Returns the shortcode for the given post ID.
	 *
	 * @since 2.0.0
	 *
	 * @param int $post_id Optional. Post ID. Defaults to 0.
	 *
	 * @return string
	 */
	public function get_shortcode( $post_id = 0 ) {

		$post_id = $post_id ? (int) $post_id : get_the_ID();

		if ( $this->use_slug ) {
			$post = get_post( $post_id );
			if ( $post ) {
				return sprintf(
					'[%s %s="%s"]',
					$this->shortcode_tag,
					$this->attribute_names['slug'],
					$post->post_name
				);
			}

			return '';
		}

		return sprintf(
			'[%s %s="%d"]',
			$this->shortcode_tag,
			$this->attribute_names['id'],
			$post_id
		);
	}
}
