<?php
/**
 * Plugin Name: Getnudged Helpful
 * Plugin URI:  https://getnudged.de
 * Description: Ein Plugin das Ihnen eine kleine Ja/Nein Umfrage unter Ihre Beitr&auml;ge setzt und Ihren Leser fragt, ob der Beitrag hilfreich ist oder nicht.
 * Version:     1.1.2
 * Author:      Getnudged
 * Author URI:  https://getnudged.de
 * License:     MIT License
 * License URI: http://opensource.org/licenses/MIT
 */

/**
 * Plugin Update Checker from YahnisElsts
 * https://github.com/YahnisElsts
 */
require 'plugin-update-checker/plugin-update-checker.php';
$className = PucFactory::getLatestClassVersion('PucGitHubChecker');
$myUpdateChecker = new $className(
    'https://github.com/Getnudged/getnudged-helpful/',
    __FILE__,
    'master'
);

/**
 * Database Functions
 */

// DB Version
global $jal_db_version;
$jal_db_version = '1.0';

// Install Table
function jal_install() {
	global $wpdb;
	global $jal_db_version;

	$table_name = $wpdb->prefix . 'helpful';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		post_id mediumint(9) NOT NULL,
		user text NOT NULL,
		status int(1) NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( 'jal_db_version', $jal_db_version );
}
register_activation_hook( __FILE__, 'jal_install' );

// Truncate Table
function delete_all_helpful() {
	global $wpdb;
	$table = $wpdb->prefix . 'helpful';
	$delete = $wpdb->query("TRUNCATE TABLE $table");
}
# register_activation_hook( __FILE__, 'delete_all_helpful' );


/**
 * Load Scripts
 */
function helpful_enqueue_scripts() 
{
	if( is_single() ) {
		wp_enqueue_style( 'helpful', plugins_url( '/helpful.css', __FILE__ ) );
		wp_enqueue_script( 'helpful', plugins_url( '/helpful.js', __FILE__ ), array('jquery'), '1.0', true );
		wp_localize_script( 'helpful', 'helpfulajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ));
	}	
}
add_action( 'wp_enqueue_scripts', 'helpful_enqueue_scripts' );

/**
 * Require Files in Include Folder
 */
foreach ( glob( plugin_dir_path( __FILE__ ) . "includes/*.php" ) as $file ) {
    include_once $file;
}
