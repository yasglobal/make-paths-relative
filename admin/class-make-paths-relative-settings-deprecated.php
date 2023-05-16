<?php
/**
 * Make Paths Relative Settings.
 *
 * @package MakePathsRelative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Make Paths Relative Settings page content.
 */
class Make_Paths_Relative_Settings_Deprecated {
	/**
	 * Class constructor.
	 */
	public function __construct() {
		$this->settings_page();
	}

	/**
	 * Settings Page by which Admin can change/choose the appropriate settings
	 * according to their need.
	 *
	 * @access private
	 * @since 0.5
	 */
	private function settings_page() {
		// phpcs:disable WordPress.Security.NonceVerification.Missing
		if ( isset( $_POST['submit'] ) ) {
			if ( ! isset( $_POST['site_url'] ) ) {
				$_POST['site_url'] = '';
			}
			if ( ! isset( $_POST['post_permalinks'] ) ) {
				$_POST['post_permalinks'] = '';
			}
			if ( ! isset( $_POST['page_permalinks'] ) ) {
				$_POST['page_permalinks'] = '';
			}
			if ( ! isset( $_POST['archive_permalinks'] ) ) {
				$_POST['archive_permalinks'] = '';
			}
			if ( ! isset( $_POST['author_permalinks'] ) ) {
				$_POST['author_permalinks'] = '';
			}
			if ( ! isset( $_POST['category_permalinks'] ) ) {
				$_POST['category_permalinks'] = '';
			}
			if ( ! isset( $_POST['scripts_src'] ) ) {
				$_POST['scripts_src'] = '';
			}
			if ( ! isset( $_POST['styles_src'] ) ) {
				$_POST['styles_src'] = '';
			}
			if ( ! isset( $_POST['image_paths'] ) ) {
				$_POST['image_paths'] = '';
			}
			$save_settings = array(
				'site_url'            => sanitize_text_field( wp_unslash( $_POST['site_url'] ) ),
				'post_permalinks'     => sanitize_text_field( wp_unslash( $_POST['post_permalinks'] ) ),
				'page_permalinks'     => sanitize_text_field( wp_unslash( $_POST['page_permalinks'] ) ),
				'archive_permalinks'  => sanitize_text_field( wp_unslash( $_POST['archive_permalinks'] ) ),
				'author_permalinks'   => sanitize_text_field( wp_unslash( $_POST['author_permalinks'] ) ),
				'category_permalinks' => sanitize_text_field( wp_unslash( $_POST['category_permalinks'] ) ),
				'scripts_src'         => sanitize_text_field( wp_unslash( $_POST['scripts_src'] ) ),
				'styles_src'          => sanitize_text_field( wp_unslash( $_POST['styles_src'] ) ),
				'image_paths'         => sanitize_text_field( wp_unslash( $_POST['image_paths'] ) ),
			);
			update_option( 'make_paths_relative', $save_settings );
		}
		// phpcs:enable WordPress.Security.NonceVerification.Missing

		$settings         = get_option( 'make_paths_relative' );
		$site_url         = '';
		$enabled_post     = '';
		$enabled_page     = '';
		$enabled_archive  = '';
		$enabled_author   = '';
		$enabled_category = '';
		$enabled_script   = '';
		$enabled_style    = '';
		$enabled_image    = '';

		if ( is_string( $settings ) ) {
			$settings = maybe_unserialize( get_option( 'make_paths_relative' ) );
		}

		if ( isset( $settings ) ) {
			if ( isset( $settings['site_url'] ) && ! empty( $settings['site_url'] ) ) {
				$site_url = $settings['site_url'];
			}
			if ( 'on' === esc_attr( $settings['post_permalinks'] ) ) {
				$enabled_post = 'checked';
			}
			if ( isset( $settings['page_permalinks'] )
				&& 'on' === esc_attr( $settings['page_permalinks'] ) ) {
				$enabled_page = 'checked';
			}
			if ( 'on' === esc_attr( $settings['archive_permalinks'] ) ) {
				$enabled_archive = 'checked';
			}
			if ( 'on' === esc_attr( $settings['author_permalinks'] ) ) {
				$enabled_author = 'checked';
			}
			if ( 'on' === esc_attr( $settings['category_permalinks'] ) ) {
				$enabled_category = 'checked';
			}
			if ( 'on' === esc_attr( $settings['scripts_src'] ) ) {
				$enabled_script = 'checked';
			}
			if ( 'on' === esc_attr( $settings['styles_src'] ) ) {
				$enabled_style = 'checked';
			}
			if ( 'on' === esc_attr( $settings['image_paths'] ) ) {
				$enabled_image = 'checked';
			}
		}
		?>
		<div class="wrap">
		<h2><?php esc_html_e( 'Make Paths Relative', 'make-paths-relative' ); ?></h2>
		<div><?php esc_html_e( 'Select which paths you want to make relative.', 'make-paths-relative' ); ?></div>
			<form enctype="multipart/form-data" action="" method="POST" id="make-paths-relative">
				<table class="make-paths-relative">
					<caption>
						<?php esc_html_e( 'Define Site Address', 'make-paths-relative' ); ?>
					</caption>
					<tbody>
						<tr>
							<th>
								<label for="name">
									<?php esc_html_e( 'Site Address :', 'make-paths-relative' ); ?>
								</label>
							</th>
							<td>
								<input type="text" name="site_url" class="regular-text" value="<?php echo esc_url( $site_url ); ?>" />
								<small><?php esc_html_e( 'Default : site_url()', 'make-paths-relative' ); ?></small>
								<div><?php esc_html_e( 'Leave the field empty to use the site_url() address', 'make-paths-relative' ); ?></div>
							</td>
						</tr>
					</tbody>
				</table>

				<table class="make-paths-relative">
					<caption>
						<?php esc_html_e( 'Make Permalinks Relative', 'make-paths-relative' ); ?>
					</caption>
					<tbody>
						<tr>
							<td>
								<input type="checkbox" name="post_permalinks" value="on" <?php echo esc_attr( $enabled_post ); ?> />
								<strong><?php esc_html_e( 'Post Permalinks', 'make-paths-relative' ); ?></strong>
							</td>
						</tr>
						<tr>
							<td>
								<input type="checkbox" name="page_permalinks" value="on" <?php echo esc_attr( $enabled_page ); ?> />
								<strong><?php esc_html_e( 'Page Permalinks', 'make-paths-relative' ); ?></strong>
							</td>
						</tr>
						<tr>
							<td>
								<input type="checkbox" name="archive_permalinks" value="on" <?php echo esc_attr( $enabled_archive ); ?> />
								<strong><?php esc_html_e( 'Archive Permalinks', 'make-paths-relative' ); ?></strong>
							</td>
						</tr>
						<tr>
							<td>
								<input type="checkbox" name="author_permalinks" value="on" <?php echo esc_attr( $enabled_author ); ?> />
								<strong><?php esc_html_e( 'Author Permalinks', 'make-paths-relative' ); ?></strong>
							</td>
						</tr>
						<tr>
							<td>
								<input type="checkbox" name="category_permalinks" value="on" <?php echo esc_attr( $enabled_category ); ?> />
								<strong><?php esc_html_e( 'Term Permalinks', 'make-paths-relative' ); ?></strong>
							</td>
						</tr>
					</tbody>
				</table>

				<table class="make-paths-relative">
					<caption>
						<?php esc_html_e( 'Make Scripts and Styles Relative', 'make-paths-relative' ); ?>
					</caption>
					<tbody>
						<tr>
							<td>
								<input type="checkbox" name="scripts_src" value="on" <?php echo esc_attr( $enabled_script ); ?> />
								<strong><?php esc_html_e( 'Scripts src', 'make-paths-relative' ); ?></strong>
							</td>
						</tr>
						<tr>
							<td>
								<input type="checkbox" name="styles_src" value="on" <?php echo esc_attr( $enabled_style ); ?> />
								<strong><?php esc_html_e( 'Styles src', 'make-paths-relative' ); ?></strong>
							</td>
						</tr>
					</tbody>
				</table>

				<table class="make-paths-relative">
					<caption>
						<?php esc_html_e( 'Make Image Paths Relative', 'make-paths-relative' ); ?>
					</caption>
					<tbody>
						<tr>
							<td>
								<input type="checkbox" name="image_paths" value="on" <?php echo esc_attr( $enabled_image ); ?> />
								<strong><?php esc_html_e( 'Image Paths', 'make-paths-relative' ); ?></strong>
							</td>
						</tr>
					</tbody>
				</table>

				<p class="submit">
					<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_html_e( 'Save Changes', 'make-paths-relative' ); ?>" />
				</p>
			</form>
		</div>
		<?php
	}
}
