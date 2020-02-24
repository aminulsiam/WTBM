<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}  // if direct access

class WtbmSettings {
	
	public function __construct() {
		$this->wtbm_settings();
	}
	
	public function wtbm_set_page_settings( $page_1_options, $page_2_options, $page_3_options ) {
		
		$default = array(
			'panelGroup-10' => $page_1_options,
			'panelGroup-11' => $page_2_options,
			'panelGroup-12' => $page_3_options,
		);
		
		return apply_filters( 'wtbm_settings_array', $default );
	}
	
	private function wtbm_settings() {
		
		
		$setting_options_1 = array(
			'page_nav'      => __( '<i class="far fa-bell"></i> Genarel Settings', 'text-domain' ),
			'priority'      => 10,
			'page_settings' => array(
				
				'section_3' => array(
					'title'       => __( 'Basic Settings', 'text-domain' ),
					'nav_title'   => __( '', 'text-domain' ),
					'description' => __( '', 'text-domain' ),
					'options'     => array(
						
						array(
							'id'      => 'wtbm_time_format',
							'title'   => __( 'Time Format', 'text-domain' ),
							'details' => __( 'Description of select field', 'text-domain' ),
							'default' => '12',
							'value'   => '12',
							'type'    => 'select',
							'args'    => array(
								'12'                  => __( '12 Hour', 'text-domain' ),
								'24'                  => __( '24 Hour', 'text-domain' ),
								'wordpress_timestamp' => __( 'WordPress Timestamp', 'text-domain' ),
							),
						),
						
						
					
					
					)
				),
				
				'section_4' => array(
					'title'       => __( 'Translation Settings', 'text-domain' ),
					'nav_title'   => __( '', 'text-domain' ),
					'description' => __( '', 'text-domain' ),
					'options'     => array(
						
						array(
							'id'          => 'tour_duration_label',
							'title'       => __( 'Tour Duration Label', 'text-domain' ),
							'details'     => __( 'Description of text field', 'text-domain' ),
							'type'        => 'text',
							'default'     => 'Default Text',
							'placeholder' => __( 'Text value', 'text-domain' ),
						),
						
						array(
							'id'          => 'tour_valid_from',
							'title'       => __( 'Tour Valid From Label', 'text-domain' ),
							'details'     => __( 'Description of text field', 'text-domain' ),
							'type'        => 'text',
							'default'     => 'Valid From',
							'placeholder' => __( 'Text value', 'text-domain' ),
						),
						
						array(
							'id'          => 'tour_valid_till',
							'title'       => __( 'Tour Valid Till Label', 'text-domain' ),
							'details'     => __( 'Description of text field', 'text-domain' ),
							'type'        => 'text',
							'default'     => 'Valid Till',
							'placeholder' => __( 'Text value', 'text-domain' ),
						),
						
						
						array(
							'id'          => 'show_hotel_selecting_message',
							'title'       => __( 'Hotel selecting message label', 'text-domain' ),
							'details'     => __( 'Description of text field', 'text-domain' ),
							'type'        => 'text',
							'default'     => 'N:B - We are selecting anyone hotel from above list',
							'placeholder' => __( 'Text value', 'text-domain' ),
						),
					
					
					)
				),
			
			
			),
		);
		
		
		$page_2_options = apply_filters( 'pdf_email_settings', array() );
		
		$page_3_options = apply_filters( 'attendee_csv_settings', array() );
		
		
		$args         = array(
			'add_in_menu'     => true,
			'menu_type'       => 'sub',
			'menu_name'       => __( 'Tour Settings', 'text-domain' ),
			'menu_title'      => __( 'Tour Settings', 'text-domain' ),
			'page_title'      => __( 'Tour Settings', 'text-domain' ),
			'menu_page_title' => __( 'Tour Settings', 'text-domain' ),
			
			'capability'  => "manage_options",
			'cpt_menu'    => "edit.php?post_type=mage_tour",
			'menu_slug'   => "mage-tour-settings",
			'option_name' => "tour_manager_settings",
			'menu_icon'   => "dashicons-image-filter",
			
			'item_name'    => __( "Tour Booking Settings" ),
			'item_version' => "1.0.0",
			'panels'       => $this->wtbm_set_page_settings( $setting_options_1, $page_2_options,
				$page_3_options ),
		);
		$AddThemePage = new AddThemePage( $args );
	}
}

new WtbmSettings();