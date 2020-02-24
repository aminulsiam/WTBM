<?php

add_action( 'wtbm_tour_inclusion_exclusion', 'wtbm_tour_inclusion_exclusion_display' );

function wtbm_tour_inclusion_exclusion_display( $tour_id ) {
	
    $inclusion = maybe_unserialize( get_post_meta( $tour_id, 'tour_inclusion', true ) );
	$exclusion = maybe_unserialize( get_post_meta( $tour_id, 'tour_exclusion', true ) );
	
	?>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
		<?php if ( is_array( $inclusion ) && sizeof( $inclusion ) > 0 ) { ?>
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#Ex1" role="tab"><?php
                    _e( 'Inclusion', 'woocommerce-tour-booking-manager' ); ?></a>
            </li>
		<?php }
		if ( is_array( $exclusion ) && sizeof( $exclusion ) > 0 ) { ?>
            <li class="nav-item">
                <a class="nav-link" id="home-tab" data-toggle="tab" href="#Ex2" role="tab"><?php _e( 'Exclusion', 'woocommerce-tour-booking-manager' ); ?></a>
            </li>
		<?php } ?>
    </ul>
    <div class="tab-content" id="myTabContent">
		<?php if ( is_array( $inclusion ) && sizeof( $inclusion ) > 0 ) { ?>
            <div class="tab-pane fade show active" id="Ex1" role="tabpanel">
                <div class="row wtbmt_exclusion_package_content">
                    <div class="col-md-12">
                        <ul>
							<?php foreach ( $inclusion as $_inclusion ) {
								?>
                                <li><?php echo $_inclusion; ?></li>
								<?php
							} ?>
                        </ul>
                    </div>
                </div>
            </div>
		<?php }
		if ( is_array( $exclusion ) && sizeof( $exclusion ) > 0 ) { ?>
            <div class="tab-pane fade" id="Ex2" role="tabpanel">
                <div class="row wtbmt_exclusion_package_content">
                    <div class="col-md-12">
                        <ul>
							<?php foreach ( $exclusion as $_exclusion ) {
								?>
                                <li><?php echo $_exclusion; ?></li>
								<?php
							} ?>
                        </ul>
                    </div>
                </div>
            </div>
		<?php } ?>
    </div>
	<?php
}