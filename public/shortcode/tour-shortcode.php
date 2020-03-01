<?php
if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access pages directly.

if ( ! class_exists( 'Woo_Tour_Shortcode' ) ) {
	
	/**
	 * Woo Tour shortcode class
	 *
	 * Class Woo_Tour_Shortcode
	 */
	class Woo_Tour_Shortcode {
		
		public function __construct() {
			add_action( 'init', array( $this, 'woo_tour_shortcode' ) );
		}
		
		/**
		 * Woo Tour Shortcode
		 *
		 * All woo tour shortcode are written in this method.
		 */
		public function woo_tour_shortcode() {
			
			//this shortcode is showing all tour pakage in a page
			add_shortcode( 'wtbm_tour_list', array( $this, 'wtbm_tour_list' ) );
			
			add_shortcode( 'tour_list', array( $this, 'tour_list' ) );
			
			//this shortcode is for search tour pakage
			add_shortcode( 'woo_tour_search', array( $this, 'woo_tour_search' ) );
			
			add_shortcode( 'wtbm_featured_tour', array( $this, 'wtbm_featured_tour' ) );
			
			add_shortcode( 'wtbm_destination_tour', array( $this, 'wtbm_destination_tour' ) );
			
		}//end method woo_tour_shortcode
		
		public function tour_list() {
			?>

            <!--Start Hero-area section-->
            <section id="wtbmt_form_1_area" class="package_listing_area"
                     style="background-image: url(assets/img/banner/img2.jpg);  background-position: center center; background-size: cover;">

                <div class="wtbmt_offer_title text-center">
                    <a href="#"><span>Member's Saving - Unlock up to $350</span></a>
                </div>

                <div class="container">
                    <div id="wtbmt_form_area" class="package_listing_area_content">
                        <div class="row justify-content-center">
                            <div class="col-md-8 col-sm-12 col-xs-12">
                                <div class="wtbmt_form_area">
                                    <div class="wtbmt_banner_title text-center">
                                        <h1>Tour Package</h1>
                                    </div>
                                    <form id="wtbmt_wanderlust_form1" action="#">
                                        <div class="wtbmt_form__item form__item_select">
                                            <div class="wtbmt_custom_select map_marker">
                                                <select>
                                                    <option value="0">Your Destinaion</option>
                                                    <option value="SanFrancisco">Barishal District</option>
                                                    <option value="NewYork">Rangamati District</option>
                                                    <option value="California">Dinajpur District</option>
                                                    <option value="California">Cox's Bazar District</option>
                                                    <option value="California">Rangpur District</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="wtbmt_form__item calander_icon">
                                            <div class="wtbmt_form__item_datepicker">
                                                <input type="text" name="checkin_display" class="wtbmt_datepicker"
                                                       placeholder="Select Your Date" id="datepicker" value=""
                                                       readonly="">
                                            </div>
                                        </div>
                                        <div class="wtbmt_form__item form__item_submit">
                                            <input type="submit" value="Find Your Destination">
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <!--Start Body-Wrapper-area section-->
            <section class="wtbmt_packege_wrapper_area">
                <div class="container">
                    <div class="row">
                        <!-- Start Left-Side-Bar -->
                        <div class="col-12 col-md-3">
                            <div class="wtbmt_wrapper_off_left">
                                <div class="wtbmt_catagory_area_title">
                                    <h4>Select All Filter</h4>
                                </div>
                                <div class="wtbmt_package_catagory">
                                    <div class="wtbmt_catagory">
                                        <h4>Categories</h4>
                                        <div class="package_catagory_content">
                                            <ul>
                                                <li class="active"><a href="#">Family</a></li>
                                                <li><a href="#">Couple</a></li>
                                                <li><a href="#">Friends Group</a></li>
                                                <li><a href="#">Single</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="wtbmt_catagory border_top">
                                        <h4>Duration ( in Days )</h4>
                                        <div class="package_catagory_content">
                                            <ul>
                                                <li class="active"><a href="#">1 to 3 Days</a></li>
                                                <li><a href="#">4 to 6 Days</a></li>
                                                <li><a href="#">7 to 9 Days</a></li>
                                                <li><a href="#">10 to 12 Days</a></li>
                                                <li><a href="#">13 or more Days</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="wtbmt_catagory border_top">
                                        <h4>Hotel Star Rating</h4>
                                        <div class="package_catagory_content">
                                            <ul>
                                                <li class="active"><a href="#">3 Star</a></li>
                                                <li><a href="#">4 Star</a></li>
                                                <li><a href="#">5 Star</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="wtbmt_catagory border_top">
                                        <h4>Tour Package Budget</h4>
                                        <div class="package_catagory_content">
                                            <ul>
                                                <li class="active"><a href="#">$200 to $500 </a></li>
                                                <li><a href="#">$500 to $800</a></li>
                                                <li><a href="#">$800 to $1000</a></li>
                                                <li><a href="#">Above $1000 </a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="wtbmt_catagory border_top">
                                        <h4>Other Benifits</h4>
                                        <div class="package_catagory_content">
                                            <ul>
                                                <li class="active"><a href="#">Breakfast</a></li>
                                                <li><a href="#">Free Lunch</a></li>
                                                <li><a href="#">Entry Fee</a></li>
                                                <li><a href="#">Transport</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-9">
                            <div class="wtbmt_top_bar">
                                <ul class="wtbmt_top_bar_tag">
                                    <li><h4>Explore best selling packages for</h4></li>
                                    <li>Bangladesh</li>
                                    <li>International</li>
                                    <li><h4>255 Tour Packages Showing</h4></li>
                                </ul>
                            </div>
							
							<?php
							
							$post_per_page = get_option( 'posts_per_page' );
							$paged         = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
							
							$args      = array(
								'posts_per_page' => $post_per_page,
								'post_type'      => 'mage_tour',
								'post_status'    => 'publish',
								'order'          => 'DESC',
								'paged'          => $paged,
							);
							$the_query = new WP_Query( $args );
							
							while ( $the_query->have_posts() ) {
								$the_query->the_post();
								
								$hotel_types = get_the_terms( get_the_ID(), 'hotel_type' );
								
								if ( ! is_array( $hotel_types ) ) {
									$hotel_types = array();
								}
								
								?>
                                
                                <!-- Travelling Package -->
                                <div class="wtbmt_single_package">
                                    <div class="wtbmt_package_image_left">
                                        <?php the_post_thumbnail('small');  ?>
                                    </div>
                                    <div class="wtbmt_package_content_right">
                                        <div class="d-flex justify-content-between">
                                            <h4><?php the_title(); ?></h4>
                                            <p>Start From $300.00</p>
                                        </div>
                                        <p> <?php echo mb_substr( get_the_content(), 1, 250 ); ?></p>
                                        <ul class="wtbmt_package_shedule">
                                            <li>7 Days & 6 Nights</li>
                                            <li class="active_color">Couple Package</li>
                                            <li><a href="<?php the_permalink(); ?>" class="btn_tour">View Tour</a></li>
                                        </ul>
                                        <div class="row border_top">
                                            <div class="col-md-6">
                                                <div class="wtbmt_package_benefits">
                                                    <h4>Other Benefits (On Arrival)</h4>
                                                    <ul class="wtbmt_package_benefits_icon">
                                                        <li><img src="assets/img/breakfast.png"><span>Breakfast</span>
                                                        </li>
                                                        <li><img src="assets/img/lunch.png"><span>Free Lunch</span></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="wtbmt_package_benefits">
                                                    <h4>Hotel included in package</h4>
                                                    <ul class="wtbmt_package_benefits_icon">
														<?php
														foreach ( $hotel_types as $hotel_type ) {
															?>
                                                            <li><span><?php echo $hotel_type->name; ?></span></li>
														<?php } ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
							
							<?php } ?>

                            <div class="pagination_nav">
								
								<?php
								
								Tour_Booking_Helper::wtbm_pagination( $the_query );
								
								wp_reset_postdata();
								
								?>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
            <!--End Body-Wrapper-area section-->
			
			<?php
		}
		
		/**
		 * Callback shortcode [wtbm_featured_tour]
		 *
		 * Show featured tours
		 *
		 * @param $atts
		 */
		public function wtbm_featured_tour( $atts ) {
			
			$atts = shortcode_atts(
				array(
					'section' => 'featured',
				),
				$atts
			);
			
			?>
            <section class="wtbmt_featured_tour pad">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-lg-6 text-center">
                            <div class="title">
                                <h1>Featured Tours</h1>
                                <p>Since this is your last morning in Bali, check out in the</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
						
						<?php
						
						$args          = array(
							'post_type' => 'mage_tour',
							'tax_query' => array(
								array(
									'taxonomy' => 'tour_types',
									'field'    => 'slug',
									'terms'    => 'featured',
								),
							),
						);
						$featured_tour = new WP_Query( $args );
						
						foreach ( $featured_tour->posts as $tour ) {
							?>
                            <div class="col-md-3 col-sm-4">
                                <div class="wtbmt_single_featured">
                                    <img src="<?php echo get_the_post_thumbnail_url( $tour->ID ); ?>">
                                    <div class="wtbmt_featured_content">
                                        <a href="#"><h4><?php echo $tour->post_title; ?></h4></a>
                                        <span>Start From $590.00</span>
                                    </div>
                                </div>
                            </div>
						<?php } ?>
                    </div>
                </div>
            </section>
			
			<?php
			
		}//end method wtbm_featured_tour
		
		/**
		 * @param $atts
		 */
		public function wtbm_destination_tour( $atts ) {
			
			$atts = shortcode_atts(
				array(
					'location' => '',
				),
				$atts
			);
			
			$args             = array(
				'post_type' => 'mage_tour',
				'tax_query' => array(
					array(
						'taxonomy' => 'destination',
						'field'    => 'slug',
						'terms'    => $atts['location'],
					),
				),
			);
			$destination_tour = new WP_Query( $args );
			
			if ( is_array( $destination_tour->posts ) && sizeof( $destination_tour->posts ) > 0 ) {
				?>
                <!-- Top-destination section start -->
                <section class="wtbmt_destination pad">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-8 col-lg-6 text-center">
                                <div class="title">
                                    <h1>Top destinations</h1>
                                    <p>Since this is your last morning in Bali, check out in the</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
							
							<?php
							
							foreach ( $destination_tour->posts as $tour ) {
								?>
                                <div class="col-md-4 col-sm-4">
                                    <div class="wtbmt_single_destination">
                                        <div class="wtbmt_cities_image">
                                            <img src="<?php echo get_the_post_thumbnail_url( $tour->ID ); ?>">
                                        </div>
                                        <div class="wtbmt_destination_hover">
                                            <h4><?php echo $tour->post_title; ?></h4>
                                            <span>750 Tours</span>
                                        </div>
                                    </div>
                                </div>
							<?php } ?>
                        </div>
                    </div>
                </section>
				
				<?php
			}
			
		}//end method wtbm_destination_tour
		
		
		/**
		 * shortcode callback [woo_tour_search]
		 *
		 * @param $atts
		 *
		 * @return string|void
		 */
		public function woo_tour_search( $atts ) {
			
			//get all taxonomy
			$terms_slug = get_terms( array(
				'taxonomy'   => 'destination',
				'hide_empty' => false,
			) );
			
			$atts = shortcode_atts(
				array(
					'view' => 'no list',
				),
				$atts
			);
			
			$get_value = isset( $_GET['search'] ) ? $_GET['search'] : "";
			$get_date  = isset( $_GET['search_date'] ) ? $_GET['search_date'] : "";
			
			?>
            <div class="search_box">
                <h1><?php echo esc_html__( "Search Tour Pakage",
						'woocommerce-tour-booking-manager' ); ?></h1>

                <form class="example" action="<?php echo site_url(); ?>/woo-tour-list/">

                    <input type="text"
                           placeholder="<?php echo esc_attr__( 'Search Your likable Tour pakage......',
						       '' ); ?>" name="search" class="search" value="<?php echo $get_value;
					?>" required/>

                    <input type="text" class="search_date" name="search_date" placeholder="Enter date"
                           value="<?php echo $get_date; ?>"/>

                    <button type="submit"><i class="fa fa-search"></i></button>

                </form>
            </div>
			<?php
			
			$slugs = array();
			foreach ( $terms_slug as $slug ) {
				$slugs[] = $slug->name;
			}
			
			$localzed_value = array(
				'pakages' => array_unique( $slugs ),
			);
			
			wp_localize_script( 'tour-public-js', 'woo_tour', $localzed_value );
			
			if ( isset( $_GET['search'] ) && ! empty( $_GET['search'] ) ) {
				
				$searching_pakages = $_GET['search'];
				$searching_date    = $_GET['search_date'];
				
				$args = array(
					'post_type' => 'mage_tour',
					
					'meta_query' => array(
						'relation' => 'AND',
						array(
							'key'     => 'end_date',
							'value'   => $searching_date,
							'compare' => '>=',
							'field'   => 'end_date',
						),
					),
					
					'tax_query'      => array(
						array(
							'taxonomy' => 'destination',
							'terms'    => $searching_pakages,
							'field'    => 'slug',
						),
					),
					'posts_per_page' => - 1,
				);
				
				$get_searching_pakages = get_posts( $args );
				
				$slugs = array();
				foreach ( $terms_slug as $slug ) {
					$slugs[] = $slug->name;
				}
				
				$localzed_value = array(
					'pakages' => array_unique( $slugs ),
				);
				
				wp_localize_script( 'tour-public-js', 'woo_tour', $localzed_value );
				
				$get_tour_pakages = Tour_Booking_Helper::search_and_all_tour_pakage( $get_searching_pakages,
					$atts );
				
				if ( $get_tour_pakages != "" ) {
					return $get_tour_pakages;
				}
				
			}//end if condition
		}//end method woo_tour_search
		
		/**
		 * Callback Shortcode[woo_tour_pakage_page]
		 */
		public function wtbm_tour_list( $atts ) {
			
			$atts = shortcode_atts(
				array(
					'view' => 'no list',
				),
				$atts
			);
			
			return Tour_Booking_Helper::All_Pakage_Page( $atts );
			
		}//end method woo_tour_pakage_page
		
		
	}//end Plugin_Shortcode class
}//end if class exist block

new Woo_Tour_Shortcode();