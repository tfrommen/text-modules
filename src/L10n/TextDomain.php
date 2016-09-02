<?php # -*- coding: utf-8 -*-

namespace tfrommen\TextModules\L10n;

use tfrommen\TextModules\Core\FileData;

/**
 * Text domain.
 *
 * @package tfrommen\TextModules\L10n
 * @since   2.0.0
 */
class TextDomain {

	/**
	 * @var string
	 */
	private $domain;

	/**
	 * Constructor. Sets up the properties.
	 *
	 * @since 2.0.0
	 *
	 * @param FileData $plugin_data Plugin data object.
	 */
	public function __construct( FileData $plugin_data ) {

		$this->domain = $plugin_data->get( 'text_domain' );
	}

	/**
	 * Loads the plugin text domain.
	 *
	 * @since 2.0.0
	 *
	 * @return bool Whether or not the text domain was loaded successfully.
	 */
	public function load() {

		return load_plugin_textdomain( $this->domain );
	}
}
