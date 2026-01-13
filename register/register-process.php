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
        echo json_encode(["success" => FALSE, "message" => "Username already exists! Please choose another!"]);
	} else {

		// Insert new account
        // Declare variables
        $registered = date('Y-m-d H:i:s');
        // We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in
        // $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $password = $_POST['password'];
        // Username does not exist, insert new account
        if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email, registered) VALUES (?, ?, ?, ?)')) {
            // Bind POST data to the prepared statement
            $stmt->bind_param('ssss', $_POST['username'], $password, $_POST['email'], $registered);
            $stmt->execute();
            // Output success message
            echo json_encode(["success" => TRUE, "message" => "You have successfully registered! You can now login!"]);
        } else {
            // Something is wrong with the SQL statement, check to make sure the accounts table exists with all 3 fields
            echo json_encode(["success" => FALSE, "message" => "Could not prepare statement!"]);
        }
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