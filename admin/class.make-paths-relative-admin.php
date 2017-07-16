<?php

/**
 * @package MakePathsRelative\Admin
 */

class Make_Paths_Relative_Admin {
  
  private static $initiated = false;

  /**
	 * Initializes WordPress hooks
	 */
  public static function init() {
    if( !self::$initiated ) {
      self::$initiated = true;

      add_action( 'admin_menu', array('Make_Paths_Relative_Admin', 'make_paths_relative_menu') );
		}
  }

  public static function make_paths_relative_menu() {
    add_menu_page('Make Paths Relative Settings', 'Make Paths Relative', 'administrator', 'make-paths-relative-settings', array('Make_Paths_Relative_Admin', 'make_paths_relative_settings_page'));
  }

  public static function make_paths_relative_settings_page() {
    if ( !current_user_can( 'administrator' ) )  {
      wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    if (isset($_POST['submit'])){
      $make_paths_relative_settings =  array(
        'site_url'             =>  $_POST['site_url'],
        'post_permalinks'      =>  $_POST['post_permalinks'],
        'archive_permalinks'   =>  $_POST['archive_permalinks'],
        'author_permalinks'    =>  $_POST['author_permalinks'],
        'category_permalinks'  =>  $_POST['category_permalinks'],
        'scripts_src'          =>  $_POST['scripts_src'],
        'styles_src'           =>  $_POST['styles_src'],
        'image_paths'          =>  $_POST['image_paths']
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
      if( esc_attr($relative_paths_setting['post_permalinks']) == 'on' ) {
        $post_permalinks_checked = 'checked';
      }
      if( esc_attr($relative_paths_setting['archive_permalinks']) == 'on' ) {
        $archive_permalinks_checked = 'checked';
      }
      if( esc_attr($relative_paths_setting['author_permalinks']) == 'on' ) {
        $author_permalinks_checked = 'checked';
      }
      if( esc_attr($relative_paths_setting['category_permalinks']) == 'on' ) {
        $category_permalinks_checked = 'checked';
      }
      if( esc_attr($relative_paths_setting['scripts_src']) == 'on' ) {
        $scripts_src_checked = 'checked';
      }
      if( esc_attr($relative_paths_setting['styles_src']) == 'on' ) {
        $styles_src_checked = 'checked';
      }
      if( esc_attr($relative_paths_setting['image_paths']) == 'on' ) {
        $image_paths_checked = 'checked';
      }
    }
    wp_enqueue_style( 'style', plugins_url('/css/admin-style.min.css', __FILE__) );
    ?>
    <div class="wrap">
    <h2>Make Paths Relative</h2>
    <div>Select which paths you want to make relative.</div>
      <form enctype="multipart/form-data" action="" method="POST" id="make-paths-relative">

        <table class="make-paths-relative">
          <caption>Define Site Address</caption>
          <tbody>
            <tr>
              <th><label for="name">Site Address :</label></th>
              <td><input type="text" name="site_url" class="regular-text" value="<?php echo $relative_paths_setting['site_url']; ?>" /><small>Default : site_url()</small>
              <div>Leave the field empty to use the <strong>site_url()</strong> address</div></td>
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

        <?php submit_button(); ?>
      </form>
    </div>
    <?php
  }
}
