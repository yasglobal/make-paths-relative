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
	 * Site URL, Either get from the Plugin settings (If exist) otherwise WP
	 * default `site_url()`.
	 *
	 * @var string
	 */
	private $site_url = null;

	/**
	 * Site URL without HTTP Protocol.
	 *
	 * @var string
	 */
	private $make_paths_relative_url = null;

	/**
	 * Class constructor.
	 */
	public function __construct() {
		$make_relative_paths = get_option( 'make_paths_relative' );
		if ( is_string( $make_relative_paths ) ) {
			$make_relative_paths = maybe_unserialize( $make_relative_paths );
		}

		if ( empty( $make_relative_paths ) ) {
			return;
		}

		$host_name = site_url();
		if ( isset( $make_relative_paths['site_url'] )
			&& ! empty( $make_relative_paths['site_url'] )
		) {
			$host_name = $make_relative_paths['site_url'];
		}
		$this->site_url = $host_name;

		if ( strpos( $host_name, 'http://' ) !== false ) {
			$host_name = str_replace( 'http://', '', $host_name );
		} elseif ( strpos( $host_name, 'https://' ) !== false ) {
			$host_name = str_replace( 'https://', '', $host_name );
		} elseif ( strpos( $host_name, '//' ) !== false ) {
			$host_name = str_replace( '//', '', $host_name );
		}
		$this->make_paths_relative_url = $host_name;

		$this->make_paths_relative_applied( $make_relative_paths );
	}

	/**
	 * It makes the permalinks, scripts, styles and image URLs(src) to relative.
	 *
	 * @access public
	 * @since 0.2
	 *
	 * @param string $link Permalink which is going to be shown.
	 * @param bool   $feed Whether to check to feed or not.
	 *
	 * @return string Return the Relative Permalink
	 */
	public function make_paths_relative_remove( $link, $feed = true ) {
		// Don't do anything if the current query is for a feed.
		if ( $feed && is_feed() ) {
			return $link;
		}

		// Don't do anything if the Product export action exists.
		if ( has_action( 'wp_ajax_woocommerce_do_ajax_product_export' ) ) {
			return $link;
		}

		$current_post_type = get_post_type();
		if ( isset( $current_post_type ) && ! empty( $current_post_type ) ) {
			$get_exclude_post_types = get_option( 'make_paths_relative_exclude' );
			if ( is_string( $get_exclude_post_types ) ) {
				$get_exclude_post_types = maybe_unserialize( $get_exclude_post_types );
			}

			if ( isset( $get_exclude_post_types['post_types'][ $current_post_type ] )
				&& 'on' === $get_exclude_post_types['post_types'][ $current_post_type ]
			) {
				return $link;
			}
		}

		$relative_link = $link;
		$relative_link = str_replace(
			'https://' . $this->make_paths_relative_url,
			'',
			$relative_link
		);
		$relative_link = str_replace(
			'http://' . $this->make_paths_relative_url,
			'',
			$relative_link
		);
		$relative_link = str_replace(
			'//' . $this->make_paths_relative_url,
			'',
			$relative_link
		);

		return apply_filters( 'paths_relative', $relative_link );
	}

	/**
	 * It converts the Permalinks to be relative for post and custom post type.
	 *
	 * @access public
	 * @since 0.6
	 *
	 * @param string $link      Permalink which is going to be shown.
	 * @param object $post      Post Details.
	 * @param string $leavename keep the post name or page name.
	 *
	 * @return string Return the Relative Permalink.
	 */
	public function relative_post_urls( $link, $post, $leavename = false ) {
		// Don't do anything if the current query is for a feed.
		if ( is_feed() ) {
			return $link;
		}

		// Don't do anything if the Product export action exists.
		if ( has_action( 'wp_ajax_woocommerce_do_ajax_product_export' ) ) {
			return $link;
		}

		/*
		 * If URL contains `post name` or `page name` then return the `link` as it
		 * is to avoid conflict on Post Edit.
		 * @link: https://wordpress.org/support/topic/compatibility-issue-between-yoast-seo-and-make-paths-relative/
		 */
		if ( $leavename ) {
			return $link;
		}

		$current_post_type = get_post_type();
		if ( isset( $current_post_type ) && ! empty( $current_post_type ) ) {
			$get_exclude_post_types = get_option( 'make_paths_relative_exclude' );
			if ( is_string( $get_exclude_post_types ) ) {
				$get_exclude_post_types = maybe_unserialize( $get_exclude_post_types );
			}

			if ( isset( $get_exclude_post_types['post_types'][ $current_post_type ] )
				&& 'on' === $get_exclude_post_types['post_types'][ $current_post_type ]
			) {
				return $link;
			}
		}

		if ( 'attachment' === $current_post_type && isset( $post->post_type )
			&& 'post' === $post->post_type ) {
			$attachment = get_post( get_the_ID() );
			if ( isset( $attachment->post_parent ) && 0 !== $attachment->post_parent
				&& $post->ID === $attachment->post_parent ) {
				return $link;
			}
		}

		$relative_link = $link;
		$relative_link = str_replace(
			'https://' . $this->make_paths_relative_url,
			'',
			$relative_link
		);
		$relative_link = str_replace(
			'http://' . $this->make_paths_relative_url,
			'',
			$relative_link
		);
		$relative_link = str_replace(
			'//' . $this->make_paths_relative_url,
			'',
			$relative_link
		);

		return apply_filters( 'paths_relative', $relative_link );
	}

	/**
	 * Apply the appropriate Filters according to the configured settings.
	 *
	 * @access private
	 * @since 0.2
	 *
	 * @param array $make_relative_paths Options which is selected in the from
	 *                                   Plugin Settings Page.
	 */
	private function make_paths_relative_applied( $make_relative_paths ) {
		// Check if current requested URL contains `sitemap.xml`.
		if ( isset( $_SERVER, $_SERVER['REQUEST_URI'] ) ) {
			$request_uri = sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) );
			if ( false !== strpos( $request_uri, 'sitemap.xml' ) ) {
				$url_path = wp_parse_url( $request_uri, PHP_URL_PATH );
				// Check if current requested path contains `sitemap.xml`.
				if ( isset( $url_path ) && false !== strpos( $url_path, 'sitemap.xml' ) ) {
					return;
				}
			}
		}

		// Filters to make the permalinks to relative.
		if ( isset( $make_relative_paths['post_permalinks'] )
			&& ! empty( $make_relative_paths['post_permalinks'] )
		) {
			add_filter(
				'the_permalink',
				array( $this, 'make_paths_relative_remove' ),
				100
			);
			add_filter(
				'post_link',
				array( $this, 'relative_post_urls' ),
				100,
				3
			);
			add_filter(
				'post_type_link',
				array( $this, 'relative_post_urls' ),
				100,
				3
			);
			add_filter(
				'wpseo_xml_sitemap_post_url',
				array( $this, 'sitemap_post_url' ),
				100
			);
		}

		if ( isset( $make_relative_paths['page_permalinks'] )
			&& ! empty( $make_relative_paths['page_permalinks'] )
		) {
			add_filter(
				'page_link',
				array( $this, 'make_paths_relative_remove' ),
				100
			);
			add_filter(
				'page_type_link',
				array( $this, 'make_paths_relative_remove' ),
				100,
				2
			);
		}

		if ( isset( $make_relative_paths['archive_permalinks'] )
			&& ! empty( $make_relative_paths['archive_permalinks'] )
		) {
			add_filter(
				'get_archives_link',
				array( $this, 'make_paths_relative_remove' ),
				100
			);
		}

		if ( isset( $make_relative_paths['author_permalinks'] )
			&& ! empty( $make_relative_paths['author_permalinks'] )
		) {
			add_filter(
				'author_link',
				array( $this, 'make_paths_relative_remove' ),
				100
			);
		}

		if ( isset( $make_relative_paths['category_permalinks'] )
			&& ! empty( $make_relative_paths['category_permalinks'] )
		) {
			add_filter(
				'term_link',
				array( $this, 'make_paths_relative_remove' ),
				100,
				3
			);
		}

		// Filters to make the scripts and style urls to relative.
		if ( isset( $make_relative_paths['scripts_src'] )
			&& ! empty( $make_relative_paths['scripts_src'] )
		) {
			add_filter(
				'script_loader_src',
				array( $this, 'make_paths_relative_remove' ),
				100
			);
		}

		if ( isset( $make_relative_paths['styles_src'] )
			&& ! empty( $make_relative_paths['styles_src'] )
		) {
			add_filter(
				'style_loader_src',
				array( $this, 'make_paths_relative_remove' ),
				100
			);
		}

		// Filter to make the media(image) src to relative.
		if ( isset( $make_relative_paths['image_paths'] )
			&& ! empty( $make_relative_paths['image_paths'] )
		) {
			add_filter(
				'wp_get_attachment_url',
				array( $this, 'make_paths_relative_remove' ),
				100
			);
			add_filter(
				'wp_calculate_image_srcset',
				array( $this, 'make_paths_relative_remove_srcset' ),
				100
			);
		}
	}

	/**
	 * Make the srcset to be relative for responsive images.
	 *
	 * @access public
	 * @since 0.3
	 *
	 * @param string $image_srcset Source set of image.
	 *
	 * @return string Return the Relative Source set of image.
	 */
	public function make_paths_relative_remove_srcset( $image_srcset ) {
		// Don't do anything if the current query is for a feed.
		if ( is_feed() ) {
			return $image_srcset;
		}

		// Don't do anything if the Product export action exists.
		if ( has_action( 'wp_ajax_woocommerce_do_ajax_product_export' ) ) {
			return $image_srcset;
		}

		$current_post_type = get_post_type();
		if ( isset( $current_post_type ) && ! empty( $current_post_type ) ) {
			$get_exclude_post_types = get_option( 'make_paths_relative_exclude' );
			if ( is_string( $get_exclude_post_types ) ) {
				$get_exclude_post_types = maybe_unserialize( $get_exclude_post_types );
			}

			if ( isset( $get_exclude_post_types['post_types'][ $current_post_type ] )
				&& 'on' === $get_exclude_post_types['post_types'][ $current_post_type ]
			) {
				return $image_srcset;
			}
		}

		if ( apply_filters( 'srcset_paths_relative', '__true' ) ) {
			foreach ( $image_srcset as $key => $value ) {
				if ( isset( $value['url'] ) ) {
					$value['url'] = str_replace(
						'https://' . $this->make_paths_relative_url,
						'',
						$value['url']
					);
					$value['url'] = str_replace(
						'http://' . $this->make_paths_relative_url,
						'',
						$value['url']
					);
					$value['url'] = str_replace(
						'//' . $this->make_paths_relative_url,
						'',
						$value['url']
					);

					$image_srcset[ $key ]['url'] = $value['url'];
				}
			}
		}

		return $image_srcset;
	}

	/**
	 * Make URL Absolute for Post Types to build Proper Sitemap using Yoast Filter.
	 *
	 * @access public
	 * @since 0.5.1
	 *
	 * @param string $post_permalink Absolute or Relative Permalink.
	 *
	 * @return string Return Absolute Permalink.
	 */
	public function sitemap_post_url( $post_permalink ) {
		if ( false === strpos( $post_permalink, $this->site_url )
			&& isset( $post_permalink[0] ) && '/' === $post_permalink[0]
		) {
			return $this->site_url . $post_permalink;
		}
		return $post_permalink;
	}
}
