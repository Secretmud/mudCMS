<?php

if (!parse_ini_file('assets/conf/config.ini')) {
    header('Location: assets/install.php');
} else {
    header('Location: page_view.php');
}