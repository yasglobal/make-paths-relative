<?php
/**
 * Make Paths Relative About.
 *
 * @package MakePathsRelative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Generate about page HTML.
 */
class Make_Paths_Relative_About {
	/**
	 * Class constructor.
	 */
	public function __construct() {
		$this->more_plugins();
	}

	/**
	 * Print HTML for Make Paths Relative About Page.
	 *
	 * @since 0.5.06
	 * @access private
	 *
	 * @return void
	 */
	private function more_plugins() {
		$img_src = plugins_url( '/assets/images', MAKE_PATHS_RELATIVE_FILE );
		?>

		<div class="wrap">
			<div class="float">
				<h1>
					<?php
						esc_html_e(
							// translators: After `v` there will be a Plugin version.
							// phpcs:ignore WordPress.WP.I18n.NonSingularStringLiteralText
							'Make Paths Relative v' . MAKE_PATHS_RELATIVE_VERSION,
							'make-paths-relative'
						);
					?>
				</h1>
				<div class="tagline">
					<p>
						<?php
						esc_html_e(
							'Thank you for choosing Make Paths Relative! We hope that your experience with our plugin for making your URLs from absolute to a relative is quick and easy.',
							'make-paths-relative'
						);
						?>
					</p>
					<p>
						<?php
						esc_html_e(
							'To support future development and to help make it even better please leave a',
							'make-paths-relative'
						);
						?>
						<a href="https://wordpress.org/support/plugin/make-paths-relative/reviews/?rate=5#new-post" title="Make Paths Relative Rating" target="_blank">
						<?php
						esc_html_e( '5-star', 'make-paths-relative' );
						?>
						</a>
						<?php
						esc_html_e(
							'rating with a nice message to me :)',
							'make-paths-relative'
						);
						?>
						</p>
					</div>
				</div>

				<div class="float">
					<?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<img src="<?php echo $img_src . '/make-paths-relative.svg'; ?>" alt="<?php esc_html_e( 'Make Paths Relative', 'make-paths-relative' ); ?>" title="<?php esc_html_e( 'Make Paths Relative', 'make-paths-relative' ); ?>" />
				</div>

				<div class="product">
				<h2>
					<?php esc_html_e( 'More from YAS Global', 'make-paths-relative' ); ?>
				</h2>
				<span>
				<?php
				esc_html_e(
					'Our List of Plugins provides the services which help you to prevent your site from XSS Attacks, Brute force attack, change absolute paths to relative, increase your site visitors by adding Structured JSON Markup and so on.',
					'make-paths-relative'
				);
				?>
				</span>

				<div class="box recommended">
					<div class="img">
						<?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<img src="<?php echo $img_src . '/custom-permalinks.svg'; ?>" alt="<?php esc_html_e( 'Custom Permalinks', 'make-paths-relative' ); ?>" title="<?php esc_html_e( 'Custom Permalinks', 'make-paths-relative' ); ?>"/>
					</div>

					<h3>
					<?php
					esc_html_e( 'Custom Permalinks', 'make-paths-relative' );
					?>
					</h3>
					<p>
					<?php
					esc_html_e( 'Custom Permalinks helps you to make your permalinks customized for <em>individual</em> posts, pages, tags or categories. It will <strong>NOT</strong> apply whole permalink structures, or automatically apply a category\'s custom permalink to the posts within that category.', 'make-paths-relative' );
					?>
					</p>
					<a href="https://www.custompermalinks.com/" class="checkout-button" title="<?php esc_html_e( 'Custom Permalinks', 'make-paths-relative' ); ?>" target="_blank">
					<?php esc_html_e( 'Check it out', 'make-paths-relative' ); ?>
					</a>
				</div>


				<div class="box recommended">
					<div class="img">
						<?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<img src="<?php echo $img_src . '/prevent-xss-vulnerability.png'; ?>" alt="<?php esc_html_e( 'Prevent XSS Vulnerability', 'make-paths-relative' ); ?>" title="<?php esc_html_e( 'Prevent XSS Vulnerability', 'make-paths-relative' ); ?>" style="transform:scale(1.5)" />
					</div>

					<h3>
						<?php
						esc_html_e( 'Prevent XSS Vulnerability', 'make-paths-relative' );
						?>
					</h3>
					<p>
						<?php
						esc_html_e(
							'Secure your site from the XSS Attacks so, your users won\'t lose any kind of information or not redirected to any other site by visiting your site with the malicious code in the URL or so. In this way, users can open their site URLs without any hesitation.',
							'make-paths-relative'
						);
						?>
					</p>
					<a href="https://wordpress.org/plugins/prevent-xss-vulnerability/" class="checkout-button" title="<?php esc_html_e( 'Prevent XSS Vulnerability', 'make-paths-relative' ); ?>" target="_blank">
						<?php esc_html_e( 'Check it out', 'make-paths-relative' ); ?>
					</a>
				</div>

				<div class="box recommended">
					<div class="img">
						<?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<img src="<?php echo $img_src . '/http-auth.svg'; ?>" alt="<?php esc_html_e( 'HTTP Auth', 'make-paths-relative' ); ?>" title="<?php esc_html_e( 'HTTP Auth', 'make-paths-relative' ); ?>" />
					</div>

					<h3>
						<?php esc_html_e( 'HTTP Auth', 'make-paths-relative' ); ?>
					</h3>
					<p>
						<?php
						esc_html_e(
							'Allows you apply HTTP Auth on your site. You can apply Http Authentication all over the site or only the admin pages. It helps to stop crawling on your site while on development or persist the Brute Attacks by locking the Admin Pages.',
							'make-paths-relative'
						);
						?>
					</p>
					<a href="https://wordpress.org/plugins/http-auth/" class="checkout-button" title="<?php esc_html_e( 'HTTP Auth', 'make-paths-relative' ); ?>" target="_blank">
						<?php esc_html_e( 'Check it out', 'make-paths-relative' ); ?>
					</a>
				</div>

				<div class="box">
					<div class="img">
						<?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<img src="<?php echo $img_src . '/schema-for-article.svg'; ?>" alt="<?php esc_html_e( 'SCHEMA for Article', 'make-paths-relative' ); ?>" title="<?php esc_html_e( 'SCHEMA for Article', 'make-paths-relative' ); ?>" />
					</div>

					<h3>
						<?php esc_html_e( 'SCHEMA for Article', 'make-paths-relative' ); ?>
					</h3>
					<p>
						<?php
						esc_html_e(
							'Simply the easiest solution to add valid schema.org as a JSON script in the head of blog posts or articles. You can choose the schema either to show with the type of Article or NewsArticle from the settings page.',
							'make-paths-relative'
						);
						?>
					</p>
					<a href="https://wordpress.org/plugins/schema-for-article/" class="checkout-button" title="<?php esc_html_e( 'SCHEMA for Article', 'make-paths-relative' ); ?>" target="_blank">
						<?php esc_html_e( 'Check it out', 'make-paths-relative' ); ?>
					</a>
				</div>

				<div class="box">
					<div class="img">
						<?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<img src="<?php echo $img_src . '/remove-links-and-scripts.svg'; ?>" alt="<?php esc_html_e( 'Remove Links and Scripts', 'make-paths-relative' ); ?>" title="<?php esc_html_e( 'Remove Links and Scripts', 'make-paths-relative' ); ?>" />
					</div>

					<h3>
						<?php esc_html_e( 'Remove Links and Scripts', 'make-paths-relative' ); ?>
					</h3>
					<p>
						<?php
						esc_html_e(
							'It removes some meta data from the WordPress header so, your header keeps clean of useless information like shortlink, rsd_link, wlwmanifest_link, emoji_scripts, wp_embed, wp_json, emoji_styles, generator and so on.',
							'make-paths-relative'
						);
						?>
					</p>
					<a href="https://wordpress.org/plugins/remove-links-and-scripts/" class="checkout-button" title="<?php esc_html_e( 'Remove Links and Scripts', 'make-paths-relative' ); ?>" target="_blank">
						<?php esc_html_e( 'Check it out', 'make-paths-relative' ); ?>
					</a>
				</div>

				<div class="box">
					<div class="img">
						<?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<img src="<?php echo $img_src . '/media-post-permalink.png'; ?>" style="transform:scale(1.5)" alt="<?php esc_html_e( 'Media Post Permalink', 'make-paths-relative' ); ?>" title="<?php esc_html_e( 'Media Post Permalink', 'make-paths-relative' ); ?>" />
					</div>

					<h3>
						<?php esc_html_e( 'Media Post Permalink', 'make-paths-relative' ); ?>
					</h3>
					<p>
						<?php
						esc_html_e(
							'On uploading  any image, let\'s say services.png, WordPress creates the attachment post with the permalink of /services/ and doesn\'t allow you to use that permalink to point your page. In this case, we come up with this great solution.',
							'make-paths-relative'
						);
						?>
					</p>
					<a href="https://wordpress.org/plugins/media-post-permalink/" class="checkout-button" title="<?php esc_html_e( 'Media Post Permalink', 'make-paths-relative' ); ?>" target="_blank">
						<?php esc_html_e( 'Check it out', 'make-paths-relative' ); ?>
					</a>
				</div>

				<div class="box">
					<div class="img">
						<?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<img src="<?php echo $img_src . '/json-structuring-markup.svg'; ?>" alt="<?php esc_html_e( 'JSON Structuring Markup', 'make-paths-relative' ); ?>" title="<?php esc_html_e( 'JSON Structuring Markup', 'make-paths-relative' ); ?>" />
					</div>

					<h3>
						<?php esc_html_e( 'JSON Structuring Markup', 'make-paths-relative' ); ?>
					</h3>
					<p>
						<?php
						esc_html_e(
							'Simply the easiest solution to add valid schema.org as a JSON script in the head of posts and pages. It provides you multiple SCHEMA types like Article, News Article, Organization and Website Schema.',
							'make-paths-relative'
						);
						?>
					</p>
					<a href="https://wordpress.org/plugins/json-structuring-markup/" class="checkout-button" title="<?php esc_html_e( 'JSON Structuring Markup', 'make-paths-relative' ); ?>" target="_blank">
						<?php esc_html_e( 'Check it out', 'make-paths-relative' ); ?>
					</a>
				</div>
			</div>
		</div>
		<?php
	}
}
