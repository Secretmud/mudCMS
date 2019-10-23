<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form method="post">
        Insert data to your config.ini file... It's located at 'assets/conf/config.ini'
        <input type="submit" value="submit">
    </form>
    <?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        if(isset($_POST['submit'])) {
            if (!parse_ini_file('conf/config.ini')) {
                echo "files empty";
            } else {
                header('Location: localhost/setup_php/index.php');
            }
        }
    ?>
</body>
</html>