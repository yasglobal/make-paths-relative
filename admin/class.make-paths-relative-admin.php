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

      add_action( 'admin_menu', array('Make_Paths_Relative_Admin', 'admin_menu') );
		}
  }

  public static function admin_menu() {
    add_menu_page('Make Paths Relative Settings', 'Make Paths Relative', 'administrator', 'make-paths-relative-settings', array('Make_Paths_Relative_Admin', 'admin_settings_page'));
    add_submenu_page( 'make-paths-relative-settings', 'Make Paths Relative Settings', 'Settings', 'administrator', 'make-paths-relative-settings', array('Make_Paths_Relative_Admin', 'admin_settings_page') );
    add_submenu_page( 'make-paths-relative-settings', 'Exclude Posts', 'Exclude Posts', 'administrator', 'make-paths-relative-exclude-posts', array('Make_Paths_Relative_Admin', 'exclude_posts_page') );
  }

  public static function admin_settings_page() {
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
    $print_site_url = 'site_url()';
    ?>
    <div class="wrap">
    <h2><?php _e('Make Paths Relative', 'make-paths-relative'); ?></h2>
    <div><?php _e('Select which paths you want to make relative.', 'make-paths-relative'); ?></div>
      <form enctype="multipart/form-data" action="" method="POST" id="make-paths-relative">

        <table class="make-paths-relative">
          <caption><?php _e('Define Site Address', 'make-paths-relative'); ?></caption>
          <tbody>
            <tr>
              <th><label for="name"><?php _e('Site Address :', 'make-paths-relative'); ?></label></th>
              <td><input type="text" name="site_url" class="regular-text" value="<?php echo $relative_paths_setting['site_url']; ?>" /><small><?php printf( __('Default : %s', 'make-paths-relative'), $print_site_url); ?></small>
              <div><?php printf( __('Leave the field empty to use the <strong>%s</strong> address', 'make-paths-relative'), $print_site_url); ?></div></td>
            </tr>
          </tbody>
        </table>

        <table class="make-paths-relative">
          <caption><?php _e('Make Permalinks Relative', 'make-paths-relative'); ?></caption>
          <tbody>
            <tr>
              <td><input type="checkbox" name="post_permalinks" value="on" <?php echo $post_permalinks_checked; ?> /><strong><?php _e('Post Permalinks', 'make-paths-relative'); ?></strong></td>
            </tr>
            <tr>
              <td><input type="checkbox" name="archive_permalinks" value="on" <?php echo $archive_permalinks_checked; ?> /><strong><?php _e('Archive Permalinks', 'make-paths-relative'); ?></strong></td>
            </tr>
            <tr>
              <td><input type="checkbox" name="author_permalinks" value="on" <?php echo $author_permalinks_checked; ?> /><strong><?php _e('Author Permalinks', 'make-paths-relative'); ?></strong></td>
            </tr>
            <tr>
              <td><input type="checkbox" name="category_permalinks" value="on" <?php echo $category_permalinks_checked; ?> /><strong><?php _e('Category Permalink', 'make-paths-relative'); ?></strong></td>
            </tr>
          </tbody>
        </table>

        <table class="make-paths-relative">
          <caption><?php _e('Make Scripts and Styles Relative', 'make-paths-relative'); ?></caption>
          <tbody>
            <tr>
              <td><input type="checkbox" name="scripts_src" value="on" <?php echo $scripts_src_checked; ?> /><strong><?php _e('Scripts src', 'make-paths-relative'); ?></strong></td>
            </tr>
            <tr>
              <td><input type="checkbox" name="styles_src" value="on" <?php echo $styles_src_checked; ?> /><strong><?php _e('Styles src', 'make-paths-relative'); ?></strong></td>
            </tr>
          </tbody>
        </table>

        <table class="make-paths-relative">
          <caption><?php _e('Make Image Paths Relative', 'make-paths-relative'); ?></caption>
          <tbody>
            <tr>
              <td><input type="checkbox" name="image_paths" value="on" <?php echo $image_paths_checked; ?> /><strong><?php _e('Image Paths', 'make-paths-relative'); ?></strong></td>
            </tr>
          </tbody>
        </table>

        <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes', 'make-paths-relative'); ?>" /></p>
      </form>
    </div>
    <?php
  }
  
  public function exclude_posts_page() {
    if ( !current_user_can( 'administrator' ) )  {
      wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    if (isset($_POST['submit'])){
      $exclude_post_types = array();
      foreach ($_POST as $key => $value) {
				if ($key === 'submit')
					continue;
				$exclude_post_types['post_types'][$key] = $value;
			}
      update_option('make_paths_relative_exclude', serialize( $exclude_post_types ) );
    }
    $post_types = get_post_types( '', 'objects' );
    $get_exclude_post_types = unserialize( get_option('make_paths_relative_exclude') );
    ?>
    <div class="wrap">
		    <h1><?php _e('Exclude Posts', 'make-paths-relative'); ?></h1>
		    <div>
						<p><?php _e('Select the PostTypes to exclude it.', 'make-paths-relative'); ?></p>
			  </div>
		    <form enctype="multipart/form-data" action="" method="POST" id="make-paths-relative-exclude-posts">
            <table class="form-table">
            <?php $get_post_type = array(); ?>
            <?php foreach ( $post_types as $post_type ) {
              if ( $post_type->name == 'revision' || $post_type->name == 'nav_menu_item' ) {
                continue;
              }
              $excluded = '';
              if (isset($get_exclude_post_types['post_types'][$post_type->name]) && $get_exclude_post_types['post_types'][$post_type->name] == "on") {
                $excluded = 'checked';
              }
			        ?>
                <tr valign="top">
                    <td><input type="checkbox" name="<?php echo $post_type->name; ?>" value="on" <?php echo $excluded; ?> /><strong><?php echo $post_type->labels->name; ?></strong>
                </tr>              
		        <?php } ?>
		        </table>

            <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes', 'make-paths-relative'); ?>" /></p>
		    </form>
      </div>
      <?php
  }
}
