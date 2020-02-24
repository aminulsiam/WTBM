<?php
/*
* @Author 		pickplugins
* Copyright: 	pickplugins.com
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}  // if direct access


$page_1_options = array(

	array(
		'id'          => 'hotel_image',
		'title'       => __( 'Hotel Image ', 'text-domain' ),
		'details'     => __( 'Hotel Image', 'text-domain' ),
		'placeholder' => 'https://i.imgur.com/GD3zKtz.png',
		'type'        => 'media',
	),
	
	array(
		'id'      => 'hotel_type',
		'title'   => __( 'Hotel Type', 'text-domain' ),
		'details' => __( 'Description of select field', 'text-domain' ),
		'default' => 'option_2',
		'value'   => 'option_2',
		'type'    => 'select',
		'args'    => 'TAX_%hotel_type%',
	),

	array(
		'id'          => 'hotel_room_details',
		'title'       => __( 'Hotel Room Details', '' ),
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
			array( 'type' => 'number', 'item_id' => 'person_capacity', 'name' => 'Person Capacity', 'min' => 1 )
		)
	),

	array(
		'id'		    => 'hotel_benefits',
		//'field_name'		    => 'text_multi_field',
		'title'		    => __('Hotel Benefits','text-domain'),
		'details'	    => __('Please Enter Hotel Benefits one by one','text-domain'),
		'value'		    => '',
		'default'		=> '',
		'placeholder'   => __('Text value','text-domain'),
		'type'		    => 'text_multi',
		'remove_text'   => '<i class="fas fa-times"></i>',
	),

	array(
		'id'          => 'address',
		'title'       => __( 'Address', 'text-domain' ),
		'details'     => __( 'Address', 'text-domain' ),
		'value'       => __( 'Textarea value', 'text-domain' ),
		'default'     => __( '', 'text-domain' ),
		'type'        => 'textarea',
		'placeholder' => __( 'Enter address is here', 'text-domain' ),
	),


	array(
		'id'          => 'email',
		'title'       => __( 'E-mail Address', 'text-domain' ),
		'details'     => __( 'Your email address', 'text-domain' ),
		'type'        => 'text',
		'default'     => '',
		'placeholder' => __( 'Enter email address', 'text-domain' ),
	),

	array(
		'id'          => 'phone',
		'title'       => __( 'Phone Number', 'text-domain' ),
		'details'     => __( 'Your phone number', 'text-domain' ),
		'type'        => 'text',
		'default'     => '',
		'placeholder' => __( 'Enter phone number', 'text-domain' ),
	),


);


$page_2_options = array(
	array(
		'id'          => 'city_image',
		'title'       => __( 'City Image ', 'text-domain' ),
		'details'     => __( 'City Image', 'text-domain' ),
		'placeholder' => 'https://i.imgur.com/GD3zKtz.png',
		'type'        => 'media',
	),
);


$page_3_options = array(
	array(
		'id'          => 'country_image',
		'title'       => __( 'Country Image ', 'text-domain' ),
		'details'     => __( 'Country Image', 'text-domain' ),
		'placeholder' => 'https://i.imgur.com/GD3zKtz.png',
		'type'        => 'media',
	),	
);


$page_4_options = array();


$args = array(
	'taxonomy' => 'hotel_details',
	'options'  => $page_1_options,
);


$city_args = array(
	'taxonomy' => 'destination',
	'options'  => $page_2_options,
);

$country_args = array(
	'taxonomy' => 'tour_country',
	'options'  => $page_3_options,
);

new TaxonomyEdit( $args );
new TaxonomyEdit( $city_args );
new TaxonomyEdit( $country_args );