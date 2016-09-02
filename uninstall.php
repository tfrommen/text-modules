<?php # -*- coding: utf-8 -*-

namespace tfrommen\TextModules;

use tfrommen\TextModules\Uninstall\Uninstaller;
use wpdb;

defined( 'WP_UNINSTALL_PLUGIN' ) or die();

if ( is_readable( __DIR__ . '/vendor/autoload.php' ) ) {
	/**
	 * Composer-generated autoload file.
	 */
	require_once __DIR__ . '/vendor/autoload.php';
}

/** @var wpdb $wpdb */
global $wpdb;

( new Uninstaller( $wpdb ) )->uninstall();
