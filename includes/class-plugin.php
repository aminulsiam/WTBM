<?php
if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access pages directly.

/**
 * @since      1.0.0
 * @package    Mage_Plugin
 * @subpackage Mage_Plugin/includes
 * @author     MagePeople team <magepeopleteam@gmail.com>
 */
class Mage_Tour_Plugin {


	protected $loader;

	protected $plugin_name;

	protected $version;

	public function __construct() {
		$this->load_dependencies();
		add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );
	}

	private function load_dependencies() {
		require_once PLUGIN_DIR . 'lib/classes/class-form-fields-generator.php';
		require_once PLUGIN_DIR . 'lib/classes/class-form-fields-wrapper.php';
		require_once PLUGIN_DIR . 'lib/classes/class-meta-box.php';
		require_once PLUGIN_DIR . 'lib/classes/class-taxonomy-edit.php';
		require_once PLUGIN_DIR . 'lib/classes/class-theme-page.php';
		require_once PLUGIN_DIR . 'lib/classes/class-menu-page.php';
		require_once PLUGIN_DIR . 'lib/class-wc-product-type.php';
		require_once PLUGIN_DIR . 'includes/class-plugin-loader.php';
		require_once PLUGIN_DIR . 'includes/class-add-cart-data.php';
		require_once PLUGIN_DIR . 'admin/class-plugin-admin.php';
		require_once PLUGIN_DIR . 'public/class-plugin-public.php';
		require_once PLUGIN_DIR . 'public/template-parts/templating.php';
		require_once PLUGIN_DIR . 'includes/class-plugin-helper.php';
		$this->loader = new Mage_Tour_Plugin_Loader();
	}


	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'mage-plugin',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}


	public function run() {
		$this->loader->run();
	}

	public function get_plugin_name() {
		return $this->plugin_name;
	}

	public function get_loader() {
		return $this->loader;
	}

	public function get_version() {
		return $this->version;
	}

}
