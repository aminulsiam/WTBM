<?php

add_action( 'hotel_room_details_with_price', 'hotel_room_details_with_price' );

function hotel_room_details_with_price( $post_id ) {
	?>
    <div class="wtbmt_order_summury_box">
        <div style="text-align: center">
            <h3>Select Your Hotel Please</h3>

            <select class="hotel_list form-group" name="tour_hotel"
                    data-id="<?php echo get_the_ID(); ?>" style="display: inline-block !important;width: 100%;height:10vh;border: 1px solid #ccc;border-radius: 4px;resize: vertical;">

                <option value="other"><?php echo
					esc_html__( 'Select Your Hotel', 'woocommerce-tour-booking-manager' ); ?></option>
				<?php
				
				$get_hotel_details = get_terms( array(
					'taxonomy'   => 'hotel_details',
					'hide_empty' => false,
				) );
				
				foreach ( $get_hotel_details as $hotel ) {
					?>
                    <option value="<?php echo esc_attr( $hotel->term_id ); ?>">
						<?php echo esc_html( ucfirst( $hotel->name ) ); ?>
                    </option>
				<?php } ?>
            </select>

        </div>

        <span class="hotel_details no_hotel"></span>
    </div>
	<?php
}