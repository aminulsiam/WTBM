<?php
add_action( "tour_room_details_with_price", "tour_room_details_with_price" );

function tour_room_details_with_price( $post_id ) {
	
	$wc_product = get_post_meta( $post_id, 'link_wc_product', true );
	
	?>
    <div class="wtbmt_order_summury_box hotel_details">
        <table class="table">
            <thead>

            <tr>
                <th>
					<?php echo esc_html__( 'Room Type', 'woocommerce-tour-booking-manager' ); ?>
                </th>

                <th>
					<?php echo esc_html__( 'Room Fare', 'woocommerce-tour-booking-manager' ); ?>
                </th>
                <th><?php echo esc_html__( 'Room Quantity', 'woocommerce-tour-booking-manager' ); ?>
                </th>
            </tr>

            </thead>

            <tbody>
			
			<?php
			
			$tour_price = maybe_unserialize( get_post_meta( $post_id,
				'hotel_room_details',
				true ) );
			
			$tour_duration = get_post_meta( $post_id,
				'tour_duration',
				true );
			
			if ( empty( $tour_duration ) ) {
				$tour_duration = 1;
			}
			
			if ( ! is_array( $tour_price ) ) {
				$tour_price = array();
			}
			
			foreach ( $tour_price as $room ) {
				?>
                <tr>
                    <td class="bold_text">
                        <input type="hidden" name="room_name[]"
                               value="<?php esc_html_e( $room['room_type'] ); ?>">
						<?php esc_html_e( $room['room_type'] ); ?>

                        <input type="hidden" name="room_cap[]"
                               value="<?php esc_html_e( $room['person_capacity'] ); ?>_<?php echo trim( $room['room_type'] ); ?>_<?php trim( esc_html_e( $room['room_fare'] ) ); ?>">

                    </td>

                    <td class="price-td">
                        <p><?php _e( '(Per Night -' . $room['room_fare'] . ' X ' . $tour_duration . ' Nights ) = ' . wc_price( $room['room_fare'] * $tour_duration ) ); ?></p>

                        <span style="display: none" class="room_price">
                            <?php esc_html_e( $room['room_fare'] * $tour_duration ); ?>
                        </span>

                        <span class="person_capacity" style="display: none">

                            <?php esc_html_e( $room['person_capacity'] ); ?></span>

                        <input type="hidden"
                               value="<?php esc_html_e( $room['room_fare'] ); ?>"
                               name="room_price[]" class="price">

                        <input type="hidden"
                               value="<?php esc_html_e( $room['person_capacity'] ); ?>"
                               name="person_capacity" class="max_person"/>

                    </td>

                    <td class="peulis-cart-quantity">
                        <select value="" class="qty" name="room_qty[]">
                            <option value=0>0</option>
							<?php
							for ( $i = 1; $i <= $room['room_qty']; $i ++ ) {
								?>
                                <option value="<?php esc_attr_e( $i ); ?>"><?php esc_html_e( $i ) ?></option>
							<?php } ?>
                        </select>
                    </td>
                </tr>
			
			<?php } ?>

            <tr>
                <td colspan="2" class="bold_text"><?php echo esc_html__( 'Total Person',
						'woocommerce-tour-booking-manager' ); ?></td>

                <td align="right">
                    <input type="number" max="0" min="0" value="0" class="total_person" name="total_person"/>
                </td>
            </tr>

            <tr style="clear: both">
                <td align="right" colspan="5" class="bold_text">
                    Total Fare :
					
					<?php
					
					$currency_pos = get_option( 'woocommerce_currency_pos' );
					
					if ( $currency_pos == "left" ) {
						echo get_woocommerce_currency_symbol();
					}
					?>
                    <span id="total" class="total">0</span>
					<?php
					if ( $currency_pos == "right" ) {
						echo get_woocommerce_currency_symbol();
					}
					
					?>
                </td>
            </tr>

            </tbody>
        </table>

        <table>
            <tr>
                <span class="form"></span>
            </tr>

            <tr>
                <div class="cart_now_btn">
                    <button class="default-btn but_btn" disabled="disabled" name="add-to-cart"
                            value="<?php echo $wc_product; ?>">
                        Add To Cart
                    </button>
                </div>
            </tr>
        </table>

        <script type="text/javascript">

            jQuery('.total_person').on('change', function () {

                var inputs = jQuery(this).val() || 0;
                var input = parseInt(inputs);
                var children = jQuery('.form > div').length || 0;

                if (input < children) {
                    jQuery('.form').empty();
                    children = 0;
                }

                for (var i = children + 1; i <= input; i++) {
                    jQuery('.form').append(
                        jQuery('<div/>')
                            .attr("id", "newDiv" + i)
                            .html('<?php do_action( 'attendee_form_builder', $post_id ); ?>')
                    );
                }

            });

        </script>
    </div>
<?php } ?>
