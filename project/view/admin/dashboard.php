<?php
// Start the session to access session variables
session_start();
include('../../functions/auth_functions.php');
include('../../functions/user_functions.php');
include('../../db/DatabaseConnection.php');
isUserAdmin();
// Automatically redirect to login if not logged in

// Retrieve session data (assuming session variables are set during login)
$role = $_SESSION['role'];  
$username = $_SESSION['username'];  


// Fetch data based on role
if ($role == 1) { // Super Admin
    // Fetch all user data (pagination can be added as needed)
    $usersData = getAllUsers($conn, 1, 100); // Default to page 1 with a limit of 5 users
    $users = $usersData['users']; // Assign the users from the returned array
    $totalUsers = getTotalUsers($conn);
    $newUsers = getNewUsers($conn);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_styles.css"
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-top">
            <div class="admin-info">
                <img src="../../assets/images/admin.png" alt="Admin" class="admin-avatar">
                <h2><?php echo "Hello " .htmlspecialchars($username); ?></h2>
            </div>
            <ul>
                <li class="active"><a href="#"><span class="icon" alt="Dashboard"></span>Dashboard</a></li>
                    <li><a href="users.php"><span class="icon"><img src="../../assets/images/users.png" alt="Users"></span>Users</a></li>
                <li><a href="admin_workout.php"><span class="icon"><img src="../../assets/images/dash.png" alt="workout"></span>Workout</a></li>
                <li><a href="admin_mealplan.php"><span class="icon"><img src="../../assets/images/recipe.png" alt="mealplan"></span>Meal Plan</a></li>
                <li><a href="admin_mealplan.php"><span class="icon"><img src="../../assets/images/users.png" alt="posts"></span>Stories</a></li>
        </ul>
        </div>

        <div class="logout">
            <a href="../../actions/logout.php">Logout</a>
        </div>
    </div>

    <header class="top-nav">
        <h1>Dashboard Overview</h1>
        <div class="top-nav-icons">
            <a href="#"><img src="../../assets/images/notification.png" alt="Notifications"></a>
            <a href="#"><img src="../../assets/images/user.png" alt="User Profile"></a>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        </div>
    </header>

    <div class="main-content">
        <section class="cards">
                <div class="card card-users">
                    <img src="../../assets/images/tusers.png" alt="Users" class="card-icon">
                    <h3>Total Users</h3>
                    <p><p><?php echo $totalUsers; ?></p></p>
                </div>
                <div class="card card-sessions">
                    <img src="../../assets/images/newuser.png" alt="New Users" class="card-icon">
                    <h3>New Users</h3>
                    <p><?php echo $newUsers; ?></p>
                </div>
                <div class="card card-new-users">
                    <img src="../../assets/images/sessions.png" alt="User Approval" class="card-icon">
                    <h3>Pending User Approvals</h3>
                    <p>0</p>
                </div>
                <div class="card card-new-users">
                    <img src="../../assets/images/sessions.png" alt="Sessions" class="card-icon">
                    <h3>Active Sessions</h3>
                    <p>1</p>
                </div>
 
        </section>


     <!-- Users Table for Super Admin -->
        <section>
            <h2>User List</h2>
            <table>
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Registered on</th>
                    </tr>
                </thead>
                <tbody id="userTable">
                    <?php
                    foreach ($users as $index => $user) {
                        // Escape user data using htmlspecialchars to prevent XSS
                        $username = htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8');
                        $email = htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8');
                        $role = htmlspecialchars($user['role'], ENT_QUOTES, 'UTF-8');
                        $created_at = htmlspecialchars($user['created_at'], ENT_QUOTES, 'UTF-8');
                        
                        echo "<tr data-id='" . htmlspecialchars($user['user_id'], ENT_QUOTES, 'UTF-8') . "'>
                                <td>" . ($index + 1) . "</td>
                                <td>{$username} </td>
                                <td>{$email}</td>
                                <td>{$role}</td>
                                <td>{$created_at}</td>
                            </tr>";
                    }
                    ?>
                </tbody>
            </table>
            </section>
    </div>


</html>
