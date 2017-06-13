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


    $('.js-filter').on('click', function (e) {
            e.preventDefault();
            var brand = '';
            var productCat = '';
            if (typeof $(this).data('brand') !== "undefined") {
                brand = $(this).data('brand');
            }
            if (typeof $(this).data('cat') !== "undefined") {
                productCat = $(this).data('cat');
            }
            if (document.documentElement.clientWidth <= 800) {
                $('.investments-categories ul').toggle();
                $('.select div').toggleClass('rotate-arrow');
            }
            var requestData = {
                'action': 'filterproducts'
            };
            if (brand != "") {
                requestData.brand = brand;
            }
            if (productCat != "") {
                requestData.productCat = productCat;
            }
            $.ajax({
                url: ajaxReq.url,
                data: requestData,
                type: 'POST',
                success: function (data) {
                    if (data) {
                        $('.items-container').html(data.html);
                        current_page = 1;
                        max_pages = data.max_num_pages;
                    }
                }
            });
        }
    );
    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    };
    $('.product-overlay .add-to-cart').on('click', function (e) {
        e.preventDefault();
        var id = getParameterByName('add-to-cart', $(this).attr('href'));
        alert(ajaxReq.cartUrl);
        $.ajax({
            url: ajaxReq.cartUrl,
            data: {'add-to-cart': id},
            type: 'GET',
            success: function (data) {
            }
        });
    });
    $('i.toggle').on('click', function (e) {
        e.preventDefault();
        $('#' + $(this).data('slug')).toggle();
    });

});
