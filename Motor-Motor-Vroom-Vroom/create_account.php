<?php
require_once 'models/User.php';
require_once 'avengers.php';
Guard::adminOnly();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Form validation
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Basic validation
    if (empty($name) || empty($email) || empty($password) || empty($role)) {
        $_SESSION['error_message'] = "All fields are required.";
    } else {
        try {
            // Check if email already exists
            if (User::findByEmail($email)) {
                throw new Exception("Email address already in use.");
            }

            // Create new user
            $user = new User([
                'name' => $name,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_BCRYPT),
                'role' => $role
            ]);

            // Save user to database
            $user->save();

            // Set success message
            $_SESSION['success_message'] = "Account created successfully!";
        } catch (Exception $e) {
            // Set error message
            $_SESSION['error_message'] = "Error: " . $e->getMessage();
        }
    }
}

// Redirect back to accounts.php
header("Location: accounts.php");
exit;
?>
