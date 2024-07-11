<?php
/**
 * Plugin Name: Make Paths Relative
 * Plugin URI: https://www.yasglobal.com/web-design-development/wordpress/make-paths-relative/
 * Description: This plugin helps ensure your website functions correctly when moved to a different domain.
 * Version: 2.1.0
 * Requires at least: 2.6
 * Requires PHP: 5.6
 * Author: Sami Ahmed Siddiqui
 * Author URI: https://www.linkedin.com/in/sami-ahmed-siddiqui/
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 *
 * Text Domain: make-paths-relative
 * Domain Path: /languages/
 *
 * @package MakePathsRelative
 */

/**
 *  Make Paths Relative - Convert Absolute URL(s) to Relative URL(s)
 *  Copyright (C) 2016-2024, Sami Ahmed Siddiqui <sami.siddiqui@yasglobal.com>
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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'MAKE_PATHS_RELATIVE_FILE' ) ) {
	define( 'MAKE_PATHS_RELATIVE_FILE', __FILE__ );
}

// Include the main Make Paths Relative class.
require_once plugin_dir_path( MAKE_PATHS_RELATIVE_FILE ) . 'includes/class-make-paths-relative.php';
