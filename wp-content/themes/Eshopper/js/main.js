jQuery(document).ready(function ($) {

    /*price range*/

    $('#sl2').slider();

    var RGBChange = function () {
        $('#RGB').css('background', 'rgb(' + r.getValue() + ',' + g.getValue() + ',' + b.getValue() + ')')
    };

    var cartProductQuantity = function () {
        if ($(this).hasClass('cart_quantity_up')) {
            document.querySelector('.cart_quantity_input').value++;
        } else {
            if (document.querySelector('.cart_quantity_input').value > 1) {
                document.querySelector('.cart_quantity_input').value--;
            }
        }
    };

    $('.update').removeAttr('disabled');

    $('.js-qty-changer').on('click', cartProductQuantity);

    /*scroll to top*/

    $(function () {
        $.scrollUp({
            scrollName: 'scrollUp', // Element ID
            scrollDistance: 300, // Distance from top/bottom before showing element (px)
            scrollFrom: 'top', // 'top' or 'bottom'
            scrollSpeed: 300, // Speed back to top (ms)
            easingType: 'linear', // Scroll to top easing (see http://easings.net/)
            animation: 'fade', // Fade, slide, none
            animationSpeed: 200, // Animation in speed (ms)
            scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
            //scrollTarget: false, // Set a custom target element for scrolling to the top
            scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
            scrollTitle: false, // Set a custom <a> title if required.
            scrollImg: false, // Set true to use image
            activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
            zIndex: 2147483647 // Z-Index for the overlay
        });
    });


    function initializeMap() {

        var lat = $('.contact-map').attr('data-lat');
        var lon = $('.contact-map').attr('data-lng');

        var centerLon = lon - 0.0105;

        var myOptions = {
            scrollwheel: false,
            draggable: false,
            disableDefaultUI: true,
            center: new google.maps.LatLng(lat, centerLon),
            zoom: 15,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        //Bind map to elemet with id gmap
        var map = new google.maps.Map(document.getElementById('gmap'), myOptions);
        var marker = new google.maps.Marker({
            map: map,
            position: new google.maps.LatLng(lat, lon),

        });

        var infowindow = new google.maps.InfoWindow({
            content: "We are here!"
        });

        google.maps.event.addListener(marker, 'click', function () {
            infowindow.open(map, marker);
        });

        infowindow.open(map, marker);
    }

    initializeMap();
});
