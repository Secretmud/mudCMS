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
        $this->insertUserData();
    }

    private function insertUserData() {
        echo "<form id='register-form' method='post'>
                <input class='register-form-input' name='username' placeholder='username' type='text'>
                <input class='register-form-input' name='email' placeholder='email' type='text'>
                <input class='register-form-input' name='pass1' placeholder='pass' type='password'>
                <input class='register-form-input' name='pass2' placeholder='pass' type='password'>
                <input class='register-form-input' type='submit' placeholder='submit' name='submit' value='register'>
              </form>";
        if (isset($_POST['submit'])) {
            if ($_POST['pass1'] == $_POST['pass2']) {
                $this->register($_POST["username"],$_POST["pass1"],$_POST["email"]);
            } else {
                echo "<script>alert('Password mismatch!')</script>";
            }
        }
    }

    private function register($uname, $pass, $email) {
        try {
            $password = password_hash($pass, PASSWORD_ARGON2I, ['memory_cost' => 2048, 'time_cost' => 4, 'threads' => 3]);
            $creatUser = $this->conn->prepare("INSERT INTO users(username, pass, email, rights) VALUES (:username, :pass, :email, :rights)");
            $creatUser->execute([":username" => $uname, ":pass" => $password, ":email" => $email, ":rights" => "admin"]);
            echo "done";
        } catch (Exception $e) {
            echo "Exception -> ".$e;
        }
        header("Location: admin/login.php");
    }
}