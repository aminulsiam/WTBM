<?php
if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access pages directly.
class Tour_Cpt {

	public function __construct() {
		add_action( 'init', array( $this, 'register_cpt' ) );
	}


	/**
	 * Register costom post type (Mage tour)
	 */
	public function register_cpt() {
		$labels = array(
			'name'               => _x( 'Tour Package', '' ),
			'singular_name'      => _x( 'Tour Package', '' ),
			'add_new_item'       => __( 'Add New Package' ),
			'add_new'            => __( 'Add New Package' ),
			'edit_item'          => __( 'Edit Package' ),
			'update_item'        => __( 'Update Package' ),
			'search_items'       => __( 'Search Package' ),
			'not_found'          => __( 'Not Found' ),
			'not_found_in_trash' => __( 'Not found in Trash' )
		);
		$args   = array(
			'public'              => true,
			'labels'              => $labels,
			'menu_icon'           => 'dashicons-palmtree',
			'supports'            => array( 'title', 'editor', 'thumbnail' ),
			'rewrite'             => array( 'slug' => 'mage_tour' ),
			'hierarchical'        => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'has_archive'         => true,
			'can_export'          => true,
			'exclude_from_search' => false,
			'yarpp_support'       => true,

		);
		register_post_type( 'mage_tour', $args );

	}

}

new Tour_Cpt();