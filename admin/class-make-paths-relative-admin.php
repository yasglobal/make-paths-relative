<?php
/**
 * Make Paths Relative Admin.
 *
 * @package MakePathsRelative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create admin menu, add privacy policy etc.
 */
class Make_Paths_Relative_Admin {

	/**
	 * Css file suffix (version number with with extension).
	 *
	 * @var string
	 */
	private $css_suffix = '-' . MAKE_PATHS_RELATIVE_VERSION . '.min.css';

	/**
	 * Initializes WordPress hooks.
	 */
	public function __construct() {
		add_action( 'admin_init', array( $this, 'privacy_policy' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );

		add_filter(
			'plugin_action_links_' . MAKE_PATHS_RELATIVE_BASENAME,
			array( $this, 'settings_link' )
		);
	}

	/**
	 * Add Settings Pages in the Dashboard Menu.
	 *
	 * @access public
	 * @since 0.2
	 *
	 * @return void
	 */
	public function admin_menu() {
		add_menu_page(
			'Make Paths Relative Settings',
			'Make Paths Relative',
			'administrator',
			'make-paths-relative-settings',
			array( $this, 'admin_settings_page' )
		);
		$settings_page = add_submenu_page(
			'make-paths-relative-settings',
			'Make Paths Relative Settings',
			'Settings',
			'administrator',
			'make-paths-relative-settings',
			array( $this, 'admin_settings_page' )
		);
		$excluded_page = add_submenu_page(
			'make-paths-relative-settings',
			'Exclude Posts',
			'Exclude Posts',
			'administrator',
			'make-paths-relative-exclude-posts',
			array( $this, 'exclude_posts_page' )
		);
		$about_page    = add_submenu_page(
			'make-paths-relative-settings',
			'About',
			'About',
			'administrator',
			'make-paths-relative-about-plugins',
			array( $this, 'about_plugin' )
		);

		add_action(
			'admin_print_styles-' . $settings_page . '',
			array( $this, 'add_settings_page_style' )
		);
		add_action(
			'admin_print_styles-' . $about_page . '',
			array( $this, 'add_about_style' )
		);
	}

	/**
	 * Add about page style.
	 *
	 * @access public
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public function add_about_style() {
		wp_enqueue_style(
			'make-paths-relative-about-style',
			plugins_url(
				'/assets/css/about-plugins' . $this->css_suffix,
				MAKE_PATHS_RELATIVE_FILE
			),
			array(),
			true
		);
	}

	/**
	 * Add settings page style.
	 *
	 * @access public
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public function add_settings_page_style() {
		wp_enqueue_style(
			'make-paths-relative-settings-style',
			plugins_url(
				'/assets/css/admin-style' . $this->css_suffix,
				MAKE_PATHS_RELATIVE_FILE
			),
			array(),
			true
		);
	}

	/**
	 * Calls another Function which shows the Settings content.
	 *
	 * @access public
	 * @since 0.2
	 *
	 * @return void
	 */
	public function admin_settings_page() {
		include_once MAKE_PATHS_RELATIVE_PATH . 'admin/class-make-paths-relative-settings.php';
		new Make_Paths_Relative_Settings();

		add_filter( 'admin_footer_text', array( $this, 'admin_footer_text' ), 1 );
	}

	/**
	 * Calls another Function to show list of PostTypes.
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @return void
	 */
	public function exclude_posts_page() {
		include_once MAKE_PATHS_RELATIVE_PATH . 'admin/class-make-paths-relative-exclude.php';
		new Make_Paths_Relative_Exclude();

		add_filter( 'admin_footer_text', array( $this, 'admin_footer_text' ), 1 );
	}

	/**
	 * Add About Plugins Page
	 *
	 * @access public
	 * @since 0.5.6
	 *
	 * @return void
	 */
	public function about_plugin() {
		include_once MAKE_PATHS_RELATIVE_PATH . 'admin/class-make-paths-relative-about.php';
		new Make_Paths_Relative_About();

		add_filter( 'admin_footer_text', array( $this, 'admin_footer_text' ), 1 );
	}

	/**
	 * Add Plugin Support and Follow Message in the footer of Admin Pages.
	 *
	 * @access public
	 * @since 0.5.1
	 *
	 * @return string Shows version, website link and twitter.
	 */
	public function admin_footer_text() {
		$footer_text = __( 'Make Paths Relative version', 'make-paths-relative' ) .
		' ' . MAKE_PATHS_RELATIVE_VERSION . ' ' .
		__( 'by', 'make-paths-relative' ) .
		' <a href="https://www.yasglobal.com/" target="_blank">' .
			__( 'Sami Ahmed Siddiqui', 'make-paths-relative' ) .
		'</a>' .
		' - ' .
		'<a href="https://wordpress.org/support/plugin/make-paths-relative" target="_blank">' .
			__( 'Support forums', 'make-paths-relative' ) .
		'</a>' .
		' - ' .
		'Follow on Twitter:' .
		' <a href="https://twitter.com/samisiddiqui91" target="_blank">' .
			__( 'Sami Ahmed Siddiqui', 'make-paths-relative' ) .
		'</a>';

		return $footer_text;
	}

	/**
	 * Plugin About, Contact and Settings Link on the Plugin Page under
	 * the Plugin Name.
	 *
	 * @access public
	 * @since 0.5.3
	 *
	 * @param array $links Contains the Plugin Basic Link (Activate/Deactivate/Delete).
	 *
	 * @return array $links Plugin Basic Links and added some customer link for Settings,
	 *                      Contact and About.
	 */
	public function settings_link( $links ) {
		$about_link = sprintf(
			// translators: %s replaced with the link.
			__( '<a href="%s" title="About">About</a>', 'make-paths-relative' ),
			'admin.php?page=make-paths-relative-about-plugins'
		);
		$contact_link = sprintf(
			// translators: %s replaced with the link.
			__( '<a href="%s" title="Contact">Contact</a>', 'make-paths-relative' ),
			'https://www.yasglobal.com/#request-form'
		);
		$settings_link = sprintf(
			// translators: %s replaced with the link.
			__( '<a href="%s" title="Settings">Settings</a>', 'make-paths-relative' ),
			'admin.php?page=make-paths-relative-settings'
		);

		array_unshift( $links, $settings_link );
		array_unshift( $links, $contact_link );
		array_unshift( $links, $about_link );

		return $links;
	}

	/**
	 * Add Privacy Policy about the Plugin.
	 *
	 * @access public
	 * @since 0.6
	 *
	 * @return void
	 */
	public function privacy_policy() {
		if ( ! function_exists( 'wp_add_privacy_policy_content' ) ) {
			return;
		}

		$privacy = esc_html__(
			'This plugin doesn\'t collects/store any user related information. To have any kind of further query please feel free to',
			'make-paths-relative'
		);

		$privacy = $privacy .
		' <a href="https://www.yasglobal.com/#request-form" target="_blank">' .
			esc_html__( 'contact us', 'make-paths-relative' ) .
		'</a>';

		wp_add_privacy_policy_content(
			'Make Paths Relative',
			wp_kses_post( wpautop( $privacy, false ) )
		);
	}
}
