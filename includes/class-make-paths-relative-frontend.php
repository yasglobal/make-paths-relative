<?php
/**
 * Make Paths Relative Frontend.
 *
 * @package MakePathsRelative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main Class that actually make the URLs relative.
 */
final class Make_Paths_Relative_Frontend {
	/**
	 * Internal doamins (If exist) otherwise WordPress default `site_url()`.
	 *
	 * @var array
	 */
	private $internal_domains = array();

	/**
	 * Sources from where domain needs to be removed.
	 *
	 * @var array
	 */
	private $remove_domain = array();

	/**
	 * Class constructor.
	 */
	public function __construct() {
		$make_relative_paths = get_option( 'make_paths_relative_settings' );
		if ( is_string( $make_relative_paths ) ) {
			$make_relative_paths = maybe_unserialize( $make_relative_paths );
		}

		if ( is_array( $make_relative_paths ) ) {
			if ( isset( $make_relative_paths['internal_domains'] ) ) {
				$this->internal_domains = $make_relative_paths['internal_domains'];
			}
		}

		$host_name = site_url();
		if ( empty( $this->internal_domains ) ) {
			$host_name = site_url();
			$host_name = str_replace( 'http://', '', $host_name );
			$host_name = str_replace( 'https://', '', $host_name );
			$host_name = str_replace( '//', '', $host_name );

			$this->internal_domains = array( $host_name );
		}

		if ( isset( $make_relative_paths['sources'], $make_relative_paths['sources']['remove_domain'] ) ) {
			$remove_domain_sources = $make_relative_paths['sources']['remove_domain'];
			if ( isset( $remove_domain_sources['body'] )
				&& 1 === (int) $remove_domain_sources['body']
			) {
				$this->remove_domain[] = 'body';

				add_action( 'init', array( $this, 'init_html' ), 1 );
				add_action( 'shutdown', array( $this, 'shutdown_html' ), 999999 );
			}

			if ( isset( $remove_domain_sources['scripts'] )
				&& 1 === (int) $remove_domain_sources['scripts']
			) {
				$this->remove_domain[] = 'scripts';

				add_filter(
					'script_loader_src',
					array( $this, 'relative_scripts_styles' ),
					999999
				);
			}

			if ( isset( $remove_domain_sources['stylesheets'] )
				&& 1 === (int) $remove_domain_sources['stylesheets']
			) {
				$this->remove_domain[] = 'stylesheets';

				add_filter(
					'style_loader_src',
					array( $this, 'relative_scripts_styles' ),
					999999
				);
			}

			if ( ( isset( $remove_domain_sources['scripts'] )
				&& 1 === (int) $remove_domain_sources['scripts']
				) ||
				( isset( $remove_domain_sources['stylesheets'] )
				&& 1 === (int) $remove_domain_sources['stylesheets'] )
			) {
				add_filter(
					'stylesheet_directory_uri',
					array( $this, 'relative_scripts_styles' ),
					999999
				);
			}
		}
	}

	/**
	 * Remove domain from the scripts and stylesheets.
	 *
	 * @access public
	 * @since 0.2
	 *
	 * @param string $src The source URL of the enqueued style.
	 *
	 * @return string
	 */
	public function relative_scripts_styles( $src ) {
		// Don't do anything if the current query is for a feed.
		if ( is_feed() ) {
			return $src;
		}

		// Don't do anything if the Product export action exists.
		if ( has_action( 'wp_ajax_woocommerce_do_ajax_product_export' ) ) {
			return $src;
		}

		if ( ! empty( $this->internal_domains ) ) {
			foreach ( $this->internal_domains as $internal_domain ) {
				$src = preg_replace( "/(http:\/\/|https:\/\/|\/\/)$internal_domain/is", '', $src );
			}
		}

		return $src;
	}

	/**
	 * Enable Output buffering and attach the function on WordPress init.
	 */
	public function init_html() {
		ob_start( array( $this, 'remove_domain_from_body' ) );
	}

	/**
	 * Simplifies a path by removing the web address to make it usable within the
	 * local system.
	 *
	 * @param string $buffer Contents of the output buffer.
	 *
	 * @return string
	 */
	public function remove_domain_from_body( $buffer ) {
		$original_buffer = $buffer;
		if ( ! empty( $this->internal_domains ) ) {
			// Replace body content with dummy string.
			$output_body_tags = array();
			preg_match_all( '/<body(.*?)>(.*?)<\/body>/is', $buffer, $output_body_tags );

			$buffer = preg_replace( '/<body(.*?)>(.*?)<\/body>/is', '<body$1>###MAKE_PATHS_RELATIVE_CLEAN_BODY###</body>', $buffer );
			foreach ( $this->internal_domains as $internal_domain ) {
				if ( isset( $output_body_tags[2], $output_body_tags[2][0] ) ) {
					$output_body_tags[2][0] = preg_replace(
						'/(http:\/\/|https:\/\/|\/\/)' . $internal_domain . '/is',
						'',
						$output_body_tags[2][0]
					);

					// Replace escaped URL.
					$output_body_tags[2][0] = str_replace(
						'http:\/\/' . $internal_domain,
						'',
						$output_body_tags[2][0]
					);
					$output_body_tags[2][0] = str_replace(
						'https:\/\/' . $internal_domain,
						'',
						$output_body_tags[2][0]
					);
					$output_body_tags[2][0] = str_replace(
						'\/\/' . $internal_domain,
						'',
						$output_body_tags[2][0]
					);
				}
			}

			// Replace dummy string with body content after removing internal domains.
			if ( isset( $output_body_tags[2], $output_body_tags[2][0] ) ) {
				$buffer = preg_replace( '/###MAKE_PATHS_RELATIVE_CLEAN_BODY###/', $output_body_tags[2][0], $buffer );
			} else {
				$buffer = $original_buffer;
			}
		}

		return $buffer;
	}

	/**
	 * Send and turn off the buffering on WordPress shutdown hook.
	 */
	public function shutdown_html() {
		if ( ob_get_length() ) {
			ob_end_flush();
		}
	}
}
