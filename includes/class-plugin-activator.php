<?php

if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access pages directly.

if ( ! class_exists( "Plugin_Activator" ) ) {
	class Plugin_Activator {

		/**
		 * This method is fire when pluging will active
		 */
		public static function active() {

			if ( ! Plugin_Activator::wtbm_get_page_by_slug( 'woo-tour-list' ) ) {
				// Create post object
				$my_post = array(
					'post_name'    => 'woo-tour-list',
					'post_title'   => wp_strip_all_tags( 'Woo tour search pakage page' ),
					'post_content' => '[woo_tour_search]',
					'post_status'  => 'publish',
					'post_author'  => 1,
					'post_type'    => 'page',
				);

				// Insert the post into the database
				wp_insert_post( $my_post );
			}


		}//end method active


		/**
		 * Prevent duplicate entry page when plugin activation
		 *
		 * @param $slug
		 *
		 * @return bool
		 */
		public static function wtbm_get_page_by_slug( $slug ) {
			if ( $pages = get_pages() ) {
				foreach ( $pages as $page ) {
					if ( $slug === $page->post_name ) {
						return $page;
					}
				}
			}

			return false;
		}


	}//end class Plugin_Activation
}//end class exists block