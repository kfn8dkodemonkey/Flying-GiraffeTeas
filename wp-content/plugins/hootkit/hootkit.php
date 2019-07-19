<?php
/**
 * Plugin Name:       HootKit
 * Description:       HootKit is a great companion plugin for WordPress themes by wpHoot.
 * Version:           1.0.10
 * Author:            wphoot
 * Author URI:        https://wphoot.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       hootkit
 * Domain Path:       /languages
 *
 * @package           Hootkit
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Uncomment the line below to load unminified CSS and JS, and add other developer data to code.
 */
// define( 'HOOT_DEBUG', true );
if ( !defined( 'HOOT_DEBUG' ) && defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG )
	define( 'HOOT_DEBUG', true );

/**
 * The core plugin class.
 *
 * @since   1.0.0
 * @package Hootkit
 */
if ( ! class_exists( 'HootKit' ) ) :

	class HootKit {

		/**
		 * Plugin version number.
		 *
		 * @since  1.0.0
		 * @access public
		 * @var    string
		 */
		public $version = '1.0.10';

		/**
		 * Plugin name.
		 *
		 * @since  1.0.0
		 * @access public
		 * @var    string
		 */
		public $name = 'HootKit';

		/**
		 * Plugin slug.
		 *
		 * @since  1.0.0
		 * @access public
		 * @var    string
		 */
		public $slug = 'hootkit';

		/**
		 * Plugin directory path with trailing slash.
		 *
		 * @since  1.0.0
		 * @access public
		 * @var    string
		 */
		public $dir = '';

		/**
		 * Plugin directory URI with trailing slash.
		 *
		 * @since  1.0.0
		 * @access public
		 * @var    string
		 */
		public $uri = '';

		/**
		 * Config variable.
		 *
		 * @since  1.0.0
		 * @access public
		 * @var    array
		 */
		public $config = array();

		/**
		 * Constructor method.
		 *
		 * @since  1.0.0
		 * @access private
		 * @return void
		 */
		private function __construct() {}

		/**
		 * Sets up the plugin.
		 *
		 * @since  1.0.0
		 * @access private
		 * @return void
		 */
		private function setup() {

			// Set the properties.
			$this->dir = trailingslashit( plugin_dir_path( __FILE__ ) );
			$this->uri = trailingslashit( plugin_dir_url( __FILE__ ) );

		}

		/**
		 * Sets up the plugin hooks.
		 *
		 * @since  1.0.0
		 * @access private
		 * @return void
		 */
		private function setup_hooks() {

			// Load Text Domain
			add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );

			// -> Initialize plugin after theme has loaded and had a chance to hook in to alter Hootkit Config
			// -> init hook may be a bit late for us to load since 'widgets_init' is used to intialize widgets
			//    (unless we hook into init at 0, which is a bit messy)
			add_action( 'after_setup_theme', array( $this, 'register' ), 90 );
			add_action( 'after_setup_theme', array( $this, 'load' ),     95 );

		}

		/**
		 * Load Plugin Text Domain
		 *
		 * @since  1.0.0
		 * @access public
		 * @return void
		 */
		public function load_plugin_textdomain() {

			load_plugin_textdomain(
				$this->slug,
				false,
				basename( dirname( __FILE__ ) ) . '/languages/' // dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
			);

		}

		/**
		 * Register the cofiguration array
		 * This function is hooked to 'init' action so that themes can register their supported configuration settings
		 *
		 * @since  1.0.0
		 * @access public
		 * @return void
		 */
		public function register() {

			/* Let themes modify the config array */
			$this->config = wp_parse_args( apply_filters( 'hootkit_register', array() ), array(
				'nohoot'    => true,  // Set true for all non wphoot themes
				'theme_css' => false, // If theme is loading its own css, hootkit wont load its own default styles
				'modules'   => array( // Supported Modules
					'sliders'  => array( 'image', 'postimage' ),
					'widgets'  => array( 'announce', 'content-blocks', 'content-posts-blocks', 'cta', 'icon', 'post-grid', 'post-list', 'social-icons', 'ticker' ),
					// @todo 'ticker' width bug: css width percentage does not work inside table/flex layout => theme should remove support if theme markup does not explicitly support this (i.e. max-width provided for ticker boxes inside table cells)
					'importer' => array(),
				),
				'themelist' => array( // wpHoot Themes
					'chromatic',		'dispatch',			'responsive-brix',
					'brigsby',			'creattica',
					'metrolo',			'juxter',			'divogue',
					'hoot-ubix',		'magazine-hoot',	'dollah',
					'hoot-business',	'hoot-du',
					'unos',				'nevark',			'neux',				'magazine-news-byte',
				),
				'presets'   => array( // Default Styles
					'white'  => __( 'White',  'hootkit' ),
					'black'  => __( 'Black',  'hootkit' ),
					'brown'  => __( 'Brown',  'hootkit' ),
					'blue'   => __( 'Blue',   'hootkit' ),
					'cyan'   => __( 'Cyan',   'hootkit' ),
					'green'  => __( 'Green',  'hootkit' ),
					'yellow' => __( 'Yellow', 'hootkit' ),
					'amber'  => __( 'Amber',  'hootkit' ),
					'orange' => __( 'Orange', 'hootkit' ),
					'red'    => __( 'Red',    'hootkit' ),
					'pink'   => __( 'Pink',   'hootkit' ),
				),
				'presetcombo'   => array( // Default Styles
					'white'        => __( 'White',           'hootkit' ),
					'black'        => __( 'Black',           'hootkit' ),
					'brown'        => __( 'Brown',           'hootkit' ),
					'brownbright'  => __( 'Brown (Bright)',  'hootkit' ),
					'blue'         => __( 'Blue',            'hootkit' ),
					'bluebright'   => __( 'Blue (Bright)',   'hootkit' ),
					'cyan'         => __( 'Cyan',            'hootkit' ),
					'cyanbright'   => __( 'Cyan (Bright)',   'hootkit' ),
					'green'        => __( 'Green',           'hootkit' ),
					'greenbright'  => __( 'Green (Bright)',  'hootkit' ),
					'yellow'       => __( 'Yellow',          'hootkit' ),
					'yellowbright' => __( 'Yellow (Bright)', 'hootkit' ),
					'amber'        => __( 'Amber',           'hootkit' ),
					'amberbright'  => __( 'Amber (Bright)',  'hootkit' ),
					'orange'       => __( 'Orange',          'hootkit' ),
					'orangebright' => __( 'Orange (Bright)', 'hootkit' ),
					'red'          => __( 'Red',             'hootkit' ),
					'redbright'    => __( 'Red (Bright)',    'hootkit' ),
					'pink'         => __( 'Pink',            'hootkit' ),
					'pinkbright'   => __( 'Pink (Bright)',   'hootkit' ),
				),
				'settings' => array(), // Misc theme specific settings // Unos <= 2.7.1 // @todo remove in future version
				'supports' => array(), // Misc theme specific settings
			) );

		}

		/**
		 * Load the supported module files
		 *
		 * @since  1.0.0
		 * @access public
		 * @return void
		 */
		public function load() {

			// Get Active Modules
			$sliders  = $this->get_config( 'modules', 'sliders' );
			$widgets  = $this->get_config( 'modules', 'widgets' );
			$importer = $this->get_config( 'modules', 'importer' );

			// Do not load this plugin with older theme versions
			if ( class_exists( 'Hoot_Theme' ) || class_exists( 'Hootubix_Theme' ) || class_exists( 'Maghoot_Theme' ) || class_exists( 'Dollah_Theme' ) )
				$sliders = $widgets = array();

			// Load Limited Core/Helper Functions
			require_once( $this->dir . 'include/hootkit-library.php' );

			if ( !empty( $sliders ) || !empty( $widgets ) ) {

				// Register/Enqueue Scripts and styles
				add_action( 'wp_enqueue_scripts',    array( $this, 'wp_register' )   , 0  );
				add_action( 'admin_enqueue_scripts', array( $this, 'admin_register' ), 0  );
				add_action( 'wp_enqueue_scripts',    array( $this, 'wp_enqueue' )    , 10 );
				add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue' ) , 10 );

				// Load Core/Helper Functions
				require_once( $this->dir . 'admin/widgets.php' );
				if ( !function_exists( 'hoot_lib_core' ) && !function_exists( 'hoot_data' ) ) { // $this->get_config( 'nohoot' ) may return true for prefixed wphoot themes hosted on wp.org
					require_once( $this->dir . 'include/hoot-library.php' );
					require_once( $this->dir . 'include/hoot-library-icons.php' );
				}
				if ( !is_admin() ) {
					require_once( $this->dir . 'include/template.php' );
				}

				// Load Sliders
				if ( !empty( $sliders ) && is_array( $sliders ) ) {
					foreach ( $sliders as $slider ) {
						if ( file_exists( $this->dir . 'admin/slider-' . sanitize_file_name( $slider ) . '.php' ) ) {
							require_once( $this->dir . 'admin/slider-' . sanitize_file_name( $slider ) . '.php' );
						}
					}
				}

				// Load Widgets
				if ( !empty( $widgets ) && is_array( $widgets ) ) {
					foreach ( $widgets as $widget ) {
						if ( file_exists( $this->dir . 'admin/widget-' . sanitize_file_name( $widget ) . '.php' ) ) {
							require_once( $this->dir . 'admin/widget-' . sanitize_file_name( $widget ) . '.php' );
						}
					}
				}

			}

			if ( !empty( $importer ) && is_array( $importer ) ) {
				// @todo add notice for users to choose
				// if ( class_exists( 'OCDI_Plugin' ) ) { }
				// Load Importer
				require_once( $this->dir . 'importer/init.php' );
				// Load Config
				add_filter( 'hkocdi/import_files', array( $this, 'register_importer' ) );
			}

		}

		/**
		 * Register Scripts and Styles
		 *
		 * @since  1.0.0
		 * @access public
		 * @return void
		 */
		public function wp_register() {

			// Get Active Modules
			$sliders = $this->get_config( 'modules', 'sliders' );
			$widgets = $this->get_config( 'modules', 'widgets' );

			// Register Styles
			if ( !empty( $sliders ) )
				wp_register_style( 'lightSlider', $this->asset_uri( 'assets/lightSlider', 'css' ), false, '1.1.2' );
			wp_register_style( 'font-awesome', $this->asset_uri( 'assets/font-awesome', 'css' ), false, '5.0.10' );
			wp_register_style( $this->slug, $this->asset_uri( 'assets/hootkit', 'css' ), array(), $this->version, 'all' );

			// Register Script
			if ( !empty( $sliders ) )
				wp_register_script( 'jquery-lightSlider', $this->asset_uri( 'assets/jquery.lightSlider', 'js' ), array( 'jquery' ), '1.1.2', true );
			if ( in_array( 'number-blocks', $widgets ) )
				wp_register_script( 'jquery-circliful', $this->asset_uri( 'assets/jquery.circliful', 'js' ), array( 'jquery' ), '20160309', true );
			wp_register_script( $this->slug, $this->asset_uri( 'assets/hootkit', 'js' ), array( 'jquery' ), $this->version, true );

		}

		/**
		 * Enqueue Scripts and Styles
		 *
		 * @since  1.0.0
		 * @access public
		 * @return void
		 */
		public function wp_enqueue() {

			$sliders = $this->get_config( 'modules', 'sliders' );
			$widgets = $this->get_config( 'modules', 'widgets' );

			if ( !empty( $sliders ) || !empty( $widgets ) ) {

				// Enqueue Styles
				if ( !empty( $sliders ) )
					wp_enqueue_style( 'lightSlider' );
				wp_enqueue_style( 'font-awesome' );
				if( !$this->get_config( 'theme_css' ) )
					wp_enqueue_style( $this->slug );

				// Enqueue Script
				if ( !empty( $sliders ) )
					wp_enqueue_script( 'jquery-lightSlider' );
				if ( in_array( 'number-blocks', $widgets ) )
					// Hootkit does not load Waypoints. It is upto the theme to deploy waypoints.
					wp_enqueue_script( 'jquery-circliful' );
				wp_enqueue_script( $this->slug );

			}

		}

		/**
		 * Register admin Scripts and Styles
		 *
		 * @since  1.0.0
		 * @access public
		 * @return void
		 */
		public function admin_register( $hook ) {

			// Register Styles
			wp_register_style( $this->slug . '-widgets', $this->asset_uri( 'admin/assets/widgets', 'css' ), array(), $this->version, 'all' );
			wp_register_style( 'select2', $this->asset_uri( 'admin/assets/select2', 'css' ), array(), '4.0.7', 'all' );
			wp_register_style( 'font-awesome', $this->asset_uri( 'assets/font-awesome', 'css' ), false, '5.0.10' );

			// Register Script
			wp_register_script( $this->slug . '-widgets', $this->asset_uri( 'admin/assets/widgets', 'js' ), array( 'jquery', 'select2', 'wp-color-picker' ), $this->version, true );
			wp_register_script( 'select2', $this->asset_uri( 'admin/assets/select2', 'js' ), array( 'jquery' ), '4.0.7', true );

		}

		/**
		 * Enqueue admin Scripts and Styles
		 *
		 * @since  1.0.0
		 * @access public
		 * @return void
		 */
		public function admin_enqueue( $hook ) {

			$sliders = $this->get_config( 'modules', 'sliders' );
			$widgets = $this->get_config( 'modules', 'widgets' );

			if ( !empty( $sliders ) || !empty( $widgets ) ) {

				// SiteOrigin Page Builder compatibility - Load widget assets for SiteOrigin Page Builder plugin on Edit screens
				$widgetload = ( ( 'post.php' == $hook || 'post-new.php' == $hook ) && ( defined( 'SITEORIGIN_PANELS_VERSION' ) && version_compare( SITEORIGIN_PANELS_VERSION, '2.0' ) >= 0 ) ) ? true : false;

				if ( 'widgets.php' == $hook || $widgetload ) {

					// Enqueue Styles
					wp_enqueue_style( 'font-awesome' );
					wp_enqueue_style( 'select2' );
					wp_enqueue_style( $this->slug . '-widgets' );
					wp_enqueue_style( 'wp-color-picker' );

					// Enqueue Script
					wp_enqueue_media();
					wp_enqueue_script( 'select2' );
					wp_enqueue_script( $this->slug . '-widgets' );

				}

			}

			// SiteOrigin Page Builder compatibility - Load css for Live Preview in backend
			// > Limitation: dynamic css is not loaded // @todo test all widgets (inc sliders)
			// if( $widgetload && $this->get_config( 'theme_css' ) && function_exists( 'hoot_locate_style' ) ) {
			// 	wp_enqueue_style( 'theme-hootkit', hoot_data()->template_uri . 'hootkit/hootkit.css' );
			// 	// wp_enqueue_style( 'theme-style', hoot_data()->template_uri . 'style.css' ); // Loads all styles including headings, grid etc -> Not Needed // Loads grid etc for widget post grid etc -> Needed
			// }

		}

		/**
		 * Get asset file uri
		 *
		 * @since  1.0.0
		 * @access public
		 * @param string $location
		 * @param string $type
		 * @return string
		 */
		public function asset_uri( $location, $type ) {

			$location = str_replace( array( $this->dir, $this->uri ), '', $location );

			// Return minified uri if not in debug mode and minified file is available
			if (
				( ! defined( 'SCRIPT_DEBUG' ) || ! SCRIPT_DEBUG ) &&
				( ! defined( 'HOOT_DEBUG'   ) || ! HOOT_DEBUG   ) &&
				file_exists( $this->dir . "{$location}.min.{$type}" ) ) {
					return $this->uri . "{$location}.min.{$type}";
				}

			// Return uri if file is available
			if ( file_exists( $this->dir . "{$location}.{$type}" ) )
				return $this->uri . "{$location}.{$type}";

			return '';

		}

		/**
		 * Register importer config
		 *
		 * @since  1.0.3
		 * @access public
		 * @return array
		 */
		public function register_importer() {
			return $this->get_config( 'modules', 'importer' );
		}

		/**
		 * Get Config values.
		 *
		 * @since  1.0.0
		 * @access public
		 * @param  string $key    Config value to return / else return entire array
		 * @param  string $subkey Check for $subkey if config value is an array
		 * @return mixed
		 */
		public function get_config( $key = '', $subkey = '' ) {

			// Early Check in case config has changed
			if ( !is_array( $this->config ) )
				return array();

			// Return the value
			if ( $key && is_string( $key ) ) {
				if ( isset( $this->config[ $key ] ) ) {
					if ( $subkey && ( is_string( $subkey ) || is_integer( $subkey ) ) ) {
						return ( isset( $this->config[ $key ][ $subkey] ) ) ? $this->config[ $key ][ $subkey ] : array();
					} else {
						return $this->config[ $key ];
					}
				} else {
					return array();
				}
			} else {
				return $this->config;
			}

		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return object
		 */
		public static function get_instance() {

			static $instance = null;

			if ( is_null( $instance ) ) {
				$instance = new self;
				$instance->setup();
				$instance->setup_hooks();
			}

			return $instance;
		}

	}

	/**
	 * Gets the instance of the `HootKit` class. This function is useful for quickly grabbing data
	 * used throughout the plugin.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	function hootkit() {
		return HootKit::get_instance();
	}

	// Lets roll!
	hootkit();

endif;