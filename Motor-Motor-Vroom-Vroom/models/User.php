<?php

require_once __DIR__ . '/../initialize.php';

class User
{
    public $id;
    public $name;
    public $email;
    public $role;
    public $password;
    public function getHomePage()
    {
        if ($this->role === ROLE_ADMIN) {
            return 'admin_home.php';
        }
        return 'index.php';
    }
    public static function getAllUsers()
    {
        global $connection;

        $stmt = $connection->prepare("SELECT * FROM `users`");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'User');
    }
    private static $currentUser = null;
    public function __construct($user = null)
    {
        if ($user) {
            $this->id = intval($user['id']);
            $this->name = $user['name'];
            $this->email = $user['email'];
            $this->role = $user['role'];
            $this->password = $user['password'];
        }
    }
    public static function getAuthenticatedUser()
    {
        if (!isset($_SESSION['user_id']))
            return null;

        if (!static::$currentUser) {
            static::$currentUser = static::find($_SESSION['user_id']);
        }

        return static::$currentUser;
    }
    public static function find($user_id)
    {
        global $connection;

        $stmt = $connection->prepare("SELECT * FROM `users` WHERE id=:id");
        $stmt->bindParam("id", $user_id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $result = $stmt->fetchAll();

        if (count($result) >= 1) {
            return new User($result[0]);
        }

        return null;
    }
    public static function findByEmail($email)
    {
        global $connection;

        $stmt = $connection->prepare("SELECT * FROM `users` WHERE email=:email");
        $stmt->bindParam("email", $email);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $result = $stmt->fetchAll();

        if (count($result) >= 1) {
            return new User($result[0]);
        }

        return null;
    }
    public static function login($email, $password)
    {
        if (empty($email))
            throw new Exception("The email is required");
        if (empty($password))
            throw new Exception("The password is required");

        $user = static::findByEmail($email);

        if ($user && $user->password == $password) {
            return $user;
        }

        throw new Exception('Wrong email or password.');
    }
    public function save()
    {
        global $connection;

        if ($this->id) {
            // Update existing user
            $stmt = $connection->prepare('UPDATE `users` SET name=:name, email=:email, password=:password, role=:role WHERE id=:id');
            $stmt->bindParam('id', $this->id);
        } else {
            // Insert new user
            $stmt = $connection->prepare('INSERT INTO `users` (name, email, password, role) VALUES (:name, :email, :password, :role)');
        }

        $stmt->bindParam('name', $this->name);
        $stmt->bindParam('email', $this->email);
        $stmt->bindParam('password', $this->password);
        $stmt->bindParam('role', $this->role);

        $stmt->execute();

        if (!$this->id) {
            $this->id = $connection->lastInsertId();
        }
    }

}