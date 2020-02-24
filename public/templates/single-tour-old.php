<?php
get_header();
the_post();
?>

<div class="tour-content">
	<?php do_action( 'woocommerce_before_single_product' ); ?>

    <div class="tour-left-content">
		
		<?php
		$gallary_images = maybe_unserialize( get_post_meta( get_the_ID(), 'tour_gallary_image', true ) );
		
		if ( ! is_array( $gallary_images ) ) {
			$gallary_images = array();
		}
		
		?>
        <div class="fotorama" data-autoplay="3000" data-allowfullscreen="true" data-width="100%" data-height="auto">
			
			<?php
			
			the_post_thumbnail();
			
			foreach ( $gallary_images as $images ) {
				echo wp_get_attachment_image( $images, array( 1000, 800 ) );
			}
			?>
        </div>

        <!-- Tour Title -->
        <section class="tour_title">
            <h1><?php the_title(); ?></h1>
        </section>

        <!-- Tour Content -->
        <p><?php the_content(); ?></p>
		
		<?php
		
		//check more details form backend, if found this section will show else not show
		
		$more_details    = maybe_unserialize( get_post_meta( $post->ID, 'more_details', true ) );
		$daywise_details = maybe_unserialize( get_post_meta( $post->ID, 'tour_daywise_details',
			true ) );
		
		
		if ( is_array( $daywise_details ) && sizeof( $daywise_details ) > 0 && ! empty( $daywise_details ) ) {
			
			?>
            <section class="daywise_details">
                <h6>
					<?php echo esc_html__( 'Daywise Details', 'woocommerce-tour-booking-manager' ); ?>
                </h6>
				<?php
				
				foreach ( $daywise_details as $daywise_detail ) {
					?>
                    <button class="accordion">
						<?php echo esc_html( ucfirst( $daywise_detail['day_title'] ) ); ?>
                    </button>
                    <div class="panel">
                        <p><?php echo esc_html( ucfirst( $daywise_detail['day_details'] ) ); ?></p>
                    </div>
				<?php } ?>
            </section>
		
		<?php }
		
		if ( is_array( $more_details ) && sizeof( $more_details ) > 0 && ! empty( $more_details ) ) {
			
			?>
            <section class="more_details">
                <h6>
					<?php echo esc_html__( 'More Details', 'woocommerce-tour-booking-manager' ); ?>
                </h6>
				<?php
				
				foreach ( $more_details as $more_detail ) {
					?>
                    <button class="accordion">
						<?php echo esc_html( ucfirst( $more_detail['details_topic'] ) ); ?>
                    </button>
                    <div class="panel">
                        <p><?php echo esc_html( ucfirst( $more_detail['details'] ) ); ?></p>
                    </div>
				<?php } ?>
            </section>
		<?php } ?>


    </div>

    <div class="tour-right-content">
		
		<?php
		
		$get_hotel_details = get_terms( array(
			'taxonomy'   => 'hotel_details',
			'hide_empty' => false,
		) );
		
		?>

        <div class="tour_destination">
			<?php
			
			$display_google_map = get_post_meta( $post->ID, 'google_map_display', true );
			
			$destinations = get_the_terms( $post->ID, 'destination' );
			
			if ( ! is_array( $destinations ) ) {
				$destinations = array();
			}
			
			foreach ( $destinations as $destination ) {
				echo "<h3><span class='dashicons dashicons-location'></span>" . esc_html__( 'Tour Destination : ', 'woocommerce-tour-booking-manager' ) . esc_html( ucfirst( $destination->name ) ) . "</h3>";
				
				if ( "on" == $display_google_map ) {
					?>
                    <iframe id="gmap_canvas"
                            src="https://maps.google.com/maps?q=<?php esc_html_e( $destination->name ); ?>&amp;t=&amp;z=10&amp;ie=UTF8&amp;iwloc=&amp;output=embed"
                            frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                            style="width: 100%;min-height: 250px;"></iframe>
				<?php }
			} ?>
        </div>

        <div class="Module-options">
            <div class="Module-option">
                <div class="text">

                    <div class="tour_offer_type">
						<?php
						global $post;
						
						$tentative_start_date = get_post_meta( $post->ID, 'start_date', true );
						$tentative_end_date   = get_post_meta( $post->ID, 'end_date', true );
						
						?>
                    </div>
					
					<?php
					$tour_duration = get_post_meta( $post->ID, 'tour_duration', true );
					
					
					if ( ! empty( $tour_duration ) ) {
						?>

                        <p class="nb">N.B : This tour duration is <?php echo $tour_duration; ?> Nights</p>
					
					<?php } ?>

                    <div class="validities">
						
						<?php
						
						$valid_form_date_format = date_i18n( "d", strtotime(
							$tentative_start_date ) );
						
						$valid_form_month_year_format = date_i18n( "M'y", strtotime(
							$tentative_start_date ) );
						
						$valid_till_date_format = date_i18n( "d", strtotime(
							$tentative_end_date ) );
						
						$valid_till_month_year_format = date_i18n( "M'y", strtotime(
							$tentative_end_date ) );
						
						?>


                        <div class="validity"><span><?php echo esc_html__( 'Valid From', 'woocommerce-tour-booking-manager' );
								?></span>
                            <p><span><?php esc_html_e( $valid_form_date_format ); ?></span>
                                <small><?php esc_html_e( $valid_form_month_year_format ); ?></small>
                            </p>
                        </div>
                        <div class="validity"><span><?php echo esc_html__( 'Valid Till', 'woocommerce-tour-booking-manager' )
								?></span>
                            <p><span><?php esc_html_e( $valid_till_date_format ); ?></span>
                                <small><?php esc_html_e( $valid_till_month_year_format ); ?></small>
                            </p>
                        </div>
                        <div class="validity"><span>Departs</span>
                            <p>
                                <small class="price">EVERY DAY</small>
                            </p>
                        </div>
                    </div>
                    <div class="row-block">
						
						<?php
						$hotel_price_source = get_post_meta( $post->ID, 'tour_price_source', true );
						
						$hotel_room_fares = get_post_meta( $post->ID, 'hotel_room_details',
							true );
						
						$get_hotel_fares = maybe_unserialize( $hotel_room_fares );
						
						
						if ( ! is_array( $get_hotel_fares ) ) {
							$get_hotel_fares = array();
						}
						
						if ( 'tour' == $hotel_price_source ) {
							
							foreach ( $get_hotel_fares as $room_fares ) {
								?>
                                <div class="column">
                                    <span><?php esc_html_e( '' . ucfirst( $room_fares['room_type'] ) . ' ', 'woocommerce-tour-booking-manager' ); ?></span><strong><span
                                                class="room_fare">
                                        <?php echo wc_price( $room_fares['room_fare'] ) . '(per night)';
                                        ?></span></strong>
                                </div>
							<?php } ?>


                            <div class="column full">
                                <div class="hotel-list">
									<?php
									foreach ( $get_hotel_details as $hotel_name ) {
										?>
                                        <div class="item">
                                            <span class="dashicons dashicons-admin-home"></span>
                                            <span class="hotel_name"><?php _e( ucfirst( $hotel_name->name )
												); ?></span>
                                        </div>
									<?php } ?>
                                </div>
                                <p class="nb"><?php echo esc_html__( 'N:B - We are selecting anyone hotel from above list', '' ); ?></p>
                            </div>
						
						<?php } ?>

                        <div class="room_and_hotel_selection" style="display: none">
							<?php echo Tour_Booking_Helper::hotel_details( $get_hotel_details ); ?>
                        </div>

                    </div>

                    <button class="btn btn-info buy_tour_pakage_button">
						<?php echo esc_html__( 'Buy Now', 'woocommerce-tour-booking-manager' ); ?>
                    </button>

                </div>
            </div>
        </div>
    </div>
	
	<?php
	
	$tour_start_date = get_post_meta( $post->ID, 'start_date', true );
	$tour_end_date   = get_post_meta( $post->ID, 'end_date', true );
	
	$tour_start_year  = date( 'Y', strtotime( $tour_start_date ) );
	$tour_start_month = date( 'm', strtotime( $tour_start_date ) );
	$tour_start_day   = date( 'd', strtotime( $tour_start_date ) );
	
	$tour_end_year  = date( 'Y', strtotime( $tour_end_date ) );
	$tour_end_month = date( 'm', strtotime( $tour_end_date ) );
	$tour_end_day   = date( 'd', strtotime( $tour_end_date ) );
	
	?>

</div>

<script src="<?php echo PLUGIN_URL . 'public/js/pop-up-modal.js'; ?>"></script>

<script type="text/javascript">
    jQuery('.add_to_cart').hide();

    jQuery(".datepicker").datepicker({

        dateFormat: 'yy-mm-dd',
        defaultDate: null,
        minDate: new Date(<?php _e( $tour_start_year ); ?>, <?php _e( $tour_start_month ); ?> -1, <?php _e( $tour_start_day ); ?>),

        maxDate: new Date(<?php _e( $tour_end_year ); ?>, <?php _e( $tour_end_month ); ?> -1, <?php _e(
			$tour_end_day ); ?>)
    });

    jQuery('.hasDatepicker').last().datepicker('refresh');

</script>
<?php get_footer(); ?>


