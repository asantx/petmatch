<?php
// Include database connection file
require_once '../db/DatabaseConnection.php'; 
require '../functions/auth_functions.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);


    // Prepare the SQL query to check if the email exists
    $query = "SELECT `user_id`,`username`, `password`, `role` FROM `group_users` WHERE `email` = ?";
    if ($stmt = $conn->prepare($query)) {
        // Bind the parameter
        $stmt->bind_param("s", $email);

        // Execute the query
        $stmt->execute();

        // Bind the result variables
        $stmt->bind_result($userId, $username, $hashedPassword, $role);

        // Check if user was found
        if ($stmt->fetch()) {
            // Verify the password against the hashed password
            if (password_verify($password, $hashedPassword)) {
                // Successful login, create session
                session_start();
                startSession($userId, $role, $username);
                if ($role == 1) {
                    header('Location: ../view/admin/dashboard.php');  // Admin Dashboard
                } elseif ($role == 2) {
                    header('Location: ../view/dashboard.php');   // User Dashboard
                } else {
                    header('Location: ../view/dashboard.php');
                }
                exit(); 
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Incorrect password.']);
                header('Location: ../view/login.php?error=invalid_credentials');
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No user found with that email address.']);
            header('Location: ../view/login.php?error=user_not_found');

        }

        // Close the statement
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error: Could not prepare the statement.']);
    }

    // Close the connection
    $conn->close();
}
?>