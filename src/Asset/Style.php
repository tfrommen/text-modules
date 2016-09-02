<?php # -*- coding: utf-8 -*-

namespace tfrommen\TextModules\Asset;

/**
 * Style model.
 *
 * @package tfrommen\TextModules\Asset;
 * @since   2.0.0
 */
final class Style implements Asset {

	/**
	 * File handle.
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	const HANDLE = 'text-modules-admin';

	/**
	 * @var string
	 */
	private $file;

	/**
	 * Constructor. Sets up the properties.
	 *
	 * @since 2.0.0
	 *
	 * @param string $file Main plugin file.
	 */
	public function __construct( $file ) {

		$this->file = (string) $file;
	}

	/**
	 * Enqueues the file.
	 *
	 * @since 2.0.0
	 *
	 * @return bool Whether or not the file has been enqueued.
	 */
	public function enqueue() {

		if ( wp_style_is( self::HANDLE ) ) {
			return false;
		}

		$file = 'assets/css/admin' . ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min' ) . '.css';

		wp_enqueue_style(
			self::HANDLE,
			plugin_dir_url( $this->file ) . $file,
			[],
			filemtime( plugin_dir_path( $this->file ) . $file )
		);

		return true;
	}
}
