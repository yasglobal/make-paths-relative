<?php
/**
 * Make Paths Relative setup.
 *
 * @package MakePathsRelative
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main Make Paths Relative class.
 */
final class Make_Paths_Relative {

	/**
	 * Make Paths Relative version.
	 *
	 * @var string
	 */
	public $version = '2.0.0';

	/**
	 * Class constructor.
	 */
	public function __construct() {
		$this->define_constants();
		$this->includes();
		$this->init_hooks();
	}

	/**
	 * Define Make Paths Relative Constants.
	 *
	 * @access private
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function define_constants() {
		$this->define(
			'MAKE_PATHS_RELATIVE_BASENAME',
			plugin_basename( MAKE_PATHS_RELATIVE_FILE )
		);
		$this->define(
			'MAKE_PATHS_RELATIVE_PATH',
			plugin_dir_path( MAKE_PATHS_RELATIVE_FILE )
		);
		$this->define( 'MAKE_PATHS_RELATIVE_VERSION', $this->version );
	}

	/**
	 * Define constant if not set already.
	 *
	 * @since 2.0.0
	 * @access private
	 *
	 * @param string      $name  Constant name.
	 * @param string|bool $value Constant value.
	 */
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * Include required files.
	 *
	 * @access private
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function includes() {
		include_once MAKE_PATHS_RELATIVE_PATH . 'includes/class-make-paths-relative-frontend.php';
		include_once MAKE_PATHS_RELATIVE_PATH . 'admin/class-make-paths-relative-admin.php';

		new Make_Paths_Relative_Frontend();
		new Make_Paths_Relative_Admin();
	}

	/**
	 * Hook into actions and filters.
	 *
	 * @since 2.0.0
	 * @access private
	 */
	private function init_hooks() {
		register_activation_hook(
			MAKE_PATHS_RELATIVE_FILE,
			array( 'Make_Paths_Relative', 'plugin_activate' )
		);

		register_uninstall_hook(
			MAKE_PATHS_RELATIVE_FILE,
			array( 'Make_Paths_Relative', 'plugin_uninstall' )
		);

		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
	}

	/**
	 * Default Settings when the plugin has activated using filter.
	 *
	 * @access public
	 * @since 0.5.3
	 *
	 * @return void
	 */
	public static function plugin_activate() {
		if ( apply_filters( 'make_paths_relative_activate_all', '__false' ) == 1 ) {
			$default_activate = array(
				'site_url'            => '',
				'post_permalinks'     => 'on',
				'page_permalinks'     => 'on',
				'archive_permalinks'  => 'on',
				'author_permalinks'   => 'on',
				'category_permalinks' => 'on',
				'scripts_src'         => 'on',
				'styles_src'          => 'on',
				'image_paths'         => 'on',
			);

			update_option( 'make_paths_relative', serialize( $default_activate ) );
		}
	}

	/**
	 * Add textdomain hook for translation
	 *
	 * @access public
	 * @since 0.5
	 *
	 * @return void
	 */
	public function load_textdomain() {
		load_plugin_textdomain(
			'make-paths-relative',
			false,
			basename( dirname( MAKE_PATHS_RELATIVE_FILE ) ) . '/languages/'
		);
	}
}

new Make_Paths_Relative();
