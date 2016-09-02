<?php # -*- coding: utf-8 -*-
/**
 * Plugin Name: Text Modules
 * Plugin URI:  https://wordpress.org/plugins/text-modules/
 * Description: Use the new Text Module custom post type and display a text module by either shortcode or widget.
 * Author:      Thorsten Frommen
 * Author URI:  http://tfrommen.de
 * Version:     2.0.0
 * Text Domain: text-modules
 * License:     MIT
 */

namespace tfrommen\TextModules;

function_exists( 'add_action' ) or die();

/**
 * Bootstraps the plugin.
 *
 * @since   2.0.0
 * @wp-hook plugins_loaded
 *
 * @return void
 */
function bootstrap() {

	if ( is_readable( __DIR__ . '/vendor/autoload.php' ) ) {
		/**
		 * Composer-generated autoload file.
		 */
		require_once __DIR__ . '/vendor/autoload.php';
	}

	( new Plugin( __FILE__ ) )->initialize();
}

add_action( 'plugins_loaded', __NAMESPACE__ . '\bootstrap' );
