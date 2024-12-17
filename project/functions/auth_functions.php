<?php

// Check if the user is logged in
function isUserLoggedIn() {
    // If the user is not logged in, redirect to the login page
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../view/login.php");
        exit();
    }
    return true;  // If the user is logged in, return true
}


function isUserAdmin() {
    // If the user is not logged in or if their role is not equal to 1, redirect to the login page
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
        header("Location: ../../view/login.php");
        exit();
    }
    return true;  // If the user is logged in and role is 1, return true
}

// Start a user session
function startSession($userId, $role, $username) {
    $_SESSION['user_id'] = $userId;
    $_SESSION['role'] = $role;
    $_SESSION['username'] = $username;
}


// Function to validate password strength
function validatePassword($password) {
    return preg_match("/^(?=.*[A-Z])(?=.*\d.*\d.*\d)(?=.*[@#$%^&+=!]).{8,}$/", $password);
}


?>


