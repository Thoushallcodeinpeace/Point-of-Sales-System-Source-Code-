<?php

require_once 'initialize.php';

class Guard {

    public static function adminOnly()
    {
        $currentUser = User::getAuthenticatedUser();

        if (!$currentUser || $currentUser->role !== ROLE_ADMIN) {
            session_start(); // Make sure the session is started
            flashMessage('error', 'Access Denied - Admin Authorization Required!', 'danger');
            redirect('login.php');
        }
    }

    public static function cashierOnly()
    {
        $currentUser = User::getAuthenticatedUser();

        if (!$currentUser || $currentUser->role !== ROLE_CASHIER) {
            redirect('login.php');
        }
    }

    public static function hasModel($modelClass)
    {
        $model = $modelClass::find(get('id'));

        if ($model == null) {
            header('Content-type: text/plain');
            die('Page not found');
        }

        return $model;
    }

    public static function guestOnly() 
    {
        $currentUser = User::getAuthenticatedUser();

        if (!$currentUser) return;

        redirect($currentUser->getHomePage());
    }
}