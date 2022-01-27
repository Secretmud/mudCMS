<?php

use Secret\MudCms\persistence\Connection;

class StartCheck {

    private $conn;

    public function __construct() {
        require_once("persistence/Connection.php");
    }

    private function dataBaseConn() {
        $this->conn = (new Connection)->getConnection();
    } 

    public function dataBaseCheck() {
        return file_exists("persistence/conf/config.php");
    }

    public function databaseCreate() {
        require_once "persistence/conf/config.php";
        $this->conn->prepare("CREATE DATABASE IF NOT EXISTS $database");
        usleep(500);
    }

    public function tableCreate() {
        $test = $this->conn->prepare('CREATE TABLE IF NOT EXISTS users (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL,
            pass VARCHAR(255) NOT NULL,
            email VARCHAR(255),
            rights VARCHAR(255),
            reg_date TIMESTAMP)');
        $test->execute();
        usleep(500);
        $test = $this->conn->prepare('CREATE TABLE IF NOT EXISTS posts (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            postdate DATE,
            title varchar(255),
            poster varchar(255),
            content text,
            postimage varchar(255),
            category varchar(255))');
        $test->execute();
        usleep(500);
    }

    private function register($uname, $pass, $email) {
        try {
            $password = password_hash($pass, PASSWORD_DEFAULT);
            $creatUser = $this->conn->prepare("INSERT INTO users(username, pass, email, rights) VALUES (:username, :pass, :email, :rights)");
            $creatUser->execute([":username" => $uname, ":pass" => $password, ":email" => $email, ":rights" => "admin"]);
            echo "done";
        } catch (Exception $e) {
            echo "Exception -> ".$e->getMessage();
        }
        header("Location: admin/login.php");
    }

    public function writeConfig() {
        echo "
            <!DOCTYPE html>
            <html lang='en'>
                <head>
                    <meta charset='utf-8'>
                    <title>Website Home</title>
                    <meta name='viewport' content='width=device-width, initial-scale=1'>
                    <meta name='theme-color' content='#317EFB'/>
                    <link rel='stylesheet' href='css/main.css'>
                    <link rel='stylesheet' href='css/colorscheme/dark.css'>
                </head>

                <body>
                    <div class='main'>
                        <form id='register-form' method='post'>
                            <div class='register-form-title'>mudCMS init v0.0.1</div>
                            <input class='register-form-input' name='username' placeholder='dbusername' type='text'>
                            <input class='register-form-input' name='database' placeholder='database name' type='text'>
                            <input class='register-form-input' name='dbpass' placeholder='db pass' type='password'>
                            <input class='register-form-input' name='host' placeholder='127.0.0.1' type='text'>
                            <input class='register-form-input' name='cms-user' placeholder='username' type='text'>
                            <input class='register-form-input' name='cms-email' placeholder='email' type='text'>
                            <input class='register-form-input' name='pass1' placeholder='pass' type='password'>
                            <input class='register-form-input' name='pass2' placeholder='pass' type='password'>
                            <input class='register-form-button' type='submit' placeholder='submit' name='submit' value='Complete setup'>
                        </form>
                    </div>
                </body>
            </html>
            ";
        if (isset($_POST['submit'])) {  
            $settings = [
                         "<?php",
                         "\$username = \"".$_POST['username']."\";",
                         "\$database = \"".$_POST['database']."\";",
                         "\$pass = \"".$_POST['dbpass']."\";",
                         "\$host = \"".$_POST['host']."\";"
                        ];  
            $fname = "config.php"; 
            $dir = "persistence/conf/";
            if (!file_exists("persistence/conf/".$fname)) {
                if (!file_exists("persistence/conf/")) {
                    mkdir($dir, 0777, true);
                }
                touch($dir.$fname);
                chmod($dir.$fname, 0777);
            }
            $file = fopen($dir.$fname, "w+");
            if ($file) {
                foreach ($settings as $i) {
                    fwrite($file, $i."\n");
                }
                fclose($file);
                chmod($dir.$fname, 0644);
                chmod($dir, 0755);
                $this->dataBaseConn();
                $this->databaseCreate();
                $this->tableCreate();
                if ($_POST['pass1'] == $_POST['pass2']) {
                    $this->register($_POST["cms-user"],$_POST["pass1"],$_POST["cms-email"]);
                } else {
                    echo "<script>alert('Password mismatch!')</script>";
                }
                sleep(2);
            } else {
                echo "Not able to read file...";
            }
        }
    }
}
