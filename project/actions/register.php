<?php
// Include database connection file
require_once('../db/DatabaseConnection.php'); 


// Check form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get form data
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']);

    // Array to hold error messages
    $errors = [];

    // Validate password strength
    if (!preg_match("/^(?=.*[A-Z])(?=.*\d.*\d.*\d)(?=.*[@#$%^&+=!]).{8,}$/", $password)) {
        header('Location: ../view/signup.php?error=weak_password');
        $errors[] = "Password must be at least 8 characters, contain 1 uppercase letter, 3 digits, and 1 special character.";
    }

    // Check if passwords match
    if ($password !== $confirmPassword) {
        header('Location: ../view/signup.php?error=password_do_not_match');
        $errors[] = "Passwords do not match.";
    }

    // If there are any errors, display them
    if (count($errors) > 0) {
        echo json_encode(['status' => 'error', 'errors' => $errors]);
        exit;
    }

    // Hash the password for security before storing it
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Prepare the SQL query to insert the new user
    $query = "INSERT INTO `group_users` (`full name`, `email`, `password`) VALUES (?, ?, ?)";
    if ($stmt = $conn->prepare($query)) {
        // Bind the parameters
        $stmt->bind_param("sss", $fullname, $email, $hashedPassword);

        // Execute the query
        if ($stmt->execute()) {
            header('Location: ../view/login.php');
        } else {
            header('Location: ../view/register.php?error=failed_signup');
        }

        // Close the statement
        $stmt->close();
    } else {
        header('Location: ../view/register.php');
    }

    // Close the connection
    $conn->close();
}
?>