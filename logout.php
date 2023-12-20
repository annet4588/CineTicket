<?php
include("header.php");
$pageTitle = "Logout";
// session_start(); // Start or resume the session

// Check if the user is logged in
if (isset($_SESSION['user_email'])) {
    // Unset all session variables
    session_unset();

    // Destroy the session
    session_destroy();

    // Redirect to the login page or any other page as needed
    header("Location: login.php"); // Replace "login.php" with your login page URL
    exit();
} else {
    // If the user is not logged in, redirect to the login page
    header("Location: login.php"); // Replace "login.php" with your login page URL
    exit();
}
?>