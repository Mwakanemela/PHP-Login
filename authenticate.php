<?php
// Start the session
session_start();
// Change the below variables to reflect your MySQL database details
require_once("config/db_connect.php");
header('Content-Type: application/json'); //tell client(browser) its a json data

// Prepare our SQL, which will prevent SQL injection
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
    // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    // Store the result so we can check if the account exists in the database
    $stmt->store_result();
    
    // Check if account exists with the input username
    if ($stmt->num_rows > 0) {
        // Account exists, so bind the results to variables
        $stmt->bind_result($id, $password);
        $stmt->fetch();
        // Note: remember to use password_hash in your registration file to store the hashed passwords
        if ($_POST['password'] === $password) {
            // Password is correct! User has logged in!
            // Regenerate the session ID to prevent session fixation attacks
            session_regenerate_id();
            // Declare session variables (they basically act like cookies but the data is remembered on the server)
            $_SESSION['account_loggedin'] = TRUE;
            $_SESSION['account_name'] = $_POST['username'];
            $_SESSION['account_id'] = $id;
            // Output success message
            //echo 'Welcome back, ' . htmlspecialchars($_SESSION['account_name'], ENT_QUOTES) . '!';
            // header('Location: home.php');
            echo json_encode(["success" => TRUE, "message" => "Login successful"]);
            exit;
        } else {
            // Incorrect password
           echo json_encode(["success" => FALSE,"message" => "Invalid details, try again or register"]);
        }
    } else {
        // Incorrect username
        echo json_encode(["success" => FALSE,"message" => "Invalid details, try again or register"]);
    }

    // Close the prepared statement
    $stmt->close();
}


?>