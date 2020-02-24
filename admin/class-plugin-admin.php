<?php
if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access pages directly.

/**
 * @package    Mage_Plugin
 * @subpackage Mage_Plugin/admin
 * @author     MagePeople team <magepeopleteam@gmail.com>
 */
class Tour_Plugin_Admin {
	
	private $plugin_name;
	
	private $version;
	
	public function __construct() {
		
		// $this->plugin_name = $plugin_name;
		// $this->version = $version;
		$this->load_admin_dependencies();
		
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ), 10 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		
		add_action( 'woocommerce_checkout_order_processed', array( $this, 'tour_booking_data_create' ) );
		add_action( 'woocommerce_order_status_changed', array( $this, 'change_attendee_status' ), 10, 4 );
		
		add_action( 'wp_trash_post', array( $this, 'wtbm_booking_info_trash' ), 90 );
		add_action( 'untrash_post', array( $this, 'wtbm_booking_info_untrash' ), 90 );
		
		//Insert tour as woocommerce hidden product
		add_action( 'wp_insert_post', array( $this, 'wtbm_on_post_publish' ), 10, 2 );
		add_action( 'save_post', array( $this, 'wtbm_wc_link_product_on_save' ), 10, 1 );
		
		add_action( 'parse_query', array( $this, 'wtbm_product_tags_sorting_query' ) );
		
	}
	
	function wtbm_count_hidden_wc_product( $tour_id ) {
		$args = array(
			'post_type'      => 'product',
			'posts_per_page' => - 1,
			'meta_query'     => array(
				array(
					'key'     => 'link_wtbm_tour',
					'value'   => $tour_id,
					'compare' => '=',
				),
			),
		);
		$loop = new WP_Query( $args );
		
		return $loop->post_count;
		
	}//end method wtbm_count_hidden_wc_product
	
	/**
	 * Hide tour in product details page which is added as woo product.
	 *
	 * @param $query
	 */
	function wtbm_product_tags_sorting_query( $query ) {
		global $pagenow;
		
		$taxonomy = 'product_visibility';
		
		$q_vars = &$query->query_vars;
		
		if ( $pagenow == 'edit.php' && isset( $q_vars['post_type'] ) && $q_vars['post_type'] == 'product' ) {
			
			$tax_query = array(
				[
					'taxonomy' => 'product_visibility',
					'field'    => 'slug',
					'terms'    => 'exclude-from-catalog',
					'operator' => 'NOT IN',
				],
			);
			$query->set( 'tax_query', $tax_query );
		}
		
	}//end method wtbm_product_tags_sorting_query
	
	/**
	 * Create Hidden tour product
	 *
	 * @param $post_id
	 * @param $title
	 */
	function wtbm_create_hidden_tour_product( $post_id, $title ) {
		$new_post = array(
			'post_title'    => $title,
			'post_content'  => '',
			'post_name'     => uniqid(),
			'post_category' => array(),
			'tags_input'    => array(),
			'post_status'   => 'publish',
			'post_type'     => 'product',
		);
		
		
		$pid = wp_insert_post( $new_post );
		
		update_post_meta( $post_id, 'link_wc_product', $pid );
		update_post_meta( $pid, 'link_wtbm_tour', $post_id );
		update_post_meta( $pid, '_price', 0.01 );
		
		update_post_meta( $pid, '_sold_individually', 'yes' );
		update_post_meta( $pid, '_virtual', 'yes' );
		$terms = array( 'exclude-from-catalog', 'exclude-from-search' );
		wp_set_object_terms( $pid, $terms, 'product_visibility' );
		update_post_meta( $post_id, 'check_if_run_once', true );
		
	}//end method wtbm_create_hidden_tour_product
	
	
	/**
	 * @param $post_id
	 */
	public function wtbm_wc_link_product_on_save( $post_id ) {
		
		if ( get_post_type( $post_id ) == 'mage_tour' ) {
			
			if ( ! isset( $_POST['wtbm_meta_box_nonce'] ) ||
			     ! wp_verify_nonce( $_POST['wtbm_meta_box_nonce'], 'wtbm_meta_box_nonce' ) ) {
				return;
			}
			
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}
			
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
			
			$tour_name = get_the_title( $post_id );
			
			if ( $this->wtbm_count_hidden_wc_product( $post_id ) == 0 || empty( get_post_meta( $post_id,
					'link_wc_product',
					true ) ) ) {
				
				$this->wtbm_create_hidden_tour_product( $post_id, $tour_name );
			}
			
			$product_id = get_post_meta( $post_id, 'link_wc_product', true ) ? get_post_meta( $post_id,
				'link_wc_product',
				true ) : $post_id;
			
			set_post_thumbnail( $product_id, get_post_thumbnail_id( $post_id ) );
			
			wp_publish_post( $product_id );
			
			$_tax_status = isset( $_POST['_tax_status'] ) ? strip_tags( $_POST['_tax_status'] ) : 'none';
			$_tax_class  = isset( $_POST['_tax_class'] ) ? strip_tags( $_POST['_tax_class'] ) : '';
			
			update_post_meta( $product_id, '_tax_status', $_tax_status );
			update_post_meta( $product_id, '_tax_class', $_tax_class );
			update_post_meta( $product_id, '_stock_status', 'instock' );
			update_post_meta( $product_id, '_manage_stock', 'no' );
			update_post_meta( $product_id, '_virtual', 'yes' );
			update_post_meta( $product_id, '_sold_individually', 'yes' );
			update_post_meta( $product_id, '_price', 0.01 );
			
			// Update post
			$my_post = array(
				'ID'         => $product_id,
				'post_title' => $tour_name, // new title
				'post_name'  => uniqid()// do your thing here
			);
			
			// unhook this function so it doesn't loop infinitely
			remove_action( 'save_post', array( $this, 'wtbm_wc_link_product_on_save' ) );
			// update the post, which calls save_post again
			wp_update_post( $my_post );
			// re-hook this function
			add_action( 'save_post', array( $this, 'wtbm_wc_link_product_on_save' ) );
			// Update the post into the database
			
			
		}
		
	}//end method wtbm_wc_link_product_on_save
	
	
	/**
	 * Add tour as a product in woocommerce product.
	 *
	 * @param $post_id
	 * @param $post
	 *
	 * @return mixed
	 */
	function wtbm_on_post_publish( $post_id, $post ) {
		if ( $post->post_type == 'mage_tour' && $post->post_status == 'publish' && empty( get_post_meta( $post_id,
				'check_if_run_once' ) ) ) {
			
			// ADD THE FORM INPUT TO $new_post ARRAY
			$new_post = array(
				'post_title'    => $post->post_title,
				'post_content'  => '',
				'post_name'     => uniqid(),
				'post_category' => array(),  // Usable for custom taxonomies too
				'tags_input'    => array(),
				'post_status'   => 'publish', // Choose: publish, preview, future, draft, etc.
				'post_type'     => 'product'  //'post',page' or use a custom post type if you want to
			);
			//SAVE THE POST
			$pid = wp_insert_post( $new_post );
			
			update_post_meta( $post_id, 'link_wc_product', $pid );
			update_post_meta( $pid, 'link_wtbm_tour', $post_id );
			update_post_meta( $pid, '_price', 0.01 );
			update_post_meta( $pid, '_sold_individually', 'yes' );
			update_post_meta( $pid, '_virtual', 'yes' );
			$terms = array( 'exclude-from-catalog', 'exclude-from-search' );
			wp_set_object_terms( $pid, $terms, 'product_visibility' );
			
			update_post_meta( $post_id, 'check_if_run_once', true );
		}
	}//end method wtbm_on_post_publish
	
	/**
	 * @param $post_id
	 */
	public function wtbm_booking_info_trash( $post_id ) {
		
		$post_type = get_post_type( $post_id );
		
		if ( $post_type == 'shop_order' ) {
			$this->change_tour_booking_status( $post_id, 'trash', 'publish', 'trash' );
		}
	}//end method wtbm_booking_info_trash
	
	/**
	 * @param $post_id
	 */
	public function wtbm_booking_info_untrash( $post_id ) {
		
		$post_type = get_post_type( $post_id );
		
		if ( $post_type == 'shop_order' ) {
			$this->change_tour_booking_status( $post_id, 'publish', 'trash', 'processing' );
		}
	}//end method wtbm_booking_info_untrash
	
	
	/**
	 * @param $order_id
	 * @param $from_status
	 * @param $to_status
	 * @param $order
	 */
	public function change_attendee_status( $order_id, $from_status, $to_status, $order ) {
		
		$order      = wc_get_order( $order_id );
		$order_meta = get_post_meta( $order_id );
		
		foreach ( $order->get_items() as $item_id => $item_values ) {
			
			$hotel_id = $this->wtbm_get_order_meta( $item_id, '_tour_id' );
			
			//check post types
			if ( get_post_type( $hotel_id ) == 'mage_tour' ) {
				
				if ( $order->has_status( 'processing' ) ) {
					
					$this->change_tour_booking_status( $order_id, 'publish', 'publish', 'processing' );
					
				}
				
				if ( $order->has_status( 'pending' ) ) {
					$this->change_tour_booking_status( $order_id, 'publish', 'publish', 'pending' );
				}
				
				if ( $order->has_status( 'on-hold' ) ) {
					$this->change_tour_booking_status( $order_id, 'publish', 'publish', 'on-hold' );
				}
				
				if ( $order->has_status( 'completed' ) ) {
					$this->change_tour_booking_status( $order_id, 'publish', 'publish', 'completed' );
				}
				
				if ( $order->has_status( 'cancelled' ) ) {
					$this->change_tour_booking_status( $order_id, 'publish', 'publish', 'cancelled' );
				}
				
				if ( $order->has_status( 'refunded' ) ) {
					$this->change_tour_booking_status( $order_id, 'publish', 'publish', 'refunded' );
				}
				
				if ( $order->has_status( 'failed' ) ) {
					$this->change_tour_booking_status( $order_id, 'publish', 'publish', 'failed' );
				}
				
			} //end of Post Type Check
		} //end order item foreach
	} //end method change_attendee_status
	
	
	/**
	 *
	 *
	 * @param $order_id
	 * @param $set_status
	 * @param $post_status
	 * @param $booking_status
	 */
	public function change_tour_booking_status( $order_id, $set_status, $post_status, $booking_status ) {
		$args = array(
			'post_type'      => array( 'mage_tour_booking' ),
			'posts_per_page' => - 1,
			'post_status'    => $post_status,
			'meta_query'     => array(
				array(
					'key'     => 'wtbm_order_id',
					'value'   => $order_id,
					'compare' => '=',
				),
			),
		);
		
		$loop = new WP_Query( $args );
		foreach ( $loop->posts as $ticket ) {
			$post_id      = $ticket->ID;
			$current_post = get_post( $post_id, 'ARRAY_A' );
			update_post_meta( $post_id, 'wtbm_order_status', $booking_status );
			$current_post['post_status'] = $set_status;
			wp_update_post( $current_post );
		}
		
	}//end method change_tour_booking_status
	
	
	/**
	 * Get Order Itemdata value by Item id
	 *
	 * @param $item_id
	 * @param $key
	 *
	 * @return mixed
	 */
	public function wtbm_get_order_meta( $item_id, $key ) {
		
		global $wpdb;
		
		$table_name = $wpdb->prefix . "woocommerce_order_itemmeta";
		$sql        = 'SELECT meta_value FROM ' . $table_name . ' WHERE order_item_id =' . $item_id . ' AND meta_key="' . $key . '"';
		$results = $wpdb->get_results( $sql ) or die( mysql_error() );
		foreach ( $results as $result ) {
			$value = $result->meta_value;
		}
		
		return $value;
	}
	
	/**
	 * @param $order_id
	 */
	public function tour_booking_data_create( $order_id ) {
		
		if ( ! $order_id ) {
			return;
		}
		
		// Getting an instance of the order object
		$order        = wc_get_order( $order_id );
		$order_meta   = get_post_meta( $order_id );
		$order_status = $order->get_status();
		
		foreach ( $order->get_items() as $item_id => $item_values ) {
			$tour_id = $this->wtbm_get_order_meta( $item_id, '_tour_id' );
			
			if ( get_post_type( $tour_id ) == 'mage_tour' ) {
				
				$first_name      = isset( $order_meta['_billing_first_name'][0] ) ? $order_meta['_billing_first_name'][0] : array();
				$last_name       = isset( $order_meta['_billing_last_name'][0] ) ? $order_meta['_billing_last_name'][0] : array();
				$company_name    = isset( $order_meta['_billing_company'][0] ) ? $order_meta['_billing_company'][0] : array();
				$address_1       = isset( $order_meta['_billing_address_1'][0] ) ? $order_meta['_billing_address_1'][0] : array();
				$address_2       = isset( $order_meta['_billing_address_2'][0] ) ? $order_meta['_billing_address_2'][0] : array();
				$city            = isset( $order_meta['_billing_city'][0] ) ? $order_meta['_billing_city'][0] : array();
				$state           = isset( $order_meta['_billing_state'][0] ) ? $order_meta['_billing_state'][0] : array();
				$postcode        = isset( $order_meta['_billing_postcode'][0] ) ? $order_meta['_billing_postcode'][0] : array();
				$country         = isset( $order_meta['_billing_country'][0] ) ? $order_meta['_billing_country'][0] : array();
				$email           = isset( $order_meta['_billing_email'][0] ) ? $order_meta['_billing_email'][0] : array();
				$phone           = isset( $order_meta['_billing_phone'][0] ) ? $order_meta['_billing_phone'][0] : array();
				$billing_intotal = isset( $order_meta['_billing_address_index'][0] ) ? $order_meta['_billing_address_index'][0] : array();
				$payment_method  = isset( $order_meta['_payment_method_title'][0] ) ? $order_meta['_payment_method_title'][0] : array();
				$user_id         = isset( $order_meta['_customer_user'][0] ) ? $order_meta['_customer_user'][0] : array();
				$address         = $address_1 . ' ' . $address_2;
				
				$total_person     = $this->wtbm_get_order_meta( $item_id, 'Total Person' );
				$tour_start       = $this->wtbm_get_order_meta( $item_id, 'Tour Start Date' );
				$tour_end         = $this->wtbm_get_order_meta( $item_id, 'Tour End Date' );
				$hotel_name       = $this->wtbm_get_order_meta( $item_id, 'Hotel Name' );
				$tour_name        = $this->wtbm_get_order_meta( $item_id, 'Tour Name' );
				$tour_price       = $this->wtbm_get_order_meta( $item_id, '_tour_price' );
				$hotel_id         = $this->wtbm_get_order_meta( $item_id, '_hotel_id' );
				$tour_info        = maybe_unserialize( $this->wtbm_get_order_meta( $item_id, '_tour_info' ) );
				$user_info        = maybe_unserialize( $this->wtbm_get_order_meta( $item_id, '_tour_user_info' ) );
				$user_single_info = maybe_unserialize( $this->wtbm_get_order_meta( $item_id,
					'_hotel_user_single_info' ) );
				$hotel_info       = maybe_unserialize( $this->wtbm_get_order_meta( $item_id, '_hotel_info' ) );
				
				if ( is_array( $user_single_info ) && sizeof( $user_single_info ) > 0 ) {
					
					$reg_form_arr = maybe_unserialize( get_post_meta( $tour_id, 'attendee_reg_form', true ) );
					
					foreach ( $user_info as $users ) {
						
						$title = '#' . $order_id . ' - ' . $tour_name;
						
						$new_post = array(
							'post_title'    => $title,
							'post_content'  => '',
							'post_category' => array(),
							'tags_input'    => array(),
							'post_status'   => 'publish',
							'post_type'     => 'mage_tour_booking',
						);
						
						//SAVE THE POST
						$pid = wp_insert_post( $new_post );
						update_post_meta( $pid, 'wtbm_tour_id', $tour_id );
						update_post_meta( $pid, 'wtbm_hotel_id', $hotel_id );
						update_post_meta( $pid, 'wtbm_start', $tour_start );
						update_post_meta( $pid, 'wtbm_end', $tour_end );
						update_post_meta( $pid, 'wtbm_total_person', $total_person );
						update_post_meta( $pid, 'wtbm_order_id', $order_id );
						update_post_meta( $pid, 'wtbm_order_total', $tour_price );
						update_post_meta( $pid, 'wtbm_tour_info', $tour_info );
						update_post_meta( $pid, 'wtbm_hotel_info', $hotel_info );
						
						foreach ( $reg_form_arr as $reg_form ) {
							update_post_meta( $pid, $reg_form['field_id'], $users[ $reg_form['field_id'] ] );
						}
						
						update_post_meta( $pid, 'wtbm_billing_first_name', $first_name );
						update_post_meta( $pid, 'wtbm_billing_last_name', $last_name );
						update_post_meta( $pid, 'wtbm_billing_company', $company_name );
						update_post_meta( $pid, 'wtbm_billing_address', $address );
						update_post_meta( $pid, 'wtbm_billing_city', $city );
						update_post_meta( $pid, 'wtbm_billing_state', $state );
						update_post_meta( $pid, 'wtbm_billing_postcode', $postcode );
						update_post_meta( $pid, 'wtbm_billing_country', $country );
						update_post_meta( $pid, 'wtbm_billing_email', $email );
						update_post_meta( $pid, 'wtbm_billing_phone', $phone );
						
						update_post_meta( $pid, 'wtbm_billing_payment', $payment_method );
						update_post_meta( $pid, 'wtbm_user_id', $user_id );
						update_post_meta( $pid, 'wtbm_order_status', $order_status );
						
					} // end of ticket info loop
				} else {
					
					for ( $x = 0; $x <= $total_person; $x ++ ) {
						
						# code...
						$title = '#' . $order_id . ' - ' . $first_name . ' ' . $last_name;
						// ADD THE FORM INPUT TO $new_post ARRAY
						$new_post = array(
							'post_title'    => $title,
							'post_content'  => '',
							'post_category' => array(),
							'tags_input'    => array(),
							'post_status'   => 'publish',
							'post_type'     => 'mage_tour_booking',
						);
						
						$pid = wp_insert_post( $new_post );
						
						update_post_meta( $pid, 'wtbm_tour_id', $tour_id );
						update_post_meta( $pid, 'wtbm_hotel_id', $hotel_id );
						update_post_meta( $pid, 'wtbm_start', $tour_start );
						update_post_meta( $pid, 'wtbm_end', $tour_end );
						update_post_meta( $pid, 'wtbm_total_person', $total_person );
						update_post_meta( $pid, 'wtbm_order_id', $order_id );
						update_post_meta( $pid, 'wtbm_order_total', $tour_price );
						update_post_meta( $pid, 'wtbm_tour_info', $tour_info );
						update_post_meta( $pid, 'wtbm_hotel_info', $hotel_info );
						
						update_post_meta( $pid, 'wtbm_billing_first_name', $first_name );
						update_post_meta( $pid, 'wtbm_billing_last_name', $last_name );
						update_post_meta( $pid, 'wtbm_billing_company', $company_name );
						update_post_meta( $pid, 'wtbm_billing_address', $address );
						update_post_meta( $pid, 'wtbm_billing_city', $city );
						update_post_meta( $pid, 'wtbm_billing_state', $state );
						update_post_meta( $pid, 'wtbm_billing_postcode', $postcode );
						update_post_meta( $pid, 'wtbm_billing_country', $country );
						update_post_meta( $pid, 'wtbm_billing_email', $email );
						update_post_meta( $pid, 'wtbm_billing_phone', $phone );
						
						update_post_meta( $pid, 'wtbm_billing_payment', $payment_method );
						update_post_meta( $pid, 'wtbm_user_id', $user_id );
						update_post_meta( $pid, 'wtbm_order_status', $order_status );
						
					}
					
				}
			} // Ticket Post Type Check end
		} //Order Item data Loop
	} //End of the function
	
	/**
	 * Enqueue all styles
	 */
	public function enqueue_styles() {
		wp_enqueue_style( 'mage-jquery-ui-style', PLUGIN_URL . 'admin/css/jquery-ui.css', array() );
		
		wp_enqueue_style( 'pickplugins-options-framework',
			PLUGIN_URL . 'admin/assets/css/pickplugins-options-framework.css' );
		
		wp_enqueue_style( 'select2.min', PLUGIN_URL . 'admin/assets/css/select2.min.css' );
		wp_enqueue_style( 'codemirror', PLUGIN_URL . 'admin/assets/css/codemirror.css' );
		wp_enqueue_style( 'fontawesome', PLUGIN_URL . 'admin/assets/css/fontawesome.min.css' );
		wp_enqueue_style( 'mage-admin-css', PLUGIN_URL . 'admin/css/mage-plugin-admin.css', array(), time(), 'all' );
	}//end method enqueue_styles
	
	/**
	 * Enqueue all scripts
	 */
	public function enqueue_scripts() {
		
		wp_enqueue_script( 'jquery' );
		
		wp_enqueue_script( 'jquery-ui-core' );
		
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
		
		wp_enqueue_script( 'tour-magepeople-options-framework',
			PLUGIN_URL . 'admin/assets/js/pickplugins-options-framework.js',
			array( 'jquery' ) );
		
		wp_enqueue_script( 'select2.min',
			PLUGIN_URL . 'admin/assets/js/select2.min.js',
			array( 'jquery' ),
			time(),
			true );
		
		wp_enqueue_script( 'codemirror',
			PLUGIN_URL . 'admin/assets/js/codemirror.min.js',
			array( 'jquery' ),
			null,
			false );
		
		wp_enqueue_script( 'form-field-dependency',
			plugins_url( 'assets/js/form-field-dependency.js', __FILE__ ),
			array( 'jquery' ),
			time(),
			false );
		
		wp_enqueue_script( 'mage-tour-plugin-js',
			PLUGIN_URL . 'admin/js/plugin-admin.js',
			array(
				'jquery',
				'jquery-ui-core',
			),
			time(),
			true );
		
	}//end method enqueue_scripts
	
	
	private function load_admin_dependencies() {
		require_once PLUGIN_DIR . 'admin/class/class-create-cpt.php';
		require_once PLUGIN_DIR . 'admin/class/class-create-tax.php';
		require_once PLUGIN_DIR . 'admin/class/class-meta-box.php';
		require_once PLUGIN_DIR . 'admin/class/class-tax-meta.php';
		require_once PLUGIN_DIR . 'admin/class/class-export.php';
		require_once PLUGIN_DIR . 'admin/class/class-setting-page.php';
	}
	
	
}

new Tour_Plugin_Admin();


add_action( 'tour_before_content_table_meta_box', 'wtbm_meta_box_nonce' );
function wtbm_meta_box_nonce() {
	wp_nonce_field( 'wtbm_meta_box_nonce', 'wtbm_meta_box_nonce' );
}
