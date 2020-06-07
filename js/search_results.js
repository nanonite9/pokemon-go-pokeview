/**
 * Google Maps - This function is called when the google maps library is loaded
 * Ajax used to asynchronously retrieve and add pokestop markers to the map
 */
function initMap() {

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {

            var pokestops = JSON.parse(this.responseText);

            var map = new google.maps.Map(document.getElementById('map'));
            var bounds = new google.maps.LatLngBounds();
            var infoWindow = new google.maps.InfoWindow();

            for (i = 0; i < pokestops.length; i++) {
                addMarker(map, pokestops[i], bounds, infoWindow);
            }

            map.fitBounds(bounds);
        }
    };

    var urlParams = new URLSearchParams(window.location.search);
    let url = "get_pokestops.php?placename=" + urlParams.get('placename') + "&" +  "rating=" + urlParams.get('rating');

    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

/**
 *
 * Add pokestop marker to Google map
 *
 * @param map
 * @param pokestop
 * @param bounds
 * @param infoWindow
 */
function addMarker(map, pokestop, bounds, infoWindow) {
    var position = new google.maps.LatLng(pokestop.latitude, pokestop.longitude);
    bounds.extend(position);
    marker = new google.maps.Marker({
        position: position,
        map: map,
        title: pokestop.name
    });

    // Allow each marker to have an info window
    google.maps.event.addListener(marker, 'click', (function (marker, i) {
        return function () {
            infoWindow.setContent('<b><a style="text-decoration: underline #1E347B;" href="pokestop.php?id=' + pokestop.pokestop_id + '">' + pokestop.location_name + "</a></b><br/> " + pokestop.description);
            infoWindow.open(map, marker);
        }
    })(marker, i));
}