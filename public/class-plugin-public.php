<?php
// Cannot access pages directly.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Tour Booking Main Public Class [free version]
 *
 * @package    woocommerce-tour-booking-manager
 * @subpackage woocommerce-tour-booking-manager/public
 * @author     MagePeople team <magepeopleteam@gmail.com>
 */
class Tour_Plugin_Public {
	
	private $plugin_name;
	
	private $version;
	
	public function __construct() {
		
		$this->load_public_dependencies();
		
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		
		add_filter( 'single_template', array( $this, 'register_custom_single_template' ) );
		add_filter( 'template_include', array( $this, 'register_custom_tax_template' ) );
		
		//hotel option selected by this wp ajax hook for log in users
		add_action( 'wp_ajax_show_hotel_by_option_selected',
			array(
				$this,
				'show_hotel_by_option_selected',
			) );
		
		//hotel options selected by this wp ajax hook for non authentical users
		add_action( 'wp_ajax_nopriv_show_hotel_by_option_selected',
			array(
				$this,
				'show_hotel_by_option_selected',
			) );
		
		//this hook is fire when click on buy now
		add_action( 'wp_ajax_buy_tour_pakage', array( $this, 'buy_tour_pakage' ) );
		
	}
	
	
	private function load_public_dependencies() {
		require_once PLUGIN_DIR . 'public/shortcode/tour-shortcode.php';
	}
	
	/**
	 * Enqueue public styles
	 */
	public function enqueue_styles() {
		
		wp_enqueue_style( 'tour-jquery-ui-css', PLUGIN_URL . 'public/css/jquery-ui.css', array(), time(), 'all' );
		
		$theme = wp_get_theme();
		
		if ( "Tour Booking Theme" != $theme->name ) {
			
			wp_enqueue_style( 'wtbmt-bootstrap-css',
				PLUGIN_URL . 'public/assets/css/bootstrap.min.css',
				array(),
				'',
				'all' );
			wp_enqueue_style( 'wtbmt-awesome-css',
				PLUGIN_URL . 'public/assets/css/font-awesome.min.css',
				array(),
				'',
				'all' );
			wp_enqueue_style( 'wtbmt-carousel-css',
				PLUGIN_URL . 'public/assets/css/owl.carousel.min.css',
				array(),
				'',
				'all' );
			wp_enqueue_style( 'wtbmt-animate-css',
				PLUGIN_URL . 'public/assets/css/animate.min.css',
				array(),
				'',
				'all' );
			wp_enqueue_style( 'wtbmt-aos-css', PLUGIN_URL . 'public/assets/css/aos.css', array(), '', 'all' );
			wp_enqueue_style( 'wtbmt-slicknav-css',
				PLUGIN_URL . 'public/assets/css/slicknav.min.css',
				array(),
				'',
				'all' );
			
			wp_enqueue_style( 'wtbmt-responsive-css',
				PLUGIN_URL . 'public/assets/css/responsive.css',
				array(),
				1,
				'all' );
			
			wp_enqueue_style( 'wtbmt-main-css', PLUGIN_URL . 'public/assets/style.css', array(), time(), 'all' );
			
		}
		
		
	}//end method enqueue_styles
	
	
	/**
	 * Load all scripts
	 */
	public function enqueue_scripts() {
		
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui' );
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		
		wp_enqueue_script( 'tour-public-js',
			PLUGIN_URL . 'public/js/plugin-public.js',
			array(
				'jquery',
				'jquery-ui-core',
				'jquery-ui-datepicker',
			),
			time(),
			true );
		
		$localzed_value = array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
		);
		
		wp_localize_script( 'tour-public-js', 'woo_tour', $localzed_value );
		
		wp_enqueue_script( 'template-custom-js',
			PLUGIN_URL . 'public/assets/js/custom.js',
			array( 'jquery' ),
			time(),
			true );
		
		wp_enqueue_script( 'owl-carousel-js',
			PLUGIN_URL . 'public/assets/js/owl.carousel.min.js',
			array( 'jquery' ),
			time(),
			true );
		
		wp_enqueue_script( 'slicknav-js',
			PLUGIN_URL . 'public/assets/js/jquery.slicknav.min.js',
			array( 'jquery' ),
			time(),
			true );
		
		
	}//end method enqueue_scripts
	
	/**
	 * Display tour [custom post] in single page
	 *
	 * @param $template
	 *
	 * @return string
	 */
	public function register_custom_single_template( $template ) {
		
		global $post;
		
		if ( $post->post_type == "mage_tour" ) {
			$template_name = 'single-tour.php';
			$template_path = 'mage-templates/';
			$default_path  = PLUGIN_DIR . 'public/templates/';
			$template      = locate_template( array( $template_path . $template_name ) );
			if ( ! $template ) :
				$template = $default_path . $template_name;
			endif;
			
			return $template;
		}
		
		return $template;
	}
	
	/**
	 * Display tour destination template by destination taxonomy
	 *
	 * @param $template
	 *
	 * @return string
	 */
	public function register_custom_tax_template( $template ) {
		if ( is_tax( 'destination' ) ) {
			$template = PLUGIN_DIR . 'public/templates/taxonomy-destination.php';
		}
		
		return $template;
	}
	
	
	/**
	 * Show hotel details by selected hotel.
	 *
	 * This is ajax callback method for hotel selected options.
	 */
	public function show_hotel_by_option_selected() {
		
		$hotel_id = isset( $_POST['hotel_id'] ) ? $_POST['hotel_id'] : "";
		$tour_id  = isset( $_POST['tour_id'] ) ? $_POST['tour_id'] : 0;
		
		$wc_product = get_post_meta( $tour_id, 'link_wc_product', true );
		
		$room_details = maybe_unserialize( get_term_meta( $hotel_id, 'hotel_room_details', true ) );
		
		if ( ! is_array( $room_details ) ) {
			$room_details = array();
		}
		
		$tour_duration = get_post_meta( $tour_id, 'tour_duration', true );
		
		if ( empty( $tour_duration ) ) {
			$tour_duration = 1;
		}
		
		?>

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
			
			$tour_duration = get_post_meta( $tour_id,
				'tour_duration',
				true );
			
			if ( empty( $tour_duration ) ) {
				$tour_duration = 1;
			}
			
			if ( sizeof( $room_details ) > 0 ) {
				foreach ( $room_details as $room ) {
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
				
				<?php }
			} else { ?>
                <tr class="no_room">
                    <span style="color: red;font-weight: bold;text-align: center">No Room available</span>
                </tr>
			<?php } ?>


            <tr>
                <td colspan="2" class="bold_text"><?php echo esc_html__( 'Total Person',
						'woocommerce-tour-booking-manager' ); ?></td>

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
                    <button class="default-btn but_btn" disabled="disabled" name="add-to-cart"
                            value="<?php esc_attr_e( $wc_product ); ?>">
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
                            .html('<?php do_action( 'attendee_form_builder', $tour_id ); ?>')
                    );
                }

            });

        </script>
		
		<?php exit();
	}//end method show_hotel_by_option_selected
	
	
}//end class Tour_Plugin_Public

new Tour_Plugin_Public();