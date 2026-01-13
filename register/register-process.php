<?php 
require_once("../config/db_connect.php");

// Check if the username already exists
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc)
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	// Store the result so we can check if the account exists in the database
	$stmt->store_result();
	// Check if the account exists
	if ($stmt->num_rows > 0) {
		// Username already exists
        echo json_encode(["success" => TRUE, "message" => "Username already exists! Please choose another!"]);
	} else {

		// Insert new account

	}
	// Close the statement
	$stmt->close();
} else {
	// Something is wrong with the SQL statement, check to make sure the accounts table exists with all 3 fields.
    echo json_encode(["success" => FALSE,"message" => "Could not prepare statement!"]);
}
// Close the connection
$con->close();
?>