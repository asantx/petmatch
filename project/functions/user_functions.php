<?php
// Function to fetch all users
function getAllUsers($conn, $page = 1, $usersPerPage = 10) {
    // Calculate the OFFSET (how many records to skip)
    $offset = ($page - 1) * $usersPerPage;

    // Prepare the query with LIMIT and OFFSET
    $query = "SELECT user_id, username, email, phase_id, role, created_at FROM group_users LIMIT ? OFFSET ?";
    
    if ($stmt = $conn->prepare($query)) {
        // Bind the LIMIT and OFFSET parameters
        $stmt->bind_param("ii", $usersPerPage, $offset);
        $stmt->execute();
        
        // Get the result
        $result = $stmt->get_result();

        // Fetch all users and modify the role based on its value
        $users = $result->fetch_all(MYSQLI_ASSOC);
        
        // Loop through users and modify role and phase_id display
        foreach ($users as &$user) {
            // Handle role
            if ($user['role'] == 1) {
                $user['role'] = 'Admin'; 
            } elseif ($user['role'] == 2) {
                $user['role'] = 'User';
            } else {
                $user['role'] = 'User';  
            }
            
            // Handle phase_id
            if ($user['phase_id'] == 1) {
                $user['phase_id'] = 'Menstrual Phase';
            } elseif ($user['phase_id'] == 2) {
                $user['phase_id'] = 'Follicular Phase';
            } elseif ($user['phase_id'] == 3) {
                $user['phase_id'] = 'Ovulation Phase';
            } elseif ($user['phase_id'] == 4) {
                $user['phase_id'] = 'Luteal Phase';
            } elseif ($user['phase_id'] === NULL) { // Use strict comparison for NULL
                $user['phase_id'] = 'NOT SET';
            }
        }


        // Get the total number of users to calculate the number of pages
        $totalQuery = "SELECT COUNT(*) AS total FROM group_users";
        $totalResult = $conn->query($totalQuery);
        $totalUsers = $totalResult->fetch_assoc()['total'];
        
        // Calculate the total number of pages
        $totalPages = ceil($totalUsers / $usersPerPage);

        // Return the users and pagination info
        return [
            'users' => $users,
            'totalPages' => $totalPages,
            'currentPage' => $page
        ];
    } else {
        // Handle query preparation error
        return false;
    }
}

// Fetch total number of users
function getTotalUsers($conn) {    
    // Prepare the SQL statement
    $sql = "SELECT COUNT(*) AS total FROM group_users";
    
    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        // Execute the statement
        $stmt->execute();
        
        // Bind the result to a variable
        $stmt->bind_result($totalUsers);
        
        // Fetch the result
        $stmt->fetch();
        
        // Close the statement
        $stmt->close();
        
        return $totalUsers;  // Return the total number of users
    } else {
        // Handle query preparation error
        error_log("Prepared statement failed: " . $conn->error);
        return 0;
    }
}

// Fetch total number of new users (created today)
function getNewUsers($conn) {
    
    // Prepare the SQL statement
    $sql = "SELECT COUNT(*) AS total FROM group_users WHERE DATE(created_at) = CURDATE()";
    
    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        // Execute the statement
        $stmt->execute();
        
        // Bind the result to a variable
        $stmt->bind_result($newUsers);
        
        // Fetch the result
        $stmt->fetch();
        
        // Close the statement
        $stmt->close();
        
        return $newUsers;  // Return the total number of new users
    } else {
        // Handle query preparation error
        error_log("Prepared statement failed: " . $conn->error);
        return 0;
    }
}

// Function to delete a user
function deleteUser($conn, $userId) {
    $query = "DELETE FROM group_users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    return $stmt->execute();
}





?>