# mudCMS

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

This is the project structure right now. Adding this just to keep a track whilst I refactor the project structure.

```bash
.
├── 404page.php
├── addins
│   ├── footer.php
│   ├── header.php
│   ├── head.php
│   └── stylepick.php
├── admin
│   ├── admin-addins
│   │   ├── footer.php
│   │   ├── header.php
│   │   └── head.php
│   ├── adminDatabase.php
│   ├── adminPanel.php
│   ├── assets
│   │   ├── contentHandler.php
│   │   ├── content-show.php
│   │   ├── data.php
│   │   └── editing.php
│   ├── content
│   ├── css
│   │   ├── main.css
│   │   └── syntax.css
│   ├── editContent.php
│   ├── index.php
│   ├── js
│   │   └── main.js
│   ├── login.php
│   ├── logout.php
│   └── makeContent.php
├── assets
│   ├── conf
│   │   └── config.php
│   ├── connection.php
│   ├── content.php
│   ├── init.php
│   └── panel.php
├── content.php
├── css
│   ├── colorscheme
│   │   ├── christmas.css
│   │   ├── dark.css
│   │   └── solarized.css
│   └── main.css
├── fds.md
├── index.php
├── js
│   └── main.js
├── LICENSE
├── notfound.html
├── page_view.php
├── README.md
└── test.txt

   32 ./page_view.php
   12 ./index.php
   14 ./assets/connection.php
   45 ./assets/content.php
   33 ./assets/panel.php
   87 ./assets/init.php
    5 ./assets/conf/config.php
   37 ./content.php
   44 ./js/main.js
    7 ./addins/head.php
    9 ./addins/footer.php
    4 ./addins/stylepick.php
    5 ./addins/header.php
   27 ./admin/index.php
    7 ./admin/admin-addins/head.php
   17 ./admin/admin-addins/footer.php
   31 ./admin/admin-addins/header.php
   40 ./admin/adminPanel.php
   27 ./admin/assets/contentHandler.php
   12 ./admin/assets/editing.php
   24 ./admin/assets/content-show.php
   10 ./admin/assets/data.php
   43 ./admin/login.php
    5 ./admin/logout.php
   38 ./admin/js/main.js
   62 ./admin/makeContent.php
  335 ./admin/css/main.css
   18 ./admin/css/syntax.css
   45 ./admin/adminDatabase.php
   62 ./admin/editContent.php
  362 ./css/main.css
   38 ./css/colorscheme/dark.css
   33 ./css/colorscheme/solarized.css
   30 ./css/colorscheme/christmas.css
   31 ./404page.php
 1631 total
```