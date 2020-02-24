<?php 
add_action('wtbm_tour_daywise_plan','wtbm_tour_daywise_plan_display');
function wtbm_tour_daywise_plan_display($tour_id){
	$daywise_details = maybe_unserialize( get_post_meta($tour_id,'tour_daywise_details', true ) );
	if ( is_array( $daywise_details ) && sizeof( $daywise_details ) > 0 && ! empty( $daywise_details ) ) {
    ?>
						<ul class="nav nav-tabs" id="myTab" role="tablist">
						<?php
							$tab_number = 1;
							foreach ( $daywise_details as $daywise_detail ) {
								?>
                                <li class="nav-item">
                                    <a class="nav-link <?php if($tab_number == 1){ echo 'active'; } ?>" id="home-tab" data-toggle="tab"
                                       href="#tab<?php echo $tab_number; ?>"
                                       role="tab"><?php echo esc_html( ucfirst( $daywise_detail['day_title'] ) ); ?></a>
                                </li>
								<?php $tab_number ++;
							} ?>																	
                        </ul>
                        
                        <div class="tab-content" id="myTabContent">
							<?php
							$tab_number = 1;							
							foreach ( $daywise_details as $daywise_detail ) {
								?>
                                <div class="tab-pane fade show <?php if($tab_number == 1){ echo 'active'; } ?> " id="tab<?php echo $tab_number; ?>"
                                     role="tabpanel">
                                    <div class="travel_content">
                                        <h4><?php echo esc_html( ucfirst( $daywise_detail['day_title'] ) ); ?></h4>
                                        <p><?php echo esc_html( ucfirst( $daywise_detail['day_details'] ) ); ?></p>                                      
                                    </div>
                                </div>
								
								<?php $tab_number ++;
							}                                                         
                            ?>																																
						</div>

	<?php
	}
}