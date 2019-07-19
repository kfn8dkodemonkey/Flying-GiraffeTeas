<?php

// The code in /importer/ folder has been borrowed from following plugins
// (with slight modifications to suit wphoot theme ux)
//
// One Click Demo Import:    https://wordpress.org/plugins/one-click-demo-import/    License: GPL
// WordPress Importer:       https://wordpress.org/plugins/wordpress-importer/       License: GPL
// Widget Importer Exporter: https://wordpress.org/plugins/widget-importer-exporter/ License: GPL
// Customizer Import/Export: https://wordpress.org/plugins/customizer-export-import/ License: GPL

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Main plugin class with initialization tasks.
 */
class HKOCDI_Plugin {
	/**
	 * Constructor for this class.
	 */
	public function __construct() {
		/**
		 * Display admin error message if PHP version is older than 5.3.2.
		 * Otherwise execute the main plugin class.
		 */
		if ( version_compare( phpversion(), '5.3.2', '<' ) ) {
			add_action( 'admin_notices', array( $this, 'old_php_admin_error_notice' ) );
		}
		else {
			// Set plugin constants.
			$this->set_plugin_constants();

			// Autoloader.
			spl_autoload_register('hkocdi_autoloader');

			// Instantiate the main plugin class *Singleton*.
			$hkocdi_one_click_demo_import = HKOCDI\OneClickDemoImport::get_instance();

			// Register WP CLI commands
			if ( defined( 'WP_CLI' ) && WP_CLI ) {
				WP_CLI::add_command( 'ocdi list', array( 'HKOCDI\WPCLICommands', 'list_predefined' ) );
				WP_CLI::add_command( 'ocdi import', array( 'HKOCDI\WPCLICommands', 'import' ) );
			}

			// spl_autoload_unregister('hkocdi_autoloader');
		}
	}


	/**
	 * Display an admin error notice when PHP is older the version 5.3.2.
	 * Hook it to the 'admin_notices' action.
	 */
	public function old_php_admin_error_notice() {
		$message = sprintf( esc_html__( 'The %2$sOne Click Demo Import%3$s plugin requires %2$sPHP 5.3.2+%3$s to run properly. Please contact your hosting company and ask them to update the PHP version of your site to at least PHP 5.3.2.%4$s Your current version of PHP: %2$s%1$s%3$s', 'hootkit' ), phpversion(), '<strong>', '</strong>', '<br>' );

		printf( '<div class="notice notice-error"><p>%1$s</p></div>', wp_kses_post( $message ) );
	}


	/**
	 * Set plugin constants.
	 *
	 * Path/URL to root of this plugin, with trailing slash and plugin version.
	 */
	private function set_plugin_constants() {
		// Path/URL to root of this plugin, with trailing slash.
		if ( ! defined( 'HK_OCDI_PATH' ) ) {
			define( 'HK_OCDI_PATH', hootkit()->dir . 'importer/' );
		}
		if ( ! defined( 'HK_OCDI_URL' ) ) {
			define( 'HK_OCDI_URL', hootkit()->uri . 'importer/' );
		}

		// Action hook to set the plugin version constant.
		add_action( 'admin_init', array( $this, 'set_plugin_version_constant' ) );
	}


	/**
	 * Set plugin version constant -> HK_OCDI_VERSION.
	 */
	public function set_plugin_version_constant() {
		if ( ! defined( 'HK_OCDI_VERSION' ) ) {
			define( 'HK_OCDI_VERSION', hootkit()->version );
		}
	}
}

// Autoloader
function hkocdi_autoloader($class) {
	if ( strpos( $class, 'HKOCDI' ) === 0 ) {
		$class = str_replace( 'HKOCDI', 'inc', $class );
		$class = str_replace( '\\', '/', $class );
		include_once HK_OCDI_PATH . $class . '.php';
	}
}

// Instantiate the plugin class.
$ocdi_plugin = new HKOCDI_Plugin();