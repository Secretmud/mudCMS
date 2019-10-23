# mudCMS


the following must be added to two places
    - /assets/connection.php
    - /admin/assets/connection.php
```php
<?php
$db_host = "";
$db_name = "";
$db_user = "";
$db_pass = "";

try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
} catch(PDOException $e) {
    echo "Connection failed: " .$e->getMessage();
}
```

