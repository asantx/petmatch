<?php
session_start();
include('../db/config.php'); // Include the DB connection
include('../functions/user_functions.php'); // Include the user-related functions

// Check if the user is logged in and has Super Admin role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 1) {
    echo "Unauthorized";
    exit();
}

// Check if user_id is set and delete the user
if (isset($_POST['user_id'])) {
    $userId = $_POST['user_id'];

    // Call deleteUser function to delete the user
    if (deleteUser($conn, $userId)) {
        echo 'success';  // Send success response
        // header('Location: ../view/admin/users.php');
    } else {
        echo 'error';  // Send error response
    }
} else {
    echo 'No user ID provided';
}
?>