<?php
/**
 * Make Paths Relative Exclude.
 *
 * @package MakePathsRelative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Avoid making paths relative for the excluded Post Types.
 */
class Make_Paths_Relative_Exclude {
	/**
	 * Class constructor.
	 */
	public function __construct() {
		$this->posts_page();
	}

	/**
	 * This allows you to exclude the PostTypes to be relative.
	 *
	 * @access private
	 * @since 0.5
	 *
	 * @return void
	 */
	private function posts_page() {
		if ( isset( $_POST['submit'] ) ) {
			$exclude_post_types = array();
			foreach ( $_POST as $key => $value ) {
				if ( $key === 'submit' ) {
					continue;
				}
				$exclude_post_types['post_types'][ $key ] = $value;
			}
			update_option(
				'make_paths_relative_exclude',
				serialize( $exclude_post_types )
			);
		}
		$post_types     = get_post_types( '', 'objects' );
		$excluded_types = unserialize(
			get_option( 'make_paths_relative_exclude' )
		);
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Exclude Posts', 'make-paths-relative' ); ?></h1>
			<div>
				<p><?php esc_html_e( 'Select the PostTypes to exclude it.', 'make-paths-relative' ); ?></p>
			</div>
			<form enctype="multipart/form-data" action="" method="POST" id="make-paths-relative-exclude-posts">
				<table class="form-table">
					<?php
					$get_post_type = array();
					foreach ( $post_types as $post_type ) {
						if ( $post_type->name == 'revision'
							|| $post_type->name == 'nav_menu_item' ) {
							continue;
						}
						$excluded = '';
						if ( isset( $excluded_types['post_types'][ $post_type->name ] )
							&& $excluded_types['post_types'][ $post_type->name ] == 'on' ) {
							$excluded = 'checked';
						}
						?>
					<tr valign="top">
						<td>
						<input type="checkbox" name="<?php echo $post_type->name; ?>" value="on" <?php echo $excluded; ?> />
						<strong><?php echo $post_type->labels->name; ?></strong>
					</tr>
					<?php } ?>
				</table>

				<p class="submit">
					<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_html_e( 'Save Changes', 'make-paths-relative' ); ?>" />
				</p>
			</form>
		</div>
		<?php
	}
}
