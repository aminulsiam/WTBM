<?php
add_action('wtbm_tour_extra_details','wtbm_tour_extra_display');
function wtbm_tour_extra_display($tour_id){
    $more_details    = maybe_unserialize( get_post_meta( $tour_id, 'more_details',
    true ) );   
	if ( is_array( $more_details ) && sizeof( $more_details ) > 0 && ! empty( $more_details ) ) {     
    ?>
<div class="panel-group wtbmt_accor_padding_top" id="accordion" role="tablist" aria-multiselectable="true">						
                                <?php
								$panel_number = 1;								
								foreach ( $more_details as $more_detail ) {
							    ?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="heading<?php echo $panel_number; ?>">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion"
                                                   href="#collapse<?php echo $panel_number; ?>"
                                                   aria-expanded="false" class="collapsed"
                                                   aria-controls="collapse<?php echo $panel_number; ?>">
													<?php echo esc_html( ucfirst( $more_detail['details_topic'] ) ); ?>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapse<?php echo $panel_number; ?>" class="panel-collapse collapse"
                                             role="tabpanel"
                                             aria-labelledby="heading<?php echo $panel_number; ?>">
                                            <div class="panel-body">
                                                <p>
													<?php echo esc_html( ucfirst( $more_detail['details'] ) ); ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>									
									<?php $panel_number ++; } ?>
						</div>    
    <?php
    }
}