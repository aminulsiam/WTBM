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
			
			//this shortcode is for search tour pakage
			add_shortcode( 'woo_tour_search', array( $this, 'woo_tour_search' ) );
			
			add_shortcode( 'wtbm_featured_tour', array( $this, 'wtbm_featured_tour' ) );
			
			add_shortcode( 'wtbm_destination_tour', array( $this, 'wtbm_destination_tour' ) );
			
		}//end method woo_tour_shortcode
		
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
				), $atts
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
									'terms'    => 'featured'
								)
							)
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
				), $atts
			);
			
			$args             = array(
				'post_type' => 'mage_tour',
				'tax_query' => array(
					array(
						'taxonomy' => 'destination',
						'field'    => 'slug',
						'terms'    => $atts['location']
					)
				)
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
				), $atts
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
				'pakages' => array_unique( $slugs )
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
							'field'    => 'slug'
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
					'pakages' => array_unique( $slugs )
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
				), $atts
			);
			
			return Tour_Booking_Helper::All_Pakage_Page( $atts );
			
		}//end method woo_tour_pakage_page
		
		
	}//end Plugin_Shortcode class
}//end if class exist block

new Woo_Tour_Shortcode();