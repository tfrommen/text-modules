# Text Modules

Have you ever wanted to use some pieces of text information more than once? For instance, contact information such as a postal address? Or some slogan, motto or claim?

This is exactly when _Text Modules_ kicks in.

## Installation

1. Upload the `text-modules` folder to the `/wp-content/plugins/` directory on your web server.
1. Activate the plugin through the _Plugins_ menu in WordPress.
1. Find the new _Text Modules_ menu in your WordPress backend.

## Usage

This plugin registers a simple post type for text modules. A text module can be accessed either via shortcode (by means of the text module's ID or slug) or via a new Tex Modules widget.

### Filters

In order to customize certain aspects of the plugin, it provides you with several filters. For each of these, a short description as well as a code example on how to alter the default behavior is given below. Just put the according code snippet in your theme's `functions.php` file or your _customization_ plugin, or to some other appropriate place.

### `text_modules_after_widget_content`

This filter lets you alter the HTML after the widget content.

```php
/**
 * Filter the HTML after the widget content.
 *
 * @param string $after_widget_content Some HTML after the widget content.
 */
add_filter( 'text_modules_after_widget_content', function() {

	return '<!-- End of Text Modules widget content -->';
} );
```

### `text_modules_before_widget_content`

This filter lets you alter the HTML before the widget content.

```php
/**
 * Filter the HTML before the widget content.
 *
 * @param string $before_widget_content Some HTML before the widget content.
 */
add_filter( 'text_modules_before_widget_content', function() {

	return '<!-- Start of Text Modules widget content -->';
} );
```

### `text_modules_post_type`

Yes, you can alter the post type (slug).

```php
/**
 * Filter the post type.
 *
 * @param string $post_type Post type.
 */
add_filter( 'text_modules_post_type', function() {

	return 'exotic_stuff';
} );
```

### `text_modules_post_type_args`

If you want to alter a specific post type argument but you can't find a fitting filter, there's `text_modules_post_type_args`, which provides you with the complete args array.

```php
/**
 * Filter the post type args.
 *
 * @param array $args Post type args.
 */
add_filter( 'text_modules_post_type_args', function( $args ) {

	// Use hierarchical external content
	$args[ 'hierarchical' ] = TRUE;

	return $args;
} );
```

### `text_modules_post_type_description`

The post type description can be customized by using the `text_modules_post_type_description` filter.

```php
/**
 * Filter the post type description.
 *
 * @param string $description Post type description.
 */
add_filter( 'text_modules_post_type_description', function() {

	// Provide a description
	return 'Simple post type for text modules.';
} );
```

### `text_modules_post_type_labels`

In case you don't like the labels, easily adapt them to your liking.

```php
/**
 * Filter the post type labels.
 *
 * @param array $labels Post type labels.
 */
add_filter( 'text_modules_post_type_labels', function( $labels ) {

	// A little more horror, please...
	$labels[ 'not_found' ] = 'ZOMG, no text module found!!1!!1!!oneone!!!1!eleven!1!';

	return $labels;
} );
```

### `text_modules_post_type_supports`

This filter provides you with the post type supports.

```php
/**
 * Filter the post type supports.
 *
 * @param array $supports Post type supports.
 */
add_filter( 'text_modules_post_type_supports', function( $supports ) {

	// Let's add revisions for our post type
	if ( ! in_array( 'revisions', $supports ) ) {
		$supports[] = 'revisions';
	}

	return $supports;
} );
```

### `text_modules_shortcode_apply_do_shortcode`

By default, do_shortcode() will be called on the shortcode output. Of course, you can change that.

```php
/**
 * Filter if the shortcode should apply do_shortcode() to the output.
 *
 * @param bool $do_shortcode Should the shortcode apply do_shortcode()?
 */
add_filter( 'text_modules_shortcode_apply_do_shortcode', '__return_false' );
```

### `text_modules_shortcode_callback`

In case you would like to adapt how the shortcode data is handled, you can provide your own shortcode callback. This can either be a string holding the function name, or an array with either a class name or an object, and the according method.

```php
/**
 * Filter the shortcode callback.
 *
 * @param array|string $callback Shortcode callback.
 */
add_filter( 'text_modules_shortcode_callback', function() {

	return 'my_text_modules_shortcode_callback';
} );
```

### `text_modules_shortcode_id_attribute_name`

This filter lets you alter the shortcode's 'id' attribute name.

```php
/**
 * Filter the 'id' shortcode attribute name.
 *
 * @param string $name Attribute name.
 */
add_filter( 'text_modules_shortcode_id_attribute_name', function() {

	return 'post_id';
} );
```

### `text_modules_shortcode_output`

This filter lets you alter the shortcode output. The second parameter holds the shortcode attributes array.

```php
/**
 * Filter the shortcode output.
 *
 * @param string $output Shortcode output.
 * @param array  $atts   Shortcode attributes array.
 */
add_filter( 'text_modules_shortcode_output', function( $output ) {

	return $output . ' Over and out.';
} );
```

### `text_modules_shortcode_query_args`

Also, there's `text_modules_shortcode_query_args`, which provides you with the complete args array for the shortcode's query.

```php
/**
 * Filter the shortcode query args.
 *
 * @param array $args Shortcode query args.
 */
add_filter( 'text_modules_shortcode_query_args', function( $args ) {

	// Exclude some text modules by ID
	$args[ 'post__not_in' ] = array( 4, 8, 15, 16, 23, 42 );

	return $args;
} );
```

### `text_modules_shortcode_slug_attribute_name`

This filter lets you alter the shortcode's 'slug' attribute name.

```php
/**
 * Filter the 'slug' shortcode attribute name.
 *
 * @param string $name Attribute name.
 */
add_filter( 'text_modules_shortcode_slug_attribute_name', function() {

	return 'post_slug';
} );
```

### `text_modules_shortcode_tag`

This filter lets you alter the shortcode's tag.

```php
/**
 * Filter the shortcode tag.
 *
 * @param string $shortcode_tag Shortcode tag.
 */
add_filter( 'text_modules_shortcode_tag', function() {

	return 'text_block';
} );
```

### `text_modules_shortcode_use_slug`

By default, text modules are being queried by their post ID first. Of course, you can change that and use the post slug instead.

```php
/**
 * Filter if the shortcode (query) should use the post slug instead of the post ID.
 *
 * @param bool $use_slug Use slug instead of ID?
 */
add_filter( 'text_modules_shortcode_use_slug', '__return_true' );
```

### `text_modules_widget_form_query_args`

Also, there's `text_modules_widget_form_query_args`, which provides you with the complete args array for the widget form's query.

```php
/**
 * Filter the widget form query args.
 *
 * @param array $args Query args.
 */
add_filter( 'text_modules_widget_form_query_args', function( $args ) {

	// Exclude some text modules by ID
	$args[ 'post__not_in' ] = array( 4, 8, 15, 16, 23, 42 );

	return $args;
} );
```

## Contribution

If you have a feature request, or if you have developed the feature already, please feel free to use the Issues and/or Pull Requests section.

Of course, you can also provide me with translations if you would like to use the plugin in another not yet included language.

## Changelog

[Changelog](CHANGELOG.md)
