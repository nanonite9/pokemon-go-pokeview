/**
 * jQuery triggered when the pokestop submission form is submitted
 * Ajax used to asynchronously create a new pokestop on the server
 */
$("#submission_form").submit(function(event) {

    var formData = new FormData(this); // Using FormData to serialize the submission form, including the pokestop image

    $.ajax({
        url : "add_pokestop.php",
        type: "POST",
        data : formData,
        cache: false,
        contentType: false,
        processData: false,
    }).done(function(){
        $("#submission_message").text("Pokestop successfully created!");
        $("#submission_message").addClass("success");
        $("#submission_message").removeClass("error"); //removing class in case the previous request was an error
        $("#submission_form").hide();
    }).fail(function(response) {

        // Error handling
        $("#submission_message").text(response.responseText);
        $("#submission_message").addClass("error");
    });

    event.preventDefault();

});

/**
 * Get user's geolocation from the browser
 */
function getGeoLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        var messageElement = document.getElementById("error_response");
        messageElement.innerHTML = "Geolocation is not supported by this browser.";
    }
}

/**
 * Add geolocation to a html element
 * @param position
 */
function showPosition(position) {
    var locationElement = document.getElementById("location");
    locationElement.value = position.coords.latitude + "," + position.coords.longitude;
    locationElement.focus();

    var messageElement = document.getElementById("error_response");
    messageElement.innerHTML = "";
}

/**
 * Display error message to user
 * @param error
 */
function showError(error) {
    var messageElement = document.getElementById("error_response");

    switch (error.code) {
        case error.PERMISSION_DENIED:
            messageElement.innerHTML = "User denied the request for Geolocation."
            break;
        case error.POSITION_UNAVAILABLE:
            messageElement.innerHTML = "Location information is unavailable."
            break;
        case error.TIMEOUT:
            messageElement.innerHTML = "The request to get user location timed out."
            break;
        case error.UNKNOWN_ERROR:
            messageElement.innerHTML = "An unknown error occurred."
            break;
    }
    messageElement.className = "error_message"
}