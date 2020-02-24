<?php
add_action( 'wtbm_tour_hotel_list', 'wtbm_tour_hotel_lists_display' );
function wtbm_tour_hotel_lists_display( $tour_id ) {
	
	$get_hotel_details = get_the_terms( $tour_id, 'hotel_details' );
	
	
	if ( is_array( $get_hotel_details ) && sizeof( $get_hotel_details ) > 0 && ! empty( $get_hotel_details ) ) {
		foreach ( $get_hotel_details as $hotel ) {
			?>

            <h2><?php echo $hotel->name; ?></h2>
            <div class="wtbmt_hotels_content">
				<?php
				// hotel_image
				$hotel_image_id = get_term_meta( $hotel->term_id, 'hotel_image', true );
				$hotel_image    = wp_get_attachment_url( $hotel_image_id );
				?>
                <div class="hotel-images" style="width: 300px;height: 200px">
                    <img src="<?php echo $hotel_image; ?>" alt="">
                </div>
                <h4><?php _e( 'Details About This Hotel', 'woocommere-tour-booking-manager' ); ?></h4>
                <p><?php echo $hotel->description; ?></p>
				<?php
				$befefits = maybe_unserialize( get_term_meta( $hotel->term_id, 'hotel_benefits', true ) );
				if ( is_array( $befefits ) && sizeof( $befefits ) && ! empty( $befefits ) ) {
					?>
                    <div class="wtbmt_benefits wtbmt_exclusion_package_content">
                        <h4><?php _e( 'Other Benefits', 'woocommere-tour-booking-manager' ); ?></h4>
                        <ul class="benefits_icon">
							<?php foreach ( $befefits as $_benefit ) {
								?>
                                <li><?php echo $_benefit; ?></li>
								<?php
							} ?>
                        </ul>
                    </div>
				<?php } ?>
            </div>
            <hr>
			<?php
		}
	}
}