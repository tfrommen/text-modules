<?php # -*- coding: utf-8 -*-

namespace tfrommen\TextModules\Uninstall;

use tfrommen\TextModules\Core\PostType;
use tfrommen\TextModules\Update\Updater;
use wpdb;

/**
 * Handles all uninstall-related stuff.
 *
 * @package tfrommen\TextModules\Uninstall
 * @since   2.0.0
 */
class Uninstaller {

	/**
	 * @var wpdb
	 */
	private $db;

	/**
	 * @var string
	 */
	private $delete_posts_query;

	/**
	 * Constructor. Sets up the properties.
	 *
	 * @since 2.0.0
	 *
	 * @param wpdb $db Database object.
	 */
	public function __construct( wpdb $db ) {

		$this->db = $db;

		$this->delete_posts_query = $db->prepare(
			"SELECT ID FROM {$db->posts} WHERE post_type = %s LIMIT 500",
			( new PostType() )->get_post_type()
		);
	}

	/**
	 * Uninstalls all plugin data.
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public function uninstall() {

		if ( is_multisite() ) {
			$this->uninstall_for_network();

			return;
		}

		$this->uninstall_for_current_site();
	}

	/**
	 * Uninstalls all plugin data for the current site.
	 *
	 * @return void
	 */
	private function uninstall_for_current_site() {

		$this->delete_posts();

		delete_option( Updater::OPTION_NAME );
	}

	/**
	 * Uninstalls all plugin data for the whole network.
	 *
	 * @return void
	 */
	private function uninstall_for_network() {

		foreach ( $this->db->get_col( "SELECT blog_id FROM {$this->db->blogs}" ) as $site_id ) {
			switch_to_blog( $site_id );

			$this->uninstall_for_current_site();

			restore_current_blog();
		}
	}

	/**
	 * Deletes all plugin posts.
	 *
	 * @return void
	 */
	private function delete_posts() {

		while ( $post_ids = $this->db->get_col( $this->delete_posts_query ) ) {
			foreach ( $post_ids as $post_id ) {
				wp_delete_post( $post_id, true );
			}
		}
	}
}
