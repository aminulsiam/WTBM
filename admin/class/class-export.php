<?php

class WtbmAttendeeExport {
	
	public function __construct() {
		// Add action hook only if action=download_csv
		if ( isset( $_GET['action'] ) && $_GET['action'] == 'download_csv_tour_attendee' ) {
			add_action( 'admin_init', array( $this, 'tour_attendee_export' ) );
		}
	}
	
	/**
	 * @param $post_id
	 *
	 * @return array
	 */
	private function create_header_row( $post_id ) {
		$reg_form_arr   = maybe_unserialize( get_post_meta( $post_id, 'attendee_reg_form', true ) );
		$default_info   = array(
			'Order ID',
			'Tour Name',
			'Billing First Name',
			'Billing Last Name',
			'Billing Phone',
			'Billing Address',
			'Billing City',
			'Billing State',
			'Billing Post Code',
			'Billing Country',
		);
		$user_reg_field = array();
		foreach ( $reg_form_arr as $reg_form ) {
			$user_reg_field[] = ucfirst( $reg_form['field_label'] );
		}
		
		return array_merge( array_filter( $default_info ), array_filter( $user_reg_field ) );
	}
	
	/**
	 * Create data into csv file.
	 *
	 * @param $post_id
	 *
	 * @return array
	 */
	private function create_data_row( $post_id ) {
		
		$reg_form_arr = maybe_unserialize( get_post_meta( get_post_meta( $post_id, 'wtbm_tour_id', true ), 'attendee_reg_form', true ) );
		
		$default_data = array(
			get_post_meta( $post_id, 'wtbm_order_id', true ),
			
			get_the_title( $post_id ),
			
			get_post_meta( $post_id, 'wtbm_billing_first_name', true ),
			get_post_meta( $post_id, 'wtbm_billing_last_name', true ),
			get_post_meta( $post_id, 'wtbm_billing_phone', true ),
			get_post_meta( $post_id, 'wtbm_billing_address', true ),
			get_post_meta( $post_id, 'wtbm_billing_city', true ),
			get_post_meta( $post_id, 'wtbm_billing_state', true ),
			get_post_meta( $post_id, 'wtbm_billing_postcode', true ),
			get_post_meta( $post_id, 'wtbm_billing_country', true )
		
		
		);
		
		$user_data = array();
		foreach ( $reg_form_arr as $reg_form ) {
			$user_data[] = get_post_meta( $post_id, $reg_form['field_id'], true ) ? get_post_meta( $post_id, $reg_form['field_id'], true ) : ' ';
		}
		
		return array_merge( $default_data, array_filter( $user_data ) );
	}
	
	/**
	 * @return bool
	 */
	public function tour_attendee_export() {
		
		// Check for current user privileges 
		if ( ! current_user_can( 'manage_options' ) ) {
			return false;
		}
		// Check if we are in WP-Admin
		if ( ! is_admin() ) {
			return false;
		}
		
		$post_id = strip_tags( $_GET['tour_id'] );
		
		ob_start();
		$domain   = $_SERVER['SERVER_NAME'];
		$filename = 'Total_Tour_Attendee_Export_' . $domain . '_' . time() . '.csv';
		
		$header_row = $this->create_header_row( $post_id );
		
		
		$data_rows = array();
		
		$args_search_qqq = array(
			'post_type'      => array( 'mage_tour_booking' ),
			'posts_per_page' => - 1,
			'meta_query'     => array(
				array(
					'key'     => 'wtbm_tour_id',
					'value'   => $post_id,
					'compare' => '='
				)
			)
		);
		$loop            = new WP_Query( $args_search_qqq );
		while ( $loop->have_posts() ) {
			$loop->the_post();
			
			$row         = $this->create_data_row( get_the_id() );
			$data_rows[] = $row;
			
		}
		wp_reset_postdata();
		
		
		$fh = @fopen( 'php://output', 'w' );
		fprintf( $fh, chr( 0xEF ) . chr( 0xBB ) . chr( 0xBF ) );
		header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
		header( 'Content-Description: File Transfer' );
		header( 'Content-type: text/csv' );
		header( "Content-Disposition: attachment; filename={$filename}" );
		header( 'Expires: 0' );
		header( 'Pragma: public' );
		fputcsv( $fh, $header_row );
		foreach ( $data_rows as $data_row ) {
			fputcsv( $fh, $data_row );
		}
		fclose( $fh );
		
		ob_end_flush();
		
		die();
	}
}

new WtbmAttendeeExport();