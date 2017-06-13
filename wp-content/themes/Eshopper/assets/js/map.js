jQuery(document).ready(function ($) {
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

