<?php
include_once 'header.php';
include_once 'assets/connection.php';
$conn = db_connect();
if ($conn->exec('SELECT * FROM users LIMIT 1')) {
    echo "it exists";
} else {
    $test = $conn->prepare('CREATE TABLE IF NOT EXISTS users (
                            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                            username VARCHAR(255) NOT NULL,
                            pass VARCHAR(255) NOT NULL,
                            email VARCHAR(255),
                            reg_date TIMESTAMP)');
    $test->execute();
    include('assets/form.php');
}