<?php


class StartCheck {
    private $conn;
    private $table;

    function __construct(\PDO $conn, String $table) {
        $this->conn = $conn;
        $this->table = $table;
    }

    public function dataBaseCheck() {
        $checkIfExists = $this->conn->prepare("SELECT 1 FROM users");
        $checkIfExists->execute();
        if ($checkIfExists->rowCount() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function tableCreate() {
        $test = $this->conn->prepare('CREATE TABLE IF NOT EXISTS users (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL,
            pass VARCHAR(255) NOT NULL,
            email VARCHAR(255),
            reg_date TIMESTAMP)');
        $test->execute();
    }

    public function insertUserData() {
        echo "<form id='register-form' method='post'>
                <input class='register-form-input' name='username' placeholder='username' type='text'>
                <input class='register-form-input' name='email' placeholder='email' type='text'>
                <input class='register-form-input' name='pass1' placeholder='pass' type='password'>
                <input class='register-form-input' name='pass2' placeholder='pass' type='password'>
                <input class='register-form-input' type='submit' placeholder='submit' name='submit' value='register'>
              </form>";
        if (isset($_POST['submit'])) {
            if ($_POST['pass1'] == $_POST['pass2']) {
                register("","","");
            } else {
                echo "<script>alert('Password mismatch!')</script>";
            }
        }
    }

    public function register($uname, $pass, $email) {
        echo "Good job";   
    }
}