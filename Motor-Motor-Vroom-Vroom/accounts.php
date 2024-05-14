<?php
require_once 'models/User.php'; // Update this with the correct path to your User class file
require_once 'avengers.php';
Guard::adminOnly();
// Check if the user is logged in
$user = User::getAuthenticatedUser();

if (!$user) {
    // User is not logged in, redirect them to the login page
    header("Location: login.php");
    exit;
}

// Check for success message
if (isset($_SESSION['success_message'])) {
    echo "<div style='color: green; font-size: 25px;'>" . $_SESSION['success_message'] . "</div>";
    unset($_SESSION['success_message']); // Remove the message from session to avoid displaying it again
}

// Check for error message
if (isset($_SESSION['error_message'])) {
    echo "<div style='color: red; font-size: 25px;'>" . $_SESSION['error_message'] . "</div>";
    unset($_SESSION['error_message']); // Remove the message from session to avoid displaying it again
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Create New Account</title>
    <link rel="stylesheet" type="text/css" href="./css/main.css">
    <link rel="stylesheet" type="text/css" href="./css/admin.css">
    <link rel="stylesheet" type="text/css" href="./css/util.css">
    <link rel="icon" href="uploads/logo-circle.png" type="image/png">
    <style>
        /* Custom CSS for adjusting card width */
        .card {
            width: 350px;
            padding: 10px;
        }
        main {
            display: flex;
            padding: 10px;
            align-items: left;
        }
        .card-label {
            margin-bottom: 8px;
        }
        .form-group {
            margin-bottom: 16px;
        }
        .btn {
            margin-top: 16px;
        }
        /* Adjust input field width for username, password, and email */
        .form-control.full-width {
            width: 97%;
        }
    </style>
</head>

<body>
    <?php require 'templates/admin_header.php' ?>

    <div class="flex">
        <?php require 'templates/admin_navbar.php' ?>
        <main style="flex: 5;">
            <div style="padding: 16px">
                <span class="subtitle">Accounts</span>
                <hr />

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Create An Account</div>
                    </div>
                    <!-- New Account Form -->
                    <form action="create_account.php" method="POST">
                        <div class="form-group">
                            <label for="name" class="card-label">Name:</label>
                            <input type="text" id="name" name="name" class="form-control full-width" required>
                        </div>
                        <div class="form-group">
                            <label for="email" class="card-label">Email:</label>
                            <input type="email" id="email" name="email" class="form-control full-width" required>
                        </div>
                        <div class="form-group">
                            <label for="password" class="card-label">Password:</label>
                            <input type="password" id="password" name="password" class="form-control full-width" required>
                        </div>
                        <div class="form-group">
                            <label for="role" class="card-label">Role:</label>
                            <select id="role" name="role" class="form-control">
                                <option value="ADMIN">Admin</option>
                                <option value="CASHIER">Cashier</option>
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">Create Account</button>
                        </div>
                    </form>
                </div>
            </div>

            <div style="padding: 16px">
                <div class="subtitle">Existing accounts</div>
                <hr />

                <table>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                    </tr>
                    <?php
                    // Fetch all users from the database
                    $users = User::getAllUsers();

                    // Loop through each user and display their details in a table row
                    foreach ($users as $user) {
                        echo "<tr>";
                        echo "<td>{$user->name}</td>";
                        echo "<td>{$user->email}</td>";
                        echo "<td>{$user->role}</td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>

        </main>

    </div>

</body>

</html>
