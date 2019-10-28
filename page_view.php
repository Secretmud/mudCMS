<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Website Home</title>
	    <meta name="description" content="I make open and free programs and like to play with config files">
        <?php include 'addins/head.php'; ?>
    <body>
		<div class="main">
            <div class="left-bar">
                <div class="content">
					<?php include('addins/header.php');?>
                </div>
            </div>
            <div class="center-top">
                <div class="grid-content">
                    <?php
                        include("assets/connection.php");
                        include('assets/content.php');
                        $conn = dbConnection();
                        $amnt = 6;
                        getPostsLatest($conn, $amnt);
                    ?>
                </div>
            </div>
            <div class="center-bottom">
				<?php
					include('addins/footer.php');
				?>
            </div>
        </div>
    </body>
</html>

