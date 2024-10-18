<?php
class User {
    private $conn;
    private $table = 'users';

    public $id;
    public $name;
    public $email;
    public $password;
    public $google_id;
    public $role;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Add methods for user operations if needed
}
?>
