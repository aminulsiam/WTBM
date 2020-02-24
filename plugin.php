<?php
/**
 * Plugin Name:       Woocommerce Tour Booking Manager
 * Plugin URI:        mage-people.com
 * Description:       This plugin will booking your tour pakage.
 * Version:           1.0.4
 * Author:            MagePeople team
 * Author URI:        mage-people.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woocommerce-tour-booking-manager
 * Domain Path:       /languages
 */


include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {

// If this file is called directly, abort.
	if ( ! defined( 'WPINC' ) ) {
		die;
	}
	
	
	/**
	 * The code that runs during plugin activation.
	 * This action is documented in includes/class-mage-plugin-activator.php
	 */
	function tour_activation_plugin() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-plugin-activator.php';
		Plugin_Activator::active();
	}
	
	/**
	 * The code that runs during plugin deactivation.
	 * This action is documented in includes/class-mage-plugin-deactivator.php
	 */
	function tour_deactivation_plugin() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-plugin-deactivator.php';
		// Mage_Plugin_Deactivator::deactivate();
	}
	
	register_activation_hook( __FILE__, 'tour_activation_plugin' );
	register_deactivation_hook( __FILE__, 'tour_deactivation_plugin' );
	
	
	class Tour_Base {
		
		public function __construct() {
			$this->define_constants();
			$this->load_main_class();
			$this->run_mage_plugin();
		}
		
		public function define_constants() {
			define( 'PLUGIN_URL', WP_PLUGIN_URL . '/' . plugin_basename( dirname( __FILE__ ) ) . '/' );
			define( 'PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
			define( 'PLUGIN_FILE', plugin_basename( __FILE__ ) );
		}
		
		public function load_main_class() {
			require PLUGIN_DIR . 'includes/class-plugin.php';
		}
		
		public function run_mage_plugin() {
			$plugin = new Mage_Tour_Plugin();
			$plugin->run();
		}
	}
	
	new Tour_Base();
} else {
	function mep_admin_notice_wc_not_active() {
		printf(
			'<div class="error" style="background:red; color:#fff;"><p>%s</p></div>',
			__( 'You Must Install Woocommerce plugin before activating Woocommerce Tour Booking Manager, Becuase It is dependent on Woocommerce' ) );
	}
	
	add_action( 'admin_notices', 'mep_admin_notice_wc_not_active' );
}

