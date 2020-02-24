<?php get_header(); ?>
<!doctype html>
<html lang="en">

<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tour Booking HTML Template</title>
</head>

<body>
<!--  Preloader  -->
<!--<div class="preloader">
    <div class="status-mes">
        <div class="bigSqr">
            <div class="square first"></div>
            <div class="square second"></div>
            <div class="square third"></div>
            <div class="square fourth"></div>
        </div>
        <div class="text_loading text-center">loading</div>
    </div>
</div>-->


<!--mobile_menu add-->
<div id="mobilenav"></div>


<!--Start Hero-area section-->
<section id="wtbmt_form_1_area" class="package_listing_area"
         style="background-image: url(<?php echo PLUGIN_URL; ?>public/assets/img/banner/img2.jpg);  background-position: center center; background-size: cover;">
    <div class="wtbmt_offer_title text-center">
        <a href="#"><span>Member's Saving - Unlock up to $350</span></a>
    </div>
    <div class="container">
        <div id="wtbmt_form_area" class="package_listing_area_content">
            <div class="row justify-content-center">
                <div class="col-md-8 col-sm-12 col-xs-12">
                    <div class="wtbmt_form_area">
                        <div class="wtbmt_banner_title text-center">
                            <h1>Tour Package</h1>
                        </div>
                        <form id="wtbmt_wanderlust_form1" action="#">
                            <div class="wtbmt_form__item form__item_select">
                                <div class="wtbmt_custom_select map_marker">
                                    <select>
                                        <option value="0">Your Destinaion</option>
                                        <option value="SanFrancisco">Barishal District</option>
                                        <option value="NewYork">Rangamati District</option>
                                        <option value="California">Dinajpur District</option>
                                        <option value="California">Cox's Bazar District</option>
                                        <option value="California">Rangpur District</option>
                                    </select>
                                </div>
                            </div>
                            <div class="wtbmt_form__item calander_icon">
                                <div class="wtbmt_form__item_datepicker">
                                    <input type="text" name="checkin_display" class="wtbmt_datepicker"
                                           placeholder="Select Your Date" id="datepicker" value="" readonly="">
                                </div>
                            </div>
                            <div class="wtbmt_form__item form__item_submit">
                                <input type="submit" value="Find Your Destination">
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!--Start Body-Wrapper-area section-->
<section class="wtbmt_packege_wrapper_area">
    <div class="container">
        <div class="row">
            <!-- Start Left-Side-Bar -->
            <div class="col-12 col-md-3">
                <div class="wtbmt_wrapper_off_left">
                    <div class="wtbmt_catagory_area_title">
                        <h4>Select All Filter</h4>
                    </div>
                    <div class="wtbmt_package_catagory">
                        <div class="wtbmt_catagory">
                            <h4>Categories</h4>
                            <div class="package_catagory_content">
                                <ul>
                                    <li class="active"><a href="#">Family</a></li>
                                    <li><a href="#">Couple</a></li>
                                    <li><a href="#">Friends Group</a></li>
                                    <li><a href="#">Single</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="wtbmt_catagory border_top">
                            <h4>Duration ( in Days )</h4>
                            <div class="package_catagory_content">
                                <ul>
                                    <li class="active"><a href="#">1 to 3 Days</a></li>
                                    <li><a href="#">4 to 6 Days</a></li>
                                    <li><a href="#">7 to 9 Days</a></li>
                                    <li><a href="#">10 to 12 Days</a></li>
                                    <li><a href="#">13 or more Days</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="wtbmt_catagory border_top">
                            <h4>Hotel Star Rating</h4>
                            <div class="package_catagory_content">
                                <ul>
                                    <li class="active"><a href="#">3 Star</a></li>
                                    <li><a href="#">4 Star</a></li>
                                    <li><a href="#">5 Star</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="wtbmt_catagory border_top">
                            <h4>Tour Package Budget</h4>
                            <div class="package_catagory_content">
                                <ul>
                                    <li class="active"><a href="#">$200 to $500 </a></li>
                                    <li><a href="#">$500 to $800</a></li>
                                    <li><a href="#">$800 to $1000</a></li>
                                    <li><a href="#">Above $1000 </a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="wtbmt_catagory border_top">
                            <h4>Other Benifits</h4>
                            <div class="package_catagory_content">
                                <ul>
                                    <li class="active"><a href="#">Breakfast</a></li>
                                    <li><a href="#">Free Lunch</a></li>
                                    <li><a href="#">Entry Fee</a></li>
                                    <li><a href="#">Transport</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-9">
                <div class="wtbmt_top_bar">
                    <ul class="wtbmt_top_bar_tag">
                        <li><h4>Explore best selling packages for</h4></li>
                        <li>Bangladesh</li>
                        <li>International</li>
                        <li><h4>255 Tour Packages Showing</h4></li>
                    </ul>
                </div>

                <!-- Travelling Package -->
				
				<?php
				
				$term_id = get_queried_object()->term_id;
				
				$args = array(
					'post_type'      => array( 'mage_tour' ),
					'posts_per_page' => - 1,
					'tax_query'      => array(
						array(
							'taxonomy' => 'destination',
							'field'    => 'term_id',
							'terms'    => $term_id
						)
					)
				);
				
				$loop = new WP_Query( $args );
				
				if ( ! empty( $loop->posts ) && count( $loop->posts ) > 0 ) {
					foreach ( $loop->posts as $post ) {
						the_post();
						?>

                        <div class="wtbmt_single_package">
                            <div class="wtbmt_package_image_left">
                                <div class="featured_img"><?php the_post_thumbnail(); ?></div>
                            </div>
                            <div class="wtbmt_package_content_right">
                                <ul>
                                    <li><h4><?php the_title(); ?></h4></li>
                                    <li><span class="package_date">Start From $300.00</span></li>
                                </ul>
                                <p><?php echo mb_substr( get_the_content(), 0, 140 ); ?>...</p>
								
								<?php
								$tour_pakage_type = get_the_terms( get_the_ID(),
									'tour_pakage_types' );
								
								
								?>

                                <ul class="wtbmt_package_shedule">
                                    <li>7 Days & 6 Nights</li>
                                    <li class="active_color">
										<?php echo ucfirst( $tour_pakage_type[0]->name ) . " Pakage "; ?>
                                    </li>
                                    <li><a href="<?php the_permalink(); ?>" class="btn_tour">View Tour</a></li>
                                </ul>

                                <div class="row border_top">
                                    <div class="col-md-6">
                                        <div class="wtbmt_package_benefits">
                                            <p>Other Benefits (On Arrival)</p>
                                            <ul class="wtbmt_package_benefits_icon">
                                                <li>
                                                    <img src="<?php echo PLUGIN_URL; ?>public/img/breakfast.png"><span>Breakfast</span>
                                                </li>
                                                <li>
                                                    <img src="<?php echo PLUGIN_URL; ?>public/img/lunch.png"><span>Free Lunch</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="wtbmt_package_benefits">
                                            <p>Hotel included in package</p>
                                            <ul class="wtbmt_package_benefits_icon">
                                                <li><span>3 Start</span></li>
                                                <li><span>4 Start</span></li>
                                                <li><span>5 Start</span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
					
					<?php }
				} else {
					echo "<h1>No Tour Found</h1>";
				} ?>


                <div class="pagination_nav">
                    <a href="#" class="pagination_btn">Prev</a>
                    <a href="#" class="active">1</a>
                    <a href="#">2</a>
                    <a href="#">2</a>
                    <a href="#">3</a>
                    <a href="#">4</a>
                    <a href="#">7</a>
                    <a href="#">9</a>
                    <a href="#">...</a>
                    <a href="#" class="pagination_btn">Next</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--End Body-Wrapper-area section-->


<?php get_footer(); ?>
<!-- footer section end -->


<!--BACK TO TOP BUTTON-->
<a href="#" class="scrollToTop"></a>

</body>

</html>