<?php

/**
 * @package MakePathsRelative\Main
 */

/**
 * Plugin Name: Make Paths Relative
 * Version: 0.4
 * Plugin URI: https://wordpress.org/plugins/make-paths-relative/
 * Description: This plugin converts the URL(Links) to relative instead of absolute.
 * Donate link: https://www.paypal.me/yasglobal
 * Author: YAS Global Team
 * Author URI: https://www.yasglobal.com/web-design-development/wordpress/make-paths-relative/
 * Text Domain: make-paths-relative
 * License: GPL v3
 */

 /**
 *  Make Paths Relative
 *  Copyright (C) 2016-2017, Sami Ahmed Siddiqui <sami.siddiqui@yasglobal.com>
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.

 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.

 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

// Make sure we don't expose any info if called directly
if( !defined('ABSPATH') ) {
  echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
  exit;
}

if( !function_exists("add_action") || !function_exists("add_filter") ) {
  header( 'Status: 403 Forbidden' );
  header( 'HTTP/1.1 403 Forbidden' );
  exit();
}

if( !defined('MAKE_PATHS_RELATIVE_PLUGIN_VERSION') ) {
  define('MAKE_PATHS_RELATIVE_PLUGIN_VERSION', '0.4');
}

if( !defined('MAKE_PATHS_RELATIVE__PLUGIN_DIR') ) {
  define('MAKE_PATHS_RELATIVE__PLUGIN_DIR', plugin_dir_path( __FILE__ ));
}

if( !is_admin() ) {
  require_once(MAKE_PATHS_RELATIVE__PLUGIN_DIR.'frontend/class.make-paths-relative.php');   
  add_action( 'init', array( 'Make_Paths_Relative', 'init' ) );
} else {
  require_once(MAKE_PATHS_RELATIVE__PLUGIN_DIR.'admin/class.make-paths-relative-admin.php');
  add_action( 'init', array( 'Make_Paths_Relative_Admin', 'init' ) );

  require_once(MAKE_PATHS_RELATIVE__PLUGIN_DIR.'frontend/class.make-paths-relative.php');   
  add_action( 'init', array( 'Make_Paths_Relative', 'init' ) );

  $plugin = plugin_basename(__FILE__); 
  add_filter("plugin_action_links_$plugin", 'make_paths_relative_settings_link' );
}

function make_paths_relative_settings_link($links) { 
  $settings_link = '<a href="admin.php?page=make-paths-relative-settings">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}
