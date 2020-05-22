<?php


class StartCheck {
    private $table;
    private $conn;

    public function dataBaseCheck() {
        return (file_get_contents("assets/conf/config.php")) ? true : false;
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
            $password = password_hash($pass, PASSWORD_DEFAULT);
            $creatUser = $this->conn->prepare("INSERT INTO users(username, pass, email, rights) VALUES (:username, :pass, :email, :rights)");
            $creatUser->execute([":username" => $uname, ":pass" => $password, ":email" => $email, ":rights" => "admin"]);
            echo "done";
        } catch (Exception $e) {
            echo "Exception -> ".$e;
        }
        header("Location: admin/login.php");
    }

    public function writeConfig() {
        echo "<form id='register-form' method='post'>
                <h1 style='margin: atuo;'>Setup</h1>
                <input class='register-form-input' name='username' placeholder='username' type='text'>
                <input class='register-form-input' name='database' placeholder='database' type='text'>
                <input class='register-form-input' name='dbpass' placeholder='pass' type='password'>
                <input class='register-form-input' name='host' placeholder='127.0.0.1' type='text'>
                <input class='register-form-input' type='submit' placeholder='submit' name='submit' value='register'>
              </form>";
        if (isset($_POST['submit'])) {     
            $settings = [
                         "<?php",
                         "\$username = \"".$_POST['username']."\";",
                         "\$database = \"".$_POST['database']."\";",
                         "\$pass = \"".$_POST['dbpass']."\";",
                         "\$host = \"".$_POST['host']."\";"
                        ];  
            $file = fopen("assets/conf/config.php", "w+");
            foreach ($settings as $i) {
                fwrite($file, $i."\n");
            }
            fclose($file);
            sleep(2);
            include("assets/conf/config.php");
            $this->conn = dbConnection();
            $this->tableCreate();
        }
    }
}
