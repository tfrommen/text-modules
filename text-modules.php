<?php # -*- coding: utf-8 -*-
/**
 * Plugin Name: Text Modules
 * Plugin URI:  https://wordpress.org/plugins/text-modules/
 * Description: Use the new Text Module custom post type and display a text module by either shortcode or widget.
 * Author:      Thorsten Frommen
 * Author URI:  http://ipm-frommen.de/wordpress
 * Version:     1.0
 * Text Domain: text-modules
 * Domain Path: /languages
 * License:     GPLv3
 */

namespace tf\TextModules;

use tf\Autoloader;

if ( ! function_exists( 'add_action' ) ) {
	return;
}

require_once __DIR__ . '/inc/Autoloader/bootstrap.php';

add_action( 'plugins_loaded', __NAMESPACE__ . '\initialize' );

/**
 * Initialize the plugin.
 *
 * @wp-hook plugins_loaded
 *
 * @return void
 */
function initialize() {

	$autoloader = new Autoloader\Autoloader();
	$autoloader->add_rule( new Autoloader\NamespaceRule( __DIR__ . '/inc', __NAMESPACE__ ) );

	$plugin = new Plugin( __FILE__ );
	$plugin->initialize();
}
