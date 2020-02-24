<?php 
add_action('wtbm_gallery_slider','wtbm_gallery_slider_display');
function wtbm_gallery_slider_display(){
    ?>

                        <div class="wtbmt_home_slider owl-carousel">							
                            <?php
							$gallary_images = maybe_unserialize( get_post_meta( get_the_ID(), 'tour_gallary_image', true ) );							
							if ( ! is_array( $gallary_images ) ) {
								$gallary_images = array();
							}							
							the_post_thumbnail();							
							foreach ( $gallary_images as $images ) {
								?>
                                <div class="wtbmt_hero_bg">
									<?php echo wp_get_attachment_image( $images, array( 1000, 800 ) ); ?>
                                </div>
							<?php } ?>
						</div>
<?php
}