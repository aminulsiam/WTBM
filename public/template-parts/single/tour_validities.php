<?php
add_action( "tour_validities", "tour_validities" );

function tour_validities( $post_id ) {
	
	$tentative_start_date = get_post_meta( $post_id, 'start_date', true );
	$tentative_end_date   = get_post_meta( $post_id, 'end_date', true );
	
	$valid_form_date_format = date_i18n( "d ",
		strtotime(
			$tentative_start_date ) );
	
	$valid_form_month_year_format = date_i18n( "M 'y",
		strtotime(
			$tentative_start_date ) );
	
	$valid_till_date_format = date_i18n( "d ",
		strtotime(
			$tentative_end_date ) );
	
	$valid_till_month_year_format = date_i18n( "M 'y",
		strtotime(
			$tentative_end_date ) );
	
	$departure_point = get_post_meta( $post_id, 'departure_point', true );
	
	
	?>

    <iframe id="gmap_canvas"
            src="https://maps.google.com/maps?q=<?php _e( $departure_point ); ?>&amp;t=&amp;z=10&amp;ie=UTF8&amp;iwloc=&amp;output=embed"
            frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
            style="width: 100%;min-height: 250px;"></iframe>

    <div class="wtbmt_validities">
        <h4>Departure Time : FLEXI TIME</h4>
        <div class="row wtbmt_validities_content">
            <div class="col-md-4 col-sm-4">
                <ul>
                    <li class="text_bold">Valid From</li>
                    <li>
                        <span><?php esc_html_e( $valid_form_date_format ); ?><?php esc_html_e( $valid_form_month_year_format ); ?>
                    </li>
                </ul>
            </div>
            <div class="col-md-4 col-sm-4">
                <ul>
                    <li class="text_bold">Valid Till</li>
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
	<?php
}