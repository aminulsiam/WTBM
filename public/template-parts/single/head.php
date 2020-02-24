<?php 
add_action('wtbm_single_title','wtbm_single_title_display');
function wtbm_single_title_display($tour_id){
?>
  <h2><?php the_title(); ?></h2> 
<?php
}