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

			$this->internal_domains = array(
				$host_name,
			);
		}

		if ( isset( $make_relative_paths['sources'], $make_relative_paths['sources']['remove_domain'] ) ) {
			$remove_domain_sources = $make_relative_paths['sources']['remove_domain'];
			if ( isset( $remove_domain_sources['images'] )
				&& 1 === (int) $remove_domain_sources['images']
			) {
				$this->remove_domain[] = 'images';
			}

			if ( isset( $remove_domain_sources['links'] )
				&& 1 === (int) $remove_domain_sources['links']
			) {
				$this->remove_domain[] = 'links';
			}

			if ( isset( $remove_domain_sources['scripts'] )
				&& 1 === (int) $remove_domain_sources['scripts']
			) {
				$this->remove_domain[] = 'scripts';
			}

			if ( isset( $remove_domain_sources['stylesheets'] )
				&& 1 === (int) $remove_domain_sources['stylesheets']
			) {
				$this->remove_domain[] = 'stylesheets';
			}
		}

		print_r( $this->remove_domain );

		if ( ! empty( $this->remove_domain ) ) {
			add_action( 'init', array( $this, 'init_html' ), 1 );
			add_action( 'shutdown', array( $this, 'shutdown_html' ), 999999 );
		}
	}

	/**
	 * Enable Output buffering and attach the function on WordPress init.
	 */
	public function init_html() {
		ob_start( array( $this, 'page_html' ) );
	}

	/**
	 * Simplifies a path by removing the web address to make it usable within the
	 * local system.
	 *
	 * @param string $buffer Contents of the output buffer.
	 *
	 * @return string
	 */
	public function page_html( $buffer ) {
		if ( ! empty( $this->internal_domains ) ) {
			$current_host = '';
			if ( isset( $_SERVER ) ) {
				if ( isset( $_SERVER['HTTP_HOST'] ) ) {
					if ( isset( $_SERVER['HTTPS'] ) ) {
						$current_host = 'https://' . $_SERVER['HTTP_HOST'];
					} else {
						$current_host = 'http://' . $_SERVER['HTTP_HOST'];
					}
				}
			}

			// $buffer = preg_replace(
			// '/<link (.*?)(rel="canonical") href="(.*?)>/i',
			// '<link $1$2 absolute-href="$3>',
			// $buffer
			// );

			preg_match_all( '/<img\s+.*?>/is', $buffer, $output_img_tags );
			preg_match_all( '/<a\s+.*?<\/a>/is', $buffer, $output_a_tags );
			preg_match_all( '/<script\s+.*?>/is', $buffer, $output_script_tags );
			preg_match_all( '/<link\s+.*?>/is', $buffer, $output_link_tags );

			foreach ( $this->internal_domains as $internal_domain ) {
				if ( isset( $output_img_tags[0] ) && in_array( 'images', $this->remove_domain, true ) ) {
					$i = 0;
					foreach ( $output_img_tags[0] as $img_tag ) {
						$replace_img_tag = preg_replace(
							'/=(\'|")(http:\/\/|https:\/\/|\/\/)' . $internal_domain . '/is',
							'=$1',
							$img_tag
						);

						$i++;

						if ( $i === 5 ) {
							// print  $internal_domain . ' img_tag: ' . $img_tag . '-------' . $replace_img_tag . '<br>';
							// exit;
						}
						$buffer = preg_replace( "/$img_tag/is", $replace_img_tag, $buffer );
					}
				}

				if ( isset( $output_a_tags[0] ) && in_array( 'links', $this->remove_domain, true ) ) {
					foreach ( $output_a_tags[0] as $a_tag ) {
						$replace_a_tag = preg_replace(
							'/=(\'|")(http:\/\/|https:\/\/|\/\/)' . $internal_domain . '/i',
							'=$1',
							$a_tag
						);

						$buffer = str_replace( $a_tag, $replace_a_tag, $buffer );
					}
				}

				if ( isset( $output_script_tags[0] ) && in_array( 'scripts', $this->remove_domain, true ) ) {
					foreach ( $output_script_tags[0] as $script_tag ) {
						$replace_script_tag = preg_replace(
							'/=(\'|")(http:\/\/|https:\/\/|\/\/)' . $internal_domain . '/i',
							'=$1',
							$script_tag
						);

						$buffer = str_replace( $script_tag, $replace_script_tag, $buffer );
					}
				}

				if ( isset( $output_link_tags[0] ) && in_array( 'stylesheets', $this->remove_domain, true ) ) {
					foreach ( $output_link_tags[0] as $link_tag ) {
						$replace_link_tag = preg_replace(
							'/=(\'|")(http:\/\/|https:\/\/|\/\/)' . $internal_domain . '/i',
							'=$1',
							$link_tag
						);

						$buffer = str_replace( $link_tag, $replace_link_tag, $buffer );
					}
				}

				/*
				// Remove domain in `href` attributes.
				$buffer = preg_replace(
					'/ href=(\'|")(http:\/\/|https:\/\/|\/\/)' . $internal_domain . '/i',
					' href=$1',
					$buffer
				);

				// Remove domain in `src` attributes.
				$buffer = preg_replace(
					'/ src=(\'|")(http:\/\/|https:\/\/|\/\/)' . $internal_domain . '/i',
					' src=$1',
					$buffer
				);

				// Remove domain in `action` attributes.
				$buffer = preg_replace(
					'/ action=(\'|")(http:\/\/|https:\/\/|\/\/)' . $internal_domain . '/i',
					' action=$1',
					$buffer
				);

				// Remove domain in `srcset` attributes.
				$buffer = preg_replace(
					'/ srcset=(\'|")(http:\/\/|https:\/\/|\/\/)' . $internal_domain . '/i',
					' srcset=$1',
					$buffer
				);

				// Remove domain in `data-` attributes.
				$buffer = preg_replace(
					'/ (data-\w*=)(\'|")(http:\/\/|https:\/\/|\/\/)' . $internal_domain . '/i',
					' $1$2',
					$buffer
				);

				// Replace domain with current host in `content` attributes.
				if ( ! empty( $current_host ) ) {
					$buffer = preg_replace(
						'/ content=(\'|")(http:\/\/|https:\/\/|\/\/)' . $internal_domain . '/i',
						' content=$1' . $current_host,
						$buffer
					);
				}
				*/
			}
		}

		// print 'output_a_tags<pre>'; print_r( $output_a_tags ); print '</pre>';
		// print 'output_img_tags<pre>'; print_r( $output_img_tags ); print '</pre>';
		// print 'output_link_tags<pre>'; print_r( $output_link_tags ); print '</pre>';
		// print 'output_script_tags<pre>'; print_r( $output_script_tags ); print '</pre>';
		exit;

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
