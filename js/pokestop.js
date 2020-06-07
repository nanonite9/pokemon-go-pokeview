/**
 * jQuery triggered when a review form is submitted
 * Ajax used to asynchronously create a new review against a pokestop
 */
$('#review_form').submit(function(event) {

    var urlParams = new URLSearchParams(window.location.search);

    $.ajax({
        url : "add_review.php?id=" + urlParams.get('id'),
        type: "POST",
        data : $( "#review_form" ).serialize() // Serialize form fields for transmission
    }).done(function(response){

        var review = JSON.parse(response);

         // Add review to existing html table if the table exists in the DOM
        if($('#reviews_table').length) {
            $('#reviews_table tr:first').after(
                '<tr>' +
                '<td>' + review.username + '</td>' +
                '<td>' + review.review + '</td>' +
                '<td><img src="media/rating/' + review.rating + '.png" style="margin:auto; width:50px; height:auto;" /></td>' +
                '<td>' + review.date_created + '</td>' +
                '</tr>');
        } else {
            //Otherwise create a new table
            $('#no_reviews').hide();
            createTable(new Array(review));
        }

        $( "#review_form" ).hide(); // Hide form from user to stop consecutive reviews from being added accidentally

        $("#response_message").text("Review has been added!");
        $("#response_message").addClass("success");
        $("#response_message").removeClass("error");
    }).fail(function(response) {

        // Error handling
        $("#response_message").text(response.responseText);
        $("#response_message").addClass("error");
    });

    event.preventDefault(); // Terminate original submit form event to prevent page refresh

});

/**
 * jQuery triggered to add pokestop reviews upon loading the "#review_list" element in the DOM
 * Ajax used to asynchronously retrieve reviews associated to the pokestop and display it in a html table
 */
$('#review_list').ready(function() {

    var urlParams = new URLSearchParams(window.location.search);

    $.ajax({
        url: "get_reviews.php?id=" + urlParams.get('id'),
        type: "GET"
    }).done(function(reviewsList) {

        if(reviewsList.length > 0) {
            createTable(reviewsList); // Add all reviews to table
        } else {
            $('#review_list').append("<div id='no_reviews'><h6>No reviews found</h6></div>"); // Display 'No reviews found'
        }
    }).fail(function(response){

        // Error handling
        $("#response_message").text(response.responseText);
        $("#response_message").addClass("error");
    });

});

/**
 * Create a html table and add pokestop reviews
 * @param reviews - Array of reviews
 */
function createTable(reviews) {
    var table = "<table id='reviews_table'><tr><th>Username</th><th>Review</th><th>Rating</th><th>Date</th></tr>";
    reviews.forEach(review => {
        table += "<tr>" +
                "<td>" + review.username + "</td>" +
                "<td>" + review.review + "</td>" +
                "<td><img src=\"media/rating/" + review.rating + ".png\" style=\"margin:auto; width:50px; height:auto;\" /></td>" +
                "<td>" + review.date_created + "</td>" +
            "</tr>"
    });
    table += "</table>";

    $('#review_list').append(table);
}

/**
 * Google Maps - This function is called when the google maps library is loaded
 */
function initMap() {

    var latitude = $("#location").data("latitude");
    var longitude = $("#location").data("longitude");

    var position = {lat: latitude, lng: longitude};

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 19, center: position
    });

    new google.maps.Marker({position: position, map: map, title: "Latitude: " + latitude + ", Longitude: " + longitude});
}
