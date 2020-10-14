<?php
/**
 * Plugin Name: Make Paths Relative
 * Plugin URI: https://www.yasglobal.com/web-design-development/wordpress/make-paths-relative/
 * Description: This plugin converts the URL(Links) to relative instead of absolute.
 * Version: 1.1.2
 * Author: YAS Global Team
 * Author URI: https://profiles.wordpress.org/sasiddiqui/
 * License: GPLv3
 *
 * Text Domain: make-paths-relative
 * Domain Path: /languages/
 *
 * @package MakePathsRelative
 */

/**
 * Make Paths Relative - Convert Absolute URL to Relative WordPress
 * Copyright (C) 2016-2020, Sami Ahmed Siddiqui <sami.siddiqui@yasglobal.com>
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
if ( ! defined( 'ABSPATH' ) ) {
  echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
  exit;
}

final class Make_Paths_Relative {

  /**
   * Class constructor.
   */
  public function __construct() {
    $this->setup_constants();
    $this->includes();
  }

  /**
   * Setup plugin constants
   *
   * @access private
   * @since 1.0.0
   *
   * @return void
   */
  private function setup_constants() {
    if ( ! defined( 'MAKE_PATHS_RELATIVE_FILE' ) ) {
      define( 'MAKE_PATHS_RELATIVE_FILE', __FILE__ );
    }

    if ( ! defined( 'MAKE_PATHS_RELATIVE_PLUGIN_VERSION' ) ) {
      define( 'MAKE_PATHS_RELATIVE_PLUGIN_VERSION', '1.1.2' );
    }

    if ( ! defined( 'MAKE_PATHS_RELATIVE_PATH' ) ) {
      define( 'MAKE_PATHS_RELATIVE_PATH',
        plugin_dir_path( MAKE_PATHS_RELATIVE_FILE )
      );
    }

    if ( ! defined( 'MAKE_PATHS_RELATIVE_BASENAME' ) ) {
      define( 'MAKE_PATHS_RELATIVE_BASENAME',
        plugin_basename( MAKE_PATHS_RELATIVE_FILE )
      );
    }
  }

  /**
   * Include required files
   *
   * @access private
   * @since 1.0.0
   *
   * @return void
   */
  private function includes() {

    require_once(
      MAKE_PATHS_RELATIVE_PATH . 'frontend/class-make-paths-relative.php'
    );
    new Make_Paths_Relative_Frontend();


    if ( is_admin() ) {
      require_once(
        MAKE_PATHS_RELATIVE_PATH . 'admin/class-make-paths-relative-admin.php'
      );
      new Make_Paths_Relative_Admin();

      add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
      register_activation_hook( MAKE_PATHS_RELATIVE_FILE,
        array( 'Make_Paths_Relative', 'plugin_activate' )
      );
      register_uninstall_hook( MAKE_PATHS_RELATIVE_FILE,
        array( 'Make_Paths_Relative',  'plugin_uninstall' )
      );
    }
  }

  /**
   * Default Settings when the plugin has activated using filter.
   *
   * @access public
   * @since 0.5.3
   *
   * @return void
   */
  public static function plugin_activate() {
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
   *
   * @access public
   * @since 0.5.3
   *
   * @return void
   */
  public static function plugin_uninstall() {
    delete_option( 'make_paths_relative' );
    delete_option( 'make_paths_relative_exclude' );
  }

  /**
   * Add textdomain hook for translation
   *
   * @access public
   * @since 0.5
   *
   * @return void
   */
  public function load_textdomain() {
    load_plugin_textdomain( 'make-paths-relative', FALSE,
      basename( dirname( MAKE_PATHS_RELATIVE_FILE ) ) . '/languages/'
    );
  }
}

new Make_Paths_Relative();
