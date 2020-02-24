(function ($) {

    $(document).ready(function () {

        // selected hotel details show by selected options
        $('.hotel_list').on('change', function () {
            var $hotel = $(this).val();
            var $tour = $(this).data('id');

            if ('other' == $hotel) {
                $('.hotel_details').addClass('no_hotel');
                $('.hotel_details').removeClass('display_hotel');
            } else {
                $('.hotel_details').addClass('display_hotel');
                $('.hotel_details').removeClass('no_hotel');

                $.ajax({
                    type: 'POST',
                    url: woo_tour.ajaxurl,
                    data: {
                        'action': 'show_hotel_by_option_selected',
                        'hotel_id': $hotel,
                        'tour_id': $tour,
                    },
                    dataType: "text",
                    success: function (data) {
                        $(".hotel_details").html(data);
                    },

                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }

                });

            }
        });//end selected options hotel room details


        // add to cart button disable if no of traveller is 0
        $('.hotel_details').on('change', '.total_person', function () {

            var inputs = jQuery(this).val() || 0;
            var input = parseInt(inputs);

            if (input > 0) {
                $('.pop_up_add_to_cart_button').attr('disabled', false);
                $('.error_text').hide();
            } else {
                $('.pop_up_add_to_cart_button').attr('disabled', true);
                $('.error_text').show();
            }
        });


        //total price fare and max person calculation
        $(".hotel_details").on("change", ".qty", function () {

            var total_room_price = 0;
            var total_person = 0;

            $(".qty").each(function () {

                var room_val = $(this).closest("tr").find(".price-td .room_price").text();
                var person_val = $(this).closest("tr").find(".price-td .person_capacity").text();

                total_room_price = parseInt(total_room_price + ($(this).val() * room_val || 0));
                total_person = parseInt(total_person + ($(this).val() * person_val || 0));

                $(".total").text(total_room_price);

                $(".total").text(total_room_price);

                $(".total_person").attr({"max": total_person});

            });//end total fare calculation and max person allowed

        });


        // fire this script when click on buy now
        $('.buy_now_btn').on('click', function (e) {

            e.preventDefault();

            $("#cart_box_popup").show(1000);
            $(".right_side_btn").hide(1000);
        });


        //add to cart button disabled if total person is 0
        $('.hotel_details').on('change', '.total_person', function () {

            var $total_person = $(this).val();

            if ($total_person > 0) {
                $('.but_btn').attr("disabled", false);
            } else {
                $('.but_btn').attr("disabled", true);
            }

        });


        // // search autocomplete
        // $(".search").autocomplete({
        //     source: woo_tour.pakages,
        // });

        //prevent mouse scrolling for total person selected
        $('.hotel_details').on('mousewheel', '.total_person', function () {
            return false;
        });

    });
}(jQuery));
