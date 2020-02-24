<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}
/**
 * Tour helper class
 *
 * Declare every function by static keyword.
 */
if ( ! class_exists( 'Tour_Booking_Helper' ) ) {
	
	/**
	 * Class Tour_Booking_Helper
	 *
	 * This is helper class for tour booking
	 */
	class Tour_Booking_Helper {
		
		/**
		 * This method is showing hotel details.
		 *
		 * @param $get_hotel_details
		 */
		public static function hotel_details( $get_hotel_details ) {
			
			global $post;
			
			$hotel_price_source = get_post_meta( $post->ID, 'tour_price_source', true );
			$tour_start_date    = get_post_meta( $post->ID, 'start_date', true );
			$tour_type          = get_post_meta( $post->ID, 'tour_offer_type', true );
			
			?>

            <div id="dialog-form" title="Buy Your Tour Pakage">
                <form action="" method="post">

                    <section class="pop-up-right">
						
						<?php
						
						if ( "flexible" == $tour_type ) {
							?>
                            <div class="form-group">
                                <label for=""><?php echo esc_html__( 'Tour Date :  ',
										'woocommerce-tour-booking-manager' ); ?></label>
                                <input type="text" class="datepicker" autocomplete="off" name="tour_date"
                                       placeholder="Enter your tour start date" required/>
                                <span class="description"><?php echo esc_html__( 'Enter your tour start date', 'woocommerce-tour-booking-manager' ); ?></span>

                            </div>
							<?php
						} elseif ( "fixed" == $tour_type ) {
							?>
                            <input type="hidden" value='<?php echo $tour_start_date; ?>' name="tour_date"/>
							<?php
						}
						
						if ( 'hotel' == $hotel_price_source ) {
							?>

                            <div class="hotel_options">

                                <h3 class="hotel_select_heading">
									<?php echo esc_html__( 'Select Your Hotel Please',
										'woocommerce-tour-booking-manager' ); ?>
                                </h3>

                                <select class="hotel" name="tour_hotel" data-id="<?php echo get_the_ID(); ?>">
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
						
						<?php } elseif ( 'tour' == $hotel_price_source ) {
						
						$tour_price = maybe_unserialize( get_post_meta( $post->ID, 'hotel_room_details',
							true ) );
						
						$tour_duration = get_post_meta( $post->ID, 'tour_duration', true );
						
						if ( empty( $tour_duration ) ) {
							$tour_duration = 1;
						}
						
						if ( ! is_array( $tour_price ) ) {
							$tour_price = array();
						}
						?>
                        <input type="hidden" name="tour_hotel" value="0">

                        <span class="hotel_details">

                                <h3><?php echo esc_html__( 'Hotel Room Details',
		                                'woocommerce-tour-booking-manager' ); ?></h3>
                                <table>
                                    <tr>
                                        <th><?php echo esc_html__( 'Room Type',
		                                        'woocommerce-tour-booking-manager' ) ?></th>
                                        <th><?php echo esc_html__( 'Room Fare',
		                                        'woocommerce-tour-booking-manager' ) ?></th>
                                        <th><?php echo esc_html__( 'Room Quantity',
		                                        'woocommerce-tour-booking-manager' ) ?></th>
                                    </tr>
	                                <?php
	                                foreach ( $tour_price as $room ) {
		                                ?>
                                        <tr>
                                            <td>
                                                <input type="hidden" name="room_name[]"
                                                       value="<?php esc_html_e( $room['room_type'] ); ?>">
                                                
   <input type="hidden" name="room_cap[]" value="<?php esc_html_e( $room['person_capacity'] ); ?>_<?php
   echo trim( $room['room_type'] ); ?>_<?php trim( esc_html_e( $room['room_fare'] ) ); ?>">
	
	                                            <?php esc_html_e( $room['room_type'] ); ?>
                                            </td>

                                            <td class="price-td">
                                                <span class="room_price" style="display: none">
                                                    <?php esc_html_e( $room['room_fare'] *
                                                                      $tour_duration ); ?>
                                                </span>

                                                <span>
                                                    <?php echo '(Per Night -' . $room['room_fare'] . ' X ' . $tour_duration . ' Nights ) = ' . wc_price( $room['room_fare'] * $tour_duration ); ?>
                                                    
                                                    
                                                </span>

                                                <span class="person_capacity" style="display: none">
                                                    <?php esc_html_e( $room['person_capacity'] ); ?></span>

                                                <input type="hidden" value="<?php esc_html_e(
	                                                $room['room_fare'] ); ?>" name="room_price[]"
                                                       class="price">

                                                <input type="hidden"
                                                       value="<?php esc_html_e( $room['person_capacity'] );
                                                       ?>" name="person_capacity" class="max_person"/>
                                            </td>

                                            <td>
                                                <select class="qty" name="room_qty[]" required>
                                                    <option value='0'>0</option>
	                                                <?php
	                                                for ( $i = 1; $i <= $room['room_qty']; $i ++ ) {
		                                                ?>
                                                        <option value="<?php esc_attr_e( $i ); ?>">
                                                            <?php esc_html_e( $i ) ?>
                                                        </option>
	                                                <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
	
	                                <?php } ?>

                                    <tr>
                                        <td colspan="2">
                                            <?php
                                            echo esc_html__( 'No of Traveller',
	                                            'woocommerce-tour-booking-manager' ); ?></td>

                                        <td align="right">
                                            <input type="number" min="0" max="0" class="total_person"
                                                   name="total_person" value="0">
                                            
                                            <span class="total_person_show_error"></span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2">
                                            <?php echo esc_html__( 'Total Price',
	                                            'woocommerce-tour-booking-manager' ); ?>
                                        </td>
	
	                                    <?php $currency_pos = get_option( 'woocommerce_currency_pos' ); ?>

                                        <td align="right">
                                            <?php
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

                                    <tr class="form_builder">
                                        <td colspan="3">
                                            
                                            <span class="form"></span>
                                            
                                            <span class="error_text" style="text-align: center">
                                                <?php echo esc_html__( 'No Traveller Selected', '' ); ?>
                                            </span>
                                            
                                            <button type="submit" class="btn btn-info
                                            pop_up_add_to_cart_button" name="add-to-cart" disabled="disabled"
                                                    value="<?php echo get_the_ID(); ?>">
                                                <?php
                                                echo esc_html__( 'Add To Cart',
	                                                'woocommerce-tour-booking-manager' ); ?>
                                            </button>
                                            
                                        </td>
                                    </tr>

                                </table>
		                    </span>
                    </section>
                </form>
            </div>

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
                                .html('<?php do_action( 'attendee_form_builder', get_the_id() ); ?>')
                        );
                    }

                });

            </script>
			<?php
		}
		}//end method hotel_details
		
		/**
		 * This method will show every tour pakage by shortcode
		 *
		 *  Shortcode output callback method
		 */
		public static function All_Pakage_Page( $atts ) {
			
			$get_pakages = get_posts( [
				'numberposts' => - 1, // -1 is for all
				'post_type'   => 'mage_tour', // or 'post', 'page'
				'orderby'     => 'title', // or 'date', 'rand'
				'order'       => 'ASC',
			] );
			
			return Tour_Booking_Helper::search_and_all_tour_pakage( $get_pakages, $atts );
			
		}//end method woo_tour
		
		
		/**
		 * Search Tour pakages by shortcode.
		 *
		 * @param $pakages
		 * @param $atts
		 */
		public static function search_and_all_tour_pakage( $pakages, $atts ) {
			
			//if anyone give view ="list" parameter in shortcode then width 100%, else by default 25vw
			//it will show the grid or list view
			$list_or_grid_width = "25vw";
			
			if ( "list" == $atts['view'] ) {
				$list_or_grid_width = "100%";
			}
			
			if ( ! is_array( $pakages ) ) {
				$pakages = array();
			}
			
			foreach ( $pakages as $pakage ) {
				
				$tour_end_date = get_post_meta( $pakage->ID, 'end_date', true );
				
				if ( $tour_end_date >= date( 'Y-m-d' ) ) {
					
					$background_img = wp_get_attachment_url( get_post_thumbnail_id( $pakage->ID ) );
					
					//get meta data for this post
					$tour_duration = get_post_meta( $pakage->ID, 'tour_duration', true );
					
					//get room fare
					$hotel_room_fare_min = maybe_unserialize( get_post_meta( $pakage->ID, 'hotel_room_details', true ) );
					
					//check $hotel_room_fare_min is array or not
					if ( ! is_array( $hotel_room_fare_min ) ) {
						$hotel_room_fare_min = array();
					}
					
					$min_fare = array();
					
					foreach ( $hotel_room_fare_min as $fare ) {
						$min_fare[] = $fare['room_fare'];
					}
					
					if ( ! empty( $min_fare ) ) {
						$min_fare = min( $min_fare );
						$doller   = ceil( $min_fare / 80 );
					} else {
						$min_fare = 0;
						$doller   = ceil( $min_fare / 80 );
					}
					?>
                    <a href="<?php echo get_post_permalink( $pakage->ID ); ?> " target="_blank">
                        <div class="Module-item"
                             style="background-image: url(<?php echo $background_img; ?>);color: white;
                                     width: <?php echo $list_or_grid_width; ?> ">
                            <div class="overlay"></div>
                            <div class="text">
                                <div class="top">
                                    <ul>
                                        <li><img src="<?php echo PLUGIN_URL . 'public/images/module-calender.png'; ?>"
                                                 alt="calender">
                                            <span><?php esc_html_e( '' . $tour_duration . ' Day', 'woocommerce-tour-booking-manager' ) ?></span>
                                        </li>
                                        <li>
                                            <img src="<?php
											echo PLUGIN_URL . 'public/images/module-tripcoin.png'; ?>"
                                                 alt="Doller sign"><span><?php esc_html_e( $doller );
												?></span></li>
                                        <li>
                                            <img src="<?php echo PLUGIN_URL . 'public/images/module-tripcoin-share.png'; ?>"
                                                 alt=""><span>50</span></li>
                                    </ul>
                                </div>
                                <div class="bottom">
                                    <span><?php echo esc_html__( 'Price starts from (per person)', 'woocommerce-tour-booking-manager' ); ?></span>
                                    <h4>
                                        <span><?php echo esc_html__( 'BDT ' . $min_fare . '', 'woocommerce-tour-booking-manager' ); ?></span>
                                    </h4>
                                    <p><?php echo esc_html( $pakage->post_title ); ?> </p>
                                    <p>
                                        <small>
                                            <i class="mdi mdi-map-marker"></i>
											<?php
											$destination = get_the_terms( $pakage->ID, 'destination' );
											
											if ( ! is_array( $destination ) ) {
												$destination = array();
											}
											
											foreach ( $destination as $location ) {
												esc_html_e( ucfirst( $location->name ) );
											}
											?>
                                        </small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
					<?php
				}//end tour end date check
			}//end foreach
			
			wp_reset_postdata();
			
		}//end method search_and_all_tour_pakage
  
		/**
		 *
		 */
        public static function form_builder_script(){
		    ?>

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
                                .html('<?php do_action( 'attendee_form_builder', get_the_ID() ); ?>')
                        );
                    }

                });

            </script>
            
            <?php
        }//end method form_builder_script
        
        
		/**
		 * Get settings from admin
		 *
		 * @param $setting_name
		 * @param $meta_key
		 * @param null $default
		 *
		 * @return null
		 */
		public static function wtbm_get_option( $setting_name, $meta_key, $default = null ) {
			$get_settings = get_option( $setting_name );
			$get_val      = $get_settings[ $meta_key ];
			$output       = $get_val ? $get_val : $default;
			
			return $output;
		}
		
		
	}//end class Tour_Booking_Helper
}//end if condition