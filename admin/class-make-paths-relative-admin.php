<?php
/**
 * @package MakePathsRelative\Admin
 */

class Make_Paths_Relative_Admin {

	/**
	 * Class constructor.
	 */
	public function __construct() {
		add_action ( 'admin_menu', array( $this, 'admin_menu' ) );
		add_filter( 'plugin_action_links_' . MAKE_PATHS_RELATIVE_BASENAME,
			array( $this, 'settings_link' )
		);
	}

	/**
	 * Add Settings Pages in the Dashboard Menu.
	 */
	public function admin_menu() {
		add_menu_page( 'Make Paths Relative Settings', 'Make Paths Relative',
			'administrator', 'make-paths-relative-settings',
			array( $this, 'admin_settings_page' )
		);
		add_submenu_page( 'make-paths-relative-settings',
			'Make Paths Relative Settings', 'Settings', 'administrator',
			'make-paths-relative-settings', array( $this, 'admin_settings_page' )
		);
		add_submenu_page( 'make-paths-relative-settings', 'Exclude Posts',
			'Exclude Posts', 'administrator', 'make-paths-relative-exclude-posts',
			array( $this, 'exclude_posts_page' )
		);
	}

	/**
	 * Admin Settings Page by which you can change/choose your settings according to your need.
	 */
	public function admin_settings_page() {
		if ( ! current_user_can( 'administrator' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		if ( isset( $_POST['submit'] ) ) {
			$save_settings =  array(
				'site_url'             =>  $_POST['site_url'],
				'post_permalinks'      =>  $_POST['post_permalinks'],
				'page_permalinks'      =>  $_POST['page_permalinks'],
				'archive_permalinks'   =>  $_POST['archive_permalinks'],
				'author_permalinks'    =>  $_POST['author_permalinks'],
				'category_permalinks'  =>  $_POST['category_permalinks'],
				'scripts_src'          =>  $_POST['scripts_src'],
				'styles_src'           =>  $_POST['styles_src'],
				'image_paths'          =>  $_POST['image_paths']
			);
			update_option( 'make_paths_relative', serialize( $save_settings ) );
		}
		$settings         = unserialize( get_option( 'make_paths_relative' ) );
		$site_url         = '';  
		$enabled_post     = '';
		$enabled_page     = '';
		$enabled_archive  = '';
		$enabled_author   = '';
		$enabled_category = '';
		$enabled_script   = '';
		$enabled_style    = '';
		$enabled_image    = '';
		if ( isset( $settings ) ) {
			if ( isset( $settings['site_url'] )
				&& ! empty( $settings['site_url'] ) ) {
				$site_url = $settings['site_url'];
			}
			if ( esc_attr( $settings['post_permalinks'] ) == 'on' ) {
				$enabled_post = 'checked';
			}
			if ( isset( $settings['page_permalinks'] )
				&& esc_attr( $settings['page_permalinks'] ) == 'on' ) {
				$enabled_page = 'checked';
			}
			if ( esc_attr( $settings['archive_permalinks'] ) == 'on' ) {
				$enabled_archive = 'checked';
			}
			if ( esc_attr( $settings['author_permalinks'] ) == 'on' ) {
				$enabled_author = 'checked';
			}
			if ( esc_attr( $settings['category_permalinks'] ) == 'on' ) {
				$enabled_category = 'checked';
			}
			if ( esc_attr( $settings['scripts_src'] ) == 'on' ) {
				$enabled_script = 'checked';
			}
			if ( esc_attr( $settings['styles_src'] ) == 'on' ) {
				$enabled_style = 'checked';
			}
			if ( esc_attr( $settings['image_paths'] ) == 'on' ) {
				$enabled_image = 'checked';
			}
		}
		wp_enqueue_style( 'style', 
			plugins_url( '/admin/css/admin-style.min.css', MAKE_PATHS_RELATIVE_FILE )
		);
		$print_site_url = 'site_url()';
		?>
		<div class="wrap">
		<h2><?php _e( 'Make Paths Relative', 'make-paths-relative' ); ?></h2>
		<div><?php _e( 'Select which paths you want to make relative.', 'make-paths-relative' ); ?></div>
			<form enctype="multipart/form-data" action="" method="POST" id="make-paths-relative">

				<table class="make-paths-relative">
					<caption><?php _e( 'Define Site Address', 'make-paths-relative' ); ?></caption>
					<tbody>
						<tr>
							<th><label for="name"><?php _e( 'Site Address :', 'make-paths-relative' ); ?></label></th>
							<td><input type="text" name="site_url" class="regular-text" value="<?php echo $site_url; ?>" /><small><?php printf( __( 'Default : %s', 'make-paths-relative' ), $print_site_url); ?></small>
							<div><?php printf( __( 'Leave the field empty to use the <strong>%s</strong> address', 'make-paths-relative' ), $print_site_url ); ?></div></td>
						</tr>
					</tbody>
				</table>

				<table class="make-paths-relative">
					<caption><?php _e( 'Make Permalinks Relative', 'make-paths-relative' ); ?></caption>
					<tbody>
						<tr>
							<td><input type="checkbox" name="post_permalinks" value="on" <?php echo $enabled_post; ?> /><strong><?php _e( 'Post Permalinks', 'make-paths-relative' ); ?></strong></td>
						</tr>
						<tr>
							<td><input type="checkbox" name="page_permalinks" value="on" <?php echo $enabled_page; ?> /><strong><?php _e('Page Permalinks', 'make-paths-relative'); ?></strong></td>
						</tr>
						<tr>
							<td><input type="checkbox" name="archive_permalinks" value="on" <?php echo $enabled_archive; ?> /><strong><?php _e( 'Archive Permalinks', 'make-paths-relative' ); ?></strong></td>
						</tr>
						<tr>
							<td><input type="checkbox" name="author_permalinks" value="on" <?php echo $enabled_author; ?> /><strong><?php _e( 'Author Permalinks', 'make-paths-relative' ); ?></strong></td>
						</tr>
						<tr>
							<td><input type="checkbox" name="category_permalinks" value="on" <?php echo $enabled_category; ?> /><strong><?php _e( 'Category Permalink', 'make-paths-relative' ); ?></strong></td>
						</tr>
					</tbody>
				</table>

				<table class="make-paths-relative">
					<caption><?php _e( 'Make Scripts and Styles Relative', 'make-paths-relative' ); ?></caption>
					<tbody>
						<tr>
							<td><input type="checkbox" name="scripts_src" value="on" <?php echo $enabled_script; ?> /><strong><?php _e( 'Scripts src', 'make-paths-relative' ); ?></strong></td>
						</tr>
						<tr>
							<td><input type="checkbox" name="styles_src" value="on" <?php echo $enabled_style; ?> /><strong><?php _e( 'Styles src', 'make-paths-relative' ); ?></strong></td>
						</tr>
					</tbody>
				</table>

				<table class="make-paths-relative">
					<caption><?php _e( 'Make Image Paths Relative', 'make-paths-relative' ); ?></caption>
					<tbody>
						<tr>
							<td><input type="checkbox" name="image_paths" value="on" <?php echo $enabled_image; ?> /><strong><?php _e( 'Image Paths', 'make-paths-relative' ); ?></strong></td>
						</tr>
					</tbody>
				</table>

				<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e( 'Save Changes', 'make-paths-relative' ); ?>" /></p>
			</form>
		</div>
		<?php
		add_filter( 'admin_footer_text', array( $this, 'admin_footer_text' ), 1 );
	}

	/**
	 * This allows you to exclude the PostTypes to be relative
	 */
  public function exclude_posts_page() {
		if ( ! current_user_can( 'administrator' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		if ( isset( $_POST['submit'] ) ) {
			$exclude_post_types = array();
			foreach ( $_POST as $key => $value ) {
				if ( $key === 'submit' ) {
					continue;
				}
				$exclude_post_types['post_types'][$key] = $value;
			}
			update_option( 'make_paths_relative_exclude',
				serialize( $exclude_post_types )
			);
		}
		$post_types     = get_post_types( '', 'objects' );
		$excluded_types = unserialize( get_option( 'make_paths_relative_exclude' ) );
		?>
		<div class="wrap">
				<h1><?php _e( 'Exclude Posts', 'make-paths-relative' ); ?></h1>
				<div>
						<p><?php _e( 'Select the PostTypes to exclude it.', 'make-paths-relative' ); ?></p>
				</div>
				<form enctype="multipart/form-data" action="" method="POST" id="make-paths-relative-exclude-posts">
						<table class="form-table">
						<?php $get_post_type = array(); ?>
						<?php foreach ( $post_types as $post_type ) {
							if ( $post_type->name == 'revision'
								|| $post_type->name == 'nav_menu_item' ) {
								continue;
							}
							$excluded = '';
							if ( isset( $excluded_types['post_types'][$post_type->name] )
								&& $excluded_types['post_types'][$post_type->name] == "on" ) {
								$excluded = 'checked';
							}
							?>
								<tr valign="top">
										<td><input type="checkbox" name="<?php echo $post_type->name; ?>" value="on" <?php echo $excluded; ?> /><strong><?php echo $post_type->labels->name; ?></strong>
								</tr>              
						<?php } ?>
						</table>

						<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e( 'Save Changes', 'make-paths-relative' ); ?>" /></p>
				</form>
			</div>
		<?php
		add_filter( 'admin_footer_text', array( $this, 'admin_footer_text' ), 1 );
  }

	/**
	 * Add Rating Message in the footer of Admin Pages of Make Paths Relative
	 */
	public function admin_footer_text() {
		/* translators: %s: five stars */
		$footer_text = sprintf( __( 'If you like <strong>Make Paths Relative</strong> please leave us a %s rating. A huge thanks in advance!', 'make-paths-relative' ), '<a href="https://wordpress.org/support/plugin/make-paths-relative/reviews?rate=5#new-post" target="_blank" data-rated="' . esc_attr__( 'Thanks :)', 'make-paths-relative' ) . '">&#9733;&#9733;&#9733;&#9733;&#9733;</a>' );
		return $footer_text;
	}

	/**
	 * Plugin Settings Page Link on the Plugin Page under the Plugin Name.
	 */
	public function settings_link( $links ) {
		$settings_link = '<a href="admin.php?page=make-paths-relative-settings" title="Settings">Settings</a>';
		array_unshift( $links, $settings_link );
		return $links;
	}
}
