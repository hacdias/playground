/*
* The javascript function to send the info to the server
* and process the answer.
*/

var ajaxCall = function() {

    //Get the info from the form and put it into a variable
    data = $('#form').serialize();

    //The ajax request begins here
    $.ajax({
        /*
         * type     =>  HTTP request type (POST, GET, etc). GET is used by default.
         * url      =>  The file that will receive the info.
         * data     =>  The info obtained from the form.
         * dataType =>  The type of answer data.
         */
        type: 'POST',
        url: 'process.php',
        data: data,
        dataType: 'json'

    }).done(function(response) {

        /*
         * When the request is done, we will analyse the answer given by the server in
         * Json Format.
         *
         * This info is sent by the server and can be any other thing than a bool value.
         */

        if(response.status === true) {
            //If the answer is true, the user is alerted of the success.
            alert('Registered successfully!');
        } else {
            //Else...
            alert('Something wents wrong!');
        }

    }).fail(function(xhr, desc, err) {

        /*
         * If some error ocurred when the function try to send the info to the server,
         * the error will be sent to the console.
         */
        alert('Something wents wrong!');
        console.log(xhr);
        console.log("Details: " + desc + "\nError:" + err);

    });
}
