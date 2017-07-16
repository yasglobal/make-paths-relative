<?php
/**
 * Plugin Name: Make Paths Relative
 * Version: 0.1
 * Plugin URI: https://wordpress.org/plugins/make-paths-relative/
 * Description: This plugin converts the URL(Links) to relative instead of absolute.
 * Donate link: https://www.paypal.me/yasglobal
 * Author: Sami Ahmed Siddiqui
 * Author URI: http://www.yasglobal.com/web-design-development/wordpress/make-paths-relative/
 * Text Domain: make-paths-relative
 * License: GPL v3
 */

 /**
 *  Make Paths Relative
 *  Copyright (C) 2016, Sami Ahmed Siddiqui <sami@samisiddiqui.com>
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

function make_paths_relative_settings_link($links) { 
   $settings_link = '<a href="admin.php?page=make-paths-relative-settings">Settings</a>'; 
   array_unshift($links, $settings_link); 
   return $links; 
}

function make_paths_relative_menu() {
	add_menu_page('Make Paths Relative Settings', 'Make Paths Relative', 'administrator', 'make-paths-relative-settings', 'make_paths_relative_settings_page');
}

function make_paths_relative_settings_page() {
	if ( !current_user_can( 'administrator' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
   if (isset($_POST['submit'])){
      $make_paths_relative_settings =  array(
                     'site_url'                 =>    $_POST['site_url'],
                     'post_permalinks'          =>    $_POST['post_permalinks'],
                     'archive_permalinks'       =>    $_POST['archive_permalinks'],
                     'author_permalinks'        =>    $_POST['author_permalinks'],
                     'category_permalinks'      =>    $_POST['category_permalinks'],
                     'scripts_src'              =>    $_POST['scripts_src'],
                     'styles_src'               =>    $_POST['styles_src'],
                     'image_paths'              =>    $_POST['image_paths'],
                  );
      update_option('make_paths_relative', serialize( $make_paths_relative_settings ) );
   }
   $relative_paths_setting = unserialize( get_option('make_paths_relative') );
   $post_permalinks_checked = '';
   $archive_permalinks_checked = '';
   $author_permalinks_checked = '';
   $category_permalinks_checked = '';
   $scripts_src_checked = '';
   $styles_src_checked = '';
   $image_paths_checked = '';
   if( isset($relative_paths_setting) ){
      if( esc_attr( $relative_paths_setting['post_permalinks'] ) == 'on' ){
         $post_permalinks_checked = 'checked';
      }
      if( esc_attr( $relative_paths_setting['archive_permalinks'] ) == 'on' ){
         $archive_permalinks_checked = 'checked';
      }
      if( esc_attr( $relative_paths_setting['author_permalinks'] ) == 'on' ){
         $author_permalinks_checked = 'checked';
      }
      if( esc_attr( $relative_paths_setting['category_permalinks'] ) == 'on' ){
         $category_permalinks_checked = 'checked';
      }
      if( esc_attr( $relative_paths_setting['scripts_src'] ) == 'on' ){
         $scripts_src_checked = 'checked';
      }
      if( esc_attr( $relative_paths_setting['styles_src'] ) == 'on' ){
         $styles_src_checked = 'checked';
      }
      if( esc_attr( $relative_paths_setting['image_paths'] ) == 'on' ){
         $image_paths_checked = 'checked';
      }
   }
   echo '<div class="wrap">';
   echo '<h2>Make Paths Relative</h2>';
   echo '<div>Select which paths you want to make relative.</div>';
   echo '<form enctype="multipart/form-data" action="" method="POST" id="make-paths-relative">';
   ?>
   <table class="make-paths-relative">
      <caption>Define Site Address</caption>
      <tbody>
         <tr>
            <th><label for="name">Site Address :</label></th>
            <td>
               <input type="text" name="site_url" class="regular-text" value="<?php echo $relative_paths_setting['site_url']; ?>" /><small>Default : site_url()</small>
               <div>Leave the field empty to use the <strong>site_url()</strong> address</div>
            </td>
         </tr>
      </tbody>
   </table>
   <table class="make-paths-relative">
      <caption>Make Permalinks Relative</caption>
      <tbody>
         <tr>
            <td><input type="checkbox" name="post_permalinks" value="on" <?php echo $post_permalinks_checked; ?> /><strong>Post Permalinks</strong></td>
         </tr>
         <tr>
            <td><input type="checkbox" name="archive_permalinks" value="on" <?php echo $archive_permalinks_checked; ?> /><strong>Archive Permalinks</strong></td>
         </tr>
         <tr>
            <td><input type="checkbox" name="author_permalinks" value="on" <?php echo $author_permalinks_checked; ?> /><strong>Author Permalinks</strong></td>
         </tr>
         <tr>
            <td><input type="checkbox" name="category_permalinks" value="on" <?php echo $category_permalinks_checked; ?> /><strong>Category Permalink</strong></td>
         </tr>
      </tbody>
   </table>

   <table class="make-paths-relative">
      <caption>Make Scripts and Styles Relative</caption>
      <tbody>
         <tr>
            <td><input type="checkbox" name="scripts_src" value="on" <?php echo $scripts_src_checked; ?> /><strong>Scripts src</strong></td>
         </tr>
         <tr>
            <td><input type="checkbox" name="styles_src" value="on" <?php echo $styles_src_checked; ?> /><strong>Styles src</strong></td>
         </tr>
      </tbody>
   </table>

   <table class="make-paths-relative">
      <caption>Make Image Paths Relative</caption>
      <tbody>
         <tr>
            <td><input type="checkbox" name="image_paths" value="on" <?php echo $image_paths_checked; ?> /><strong>Image Paths</strong></td>
         </tr>
      </tbody>
   </table>


   <?php
   submit_button(); 
   echo '</form>';
   echo '</div>';
}

/**
 * It makes the permalinks, scripts, styles and image URLs(srd) to relative
 */
function make_paths_relative($link) {
   global $site_url;
   return str_replace($site_url, '', $link);
}

function make_paths_relative_attachment() {
   wp_register_style( 'style', plugins_url('/style.css', __FILE__) );
   wp_enqueue_style( 'style' );
}

if ( function_exists("add_filter") ) {

   $plugin = plugin_basename(__FILE__); 
   add_filter( "plugin_action_links_$plugin", 'make_paths_relative_settings_link' );

   add_action( 'admin_menu', 'make_paths_relative_menu' );

   $make_relative_paths = unserialize( get_option('make_paths_relative') );
   if( isset($make_relative_paths) && !empty($make_relative_paths) ){
      global $site_url;
      $site_url = site_url();
      if( isset($make_relative_paths['site_url']) && !empty($make_relative_paths['site_url']) ){
         $site_url = $make_relative_paths['site_url'];
      }
      //Filters to make the permalinks to relative
      if( isset($make_relative_paths['post_permalinks']) && !empty($make_relative_paths['post_permalinks']) ){
         add_filter( 'the_permalink', 'make_paths_relative' );
         add_filter( 'post_link', 'make_paths_relative' );
         add_filter( 'post_type_link', 'make_paths_relative', 10, 2 );
      }
      if( isset($make_relative_paths['archive_permalinks']) && !empty($make_relative_paths['archive_permalinks']) ){
         add_filter( 'get_archives_link', 'make_paths_relative' );
      }
      if( isset($make_relative_paths['author_permalinks']) && !empty($make_relative_paths['author_permalinks']) ){
         add_filter( 'author_link', 'make_paths_relative' );
      }
      if( isset($make_relative_paths['category_permalinks']) && !empty($make_relative_paths['category_permalinks']) ){
         add_filter( 'category_link', 'make_paths_relative' );
      }
      
      //Filters to make the scripts and style urls to relative
      if( isset($make_relative_paths['scripts_src']) && !empty($make_relative_paths['scripts_src']) ){
         add_filter('script_loader_src', 'make_paths_relative');
      }
      if( isset($make_relative_paths['styles_src']) && !empty($make_relative_paths['styles_src']) ){
         add_filter('style_loader_src', 'make_paths_relative');
      }
      
      //Filter to make the media(image) src to relative
      if( isset($make_relative_paths['image_paths']) && !empty($make_relative_paths['image_paths']) ){
         add_filter( 'wp_get_attachment_url', 'make_paths_relative' );
      }
   }
   
   if ( isset($_GET['page']) && !empty($_GET['page']) && $_GET['page'] == 'make-paths-relative-settings' ) {
      add_action('admin_print_styles', 'make_paths_relative_attachment');
   }
}
