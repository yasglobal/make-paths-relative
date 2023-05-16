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
class Make_Paths_Relative_Exclude_Deprecated {
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
	 */
	private function posts_page() {
		// phpcs:ignore WordPress.Security.NonceVerification.Missing
		if ( isset( $_POST['submit'] ) ) {
			$exclude_post_types = array();
			// phpcs:ignore WordPress.Security.NonceVerification.Missing
			foreach ( $_POST as $key => $value ) {
				if ( 'submit' === $key ) {
					continue;
				}
				$exclude_post_types['post_types'][ $key ] = $value;
			}

			update_option( 'make_paths_relative_exclude', $exclude_post_types );
		}
		$post_types     = get_post_types( '', 'objects' );
		$excluded_types = get_option( 'make_paths_relative_exclude' );

		if ( is_string( $excluded_types ) ) {
			$excluded_types = maybe_unserialize( $excluded_types );
		}
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
						if ( 'revision' === $post_type->name
							|| 'nav_menu_item' === $post_type->name ) {
							continue;
						}
						$excluded = '';
						if ( isset( $excluded_types['post_types'][ $post_type->name ] )
							&& 'on' === $excluded_types['post_types'][ $post_type->name ]
						) {
							$excluded = 'checked';
						}
						?>
					<tr valign="top">
						<td>
						<input type="checkbox" name="<?php echo esc_attr( $post_type->name ); ?>" value="on" <?php echo esc_attr( $excluded ); ?> />
						<strong><?php echo esc_html( $post_type->labels->name ); ?></strong>
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
