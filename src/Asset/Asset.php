<?php # -*- coding: utf-8 -*-

namespace tfrommen\TextModules\Asset;

/**
 * Interface for all assets.
 *
 * @package tfrommen\TextModules\Asset
 * @since   2.0.0
 */
interface Asset {

	/**
	 * Enqueues the file.
	 *
	 * @since 2.0.0
	 *
	 * @return bool Whether or not the file has been enqueued.
	 */
	public function enqueue();
}
