<?php # -*- coding: utf-8 -*-

namespace tf\TextModules\Views;

use tf\TextModules\Models;
use tf\TextModules\Widget;

/**
 * Class WidgetForm
 *
 * @package tf\TextModules\Views
 */
class WidgetForm {

	/**
	 * @var array
	 */
	private $instance;

	/**
	 * @var string
	 */
	private $post_type;

	/**
	 * @var Widget
	 */
	private $widget;

	/**
	 * Constructor. Set up the properties.
	 *
	 * @param Widget          $widget    Widget.
	 * @param array           $instance  Widget settings.
	 * @param Models\PostType $post_type Post type model.
	 */
	public function __construct( Widget $widget, array $instance, Models\PostType $post_type ) {

		$this->widget = $widget;

		$this->instance = $instance;

		$this->post_type = $post_type->get_post_type();
	}

	/**
	 * Render the HTML.
	 *
	 * @return void
	 */
	public function render() {

		$key = 'title';
		$id = $this->widget->get_field_id( $key );
		$name = $this->widget->get_field_name( $key );
		$value = isset( $this->instance[ $key ] ) ? esc_attr( $this->instance[ $key ] ) : '';
		?>
		<p>
			<label for="<?php echo $id; ?>">
				<?php _e( 'Title:', 'text-modules' ); ?>
			</label>
			<input type="text" name="<?php echo $name; ?>" id="<?php echo $id; ?>" class="widefat"
				value="<?php echo $value; ?>">
		</p>
		<?php
		$key = 'post_id';
		$id = $this->widget->get_field_id( $key );
		$name = $this->widget->get_field_name( $key );
		$value = isset( $this->instance[ $key ] ) ? esc_attr( $this->instance[ $key ] ) : 0;

		$args = array(
			'post_type'      => $this->post_type,
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
			'no_found_rows'  => TRUE,
		);
		/**
		 * Filter the widget form query args.
		 *
		 * @param array $args Query args.
		 */
		$args = apply_filters( 'text_modules_widget_form_query_args', $args );
		$posts = get_posts( $args );

		$have_posts = is_array( $posts ) && $posts;

		$post_type_object = get_post_type_object( $this->post_type );
		?>
		<p>
			<label for="<?php echo $id; ?>">
				<?php _e( 'Text Module:', 'text-modules' ); ?>
			</label>
			<select name="<?php echo $name; ?>" id="<?php echo $id; ?>" class="widefat">
				<?php if ( $have_posts ) : ?>
					<?php foreach ( $posts as $post ) : ?>
						<option value="<?php echo $post->ID; ?>" <?php selected( $value, $post->ID ); ?>>
							<?php
							$format = _x( '%s (ID: %d)', 'Widget form option format, %s = Post title, %d = Post ID', 'text-modules' );
							printf(
								$format,
								$post->post_title,
								$post->ID
							);
							?>
						</option>
					<?php endforeach; ?>
				<?php else : ?>
					<option value="" selected="selected"><?php echo $post_type_object->labels->not_found; ?></option>
				<?php endif; ?>
			</select>
		</p>
	<?php
	}

}
