<?php # -*- coding: utf-8 -*-

namespace tfrommen\TextModules\Widget;

use tfrommen\TextModules\Core\Shortcode;

/**
 * Widget front end view.
 *
 * @package tfrommen\TextModules\Widget;
 * @since   2.0.0
 */
class WidgetView {

	/**
	 * @var Shortcode
	 */
	private $shortcode;

	/**
	 * Constructor. Sets up the properties.
	 *
	 * @since 2.0.0
	 *
	 * @param Shortcode $shortcode Shortcode model.
	 */
	public function __construct( Shortcode $shortcode ) {

		$this->shortcode = $shortcode;
	}

	/**
	 * Renders the HTML.
	 *
	 * @since   2.0.0
	 * @wp-hook {$widget_action_prefix}_render
	 *
	 * @param array  $args     Widget arguments.
	 * @param array  $instance Current settings.
	 * @param string $id_base  Widget ID base.
	 *
	 * @return void
	 */
	public function render( array $args, array $instance, $id_base ) {

		$before_widget = $this->get_before_widget( $args );

		$title = $this->get_title( $args, $instance, $id_base );

		$shortcode = $this->get_shortcode( $instance );

		$after_widget = $this->get_after_widget( $args );

		echo $before_widget . $title . $shortcode . $after_widget;
	}

	/**
	 * Returns the before_widget string.
	 *
	 * @param array $args Widget arguments.
	 *
	 * @return string
	 */
	private function get_before_widget( array $args ) {

		$before_widget = isset( $args['before_widget'] ) ? $args['before_widget'] : '';

		/**
		 * Filters the HTML before the widget content.
		 *
		 * @param string $before_widget_content Some HTML before the widget content.
		 */
		$before_widget_content = (string) apply_filters( 'text_modules_before_widget_content', '' );

		return $before_widget . $before_widget_content;
	}

	/**
	 * Returns the widget title.
	 *
	 * @param array  $args     Widget arguments.
	 * @param array  $instance Current settings.
	 * @param string $id_base  Widget ID base.
	 *
	 * @return string
	 */
	private function get_title( array $args, array $instance, $id_base ) {

		$title = '';
		if ( isset( $instance['title'] ) ) {
			$title = esc_html( $instance['title'] );
		}
		/** This filter is documented in wp-includes/default-widgets.php */
		$title = (string) apply_filters( 'widget_title', $title, $instance, $id_base );
		if ( ! $title ) {
			return '';
		}

		if ( isset( $args['before_title'] ) ) {
			$title = $args['before_title'] . $title;
		}

		if ( isset( $args['after_title'] ) ) {
			$title .= $args['after_title'];
		}

		return $title;
	}

	/**
	 * Returns the shortcode.
	 *
	 * @param array $instance Current settings.
	 *
	 * @return string
	 */
	private function get_shortcode( array $instance ) {

		$post_id = 0;
		if ( isset( $instance['post_id'] ) ) {
			$post_id = (int) $instance['post_id'];
		}

		$shortcode = $this->shortcode->get_shortcode( $post_id );
		$shortcode = do_shortcode( $shortcode );
		/** This filter is documented in wp-includes/post-template.php */
		$shortcode = (string) apply_filters( 'the_content', $shortcode );
		$shortcode = str_replace( ']]>', ']]&gt;', $shortcode );

		return $shortcode;
	}

	/**
	 * Returns the after_widget string.
	 *
	 * @param array $args Widget arguments.
	 *
	 * @return string
	 */
	private function get_after_widget( array $args ) {

		/**
		 * Filters the HTML after the widget content.
		 *
		 * @param string $after_widget_content Some HTML after the widget content.
		 */
		$after_widget_content = (string) apply_filters( 'text_modules_after_widget_content', '' );

		$after_widget = isset( $args['after_widget'] ) ? $args['after_widget'] : '';

		return $after_widget_content . $after_widget;
	}
}
