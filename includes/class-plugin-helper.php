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
		 * Change Booking status when changing the woocommerce order status.
		 *
		 * @param $order_id
		 * @param $set_status
		 * @param $post_status
		 * @param $booking_status
		 */
		public static function change_tour_booking_status( $order_id, $set_status, $post_status, $booking_status ) {
			
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
			
			foreach ( $loop->posts as $tour ) {
				$post_id      = $tour->ID;
				$current_post = get_post( $post_id, 'ARRAY_A' );
				update_post_meta( $post_id, 'wtbm_order_status', $booking_status );
				$current_post['post_status'] = $set_status;
				wp_update_post( $current_post );
			}
			
		}//end method change_tour_booking_status
		
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
					$hotel_room_fare_min = maybe_unserialize( get_post_meta( $pakage->ID,
						'hotel_room_details',
						true ) );
					
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
                                            <span><?php esc_html_e( '' . $tour_duration . ' Day',
													'woocommerce-tour-booking-manager' ) ?></span>
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
                                    <span><?php echo esc_html__( 'Price starts from (per person)',
		                                    'woocommerce-tour-booking-manager' ); ?></span>
                                    <h4>
                                        <span><?php echo esc_html__( 'BDT ' . $min_fare . '',
		                                        'woocommerce-tour-booking-manager' ); ?></span>
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
         * Add pagination in tour listing page.
         *
		 * @param $the_query
		 */
		public static function wtbm_pagination( $the_query ) {
			
			$total_pages = $the_query->max_num_pages;
			
			if ( $total_pages > 1 ) {
				
				$current_page = max( 1, get_query_var( 'paged' ) );
				
				echo paginate_links( array(
					'base'      => get_pagenum_link( 1 ) . '%_%',
					'format'    => '/page/%#%',
					'current'   => $current_page,
					'total'     => $total_pages,
					'prev_text' => __( '« prev' ),
					'next_text' => __( 'next »' ),
				) );
			}
		}//end method wtbm_pagination
		
		
	}//end class Tour_Booking_Helper
}//end if condition