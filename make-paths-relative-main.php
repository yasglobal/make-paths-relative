<?php
/**
 * @package MakePathsRelative\Main
 */

// Make sure we don't expose any info if called directly
if ( ! defined( 'ABSPATH' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

if ( ! function_exists( 'add_action' ) || ! function_exists( 'add_filter' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

define( 'MAKE_PATHS_RELATIVE_PLUGIN_VERSION', '0.5.4' );

if ( ! defined( 'MAKE_PATHS_RELATIVE_PATH' ) ) {
	define( 'MAKE_PATHS_RELATIVE_PATH', plugin_dir_path( MAKE_PATHS_RELATIVE_FILE ) );
}

if ( ! defined( 'MAKE_PATHS_RELATIVE_BASENAME' ) ) {
	define( 'MAKE_PATHS_RELATIVE_BASENAME', plugin_basename( MAKE_PATHS_RELATIVE_FILE ) );
}

if ( is_admin() ) {
	require_once( MAKE_PATHS_RELATIVE_PATH . 'admin/class-make-paths-relative-admin.php' );
	new Make_Paths_Relative_Admin();

	register_activation_hook( MAKE_PATHS_RELATIVE_FILE, 'make_paths_relative_plugin_activate' );
	register_uninstall_hook( MAKE_PATHS_RELATIVE_FILE, 'make_paths_relative_plugin_uninstall' );
}
require_once( MAKE_PATHS_RELATIVE_PATH . 'frontend/class-make-paths-relative.php' );
new Make_Paths_Relative();

function make_paths_relative_plugin_activate() {
	if ( apply_filters( 'make_paths_relative_activate_all', '__false' ) == 1 ) {
		$default_activate =  array(
			'site_url'             =>  '',
			'post_permalinks'      =>  'on',
			'page_permalinks'      =>  'on',
			'archive_permalinks'   =>  'on',
			'author_permalinks'    =>  'on',
			'category_permalinks'  =>  'on',
			'scripts_src'          =>  'on',
			'styles_src'           =>  'on',
			'image_paths'          =>  'on'
		);
		update_option( 'make_paths_relative', serialize( $default_activate ) );
	}
}

/**
 * Remove Option on uninstalling/deleting the Plugin.
 */
function make_paths_relative_plugin_uninstall() {
	delete_option( 'make_paths_relative' );
	delete_option( 'make_paths_relative_exclude' );
}
/**
 * Add textdomain hook for translation
 */
function make_paths_relative_load_plugin_textdomain() {
	load_plugin_textdomain( 'make-paths-relative', FALSE, MAKE_PATHS_RELATIVE_BASENAME . '/i18n/languages/' );
}
add_action( 'plugins_loaded', 'make_paths_relative_load_plugin_textdomain' );
