<?php

require_once __DIR__ . '/../initialize.php';

unset($_SESSION['user_id']);

redirect('../login.php');