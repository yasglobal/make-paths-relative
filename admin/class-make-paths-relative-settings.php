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
class Make_Paths_Relative_Settings {
	/**
	 * Class constructor.
	 */
	public function __construct() {
		$this->settings_page();
	}

	/**
	 * Save make paths relative Settings.
	 *
	 * @access private
	 * @since 2.0.0
	 */
	private function save_settings() {
		$form_submit = filter_input( INPUT_POST, 'submit' );
		$user_id     = get_current_user_id();

		if ( $form_submit
			&& check_admin_referer(
				'make-paths-relative-settings_' . $user_id,
				'_make_paths_relative_settings_nonce'
			)
		) {
			$mps_settings = array(
				'relative_domains' => array(),
				'hyperlinks'       => 0,
				'images_source'    => 0,
				'scripts_source'   => 0,
				'styles_source'    => 0,
			);

			$relative_domains = filter_input( INPUT_POST, 'relative_domains' );
			$relative_domains = str_replace( 'http://', '', $relative_domains );
			$relative_domains = str_replace( 'https://', '', $relative_domains );
			$relative_domains = str_replace( '://', '', $relative_domains );
			$strip_domains    = wp_kses( $relative_domains, array() );
			$strip_domains    = explode( "\n", $strip_domains );
			foreach ( $strip_domains as $domain ) {
				$domain = trim( $domain );
				$domain = rtrim( $domain, '/' );
				if ( ! empty( $domain ) && ! in_array( $domain, $mps_settings['relative_domains'], true ) ) {
					$mps_settings['relative_domains'][] = $domain;
				}
			}

			$enable_hyperlinks = (int) filter_input( INPUT_POST, 'hyperlinks' );
			if ( 1 === $enable_hyperlinks ) {
				$mps_settings['hyperlinks'] = 1;
			}

			$enable_images = (int) filter_input( INPUT_POST, 'images_source' );
			if ( 1 === $enable_images ) {
				$mps_settings['images_source'] = 1;
			}

			$enable_scripts = (int) filter_input( INPUT_POST, 'scripts_source' );
			if ( 1 === $enable_scripts ) {
				$mps_settings['scripts_source'] = 1;
			}

			$enable_styles = (int) filter_input( INPUT_POST, 'styles_source' );
			if ( 1 === $enable_styles ) {
				$mps_settings['styles_source'] = 1;
			}

			update_option( 'make_paths_relative_settings', $mps_settings );

			if ( isset( $_POST['deprecated_settings'] ) ) {
				delete_option( 'make_paths_relative' );
				delete_option( 'make_paths_relative_exclude' );
			}
		}
	}

	/**
	 * Settings Page by which Admin can change/choose the appropriate settings
	 * according to their need.
	 *
	 * @access private
	 * @since 2.0.0
	 */
	private function settings_page() {
		$this->save_settings();

		$get_mps_settings   = get_option( 'make_paths_relative_settings' );
		$hyperlinks_enabled = '';
		$images_enabled     = '';
		$old_mps_settings   = get_option( 'make_paths_relative' );
		$scripts_enabled    = '';
		$styles_enabled     = '';
		$user_id            = get_current_user_id();

		if ( is_array( $get_mps_settings ) ) {
			if ( isset( $get_mps_settings['hyperlinks'] )
				&& 1 === (int) $get_mps_settings['hyperlinks']
			) {
				$hyperlinks_enabled = 'checked';
			}

			if ( isset( $get_mps_settings['images_source'] )
				&& 1 === (int) $get_mps_settings['images_source']
			) {
				$images_enabled = 'checked';
			}

			if ( isset( $get_mps_settings['scripts_source'] )
				&& 1 === (int) $get_mps_settings['scripts_source']
			) {
				$scripts_enabled = 'checked';
			}

			if ( isset( $get_mps_settings['styles_source'] )
				&& 1 === (int) $get_mps_settings['styles_source']
			) {
				$styles_enabled = 'checked';
			}
		}
		?>
		<div class="wrap">
			<h2><?php esc_html_e( 'Make Paths Relative', 'make-paths-relative' ); ?></h2>
			<div>
				<?php esc_html_e( 'Select which paths you want to make relative.', 'make-paths-relative' ); ?>
			</div>
			<form enctype="multipart/form-data" action="" method="POST" id="make-paths-relative">
				<?php
				wp_nonce_field(
					'make-paths-relative-settings_' . $user_id,
					'_make_paths_relative_settings_nonce',
					true
				);
				?>
				<table class="make-paths-relative">
					<caption>
						<?php esc_html_e( 'Define Site Addresses', 'make-paths-relative' ); ?>
					</caption>
					<tbody>
						<tr>
							<th>
								<label for="relative_domains">
									<?php esc_html_e( 'Site Addresses :', 'make-paths-relative' ); ?>
								</label>
							</th>
							<td>
								<textarea id="relative_domains" name="relative_domains" placeholder="Add URL(s) need to be relative without http / https. Like: www.yasglobal.com" rows="5" cols="100"><?php echo esc_html( implode( "\n", $get_mps_settings['relative_domains'] ) ); ?></textarea>
								<div><?php esc_html_e( 'Leave the field empty to use the site_url() address or add address(es) one in each line.', 'make-paths-relative' ); ?></div>
							</td>
						</tr>
					</tbody>
				</table>

				<table class="make-paths-relative">
					<caption>
						<?php esc_html_e( 'Make Paths Relative', 'make-paths-relative' ); ?>
					</caption>
					<tbody>
						<tr>
							<td>
								<input type="checkbox" id="hyperlinks" name="hyperlinks" value="1" <?php echo esc_attr( $hyperlinks_enabled ); ?> />
								<label for="hyperlinks">
									<?php esc_html_e( 'Hyperlink(s) / URL (s)', 'make-paths-relative' ); ?>
								</label>
							</td>
						</tr>
						<tr>
							<td>
								<input type="checkbox" id="images_source" name="images_source" value="1" <?php echo esc_attr( $images_enabled ); ?> />
								<label for="images_source">
									<?php esc_html_e( 'Image(s) URL', 'make-paths-relative' ); ?>
								</label>
							</td>
						</tr>
						<tr>
							<td>
								<input type="checkbox" id="scripts_source" name="scripts_source" value="1" <?php echo esc_attr( $scripts_enabled ); ?> />
								<label for="scripts_source">
									<?php esc_html_e( 'Script(s) URL', 'make-paths-relative' ); ?>
								</label>
							</td>
						</tr>
						<tr>
							<td>
								<input type="checkbox" id="styles_source" name="styles_source" value="1" <?php echo esc_attr( $styles_enabled ); ?> />
								<label for="styles_source">
									<?php esc_html_e( 'Style(s) URL', 'make-paths-relative' ); ?>
								</label>
							</td>
						</tr>
					</tbody>
				</table>

				<?php if ( ! empty( $old_mps_settings ) ) :?>
					<table class="make-paths-relative">
						<caption>
							<?php esc_html_e( 'Settings (Deprecated)', 'make-paths-relative' ); ?>
						</caption>
						<tbody>
							<tr>
								<td>
									<input type="checkbox" id="deprecated_settings" name="deprecated_settings" value="1" />
									<label for="deprecated_settings">
										<?php esc_html_e( 'Remove (Recommended)', 'make-paths-relative' ); ?>
									</label>
								</td>
							</tr>
						</tbody>
					</table>
				<?php endif; ?>

				<p class="submit">
					<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_html_e( 'Save Changes', 'make-paths-relative' ); ?>" />
				</p>
			</form>
		</div>
		<?php
	}
}
