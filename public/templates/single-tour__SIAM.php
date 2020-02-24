<?php
get_header();
the_post();
?>


    <!--Start Body-Wrapper-area section-->
    <section class="wrapper_area">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8">
                    <!-- Slider-area -->
                    
                    <div class="wtbmt_hero_area">
                        <div class="wtbmt_hero_content" style="margin-bottom: 20px;">
							<?php echo ucfirst( get_the_title() ); ?>
                        </div>
                        <div class="wtbmt_home_slider owl-carousel">							
							<?php
							$gallary_images = maybe_unserialize( get_post_meta( get_the_ID(), 'tour_gallary_image', true ) );							
							if ( ! is_array( $gallary_images ) ) {
								$gallary_images = array();
							}							
							the_post_thumbnail();							
							foreach ( $gallary_images as $images ) {
								?>
                                <div class="hero_bg">
									<?php echo wp_get_attachment_image( $images, array( 1000, 800 ) ); ?>
                                </div>
							<?php } ?>
                        </div>
                    </div>

                    <div class="home_overview">
                        <h2>Overview</h2>
                        <div class="content">
                            <p><?php the_content(); ?></p>
                        </div>
                    </div>

                    <!-- Travelling Package -->
                    <div class="travelling_package">
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
                                <ul class="">
                                    <li>Visit Batubalan, Elephant Cave, Kintam</li>
                                    <li>Enjoy water sports</li>
                                    <li>Cover Gitgit Waterfalls, Twin Lake View</li>
                                </ul>
                            </div>
                        </div>
                    </div>
					
					<?php
					
					$more_details    = maybe_unserialize( get_post_meta( $post->ID, 'more_details',
						true ) );
					$daywise_details = maybe_unserialize( get_post_meta( $post->ID,
						'tour_daywise_details', true ) );
					
					if ( is_array( $daywise_details ) && sizeof( $daywise_details ) > 0 && ! empty( $daywise_details ) ) {
					
					?>

                    <!-- Travelling Plan -->
                    <div class="traveling_plan">
                        <h2>Travel plan</h2>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
							<?php
							$tab_number = 1;
							foreach ( $daywise_details as $daywise_detail ) {
								?>
                                <li class="nav-item">
                                    <a class="nav-link" id="home-tab" data-toggle="tab"
                                       href="#tab<?php echo $tab_number; ?>"
                                       role="tab"><?php echo esc_html( ucfirst( $daywise_detail['day_title'] ) ); ?></a>
                                </li>
								<?php $tab_number ++;
							} ?>
                        </ul>

                        <div class="tab-content" id="myTabContent">
							
							<?php
							$tab_number = 1;
							
							foreach ( $daywise_details as $daywise_detail ) {
								?>
                                <div class="tab-pane fade show active " id="tab<?php echo $tab_number; ?>"
                                     role="tabpanel">
                                    <h3><?php echo esc_html( ucfirst( $daywise_detail['day_title'] ) ); ?></h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <img src="<?php echo PLUGIN_URL; ?>public/img/hotelroom1.jpg">
                                        </div>
                                        <div class="col-md-6">
                                            <img src="<?php echo PLUGIN_URL; ?>public/img/hotelroom2.jpg">
                                        </div>
                                    </div>
                                    <div class="travel_content">
                                        <h4>Time to bid farewell to your honeymoon in Cox-Bazar</h4>
                                        <p><?php echo esc_html( ucfirst( $daywise_detail['day_details'] ) ); ?></p>

                                        <div class="benefits">
                                            <h4>Other Benefits (On Arrival)</h4>
                                            <ul class="benefits_icon">
                                                <li>
                                                    <img src="<?php echo PLUGIN_URL; ?>public/img/breakfast.png">Breakfast
                                                </li>
                                                <li>
                                                    <img src="<?php echo PLUGIN_URL; ?>public/img/lunch.png">Free Lunch
                                                </li>
                                                <li>
                                                    <img src="<?php echo PLUGIN_URL; ?>public/img/entry fee.png">Entry
                                                    Fee
                                                </li>
                                            </ul>

                                        </div>
                                    </div>
                                </div>
								
								<?php $tab_number ++;
							}
                            } 
                            
                            ?>

                       
                    <!--  end of travelling plan -->
					
					<?php
					
					$price_source = get_post_meta( get_the_ID(), 'tour_price_source', true );
					
					$get_hotel_details = get_terms( array(
						'taxonomy'   => 'hotel_details',
						'hide_empty' => false,
					) );
					
					if ( 'hotel' == $price_source ) { ?>
                        <!-- Hotels Room -->
                        <div class="hotels_room">
                            <h2>Hotels</h2>
							<?php
							foreach ( $get_hotel_details as $hotel_detail ) {
								
								$image_id = get_term_meta( $hotel_detail->term_id, 'hotel_image',
									true );
								
								$tax_term_image = wp_get_attachment_image( $image_id, 'medium-large' );
								
								?>
                                <h3><?php echo ucfirst( $hotel_detail->name ); ?></h3>
                                <div class="row">
                                    <div class="col-md-6">
										<?php echo $tax_term_image; ?>
                                    </div>

                                    <div class="col-md-6">
										<?php echo $tax_term_image; ?>
                                    </div>

                                </div>

                                <div class="hotels_content">
									<?php
									if ( ! empty( $hotel_detail->description ) ) {
										?>
                                        <h4><?php echo "Details about " . ucfirst( $hotel_detail->name );
											?></h4>
                                        <p><?php echo $hotel_detail->description; ?></p>
									<?php } ?>
                                    <br>

                                    <div class="benefits">
                                        <h4>Other Benefits (On Arrival)</h4>
                                        <ul class="benefits_icon">
                                            <li>
                                                <img src="<?php echo PLUGIN_URL; ?>public/img/drinks.png">Welcome
                                                Drinks
                                            </li>
                                            <li>
                                                <img src="<?php echo PLUGIN_URL; ?>public/img/wifi.png">Free
                                                Wifi
                                            </li>
                                        </ul>
                                    </div>
                                </div>
							<?php } ?>
                        </div>
					<?php } ?>
                    <!-- end of hotel details  -->
					
					
					<?php
					if ( is_array( $more_details ) && sizeof( $more_details ) > 0 && ! empty( $more_details ) ) {
						?>

                        <div class="faq_tab_wrapper">
                            <div class="panel-group accor_padding_top" id="accordion" role="tablist"
                                 aria-multiselectable="true">
								
								<?php
								$panel_number = 1;
								
								foreach ( $more_details as $more_detail ) {
									?>

                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="heading<?php echo $panel_number; ?>">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion"
                                                   href="#collapse<?php echo $panel_number; ?>"
                                                   aria-expanded="false" class="collapsed"
                                                   aria-controls="collapse<?php echo $panel_number; ?>">
													<?php echo esc_html( ucfirst( $more_detail['details_topic'] ) ); ?>
                                                </a>
                                            </h4>
                                        </div>

                                        <div id="collapse<?php echo $panel_number; ?>" class="panel-collapse collapse"
                                             role="tabpanel"
                                             aria-labelledby="heading<?php echo $panel_number; ?>">
                                            <div class="panel-body">
                                                <p>
													<?php echo esc_html( ucfirst( $more_detail['details'] ) ); ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
									
									<?php $panel_number ++;
								} ?>

                            </div>
                        </div>
					
					<?php } ?>

                </div>
                <!-- End Left-Side-Bar -->


                <!-- Start Right-Side-Bar -->
                <div class="col-12 col-md-4">
                    <div class="wrapper_off_right">
                        
                        <div class="map_area_title">
                            <h4>Starting From</h4>
                            <p>350.00$/29000BDT (7 days)</p>
                            <p>(Per Person)</p>
                        </div>


                        <div class="map_area ">
                            <iframe id="gmap_canvas"
                                    src="https://maps.google.com/maps?q=Coxesbazar&amp;t=&amp;z=10&amp;ie=UTF8&amp;iwloc=&amp;output=embed"
                                    frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                                    style="width: 100%;min-height: 250px;"></iframe>
							
							<?php
							
							$tentative_start_date = get_post_meta( $post->ID, 'start_date', true );
							$tentative_end_date   = get_post_meta( $post->ID, 'end_date', true );
							
							$valid_form_date_format = date_i18n( "d ", strtotime(
								$tentative_start_date ) );
							
							$valid_form_month_year_format = date_i18n( "M 'y", strtotime(
								$tentative_start_date ) );
							
							$valid_till_date_format = date_i18n( "d ", strtotime(
								$tentative_end_date ) );
							
							$valid_till_month_year_format = date_i18n( "M 'y", strtotime(
								$tentative_end_date ) );
							
							?>

                            <div class="validities">
								<?php
								$tour_offer_type = get_post_meta( get_the_ID(), 'tour_offer_type',
									true );
								?>

                                <h4>Departure Time : <?php echo ucfirst( $tour_offer_type ); ?></h4>

                                <div class="row validities_content">

                                    <div class="col-md-4 col-sm-4">
                                        <ul>
                                            <li class="text_bold">From</li>
                                            <li>
                                                <span><?php esc_html_e( $valid_form_date_format ); ?><?php esc_html_e( $valid_form_month_year_format ); ?>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="col-md-4 col-sm-4">
                                        <ul>
                                            <li class="text_bold">Till</li>
                                            <li>
                                                <span><?php esc_html_e( $valid_till_date_format ); ?><?php esc_html_e( $valid_till_month_year_format ); ?>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="col-md-4 col-sm-4">
                                        <ul>
                                            <li class="text_bold">Departs</li>
                                            <li>Eveyday</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="hotel_booking">
                                <h4>Hotels</h4>
                                <div class="row validities_content">
									
									<?php
									foreach ( $get_hotel_details as $hotel_detail ) {
										?>
                                        <h4 class="booking_title"
                                            style="margin-right: 10px"><?php echo $hotel_detail->name; ?></h4>
									<?php } ?>
									
									<?php
									if ( 'tour' == $price_source ){
									?>
                                    <h5>N. B - Price includes VAT & Tax, We are Selecting hotel from above list<h5>
											<?php } ?>
                                </div>
                            </div>
                            <!-- End Map-Area -->

                            <form action="" method="post">
                                <div class="right_side_btn">
                                    <button class="default-btn but_btn buy_now_btn">Buy Now</button>
                                </div>

                                <!-- Start CartBox-Popup -->
                                <div id="cart_box_popup" style="display: none">
                                    <div class="buy_cart_form">
                                        <div class="buy_cart_form">
											
											<?php
											$tour_offer_type = get_post_meta( get_the_ID(),
												'tour_offer_type', true );
											
											
											if ( 'flexible' == $tour_offer_type ) {
												?>

                                                <div class="datepicker_form">
                                                    <h2>Type your tour date</h2>
                                                    <div class="form-group">
                                                        <div class='input-group date' id='datepicker'>
                                                            <input type='text' class="form-control datepicker"
                                                                   placeholder="MM/DD/YY"/>
                                                        </div>
                                                    </div>
                                                </div>
												
												<?php
											}
											if ( 'tour' == $price_source ) {
											
											$tour_price = maybe_unserialize( get_post_meta( $post->ID,
												'hotel_room_details', true ) );
											
											$tour_duration = get_post_meta( $post->ID, 'tour_duration',
												true );
											
											if ( empty( $tour_duration ) ) {
												$tour_duration = 1;
											}
											
											if ( ! is_array( $tour_price ) ) {
												$tour_price = array();
											}
											
											?>

                                            <div class="wtbmt_order_summury_box  hotel_details">

                                                <table class="table">
                                                    <thead>

                                                    <tr>

                                                        <th><?php echo esc_html__( 'Room Type', 'woocommerce-tour-booking-manager' ) ?></th>
                                                        <th><?php echo esc_html__( 'Room Fare', 'woocommerce-tour-booking-manager' ) ?></th>
                                                        <th><?php echo esc_html__( 'Room Quantity', 'woocommerce-tour-booking-manager' ) ?></th>

                                                    </tr>

                                                    </thead>
                                                    <tbody>
													
													<?php
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
                                                        <td colspan="2" class="bold_text"><?php echo esc_html__( 'Total Person', 'woocommerce-tour-booking-manager' ); ?></td>

                                                        <td align="right">
                                                            <input type="number" max="0" min="0" value="0"
                                                                   class="total_person" name="total_person"/>
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
                                                            <button class="default-btn but_btn"
                                                                    name="add-to-cart" disabled="disabled">
                                                                Add To Cart
                                                            </button>
                                                        </div>
                                                    </tr>
                                                </table>
                            </form>

                        </div>
						
						<?php
						
						echo Tour_Booking_Helper::form_builder_script();
						
						} else {
							?>

                            <div style="text-align: center">
                                <h4>Select Your Hotel Please</h4>

                                <select class="hotel_list form-group" name="tour_hotel"
                                        data-id="<?php echo get_the_ID(); ?>"
                                        style="display: inline-block !important;">
                                    <option value="other"><?php echo
										esc_html__( 'Select Your Hotel', 'woocommerce-tour-booking-manager' ) ?></option>
									<?php
									foreach ( $get_hotel_details as $hotel ) {
										?>
                                        <option value="<?php echo esc_attr( $hotel->term_id ); ?>">
											<?php echo esc_html( ucfirst( $hotel->name ) ); ?>
                                        </option>
									<?php } ?>
                                </select>

                            </div>

                            <span class="hotel_details no_hotel"></span>
							
							<?php
						}
						?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Body-Wrapper-area section-->





    
    <!--Start Blog section-->
    <section id="blog_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 testimonial-right">
                    <div class="blog_carousel owl-carousel">
                        <div class="blog-item">
                            <!--                            <img src="-->
							<?php //echo PLUGIN_URL; ?><!--public/img/blog1.jpg" alt="blog">-->
                            <div class="single_blog">
                                <div class="blog_content">
                                    <h4>How can get started your tour</h4>

                                    <p>At vero eos et accusamus et iusto odio dignissimos ducqui blanditiis
                                        praesentium voluptatum deleniti atque corrupti quos et quas
                                        accusamus et iusto.</p>

                                    <ul class="tour_shedule">
                                        <li class="active_color">5 Days & 4 Nights</li>
                                        <li>Start From $500.00</li>
                                    </ul>
                                </div>
                                <div class="blog_benefits">
                                    <h4>Other Benefits (On Arrival)</h4>
                                    <ul class="blog_benefits_icon">
                                        <li>
                                            <img src="<?php echo PLUGIN_URL; ?>public/img/breakfast.png"><span>Breakfast</span>
                                        </li>
                                        <li>
                                            <img src="<?php echo PLUGIN_URL; ?>public/img/lunch.png"><span>Free Lunch</span>
                                        </li>
                                        <li>
                                            <img src="<?php echo PLUGIN_URL; ?>public/img/entry fee.png"><span>Entry Fee</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="blog-item">
                            <!--                            <img src="-->
							<?php //echo PLUGIN_URL; ?><!--public/img/blog2.jpg" alt="blog">-->
                            <div class="single_blog">
                                <div class="blog_content">
                                    <h4>How can get started your tour</h4>
                                    <p>At vero eos et accusamus et iusto odio dignissimos ducqui blanditiis praesentium
                                        voluptatum deleniti atque corrupti quos et quas accusamus et iusto.</p>

                                    <ul class="tour_shedule">
                                        <li class="active_color">5 Days & 4 Nights</li>
                                        <li>Start From $500.00</li>
                                    </ul>
                                </div>
                                <div class="blog_benefits">
                                    <h4>Other Benefits (On Arrival)</h4>
                                    <ul class="blog_benefits_icon">
                                        <li>
                                            <img src="<?php echo PLUGIN_URL; ?>public/img/breakfast.png"><span>Breakfast</span>
                                        </li>
                                        <li>
                                            <img src="<?php echo PLUGIN_URL; ?>public/img/lunch.png"><span>Free Lunch</span>
                                        </li>
                                        <li>
                                            <img src="<?php echo PLUGIN_URL; ?>public/img/entry fee.png"><span>Entry Fee</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="blog-item">
                            <!--                            <img src="-->
							<?php //echo PLUGIN_URL; ?><!--public/img/blog3.jpg" alt="blog">-->
                            <div class="single_blog">
                                <div class="blog_content">
                                    <h4>How can get started your tour</h4>
                                    <p>At vero eos et accusamus et iusto odio dignissimos ducqui blanditiis praesentium
                                        voluptatum deleniti atque corrupti quos et quas accusamus et iusto.</p>

                                    <ul class="tour_shedule">
                                        <li class="active_color">5 Days & 4 Nights</li>
                                        <li>Start From $500.00</li>
                                    </ul>
                                </div>
                                <div class="blog_benefits">
                                    <h4>Other Benefits (On Arrival)</h4>
                                    <ul class="blog_benefits_icon">
                                        <li>
                                            <img src="<?php echo PLUGIN_URL; ?>public/img/breakfast.png"><span>Breakfast</span>
                                        </li>
                                        <li>
                                            <img src="<?php echo PLUGIN_URL; ?>public/img/lunch.png"><span>Free Lunch</span>
                                        </li>
                                        <li>
                                            <img src="<?php echo PLUGIN_URL; ?>public/img/entry fee.png"><span>Entry Fee</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Blog section-->

<?php get_footer(); ?>