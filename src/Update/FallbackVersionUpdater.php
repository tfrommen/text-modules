<?php # -*- coding: utf-8 -*-

namespace tfrommen\TextModules\Update;

/**
 * Handles all update-related stuff.
 *
 * @package tfrommen\TextModules\Update
 * @since   2.0.0
 */
final class FallbackVersionUpdater implements Updater {

	/**
	 * @var string
	 */
	private $version;

	/**
	 * Constructor. Sets up the properties.
	 *
	 * @since 2.0.0
	 *
	 * @param string $version Optional. Current plugin version. Defaults to '0'.
	 */
	public function __construct( $version = '0' ) {

		$this->version = (string) $version;
	}

	/**
	 * Updates the plugin data.
	 *
	 * @since 2.0.0
	 *
	 * @return bool Whether or not the plugin data was updated.
	 */
	public function update() {

		if ( get_option( self::OPTION_NAME ) === $this->version ) {
			return false;
		}

		update_option( self::OPTION_NAME, $this->version );

		return true;
	}
}
