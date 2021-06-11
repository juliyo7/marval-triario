<?php
/**
 * Plugin Name: JetEngine
 * Plugin URI:  https://crocoblock.com/plugins/jetengine/
 * Description: The ultimate solution for managing custom post types, taxonomies and meta boxes.
 * Version:     2.8.3
 * Author:      Crocoblock
 * Author URI:  https://crocoblock.com/
 * Text Domain: jet-engine
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die();
}

// If class `Jet_Engine` doesn't exists yet.
if ( ! class_exists( 'Jet_Engine' ) ) {

	/**
	 * @property Jet_Engine_Booking_Forms $forms
	 *
	 * Sets up and initializes the plugin.
	 */
	class Jet_Engine {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    object
		 */
		private static $instance = null;

		/**
		 * A reference to an instance of cherry framework core class.
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    object
		 */
		private $core = null;

		/**
		 * Holder for base plugin URL
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    string
		 */
		private $plugin_url = null;

		/**
		 * Plugin version
		 *
		 * @var string
		 */
		private $version = '2.8.3';

		/**
		 * Holder for base plugin path
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    string
		 */
		private $plugin_path = null;

		/**
		 * Plugin base name
		 *
		 * @var string
		 */
		public $plugin_name = null;

		/**
		 * Jet engine menu page slug
		 *
		 * @var string
		 */
		public $admin_page = 'jet-engine';

		/**
		 * Components
		 */
		public $framework;
		/**
		 * @var Jet_Engine_DB
		 */
		public $db;
		public $api;
		public $components;
		public $post_type;
		public $cpt;
		public $taxonomies;
		public $meta_boxes;
		public $relations;
		/**
		 * @var Jet_Engine_Listings
		 */
		public $listings;
		public $compatibility;
		public $dynamic_tags;
		/**
		 * @var Jet_Engine_Frontend
		 */
		public $frontend;
		public $dashboard;
		/**
		 * @var Jet_Engine_Modules
		 */
		public $modules;
		public $forms;
		/**
		 * @var Jet_Engine_Options_Pages
		 */
		public $options_pages;
		public $accessibility;
		public $dynamic_functions;

		/**
		 * Sets up needed actions/filters for the plugin to initialize.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function __construct() {

			$this->plugin_name = plugin_basename( __FILE__ );

			// Load framework
			add_action( 'after_setup_theme', array( $this, 'framework_loader' ), -20 );

			// Internationalize the text strings used.
			add_action( 'init', array( $this, 'lang' ), -999 );
			// Load files.
			add_action( 'init', array( $this, 'init' ), -999 );

			// Jet Dashboard Init
			add_action( 'init', array( $this, 'jet_dashboard_init' ), -999 );

			// Register activation and deactivation hook.
			register_activation_hook( __FILE__, array( $this, 'activation' ) );
			register_deactivation_hook( __FILE__, array( $this, 'deactivation' ) );


		}

		/**
		 * Returns plugin version
		 *
		 * @return string
		 */
		public function get_version() {
			return $this->version;
		}

		/**
		 * Load framework modules
		 *
		 * @return [type] [description]
		 */
		public function framework_loader() {

			require $this->plugin_path( 'framework/loader.php' );

			$this->framework = new Jet_Engine_CX_Loader(
				array(
					$this->plugin_path( 'framework/interface-builder/cherry-x-interface-builder.php' ),
					$this->plugin_path( 'framework/post-meta/cherry-x-post-meta.php' ),
					$this->plugin_path( 'framework/term-meta/cherry-x-term-meta.php' ),
					$this->plugin_path( 'framework/vue-ui/cherry-x-vue-ui.php' ),
					$this->plugin_path( 'framework/jet-dashboard/jet-dashboard.php' ),
					$this->plugin_path( 'framework/jet-elementor-extension/jet-elementor-extension.php' ),
				)
			);

		}

		/**
		 * Initilize admin-only plugin parts
		 *
		 * @return [type] [description]
		 */
		public function admin_init() {

			if ( ! is_admin() ) {
				return;
			}

			require $this->plugin_path( 'includes/core/accessibility.php' );
			require $this->plugin_path( 'includes/dashboard/manager.php' );

			$this->dashboard     = new Jet_Engine_Dashboard();
			$this->accessibility = new Jet_Engine_Accessibility();

		}

		/**
		 * Manually init required modules.
		 *
		 * @return void
		 */
		public function init() {

			require $this->plugin_path( 'includes/classes/tools.php' );

			$this->admin_init();

			require $this->plugin_path( 'includes/core/db.php' );
			require $this->plugin_path( 'includes/core/functions.php' );
			require $this->plugin_path( 'includes/core/components-manager.php' );
			require $this->plugin_path( 'includes/core/modules-manager.php' );
			require $this->plugin_path( 'includes/core/dynamic-functions.php' );
			require $this->plugin_path( 'includes/compatibility/manager.php' );

			// Initialize REST API
			require $this->plugin_path( 'includes/rest-api/manager.php' );
			$this->api = new Jet_Engine_REST_API();

			$this->db                = new Jet_Engine_DB();
			$this->components        = new Jet_Engine_Components();
			$this->modules           = new Jet_Engine_Modules();
			$this->compatibility     = new Jet_Engine_Compatibility();
			$this->dynamic_functions = new Jet_Engine_Dynamic_Functions();

			// Register plugin-related shortcodes
			require $this->plugin_path( 'includes/classes/shortcodes.php' );
			new Jet_Engine_Shortcodes();

			if ( wp_doing_ajax() ) {

				if ( ! class_exists( 'Jet_Engine_Posts_Search_Handler' ) ) {
					require $this->plugin_path( 'includes/classes/posts-search.php' );
				}

				new Jet_Engine_Posts_Search_Handler();
			}

			do_action( 'jet-engine/init', $this );

		}

		/**
		 * Init the JetDashboard module
		 *
		 * @return void
		 */
		public function jet_dashboard_init() {

			if ( is_admin() ) {

				$jet_dashboard_module_data = $this->framework->get_included_module_data( 'jet-dashboard.php' );

				$jet_dashboard = \Jet_Dashboard\Dashboard::get_instance();

				$jet_dashboard->init( array(
					'path'           => $jet_dashboard_module_data['path'],
					'url'            => $jet_dashboard_module_data['url'],
					'cx_ui_instance' => array( $this, 'jet_dashboard_ui_instance_init' ),
					'plugin_data'    => array(
						'slug'    => 'jet-engine',
						'file'    => 'jet-engine/jet-engine.php',
						'version' => $this->get_version(),
						'plugin_links' => array(
							array(
								'label'  => esc_html__( 'Settings', 'jet-engine' ),
								'url'    => add_query_arg( array( 'page' => 'jet-engine' ), admin_url( 'admin.php' ) ),
								'target' => 'self',
							),
							array(
								'label'  => esc_html__( 'Listing Items', 'jet-engine' ),
								'url'    => add_query_arg( array( 'post_type' => 'jet-engine' ), admin_url( 'edit.php' ) ),
								'target' => 'self',
							),
							array(
								'label'  => esc_html__( 'Post Types List', 'jet-engine' ),
								'url'    => add_query_arg( array( 'page' => 'jet-engine-cpt' ), admin_url( 'admin.php' ) ),
								'target' => 'self',
							),
							array(
								'label'  => esc_html__( 'Meta Boxes List', 'jet-engine' ),
								'url'    => add_query_arg( array( 'page' => 'jet-engine-meta' ), admin_url( 'admin.php' ) ),
								'target' => 'self',
							),
							array(
								'label'  => esc_html__( 'Taxonomies List', 'jet-engine' ),
								'url'    => add_query_arg( array( 'page' => 'jet-engine-cpt-tax' ), admin_url( 'admin.php' ) ),
								'target' => 'self',
							),
							array(
								'label'  => esc_html__( 'Relations List', 'jet-engine' ),
								'url'    => add_query_arg( array( 'page' => 'jet-engine-relations' ), admin_url( 'admin.php' ) ),
								'target' => 'self',
							),
							array(
								'label'  => esc_html__( 'Options Pages', 'jet-engine' ),
								'url'    => add_query_arg( array( 'page' => 'jet-engine-options-pages' ), admin_url( 'admin.php' ) ),
								'target' => 'self',
							),
						),
					),
				) );
			}
		}

		/**
		 * Get Vue UI Instance for JetDashboard module
		 *
		 * @return CX_Vue_UI
		 */
		public function jet_dashboard_ui_instance_init() {
			$cx_ui_module_data = $this->framework->get_included_module_data( 'cherry-x-vue-ui.php' );

			return new CX_Vue_UI( $cx_ui_module_data );
		}

		/**
		 * Check if theme has elementor
		 *
		 * @return boolean
		 */
		public function has_elementor() {
			return defined( 'ELEMENTOR_VERSION' );
		}

		/**
		 * Check if theme has elementor
		 *
		 * @return boolean
		 */
		public function has_elementor_pro() {
			return defined( 'ELEMENTOR_PRO_VERSION' );
		}

		/**
		 * Returns path to file or dir inside plugin folder
		 *
		 * @param  string $path Path inside plugin dir.
		 * @return string
		 */
		public function plugin_path( $path = null ) {

			if ( ! $this->plugin_path ) {
				$this->plugin_path = trailingslashit( plugin_dir_path( __FILE__ ) );
			}

			return $this->plugin_path . $path;
		}
		/**
		 * Returns url to file or dir inside plugin folder
		 *
		 * @param  string $path Path inside plugin dir.
		 * @return string
		 */
		public function plugin_url( $path = null ) {

			if ( ! $this->plugin_url ) {
				$this->plugin_url = trailingslashit( plugin_dir_url( __FILE__ ) );
			}

			return $this->plugin_url . $path;
		}

		/**
		 * Loads the translation files.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function lang() {
			load_plugin_textdomain( 'jet-engine', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		}

		/**
		 * Get the template path.
		 *
		 * @return string
		 */
		public function template_path() {
			return apply_filters( 'jet-engine/template-path', 'jet-engine/' );
		}

		/**
		 * Returns path to template file.
		 *
		 * @return string|bool
		 */
		public function get_template( $name = null ) {

			$template = locate_template( $this->template_path() . $name );

			if ( ! $template ) {
				$template = $this->plugin_path( 'templates/' . $name );
			}

			if ( file_exists( $template ) ) {
				return $template;
			} else {
				return false;
			}
		}

		/**
		 * Do some stuff on plugin activation
		 *
		 * @since  1.0.0
		 * @return void
		 */
		public function activation() {
			require $this->plugin_path( 'includes/core/db.php' );
			Jet_Engine_DB::create_all_tables();
		}

		/**
		 * Do some stuff on plugin activation
		 *
		 * @since  1.0.0
		 * @return void
		 */
		public function deactivation() {
		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return Jet_Engine
		 */
		public static function get_instance() {
			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}
			return self::$instance;
		}
	}
}

if ( ! function_exists( 'jet_engine' ) ) {

	/**
	 * Returns instance of the plugin class.
	 *
	 * @since  1.0.0
	 * @return Jet_Engine
	 */
	function jet_engine() {
		return Jet_Engine::get_instance();
	}
}

jet_engine();
