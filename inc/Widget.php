<?php # -*- coding: utf-8 -*-

namespace tf\TextModules;

/**
 * Class Widget
 */
class Widget extends \WP_Widget {

	/**
	 * @var Models\PostType
	 */
	private $post_type;

	/**
	 * @var Models\Shortcode
	 */
	private $shortcode;

	/**
	 * Constructor. Set up the environment and call the parent constructor.
	 */
	public function __construct() {

		$this->post_type = new Models\PostType();
		$this->shortcode = new Models\Shortcode( $this->post_type );

		$id_base = 'text-modules';
		$name = esc_html_x( 'Text Module', 'Widget title', 'text-modules' );
		$description = esc_html_x( 'Displays a specific text module.', 'Widget description', 'text-modules' );
		$widget_options = array(
			'classname'   => 'widget-' . $id_base,
			'description' => $description,
		);
		parent::__construct( $id_base, $name, $widget_options );
	}

	/**
	 * Register the widget.
	 *
	 * @wp-hook widgets_init
	 *
	 * @return void
	 */
	public function register() {

		register_widget( __CLASS__ );
	}

	/**
	 * Render the settings form.
	 *
	 * @param array $instance Current settings.
	 *
	 * @return void
	 */
	public function form( $instance ) {

		$view = new Views\WidgetForm( $this, $instance, $this->post_type );
		$view->render();
	}

	/**
	 * Update the widget settings.
	 *
	 * @param array $new_instance New settings as input by the user.
	 * @param array $instance     Current settings.
	 *
	 * @return array
	 */
	public function update( $new_instance, $instance ) {

		if ( isset( $new_instance[ 'title' ] ) ) {
			$instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
		}

		if ( isset( $new_instance[ 'post_id' ] ) ) {
			$instance[ 'post_id' ] = absint( $new_instance[ 'post_id' ] );
		}

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions[ $this->option_name ] ) ) {
			delete_option( $this->option_name );
		}

		return $instance;
	}

	/**
	 * Render the widget.
	 *
	 * @param array $args     Display arguments including before_title, after_title, before_widget, and after_widget.
	 * @param array $instance Current settings.
	 *
	 * @return void
	 */
	public function widget( $args, $instance ) {

		$view = new Views\Widget(
			$args,
			$instance,
			$this->id_base,
			$this->shortcode
		);
		$view->render();
	}

}
