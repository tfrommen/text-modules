<?php # -*- coding: utf-8 -*-

namespace tfrommen\TextModules\Core;

/**
 * Interface for all file data implementations.
 *
 * @package tfrommen\TextModules\Core
 * @since   2.0.0
 */
interface FileData {

	/**
	 * Checks if there is a value stored under the given key.
	 *
	 * @since 2.0.0
	 *
	 * @param string $key Header key.
	 *
	 * @returns bool Whether or not there is a value stored under the given key.
	 */
	public function has( $key );

	/**
	 * Returns the value stored under the given key.
	 *
	 * @since 2.0.0
	 *
	 * @param mixed $key Header key.
	 *
	 * @returns string Value stored under the given key.
	 */
	public function get( $key );
}
