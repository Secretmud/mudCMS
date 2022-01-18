<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Website Home</title>
	    <meta name="description" content="I make open and free programs and like to play with config files">
        <?php use Secret\MudCms\assets\ResponseBuilder;

        include 'addins/head.php'; ?>
    <body>
		<div class="main">
            <?php
                include_once("assets/ResponseBuilder.php");
                $a = new ResponseBuilder();

            if (empty($_GET)) {
                echo $a->page_view();
            }
            $page = 0;
            if (!empty($_GET['page'])) {
                $page =  $_GET['page'];
            }
            foreach ($_GET as $k => $v) {
                switch ($k) {
                    case "type":
                        switch ($v) {
                            case "latest":
                                echo $a->page_view($page);
                                break;
                            case "cat":
                                if (!empty($_GET['category'])) {
                                    echo $a->show_cat($_GET['category'], $page);
                                }
                                break;
                            default:
                                echo $a->page_view();
                                break;
                        }

                        break;

                    case "contentId":
                        echo $a->post_view($v);
                        break;

                    default:
                        echo $a->page_view();
                        break;
                }
                break;
            }



            ?>
        </div>
    </body>
</html>