<?php
get_header();
the_post();
?>
    <!--Start Body-Wrapper-area section-->
    <section class="wtbmt_wrapper_area">
		<?php do_action( "woocommerce_before_single_product" ); ?>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="wtbmt_top_bar">
						<?php do_action( 'wtbm_single_title', get_the_title() ); ?>
                    </div>
                    <!-- Slider-area -->
                    <div class="wtbmt_hero_area">
						<?php do_action( 'wtbm_gallery_slider' ); ?>
                    </div>
                    <div class="wtbmt_home_overview">
                        <h2><?php _e( 'Overview', 'woocommere-tour-booking-manager' ); ?></h2>
                        <div class="wtbmt_content">
							<?php do_action( 'wtbm_tour_content' ); ?>
                        </div>
                    </div>

                    <!-- Travelling Package -->
                    <div class="wtbmt_travelling_package">
                        <h2>Our traveling place in hanymoon package</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <ul>
                                    <li>Relish candle light dinner on beach</li>
                                    <li>Enjoy a splendid dolphin tour</li>
                                    <li>Cover Gitgit Waterfall Twin Lake View</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul>
                                    <li>Visit Batubalan, Elephant Cave, Kintam</li>
                                    <li>Enjoy water sports</li>
                                    <li>Cover Gitgit Waterfalls, Twin Lake View</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Travelling Plan -->
                    <div class="wtbmt_traveling_plan">
                        <h2><?php _e( 'Travel Plan', 'woocommere-tour-booking-manager' ); ?></h2>
						<?php do_action( 'wtbm_tour_daywise_plan', get_the_id() ); ?>
                    </div>

                    <!-- Hotels Room -->
                    <div class="wtbmt_hotels_room">
                        <h2><?php _e( 'Hotels Included in this tour', 'woocommere-tour-booking-manager' ); ?></h2>
                        <hr>
						<?php do_action( 'wtbm_tour_hotel_list', get_the_id() ); ?>
                    </div>

                    <!-- Exclusion and Limitations -->
                    <div class="wtbmt_exclusion_package">
						<?php do_action( 'wtbm_tour_inclusion_exclusion', get_the_id() ); ?>
                    </div>

                    <!-- Frequently Asked Qestion -->
                    <div class="wtbmt_faq_tab_wrapper">
						<?php do_action( 'wtbm_tour_extra_details', get_the_id() ); ?>
                    </div>
                </div>
                <!-- End Left-Side-Bar -->


                <!-- Start Right-Side-Bar -->
                <div class="col-12 col-md-4">
                    <div class="wtbmt_wrapper_off_right">
                        <div class="wtbmt_map_area_title">
                            <h4>Starting From</h4>
                            <p>350.00$/29000BDT (7 days)</p>
                            <p>(Per Person)</p>
                        </div>

                        <div class="wtbmt_map_area ">
							
							<?php
							do_action( "tour_validities", get_the_ID() );
							?>

                            <div class="wtbmt_hotel_booking">
                                <h4>Hotel Booking Price</h4>

                                <h4 class="wtbmt_booking_title">Hotel Kollol in Cox-bazar</h4>
                                <h5>Price includes VAT & Tax<h5>
                            </div>

                        </div>
                        <!-- End Map-Area -->

                        <div class="wtbmt_right_side_btn">
                            <button class="default-btn but_btn buy_now_btn">Buy Now</button>
                        </div>

                        <!-- Start CartBox-Popup -->

                        <form action="" method="post">
                            <div id="wtbmt_cart_box_popup">

                                <div class="wtbmt_buy_cart_form">
									
									<?php
									$tour_offer_type = get_post_meta( get_the_ID(), 'tour_offer_type', true );
									
									if ( "flexible" == $tour_offer_type ) {
										
										?>

                                        <div class="wtbmt_datepicker_form">
                                            <h4>Type your tour date</h4>
                                            <div class="form-group">
                                                <div class="input-group date">
                                                    <input type="text" name="tour_start_date" id="datepicker"
                                                    autocomplete="off" placeholder="Select your flexible date">
                                                </div>
                                            </div>
                                        </div>
										
										<?php
									}
									
									$price_source = get_post_meta( get_the_ID(), 'tour_price_source', true );
									
									if ( 'tour' == $price_source ) {
										do_action( "tour_room_details_with_price", get_the_id() );
									} else {
										do_action( "hotel_room_details_with_price", get_the_id() );
									}
									?>

                                </div>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Body-Wrapper-area section-->


    <!--Start Blog section-->

    <?php do_action( 'related_tour_section' ); ?>

    <!--End Blog section-->
<?php get_footer(); ?>