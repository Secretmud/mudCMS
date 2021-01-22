# mudCRM
When you start up the website for the first time, it will prompt you to connect to the database and have you fill in the name and password of the user that will be accessing said database.


## Information 

The configuration file that is used to access the database is placed here:

- assets
    - conf
        - config.php
        
If you end up creating something that needs database connection, use the following function:
```php
<?php

function dbConnection() { 
    static $connection;
    if(!isset($connection)) {
        include('conf/config.php');
        try {
            $connection = new PDO("mysql:host=$host;dbname=$database", $username, $pass);
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    return $connection;
}
```
This is the markdown used when posting

```Markdown
# h1
## h2
### h3

-- citation

! http://localhost/http/Blog/admin/images/grey_2.jpg : grey_2.jpg

~
$tmp = ($arr[$x] == "") ? "<div></div>" : preg_replace($find, $replace, $arr[$x]);
~
```
