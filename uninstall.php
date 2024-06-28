<?php
/**
 * Make Paths Relative Uninstall
 *
 * Delete Options on uninstalling the Plugin.
 *
 * @package MakePathsRelative
 * @since 0.5.3
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( 'make_paths_relative' );
delete_option( 'make_paths_relative_exclude' );
delete_option( 'make_paths_relative_settings' );

// Clear any cached data that has been removed.
wp_cache_flush();
