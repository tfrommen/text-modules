<?php # -*- coding: utf-8 -*-

namespace tf\TextModules\Models;

/**
 * Class Shortcode
 *
 * @package tf\TextModules\Models
 */
class Shortcode {

	/**
	 * @var array
	 */
	private $attribute_names = array();

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
	 * @param PostType $post_type Post type model.
	 */
	public function __construct( PostType $post_type ) {

		$this->post_type = $post_type->get_post_type();

		/**
		 * Filter the 'id' shortcode attribute name.
		 *
		 * @param string $name Attribute name.
		 */
		$this->attribute_names[ 'id' ] = apply_filters( 'text_modules_shortcode_id_attribute_name', 'id' );

		/**
		 * Filter the 'slug' shortcode attribute name.
		 *
		 * @param string $name Attribute name.
		 */
		$this->attribute_names[ 'slug' ] = apply_filters( 'text_modules_shortcode_slug_attribute_name', 'slug' );

		/**
		 * Filter the shortcode tag.
		 *
		 * @param string $shortcode_tag Shortcode tag.
		 */
		$this->shortcode_tag = apply_filters( 'text_modules_shortcode_tag', 'text_module' );

		/**
		 * Filter if the shortcode (query) should use the post slug instead of the post ID.
		 *
		 * @param bool $use_slug Use slug instead of ID?
		 */
		$this->use_slug = apply_filters( 'text_modules_shortcode_use_slug', FALSE );
	}

	/**
	 * Add the shortcode.
	 *
	 * @return void
	 */
	public function add() {

		/**
		 * Filter the shortcode callback.
		 *
		 * @param array|string $callback Shortcode callback.
		 */
		$callback = apply_filters( 'text_modules_shortcode_callback', array( $this, 'callback' ) );
		add_shortcode( $this->shortcode_tag, $callback );
	}

	/**
	 * The shortcode callback.
	 *
	 * @param array $atts Shortcode attributes.
	 *
	 * @return string
	 */
	public function callback( $atts ) {

		$args = array(
			'post_type'      => $this->post_type,
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'no_found_rows'  => TRUE,
		);

		$name = $this->attribute_names[ 'id' ];
		$id = isset( $atts[ $name ] ) ? absint( $atts[ $name ] ) : 0;
		if ( $id ) {
			$args[ 'p' ] = $id;
		}

		$name = $this->attribute_names[ 'slug' ];
		$slug = ( isset( $atts[ $name ] ) ) ? $atts[ $name ] : '';
		if (
			$slug
			&& (
				$this->use_slug
				|| ! $id
			)
		) {
			unset( $args[ 'p' ] );
			$args[ 'name' ] = $slug;
		}

		/**
		 * Filter the shortcode query args.
		 *
		 * @param array $args Shortcode query args.
		 */
		$args = apply_filters( 'text_modules_shortcode_query_args', $args );
		$post = get_posts( $args );
		if ( ! $post ) {
			return '';
		}

		$post = reset( $post );
		if ( ! isset( $post->post_content ) ) {
			return '';
		}

		$output = $post->post_content;
		/**
		 * Filter the shortcode output.
		 *
		 * @param string $output Shortcode output.
		 * @param array  $atts   Shortcode attributes array.
		 */
		$output = apply_filters( 'text_modules_shortcode_output', $output, $atts );

		/**
		 * Filter if the shortcode should apply do_shortcode() to the output.
		 *
		 * @param bool $do_shortcode Should the shortcode apply do_shortcode()?
		 */
		if ( apply_filters( 'text_modules_shortcode_apply_do_shortcode', TRUE ) ) {
			$output = do_shortcode( $output );
		}

		return $output;
	}

	/**
	 * Get the shortcode for the given post ID.
	 *
	 * @param int $post_id Optional. Post ID. Defaults to 0.
	 *
	 * @return string
	 */
	public function get_shortcode( $post_id = 0 ) {

		$post_id = $post_id ? absint( $post_id ) : get_the_ID();

		if ( $this->use_slug ) {
			$post = get_post( $post_id );
			if ( isset( $post->post_name ) ) {
				return sprintf(
					'[%s %s="%s"]',
					$this->shortcode_tag,
					$this->attribute_names[ 'slug' ],
					$post->post_name
				);
			} else {
				return '';
			}
		} else {
			return sprintf(
				'[%s %s="%s"]',
				$this->shortcode_tag,
				$this->attribute_names[ 'id' ],
				$post_id
			);
		}
	}

}
