<?php


class StartCheck {
    private $table;
    private $conn;

    public function dataBaseCheck() {
        return (file_get_contents("assets/conf/config.php")) ? true : false;
    }

    public function databaseCreate() {
        require("assets/conf/config.php");
        $conn = dbConnection();
        $test = $conn->prepare('CREATE DATABASE IF NOT EXISTS mudCMS');
        $test->execute();
    }

    public function tableCreate() {
        require("assets/conf/config.php");
        $conn = dbConnection();
        $test = $conn->prepare('CREATE TABLE IF NOT EXISTS users (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL,
            pass VARCHAR(255) NOT NULL,
            email VARCHAR(255),
            reg_date TIMESTAMP)');
        $test->execute();
        usleep(2500);
    }

    private function register($uname, $pass, $email) {
        require("assets/conf/config.php");
        $conn = dbConnection();
        try {
            echo $uname ." ". $pass ." ". $email;
            $password = password_hash($pass, PASSWORD_DEFAULT);
            $creatUser = $conn->prepare("INSERT INTO users(username, pass, email, rights) VALUES (:username, :pass, :email, :rights)");
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
                <input class='register-form-input' name='cms-user' placeholder='username' type='text'>
                <input class='register-form-input' name='cms-email' placeholder='email' type='text'>
                <input class='register-form-input' name='pass1' placeholder='pass' type='password'>
                <input class='register-form-input' name='pass2' placeholder='pass' type='password'>
                <input class='register-form-input' type='submit' placeholder='submit' name='submit' value='register'>
              </form>";
        if (isset($_POST['submit'])) {  
            echo $_POST['username'];
            echo $_POST['database'];
            echo $_POST['dbpass'];
            echo $_POST['host'];
            echo $_POST['cms-user'];
            echo $_POST['cms-email'];   
            echo $_POST['pass1'];
            echo $_POST['pass2'];
            
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
            if ($_POST['pass1'] == $_POST['pass2']) {
                $this->register($_POST["cms-user"],$_POST["pass1"],$_POST["cms-email"]);
            } else {
                echo "<script>alert('Password mismatch!')</script>";
            }
            sleep(2);
            $this->tableCreate();
        }
    }
}
