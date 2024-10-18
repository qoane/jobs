<?php
class Job {
    private $conn;
    private $table = 'jobs';

    public $id;
    public $user_id;
    public $title;
    public $description;
    public $location;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Add methods for job operations if needed
}
?>
