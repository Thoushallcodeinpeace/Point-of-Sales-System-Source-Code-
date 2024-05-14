<?php

//Guard
require_once 'avengers.php';
Guard::guestOnly();

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Point of Sale System - Login</title>
    <link rel="stylesheet" type="text/css" href="./css/main.css">
    <link rel="stylesheet" type="text/css" href="./css/login.css">
    <link rel="stylesheet" type="text/css" href="./css/util.css">
    <link rel="icon" href="uploads/logo-circle.png" type="image/png">

    <style>
        body{
            background-image: url('uploads/bg-parts-chuchu.jpg');
            background-size:cover;
        }
        
    </style>
</head>

<body>

    <div class="login card">

        <div class="card-header">
            <div class="card-title">Welcome to 4JS Login Dashboard</div>
        </div>

        <div class="card-content">
            <form method="POST" action="api/login_controller.php">

                <?php displayFlashMessage('login') ?>

                <div class="form-control">
                    <label>Email</label>
                    <input type="text" name="email" placeholder="Enter your email here" required="true" />
                </div>

                <div class="form-control mt-16">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter your password here" required="true" />
                </div>

                <div class="mt-16 flex justify-end">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>

            </form>
        </div>
    </div>


</body>

</html>