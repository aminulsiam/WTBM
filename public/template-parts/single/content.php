<?php
add_action('wtbm_tour_content','wtbm_tour_content_display');
function wtbm_tour_content_display(){
    the_content();
}