<?php # -*- coding: utf-8 -*-

namespace tfrommen\TextModules\Core;

/**
 * Plugin data.
 *
 * @package tfrommen\TextModules\Common
 * @since   2.0.0
 */
final class PluginData implements FileData {

	/**
	 * @var string[]
	 */
	private $data;

	/**
	 * Constructor. Sets up the properties.
	 *
	 * @since 2.0.0
	 *
	 * @param string   $file    Main plugin file.
	 * @param string[] $headers Array of file headers.
	 */
	public function __construct( $file, array $headers ) {

		$this->data = get_file_data( $file, $headers );
	}

	/**
	 * Checks if there is a value stored under the given key.
	 *
	 * @since 2.0.0
	 *
	 * @param string $key Header key.
	 *
	 * @returns bool Whether or not there is a value stored under the given key.
	 */
	public function has( $key ) {

		return isset( $this->data[ $key ] );
	}

	/**
	 * Returns the value stored under the given key.
	 *
	 * @since 2.0.0
	 *
	 * @param mixed $key Header key.
	 *
	 * @returns string Value stored under the given key.
	 */
	public function get( $key ) {

		if ( empty( $this->data[ $key ] ) ) {
			return '';
		}

		return (string) $this->data[ $key ];
	}
}
