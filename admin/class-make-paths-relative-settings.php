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
				'internal_domains' => array(),
				'sources'          => array(
					'remove_domain' => array(
						'body'        => 0,
						'scripts'     => 0,
						'stylesheets' => 0,
					),
				),
			);

			$internal_domains = filter_input( INPUT_POST, 'internal_domains' );
			$internal_domains = preg_replace( '/(http:\/\/|https:\/\/|\/\/)/i', '', $internal_domains );
			$strip_domains    = wp_kses( $internal_domains, array() );
			$strip_domains    = explode( "\n", $strip_domains );
			foreach ( $strip_domains as $domain ) {
				$domain = trim( $domain );
				$domain = rtrim( $domain, '/' );
				if ( ! empty( $domain ) && ! in_array( $domain, $mps_settings['internal_domains'], true ) ) {
					$mps_settings['internal_domains'][] = $domain;
				}
			}

			$enable_hyperlinks = (int) filter_input( INPUT_POST, 'hyperlinks' );
			if ( 1 === $enable_hyperlinks ) {
				$mps_settings['sources']['remove_domain']['links'] = 1;
			}

			$enable_body = (int) filter_input( INPUT_POST, 'body_content' );
			if ( 1 === $enable_body ) {
				$mps_settings['sources']['remove_domain']['body'] = 1;
			}

			$enable_scripts = (int) filter_input( INPUT_POST, 'scripts_source' );
			if ( 1 === $enable_scripts ) {
				$mps_settings['sources']['remove_domain']['scripts'] = 1;
			}

			$enable_styles = (int) filter_input( INPUT_POST, 'styles_source' );
			if ( 1 === $enable_styles ) {
				$mps_settings['sources']['remove_domain']['stylesheets'] = 1;
			}

			update_option( 'make_paths_relative_settings', $mps_settings, false );

			// Remove Deprecated settings if exists.
			if ( get_option( 'make_paths_relative' ) ) {
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

		$body_enabled       = '';
		$get_mps_settings   = get_option( 'make_paths_relative_settings' );
		$hyperlinks_enabled = '';
		$internal_domains   = array();
		$scripts_enabled    = '';
		$styles_enabled     = '';
		$user_id            = get_current_user_id();

		if ( is_array( $get_mps_settings ) ) {
			if ( isset( $get_mps_settings['internal_domains'] ) ) {
				$internal_domains = $get_mps_settings['internal_domains'];
			}

			if ( isset( $get_mps_settings['sources'], $get_mps_settings['sources']['remove_domain'] ) ) {
				$remove_domain_sources = $get_mps_settings['sources']['remove_domain'];
				if ( isset( $remove_domain_sources['body'] )
					&& 1 === (int) $remove_domain_sources['body']
				) {
					$body_enabled = 'checked';
				}

				if ( isset( $remove_domain_sources['links'] )
					&& 1 === (int) $remove_domain_sources['links']
				) {
					$hyperlinks_enabled = 'checked';
				}

				if ( isset( $remove_domain_sources['scripts'] )
					&& 1 === (int) $remove_domain_sources['scripts']
				) {
					$scripts_enabled = 'checked';
				}

				if ( isset( $remove_domain_sources['stylesheets'] )
					&& 1 === (int) $remove_domain_sources['stylesheets']
				) {
					$styles_enabled = 'checked';
				}
			}
		}
		?>

		<div class="wrap">
			<h2><?php esc_html_e( 'Make Paths Relative', 'make-paths-relative' ); ?></h2>
			<div>
				<?php esc_html_e( 'Mark the paths/URLs that should be treated as internal links.', 'make-paths-relative' ); ?>
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
							<td>
								<textarea id="internal_domains" name="internal_domains" placeholder="List internal domain names, one per line, excluding the http or https prefix." rows="10" cols="100"><?php echo esc_html( implode( "\n", $internal_domains ) ); ?></textarea>
								<div><?php esc_html_e( 'Leave the field blank to use the website\'s main address. Otherwise, enter each address on a separate line.', 'make-paths-relative' ); ?></div>
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
								<input type="checkbox" id="body_content" name="body_content" value="1" <?php echo esc_attr( $body_enabled ); ?> />
								<label for="body_content">
									<?php esc_html_e( 'Body Content', 'make-paths-relative' ); ?>
									<small>Includes images, links, inline style, script, etc. which comes under <code>&lt;body&gt;</code>tag.</small>
								</label>
							</td>
						</tr>
						<tr>
							<td>
								<input type="checkbox" id="scripts_source" name="scripts_source" value="1" <?php echo esc_attr( $scripts_enabled ); ?> />
								<label for="scripts_source">
									<?php esc_html_e( 'Script(s) under head tag', 'make-paths-relative' ); ?>
								</label>
							</td>
						</tr>
						<tr>
							<td>
								<input type="checkbox" id="styles_source" name="styles_source" value="1" <?php echo esc_attr( $styles_enabled ); ?> />
								<label for="styles_source">
									<?php esc_html_e( 'Stylesheet(s) under head tag', 'make-paths-relative' ); ?>
								</label>
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
