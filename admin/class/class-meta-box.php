<?php
/*
* @Author 		pickplugins
* Copyright: 	pickplugins.com
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}  // if direct access

/**
 * Class Woo_Tour_Meta
 */
class Woo_Tour_Meta {
	
	public function __construct() {
		$this->metabox();
		
		add_action( 'save_post', array( $this, 'update_price_of_tour_pakage' ) );
	}
	
	/**
	 * @param $post_id
	 */
	public function update_price_of_tour_pakage( $post_id ) {
		global $post;
		if ( $post ) {
			if ( $post->post_type != 'mage_tour' ) {
				return;
			}
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}
			$update_price = update_post_meta( $post_id, '_price', 0 );
		}
	}//end method update_price_of_ticket
	
	/**
	 *
	 */
	public function metabox() {
		
		$page_1_options = array(
			
			'page_nav' => __( '<i class="far fa-dot-circle"></i> Nav Title 1', 'woocommerce-tour-booking-manager' ),
			'priority' => 10,
			'sections' => array(
				
				'section_0' => array(
					'title'       => __( '', 'woocommerce-tour-booking-manager' ),
					'description' => __( '', 'woocommerce-tour-booking-manager' ),
					'options'     => array(
						
						array(
							'id'      => 'tour_gallary_image',
							'title'   => __( 'Tour Gallary Images', 'woocommerce-tour-booking-manager' ),
							'details' => __( 'Please upload images for this tour', 'woocommerce-tour-booking-manager' ),
							'type'    => 'media_multi',
						),
						
						array(
							'id'          => 'departure_point',
							'title'       => __( 'Departure Point Name', 'woocommerce-tour-booking-manager' ),
							'details'     => __( 'Write tour Departure point', 'woocommerce-tour-booking-manager' ),
							'type'        => 'text',
							'default'     => '',
							'placeholder' => __( 'Enter your Departure point Name', 'woocommerce-tour-booking-manager' ),
						),
						
						
						array(
							'id'      => 'google_map_display',
							'title'   => __( 'Display Google Map', 'woocommerce-tour-booking-manager' ),
							'details' => __( 'If it is checked then show google map.', 'woocommerce-tour-booking-manager' ),
							'default' => array( 'option_3', 'option_2' ),
							'value'   => 'on',
							'type'    => 'checkbox',
							'args'    => array(
								'on' => __( '', 'woocommerce-tour-booking-manager' ),
							),
						),
						
						array(
							'id'      => 'tour_offer_type',
							'title'   => __( 'Tour Type', 'woocommerce-tour-booking-manager' ),
							'details' => __( 'You can select your tour offer type,',
								'woocommerce-tour-booking-manager' ),
							'default' => 'Fixed',
							'value'   => 'fixed',
							'type'    => 'select',
							'args'    => array(
								'flexible' => __( 'Flexible', 'woocommerce-tour-booking-manager' ),
								'fixed'    => __( 'Fixed', 'woocommerce-tour-booking-manager' )
							),
						),
						
						array(
							'id'      => 'tour_duration',
							'title'   => __( 'Tour Duration', 'woocommerce-tour-booking-manager' ),
							'details' => __( 'Write your tour duration days, like What is the number of nights of your tour. Example : 3 ', 'woocommerce-tour-booking-manager' ),
							'type'    => 'text',
							'min' => 1,
							'max' => 30,
						),
						
						array(
							'id'          => 'start_date',
							'title'       => __( 'Tour Start Date', 'woocommerce-tour-booking-manager' ),
							'details'     => __( 'Start date of tour', 'woocommerce-tour-booking-manager' ),
							'date_format' => 'yy-mm-dd',
							'placeholder' => 'yy-mm-dd',
							'default'     => '', // today date
							'value'       => '', // today date
							'type'        => 'datepicker',
						),
						
						array(
							'id'          => 'end_date',
							'title'       => __( 'Tour end date', 'woocommerce-tour-booking-manager' ),
							'details'     => __( 'End date of tour', 'woocommerce-tour-booking-manager' ),
							'date_format' => 'yy-mm-dd',
							'placeholder' => 'yy-mm-dd',
							'default'     => '', // today date
							'value'       => '', // today date
							'type'        => 'datepicker',
						
						),
						
						array(
							'id'          => 'tour_daywise_details',
							'title'       => __( 'Tour Daywise Details', '' ),
							'details'     => __( 'You can write every days plane', '' ),
							'type'        => 'repeatable',
							'default'     => '',
							'collapsible' => true,
							'sortable'    => false,
							'title_field' => 'day_title',
							
							'fields' => array(
								
								array(
									'type'        => 'text',
									'item_id'     => 'day_title',
									'name'        => 'Title',
									'placeholder' => "hello"
								),
								
								array(
									'type'        => 'textarea',
									'item_id'     => 'day_details',
									'name'        => 'Day Details',
									'placeholder' => "hello"
								),
							
							)
						),
						
						array(
							'id'          => 'more_details',
							'title'       => __( 'Tour More Details', '' ),
							'details'     => __( 'You can write details like cancellation policy,Tax etc',
								'' ),
							'type'        => 'repeatable',
							'default'     => '',
							'collapsible' => true,
							'sortable'    => false,
							'title_field' => 'details_topic',
							
							'fields' => array(
								
								array(
									'type'    => 'text',
									'item_id' => 'details_topic',
									'name'    => 'Details Topic',
									'default' => ''
								),
								array(
									'type'    => 'textarea',
									'item_id' => 'details',
									'name'    => 'Details',
									'default' => ''
								),
							
							)
						),
						array(
							'id'		    => 'tour_inclusion',
							//'field_name'		    => 'text_multi_field',
							'title'		    => __('Tour Inclusion','text-domain'),
							'details'	    => __('Please Enter What services are include with this tour one by one','text-domain'),
							'value'		    => '',
							'default'		=> '',
							'placeholder'   => __('Ex: Relish candle light dinner on beach','text-domain'),
							'type'		    => 'text_multi',
							'remove_text'   => '<i class="fas fa-times"></i>',
						),
						array(
							'id'		    => 'tour_exclusion',
							//'field_name'		    => 'text_multi_field',
							'title'		    => __('Tour Exclusions','text-domain'),
							'details'	    => __('Please Enter What services are exclude with this tour one by one','text-domain'),
							'value'		    => '',
							'default'		=> '',
							'placeholder'   => __('Ex: Relish candle light dinner on beach','text-domain'),
							'type'		    => 'text_multi',
							'remove_text'   => '<i class="fas fa-times"></i>',
						),













					)
				),
			
			),
		);
		
		
		$meta_1_options = array(
			
			'page_nav' => __( '<i class="far fa-dot-circle"></i> Nav Title 1', 'woocommerce-tour-booking-manager' ),
			'priority' => 10,
			'sections' => array(
				
				'section_0' => array(
					'title'       => __( '', 'woocommerce-tour-booking-manager' ),
					'description' => __( '', 'woocommerce-tour-booking-manager' ),
					'options'     => array(
						
						
						array(
							'id'      => 'tour_price_source',
							'title'   => __( 'Tour Price Source', 'woocommerce-tour-booking-manager' ),
							'details' => __( 'Please select this tour price source. If you want to use hotel room pricing as this tour price then please select Hotel from above or if you want to set your own pricing then select Tour from above and set your prining by click Tour Pricing button below', 'woocommerce-tour-booking-manager' ),
							'default' => 'hotel',
							// 'value'   => 'on',
							'type'    => 'radio',
							'args'    => array(
								'hotel' => __( 'Hotel', 'woocommerce-tour-booking-manager' ),
								'tour'  => __( 'Tour', 'woocommerce-tour-booking-manager' )
							
							),
						),
						
						
						array(
							'id'          => 'hotel_room_details',
							'title'       => __( 'Tour Pricing', '' ),
							'details'     => __( '', '' ),
							'type'        => 'repeatable',
							'default'     => '',
							'collapsible' => true,
							'sortable'    => false,
							'title_field' => 'room_type',
							'fields'      => array(
								array( 'type' => 'text', 'item_id' => 'room_type', 'name' => 'Room Type' ),
								array( 'type' => 'text', 'item_id' => 'room_fare', 'name' => 'Room Fare' ),
								array( 'type' => 'text', 'item_id' => 'room_qty', 'name' => 'Room Quantity' ),
								array(
									'type'    => 'number',
									'item_id' => 'person_capacity',
									'name'    => 'Person Capacity',
									'min'     => 1
								)
							)
						),
					
					
					)
				),
			
			),
		);
		
		
		$page_2_options = array(
			
			'page_nav' => __( '<i class="fas fa-cog"></i> Nav Title 2', 'woocommerce-tour-booking-manager' ),
			'priority' => 10,
			'sections' => array(),
		);
		
		
		$page_3_options = array(
			
			'page_nav' => __( '<i class="far fa-bell"></i> Nav Title 3', 'woocommerce-tour-booking-manager' ),
			'priority' => 10,
			'sections' => array(),
		);
		
		
		$page_4_options = array(
			
			'page_nav' => __( '<i class="fas fa-bomb"></i> Nav Title 4', 'woocommerce-tour-booking-manager' ),
			'priority' => 10,
			'sections' => array(),
		);
		
		
		$metabox_1 = array(
			'meta_box_id'    => 'post_meta_box_1',
			'meta_box_title' => __( 'Tour Booking Information', 'woocommerce-tour-booking-manager' ),
			'screen'         => array( 'mage_tour' ),
			'context'        => 'normal', // 'normal', 'side', and 'advanced'
			'priority'       => 'high', // 'high', 'low'
			'callback_args'  => array(),
			'nav_position'   => 'none', // right, top, left, none
			'item_name'      => "PickPlugins",
			'item_version'   => "1.0.2",
			'panels'         => array(
				'panelGroup-1' => $page_1_options,
				'panelGroup-2' => $page_2_options,
				'panelGroup-3' => $page_3_options,
				'panelGroup-4' => $page_4_options,
			
			),
		);
		
		
		$pricing_setup = array(
			'meta_box_id'    => 'post_meta_box_2',
			'meta_box_title' => __( 'Pricing Setup', 'woocommerce-tour-booking-manager' ),
			//'callback'       => '_meta_box_callback',
			'screen'         => array( 'mage_tour' ),
			'context'        => 'normal', // 'normal', 'side', and 'advanced'
			'priority'       => 'high', // 'high', 'low'
			'callback_args'  => array(),
			'nav_position'   => 'none', // right, top, left, none
			'item_name'      => "PickPlugins",
			'item_version'   => "1.0.2",
			'panels'         => array(
				'panelGroup-1' => $meta_1_options,
				'panelGroup-2' => $page_2_options,
				'panelGroup-3' => $page_3_options,
				'panelGroup-4' => $page_4_options,
			
			),
		);
		
		
		$AddMenuPage1 = new AddMetaBox( $metabox_1 );
		$AddMenuPage2 = new AddMetaBox( $pricing_setup );
		
	}//end method metabox
}

new Woo_Tour_Meta();


