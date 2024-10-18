<?php
class Application {
    private $conn;
    private $table = 'applications';

    public $id;
    public $job_id;
    public $user_id;
    public $cover_letter;
    public $applied_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Add methods for application operations if needed
}
?>
