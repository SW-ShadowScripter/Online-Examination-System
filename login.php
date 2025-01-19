<?php
session_start();
if (isset($_SESSION["email"])) {
    session_destroy();
}
include_once 'dbConnection.php';
$ref = @$_GET['q'];
$email = $_POST['email'];
$password = $_POST['password'];

// Sanitize input
$email = stripslashes($email);
$email = addslashes($email);
$password = stripslashes($password);
$password = addslashes($password);

// Hash the password
$password = md5($password); 

// Query the database for matching user
$result = mysqli_query($con, "SELECT name FROM user WHERE email = '$email' AND password = '$password'") or die('Error in query');
$count = mysqli_num_rows($result);

// Check if the user exists
if ($count == 1) {
    while ($row = mysqli_fetch_array($result)) {
        $name = $row['name'];
    }
    $_SESSION["name"] = $name;
    $_SESSION["email"] = $email;
    header("location:account.php?q=1");  // Successful login, redirect to account page
} else {
    header("location:$ref?w=Wrong Username or Password");  // Redirect back to the login page with an error
}
?>
