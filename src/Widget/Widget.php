<?php # -*- coding: utf-8 -*-

namespace tfrommen\TextModules\Widget;

use WP_Widget;

/**
 * Widget model.
 *
 * @package tfrommen\TextModules\Widget
 * @since   2.0.0
 */
class Widget extends WP_Widget {

	/**
	 * Name (prefix) for widget actions.
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	const ACTION = 'text_modules.render_widget';

	/**
	 * Constructor. Calls the parent constructor.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {

		$id_base = 'text-modules';

		parent::__construct(
			$id_base,
			esc_html_x( 'Text Module', 'Widget title', 'text-modules' ),
			array(
				'classname'   => "widget-{$id_base}",
				'description' => __( 'Displays a specific text module.', 'text-modules' ),
			)
		);
	}

	/**
	 * Registers the widget.
	 *
	 * @since   2.0.0
	 * @wp-hook widgets_init
	 *
	 * @return void
	 */
	public function register() {

		register_widget( __CLASS__ );
	}

	/**
	 * Renders the settings form.
	 *
	 * @since 2.0.0
	 *
	 * @param array $instance Current settings.
	 *
	 * @return void
	 */
	public function form( $instance ) {

		/**
		 * Fires when the back-end view is rendered.
		 *
		 * @since 2.0.0
		 *
		 * @param Widget $widget   Widget model.
		 * @param array  $instance Current settings.
		 */
		do_action( self::ACTION . '_form', $this, $instance );
	}

	/**
	 * Updates the widget settings.
	 *
	 * @since 2.0.0
	 *
	 * @param array $new_instance New settings as input by the user.
	 * @param array $instance     Current settings.
	 *
	 * @return array Updated widget settings.
	 */
	public function update( $new_instance, $instance ) {

		if ( isset( $new_instance['title'] ) ) {
			$instance['title'] = strip_tags( $new_instance['title'] );
		}

		if ( isset( $new_instance['post_id'] ) ) {
			$instance['post_id'] = (int) $new_instance['post_id'];
		}

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions[ $this->option_name ] ) ) {
			delete_option( $this->option_name );
		}

		return $instance;
	}

	/**
	 * Renders the widget.
	 *
	 * @since 2.0.0
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Current settings.
	 *
	 * @return void
	 */
	public function widget( $args, $instance ) {

		/**
		 * Fires when the front-end view is rendered.
		 *
		 * @since 2.0.0
		 *
		 * @param array  $args     Widget arguments.
		 * @param array  $instance Current settings.
		 * @param string $id_base  Widget ID base.
		 */
		do_action( self::ACTION, $args, $instance, $this->id_base );
	}
}
