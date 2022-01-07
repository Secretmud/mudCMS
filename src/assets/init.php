<?php


class StartCheck {

    public function dataBaseCheck() {
        return file_exists("assets/conf/config.php");
    }

    public function databaseCreate() {
        require_once "conf/config.php";
        require_once "connection.php";
        $conn = dbConnection();
        $test = $conn->prepare("CREATE DATABASE IF NOT EXISTS $database");
        usleep(500);
        $conn = null;
    }

    public function tableCreate() {
        require_once "connection.php";
        $conn = dbConnection();
        $test = $conn->prepare('CREATE TABLE IF NOT EXISTS users (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL,
            pass VARCHAR(255) NOT NULL,
            email VARCHAR(255),
            rights VARCHAR(255),
            reg_date TIMESTAMP)');
        $test->execute();
        usleep(500);
        $test = $conn->prepare('CREATE TABLE IF NOT EXISTS posts (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            postdate DATE,
            title varchar(255),
            poster varchar(255),
            content text,
            postimage varchar(255),
            category varchar(255))');
        $test->execute();
        usleep(500);
        $conn = null;
    }

    private function register($uname, $pass, $email) {
        require_once "connection.php";
        $conn = dbConnection();
        try {
            $password = password_hash($pass, PASSWORD_DEFAULT);
            $creatUser = $conn->prepare("INSERT INTO users(username, pass, email, rights) VALUES (:username, :pass, :email, :rights)");
            $creatUser->execute([":username" => $uname, ":pass" => $password, ":email" => $email, ":rights" => "admin"]);
            echo "done";
        } catch (Exception $e) {
            echo "Exception -> ".$e->getMessage();
        }
        $conn = null;
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
                    <link rel='stylesheet' href='admin/css/syntax.css'>
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
            touch("assets/conf/config.php");
            chmod("assets/conf/config.php", 0755);
            $file = fopen("assets/conf/config.php", "w");
            foreach ($settings as $i) {
                fwrite($file, $i."\n");
            }
            fclose($file);
            $this->databaseCreate();
            $this->tableCreate();
            if ($_POST['pass1'] == $_POST['pass2']) {
                $this->register($_POST["cms-user"],$_POST["pass1"],$_POST["cms-email"]);
            } else {
                echo "<script>alert('Password mismatch!')</script>";
            }
            sleep(2);
        }
    }
}