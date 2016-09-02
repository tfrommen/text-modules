<?php # -*- coding: utf-8 -*-

namespace tfrommen\TextModules\Update;

/**
 * Interface for all updater implementations.
 *
 * @package tfrommen\TextModules\Update
 * @since   2.0.0
 */
interface Updater {

	/**
	 * Version option name.
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	const OPTION_NAME = 'text_modules_version';

	/**
	 * Updates the plugin data.
	 *
	 * @since 2.0.0
	 *
	 * @return bool Whether or not the plugin data was updated.
	 */
	public function update();
}
