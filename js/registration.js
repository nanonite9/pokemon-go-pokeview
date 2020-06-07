
/**
 * jQuery triggered when the registration form is submitted
 * Ajax used to asynchronously create a new user on the server
 */
$( "#registration_form").submit(function( event ) {

    try {
        // Client-side validation
        validateEmail(document.registration_form.email);
        validateGender(document.registration_form.gender);
        validateDob(document.registration_form.dob);
        validateUsername(document.registration_form.username);
        validatePassword(document.registration_form.pwd);

        //Submit form to backend
        $.ajax({
            url : "register_user.php",
            type: "POST",
            data : $( "#registration_form" ).serialize()
        }).done(function(response){
            $("#registration_message").text(response);
            $("#registration_message").addClass("success");
            $("#registration_message").removeClass("error"); //removing class in case the previous request was an error

            $("#registration_form").hide();
        }).fail(function(response) {

            // Error handling
            $("#registration_message").text(response.responseText);
            $("#registration_message").addClass("error");
        });

    } catch (err) {
        $("#registration_message").addClass("error");
        $("#registration_message").text(err);
    }

    $("#registration_message").focus();

    event.preventDefault(); // Terminate original submit form event to prevent page refresh
});

/**
 * Using jQuery and jQuery UI to add a datepicker functionality to the date of birth field
 */
$( function() {
    $( "#dob" ).datepicker({
        yearRange: '1920:2010',
        changeMonth: true,
        changeYear: true});
} );

/**
 * Validate date of birth
 * @param dob
 */
function validateDob(dob) {
    var format = /^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/;
    if (!dob.value.match(format)) {
        throw "Invalid date of birth";
    }
    dob.focus();
}

/**
 * Validate email
 * @param email
 */
function validateEmail(email) {
    var format = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (!email.value.match(format)) {
        throw "Invalid email address!";
    }
    email.focus();
}

/**
 * Validate username
 * @param username
 */
function validateUsername(username) {
    var format = /^[a-z0-9]+$/i;
    if (!username.value.match(format)) {
        throw "Invalid username: letters, numbers or underscores only";
    }
    username.focus();
}

/**
 * Validate password
 * @param password
 */
function validatePassword(password) {
    var format = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{5,20}$/;
    /* post reference */
    /* at least one lowercase, one uppercase, one numeric, one special, 5,20*/
    /* nts: i switched up the order... ref: https://www.w3resource.com/javascript/form/password-validation.php */
    if (!password.value.match(format)) {
        throw "Invalid password: at least one lowercase, one uppercase, one special character, and one numeric; must be 5-20 letters long only";
    }

    password.focus();
}

/**
 * Validate gender
 * @param gender
 */
function validateGender(gender) {
    if (gender.value === "") {
        throw "Must choose a gender option!";
    }
}