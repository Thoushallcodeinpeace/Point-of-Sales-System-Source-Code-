<?php
require_once __DIR__.'/../initialize.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = post('email');
    $password = post('password');

    try {
        $user = User::findByEmail($email);

        if ($user && password_verify($password, $user->password)) {
            $_SESSION['user_id'] = $user->id;
            redirect('../'.$user->getHomePage());
        } else {
            flashMessage('login', 'Invalid email or password', FLASH_ERROR);
            redirect('../login.php');
        }
    } catch (Exception $error) {
        // Handle other exceptions, if any
        flashMessage('login', $error->getMessage(), FLASH_ERROR);
        redirect('../login.php');
    }
}
?>
