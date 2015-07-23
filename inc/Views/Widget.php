<?php # -*- coding: utf-8 -*-

namespace tf\TextModules\Views;

use tf\TextModules\Models;

/**
 * Class Widget
 *
 * @package tf\TextModules\Views
 */
class Widget {

	/**
	 * @var string
	 */
	private $after_widget;

	/**
	 * @var string
	 */
	private $before_widget;

	/**
	 * @var string
	 */
	private $shortcode;

	/**
	 * Constructor. Set up the properties.
	 *
	 * @param array            $args      Display arguments including before_title, after_title, before_widget, and
	 *                                    after_widget.
	 * @param array            $instance  Widget settings.
	 * @param string           $id_base   Widget ID base.
	 * @param Models\Shortcode $shortcode Shortcode model.
	 */
	public function __construct(
		array $args,
		array $instance,
		$id_base,
		Models\Shortcode $shortcode
	) {

		$before_widget = isset( $args[ 'before_widget' ] ) ? $args[ 'before_widget' ] : '';
		/**
		 * Filter the HTML before the widget content.
		 *
		 * @param string $before_widget_content Some HTML before the widget content.
		 */
		$before_widget_content = apply_filters( 'text_modules_before_widget_content', '' );
		$this->before_widget = $before_widget . $before_widget_content;

		/**
		 * Filter the HTML after the widget content.
		 *
		 * @param string $after_widget_content Some HTML after the widget content.
		 */
		$after_widget_content = apply_filters( 'text_modules_after_widget_content', '' );
		$after_widget = isset( $args[ 'after_widget' ] ) ? $args[ 'after_widget' ] : '';
		$this->after_widget = $after_widget_content . $after_widget;

		$post_id = 0;
		if ( isset( $instance[ 'post_id' ] ) ) {
			$post_id = absint( $instance[ 'post_id' ] );
		}

		$title = '';
		if ( isset( $instance[ 'title' ] ) ) {
			$title = esc_attr( $instance[ 'title' ] );
		}
		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $id_base );
		if ( $title ) {
			if ( isset( $args[ 'before_title' ] ) ) {
				$this->before_widget .= $args[ 'before_title' ];
			}
			$this->before_widget .= $title;
			if ( isset( $args[ 'after_title' ] ) ) {
				$this->before_widget .= $args[ 'after_title' ];
			}
		}

		$this->shortcode = $shortcode->get_shortcode( $post_id );
	}

	/**
	 * Render the HTML.
	 *
	 * @return void
	 */
	public function render() {

		echo $this->before_widget . do_shortcode( $this->shortcode ) . $this->after_widget;
	}

}
