/**
 * jQuery triggered when the login form is submitted
 * Ajax used to asynchronously authenticate the user on the server
 */
$('#login_form').submit(function(event) {

    $.ajax({
        url : "authenticate.php",
        type: "POST",
        data : $( "#login_form" ).serialize()
    }).done(function(response){

        $("#login_message").text(response);
        $("#login_message").addClass("success");
        $("#login_message").removeClass("error"); //removing class in case the previous request was an error

        location.reload(); // Refresh page to redirect user to the home page

    }).fail(function(response) {

        // Error handling
        $("#login_message").text(response.responseText);
        $("#login_message").addClass("error");

    });

    event.preventDefault();

});