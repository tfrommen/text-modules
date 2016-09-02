<?php # -*- coding: utf-8 -*-

namespace tfrommen\TextModules\Widget;

use tfrommen\TextModules\Core\PostType;
use WP_Post;

/**
 * Widget form view.
 *
 * @package tfrommen\TextModules\Widget
 * @since   2.0.0
 */
class FormView {

	/**
	 * @var string
	 */
	private $post_type;

	/**
	 * Constructor. Sets up the properties.
	 *
	 * @since 2.0.0
	 *
	 * @param string $post_type Optional. Post type name. Defaults to empty string.
	 */
	public function __construct( $post_type = '' ) {

		$this->post_type = $post_type ? (string) $post_type : ( new PostType() )->get_post_type();
	}

	/**
	 * Renders the HTML.
	 *
	 * @since   2.0.0
	 * @wp-hook {$widget_action_prefix}_render_form
	 *
	 * @param Widget $widget   Widget model.
	 * @param array  $instance Current settings.
	 *
	 * @return void
	 */
	public function render( Widget $widget, array $instance ) {

		$key = 'title';

		$id = $widget->get_field_id( $key );

		$value = isset( $instance[ $key ] ) ? $instance[ $key ] : '';
		?>
		<p>
			<label for="<?php echo $id; ?>">
				<?php esc_html_e( 'Title:', 'text-modules' ); ?>
			</label>
			<input type="text" name="<?php echo $widget->get_field_name( $key ); ?>" id="<?php echo $id; ?>"
				class="widefat" value="<?php echo esc_attr( $value ); ?>">
		</p>
		<?php
		$key = 'post_id';

		$id = $widget->get_field_id( $key );

		$posts = $this->get_posts();
		?>
		<p>
			<label for="<?php echo $id; ?>">
				<?php esc_html_e( 'Text Module:', 'text-modules' ); ?>
			</label>
			<select name="<?php echo $widget->get_field_name( $key ); ?>" id="<?php echo $id; ?>" class="widefat">
				<?php if ( $posts ) : ?>
					<?php
					$value = isset( $instance[ $key ] ) ? $instance[ $key ] : 0;

					/* translators: 1: post title, 2: post ID */
					$format = esc_html_x( '%s (ID: %d)', 'Widget form option format', 'text-modules' );
					?>
					<?php foreach ( $posts as $post ) : ?>
						<option value="<?php echo $post->ID; ?>" <?php selected( $value, $post->ID ); ?>>
							<?php
							printf(
								$format,
								$post->post_title,
								$post->ID
							);
							?>
						</option>
					<?php endforeach; ?>
				<?php else : ?>
					<?php $post_type_object = get_post_type_object( $this->post_type ); ?>
					<option value="" selected="selected"><?php echo $post_type_object->labels->not_found; ?></option>
				<?php endif; ?>
			</select>
		</p>
		<?php
	}

	/**
	 * Returns all text modules.
	 *
	 * @return WP_Post[] Text module posts.
	 */
	private function get_posts() {

		/**
		 * Filters the widget form query args.
		 *
		 * @since 2.0.0
		 *
		 * @param array $args Query args.
		 */
		$args = (array) apply_filters( 'text_modules_widget_form_query_args', [
			'post_type'      => $this->post_type,
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
			'no_found_rows'  => true,
		] );

		$posts = get_posts( $args );

		return $posts;
	}
}
