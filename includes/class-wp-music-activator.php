<?php

/**
 * Fired during plugin activation
 *
 * @link       https://profiles.wordpress.org/abditsori/
 * @since      1.0.0
 *
 * @package    Wp_Music
 * @subpackage Wp_Music/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wp_Music
 * @subpackage Wp_Music/includes
 * @author     Abdi Tolessa <tolesaabdi1@gmail.com>
 */
class Wp_Music_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */

	public static function activate() {

		global $wpdb;

		$table_name = $wpdb->prefix . 'wp_music';
		$wpdb_collate = $wpdb->collate;

		$sql = "CREATE TABLE $table_name (
			post_id mediumint(8) unsigned NOT NULL,
			composer_name varchar(255) NULL,
			publisher varchar(255) NULL,
			year_of_recording varchar(255) NULL,
			additional_contributors varchar(255) NULL,
			url varchar(255) NULL,
			price double(8,2) NULL,
			PRIMARY KEY  (post_id)
			)
			COLLATE $wpdb_collate";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta( $sql );
	}

}
