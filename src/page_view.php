<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Website Home</title>
	    <meta name="description" content="I make open and free programs and like to play with config files">
        <?php include 'addins/head.php'; ?>
    <body>
		<div class="main">
            <?php
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
                include "assets/build_page_response.php";
                $a = new ResponseBuilder();
                if (!empty($_GET)) {
                    switch($_GET['type']) {
                        case "all":
                            echo $a->page_view();
                            break;
                        case "latest":
                            echo $a->page_view();
                            break;
                        case "cat":
                            echo $a->show_cat($_GET['category']);
                            break;
                        default:
                            echo $a->page_view();
                            break;
                    } 
                } else {
                    echo $a->page_view();
                }
            ?>
        </div>
    </body>
</html>