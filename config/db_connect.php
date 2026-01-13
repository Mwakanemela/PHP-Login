<?php 

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'practicals';
// Try and connect using the info above
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
// Check for connection errors
if (mysqli_connect_errno()) {
    // If there is an error with the connection, stop the script and display the error
    exit('Failed to connect to MySQL!');
}

// Now we check if the data from the login form was submitted, isset() will check if the data exists
if (!isset($_POST['username'], $_POST['password'])) {
    // Could not get the data that should have been sent
    exit('Please fill both the username and password fields!');
}

?>