<?php

class Tour_WotmCartCalculation {
	public function __construct() {
		$this->add_hooks();
	}
	
	public function add_hooks() {
		add_filter( 'woocommerce_add_cart_item_data', array( $this, 'prepare_cart_data' ), 10, 3 );
		add_action( 'woocommerce_before_calculate_totals', array( $this, 'update_cart_price' ) );
		add_filter( 'woocommerce_get_item_data', array( $this, 'show_data_in_cart_table' ), 10, 2 );
		add_action( 'woocommerce_checkout_create_order_line_item', array( $this, 'add_data_into_order_item' ), 10, 4 );
		
	}
	
	
	/**
	 * Get tour room price from hotel meta data
	 *
	 * @param $tour_id
	 * @param $room_name
	 * @param $room_qty
	 *
	 * @return float|int
	 */
	function get_tour_room_price( $tour_id, $room_name, $room_qty ) {
		$room_details = maybe_unserialize( get_post_meta( $tour_id, 'hotel_room_details', true ) );
		$room_fare    = 0;
		
		$tour_duration = get_post_meta( $tour_id, 'tour_duration', true );
		
		foreach ( $room_details as $key => $val ) {
			if ( $val['room_type'] === $room_name ) {
				$room_fare = $val['room_fare'];
			}
		}
		
		$total = ( $room_fare * $room_qty ) * $tour_duration;
		
		return $total;
	}
	
	/**
	 * Get hotel room price from hotel details taxonomy.
	 *
	 * @param $hotel_id
	 * @param $room_name
	 * @param $room_qty
	 *
	 * @return float|int
	 */
	function get_tour_hotel_room_price( $hotel_id, $room_name, $room_qty, $tour_duration ) {
		$room_details = maybe_unserialize( get_term_meta( $hotel_id, 'hotel_room_details', true ) );
		
		$room_fare = 0;
		foreach ( $room_details as $key => $val ) {
			if ( $val['room_type'] === $room_name ) {
				$room_fare = $val['room_fare'];
			}
		}
		
		$total = ( $room_fare * $room_qty ) * $tour_duration;
		
		return $total;
		
		return ( $room_fare * $room_qty );
		
	}
	
	/**
	 * Add to cart all tour information
	 *
	 * @param $cart_item_data
	 * @param $product_id
	 * @param $variation_id
	 *
	 * @return mixed
	 */
	public function prepare_cart_data( $cart_item_data, $product_id, $variation_id ) {
		
		$product_id = get_post_meta( $product_id, 'link_wtbm_tour', true ) ? get_post_meta( $product_id,
			'link_wtbm_tour',
			true ) : $product_id;
		
		if ( get_post_type( $product_id ) == 'mage_tour' ) {
			
			$tour_date = isset( $_POST['tour_start_date'] ) ? $_POST['tour_start_date'] : "";
			
			$days                  = get_post_meta( $product_id, 'tour_duration', true ) . ' days';
			$tour_end_date         = date( 'Y-m-d', strtotime( $days, strtotime( $tour_date ) ) );
			$tour_total_person     = isset( $_POST['total_person'] ) ? $_POST['total_person'] : "";
			$tour_hotel            = isset( $_POST['tour_hotel'] ) ? $_POST['tour_hotel'] : "";
			$tour_hotel_room_name  = isset( $_POST['room_name'] ) ? $_POST['room_name'] : "";
			$tour_hotel_room_cap   = isset( $_POST['room_cap'] ) ? $_POST['room_cap'] : "";
			$tour_hotel_room_price = isset( $_POST['room_price'] ) ? $_POST['room_price'] : "";
			$tour_hotel_room_qty   = isset( $_POST['room_qty'] ) ? $_POST['room_qty'] : "";
			
			
			$reg_form_arr = maybe_unserialize( get_post_meta( $product_id, 'attendee_reg_form', true ) );
			
			$cn      = 0;
			$hotel_r = array();
			foreach ( $tour_hotel_room_cap as $cap ) {
				
				$arr            = explode( '_', $cap );
				$total_quantity = $arr[0] * $tour_hotel_room_qty[ $cn ];
				
				for ( $i = 0; $i < $total_quantity; $i ++ ) {
					$hotel_r[ $i ]['room_name']  = stripslashes( strip_tags( $arr[1] ) );
					$hotel_r[ $i ]['room_price'] = stripslashes( strip_tags( $arr[2] ) );
				}
				
				$t_arr[] = $hotel_r;
				$cn ++;
			}
			
			$room_arr = call_user_func_array( "array_merge", $t_arr );
			
			//Get the main price of hotel room
			$price_source = get_post_meta( $product_id, 'tour_price_source', true );
			
			$tour_duration = get_post_meta( $product_id, 'tour_duration', true );
			
			if ( $price_source == 'tour' ) {
				$room_fare = 0;
				$count     = 0;
				foreach ( $tour_hotel_room_name as $room_name ) {
					$room_fare = ( $room_fare + $this->get_tour_room_price( $product_id,
							$room_name,
							$tour_hotel_room_qty[ $count ] ) );
					$count ++;
				}
				
			} elseif ( $price_source == 'hotel' ) {
				$room_fare = 0;
				$count     = 0;
				foreach ( $tour_hotel_room_name as $room_name ) {
					$room_fare = ( $room_fare + $this->get_tour_hotel_room_price( $tour_hotel,
							$room_name,
							$tour_hotel_room_qty[ $count ],
							$tour_duration ) );
					$count ++;
				}
			}
			
			$total_price = $room_fare;
			
			$total_room = count( $tour_hotel_room_name );
			
			for ( $i = 0; $i < $total_room; $i ++ ) {
				
				$room_qty = $tour_hotel_room_qty[ $i ];
				if ( $room_qty > 0 ) {
					
					$hotel[ $i ]['tour_id'] = stripslashes( strip_tags( $product_id ) );
					
					$hotel[ $i ]['hotel_id']   = stripslashes( strip_tags( $tour_hotel ) );
					$hotel[ $i ]['room_name']  = stripslashes( strip_tags( $tour_hotel_room_name[ $i ] ) );
					$hotel[ $i ]['room_price'] = stripslashes( strip_tags( $tour_hotel_room_price[ $i ] ) );
					$hotel[ $i ]['room_qty']   = stripslashes( strip_tags( $tour_hotel_room_qty[ $i ] ) );
				}
			}
			
			for ( $i = 0; $i < $tour_total_person; $i ++ ) {
				
				$hotel_single[ $i ]['tour_id']    = stripslashes( strip_tags( $product_id ) );
				$hotel_single[ $i ]['hotel_id']   = stripslashes( strip_tags( $tour_hotel ) );
				$hotel_single[ $i ]['room_name']  = $room_arr[ $i ]['room_name'];
				$hotel_single[ $i ]['room_price'] = $room_arr[ $i ]['room_price'];
				
				if ( is_array( $reg_form_arr ) && sizeof( $reg_form_arr ) > 0 ) {
					foreach ( $reg_form_arr as $_reg ) {
						
						$field_id = isset( $_POST[ $_reg['field_id'] ][ $i ] ) ? $_POST[ $_reg['field_id'] ][ $i ] : "";
						
						$hotel_single[ $i ][ $_reg['field_id'] ] = stripslashes( strip_tags( $field_id ) );
					}
				}
			}
			
			if ( is_array( $reg_form_arr ) && sizeof( $reg_form_arr ) > 0 ) {
				foreach ( $reg_form_arr as $_reg ) {
					
					$field_id = isset( $_POST[ $_reg['field_id'] ][ $i ] ) ? $_POST[ $_reg['field_id'] ][ $i ]
						: "";
					
					$hotel_user_single[ $i ][ $_reg['field_id'] ] = stripslashes( strip_tags( $field_id ) );
					
				}
				
			} else {
				$hotel_user_single = array();
			}
			
			$cart_item_data['tour_id']                     = $product_id;
			$cart_item_data['tour_hotel_id']               = $tour_hotel;
			$cart_item_data['tour_start_date']             = $tour_date;
			$cart_item_data['tour_end_date']               = $tour_end_date;
			$cart_item_data['tour_total_price']            = $total_price;
			$cart_item_data['line_total']                  = $total_price;
			$cart_item_data['line_subtotal']               = $total_price;
			$cart_item_data['tour_hotel_info']             = $hotel;
			$cart_item_data['tour_hotel_single_info']      = $hotel_single;
			$cart_item_data['tour_hotel_user_single_info'] = $hotel_user_single;
			$cart_item_data['tour_total_person']           = $tour_total_person;
		}
		$cart_item_data['mage_tour_id'] = $product_id;
		
		return $cart_item_data;
	}//end method prepare_cart_data
	
	/**
	 * This function will call if cart price is update.
	 *
	 * @param $cart_object
	 */
	public function update_cart_price( $cart_object ) {
		foreach ( $cart_object->cart_contents as $key => $value ) {
			$qrtid = $value['mage_tour_id'];
			if ( get_post_type( $qrtid ) == 'mage_tour' ) {
				$cp = $value['tour_total_price'];
				$value['data']->set_price( $cp );
				$new_price = $value['data']->get_price();
				$value['data']->set_regular_price( $cp );
				$value['data']->set_sale_price( $cp );
				$value['data']->set_sold_individually( 'yes' );
			}
		}
	}//end method update_cart_price
	
	/**
	 * @param $item_data
	 * @param $cart_item
	 *
	 * @return mixed
	 */
	public function show_data_in_cart_table( $item_data, $cart_item ) {
		$qrtid = $cart_item['mage_tour_id'];
		if ( get_post_type( $qrtid ) == 'mage_tour' ) {
			$reg_form_arr = maybe_unserialize( get_post_meta( $qrtid, 'attendee_reg_form', true ) );
			$tour_data    = $cart_item['tour_hotel_info'];
			
			$ticket_user_info = $cart_item['tour_hotel_single_info'];
			echo '<ul class="cart-common-list"  style="margin-bottom: 30px!important;">';
			echo '<li>Start Date: ' . $cart_item['tour_start_date'] . '</li>';
			echo '<li>End Date: ' . $cart_item['tour_end_date'] . '</li>';
			echo '<li>Total Person: ' . $cart_item['tour_total_person'] . '</li>';
			echo '</ul>';
			
			
			$term_arr = get_term_by( 'id', $cart_item['tour_hotel_id'], 'hotel_details' );
			
			echo '<ul class="cart-free-list" style="margin-bottom: 30px!important">';
			if ( $cart_item['tour_hotel_id'] > 0 ) {
				echo '<li>Hotel: ' . $term_arr->name . '</li>';
			}
			
			$tour_duration = get_post_meta( $qrtid, 'tour_duration', true );
			
			foreach ( $tour_data as $hotel ) {
				?>

                <li> <?php _e( 'Room: ' ); ?> <?php echo $hotel['room_name'] . ' (Per Night Price - ' . wc_price( $hotel['room_price'] ) . ''; ?>
                    )
                </li>

                <li> <?php echo esc_html__( 'Tour Duration: ', '' ) . $tour_duration . ' Nights'; ?></li>


                <li> <?php echo ( 'Total : ' ) . $tour_duration . ' Nights X Per Nights ' . wc_price( $hotel['room_price'] ) . ' = ' . wc_price( $tour_duration * $hotel['room_price'] ); ?>
                </li>
				
				<?php
			}
			echo '</ul>';
			
			if ( is_array( $ticket_user_info ) && sizeof( $ticket_user_info ) > 0 ) {
				
				foreach ( $ticket_user_info as $user_info ) {
					echo '<ul class="cart-user-list"  style="margin-bottom: 30px !important">';
					
					if ( ! is_array( $reg_form_arr ) ) {
						$reg_form_arr = array();
					}
					
					foreach ( $reg_form_arr as $_reg ) {
						
						if ( "" != $user_info[ $_reg['field_id'] ] ) {
							
							echo '<li>' . $_reg['field_label'] . ': ' . $user_info[ $_reg['field_id'] ] .
							     '</li>';
						}
						
					}

//					echo '<li>Room Name: ' . $user_info['room_name'] . '</li>';
					
					echo '</ul>';
				}
			}
			
		}
		
		return $item_data;
	}//end method show_date_in_cart_table
	
	/**
	 *
	 *
	 * @param $item
	 * @param $cart_item_key
	 * @param $values
	 * @param $order
	 */
	public function add_data_into_order_item( $item, $cart_item_key, $values, $order ) {
		$qrtid = $values['tour_id'];
		
		if ( get_post_type( $qrtid ) == 'mage_tour' ) {
			
			$tour_id               = $values['tour_id'];
			$hotel_id              = $values['tour_hotel_id'];
			$tour_start            = $values['tour_start_date'];
			$tour_end              = $values['tour_end_date'];
			$total_price           = $values['tour_total_price'];
			$hotel_info            = $values['tour_hotel_info'];
			$total_person          = $values['tour_total_person'];
			$tour_user_info        = $values['tour_hotel_single_info'];
			$tour_user_single_info = $values['tour_hotel_user_single_info'];
			
			$tour_extra_info = array(
				'hotel_id'     => $hotel_id,
				'total_price'  => $total_price,
				'total_person' => $total_person,
			);
			
			$item->add_meta_data( '_tour_price', $total_price );
			$item->add_meta_data( '_tour_info', $tour_extra_info );
			$item->add_meta_data( '_tour_user_info', $tour_user_info );
			$item->add_meta_data( '_hotel_info', $hotel_info );
			$item->add_meta_data( '_hotel_id', $hotel_id );
			$item->add_meta_data( '_hotel_user_single_info', $tour_user_single_info );
			
			$item->add_meta_data( 'Tour Name', get_the_title( $tour_id ) );
			
			if ( $hotel_id > 0 ) {
				$term_arr   = get_term_by( 'id', $hotel_id, 'hotel_details' );
				$hotel_name = $term_arr->name;
				$item->add_meta_data( 'Hotel Name', $hotel_name );
			} else {
				$item->add_meta_data( 'Hotel Name', 'N/A' );
			}
			
			foreach ( $hotel_info as $hotel ) {
				$room_name = $hotel['room_name'];
				$room_qty  = $hotel['room_qty'];
				$item->add_meta_data( "$room_name X $room_qty", wc_price( $hotel['room_price'] * $hotel['room_qty'] ) );
			}
			
			
			$item->add_meta_data( 'Tour Start Date', $tour_start );
			$item->add_meta_data( 'Tour End Date', $tour_end );
			$item->add_meta_data( 'Total Person', $total_person );
		}
		$item->add_meta_data( '_tour_id', $tour_id );
		
	}//end method add_data_into_order_item
}

new Tour_WotmCartCalculation();