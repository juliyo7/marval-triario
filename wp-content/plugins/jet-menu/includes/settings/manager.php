<?php
namespace Jet_Menu;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
/**
 * Define Controller class
 */
class Settings {

	/**
	 * A reference to an instance of this class.
	 *
	 * @since 1.0.0
	 * @var   object
	 */
	private static $instance = null;

	/**
	 * [$subpage_modules description]
	 * @var array
	 */
	public $subpage_modules = array();

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	// Here initialize our namespace and resource name.
	public function __construct() {

		$this->subpage_modules = apply_filters( 'jet-menu/settings/registered-subpage-modules', array(
			'jet-menu-general-settings' => array(
				'class' => '\\Jet_Menu\\Settings\\General',
				'args'  => array(),
			),
			'jet-menu-desktop-menu-settings' => array(
				'class' => '\\Jet_Menu\\Settings\\Desktop_Menu',
				'args'  => array(),
			),
			'jet-menu-desktop-menu-items-settings' => array(
				'class' => '\\Jet_Menu\\Settings\\Desktop_Menu_Items',
				'args'  => array(),
			),
			'jet-menu-desktop-advanced-settings' => array(
				'class' => '\\Jet_Menu\\Settings\\Desktop_Advanced',
				'args'  => array(),
			),
			'jet-menu-mobile-menu-settings' => array(
				'class' => '\\Jet_Menu\\Settings\\Mobile_Menu',
				'args'  => array(),
			),
		) );

		add_action( 'init', array( $this, 'register_settings_category' ), 10 );

		add_action( 'init', array( $this, 'init_plugin_subpage_modules' ), 10 );
	}

	/**
	 * [init description]
	 * @return [type] [description]
	 */
	public function register_settings_category() {

		\Jet_Dashboard\Dashboard::get_instance()->module_manager->register_module_category( array(
			'name'     => esc_html__( 'JetMenu', 'jet-menu' ),
			'slug'     => 'jet-menu-settings',
			'priority' => 1
		) );
	}

	/**
	 * [init_plugin_subpage_modules description]
	 * @return [type] [description]
	 */
	public function init_plugin_subpage_modules() {
		require jet_menu()->plugin_path( 'includes/settings/subpage-modules/general.php' );
		require jet_menu()->plugin_path( 'includes/settings/subpage-modules/desktop-menu.php' );
		require jet_menu()->plugin_path( 'includes/settings/subpage-modules/desktop-menu-items.php' );
		require jet_menu()->plugin_path( 'includes/settings/subpage-modules/desktop-advanced.php' );
		require jet_menu()->plugin_path( 'includes/settings/subpage-modules/mobile-menu.php' );

		foreach ( $this->subpage_modules as $subpage => $subpage_data ) {
			\Jet_Dashboard\Dashboard::get_instance()->module_manager->register_subpage_module( $subpage, $subpage_data );
		}
	}

}

