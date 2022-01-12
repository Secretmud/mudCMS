<?php

use Secret\MudCms\persistence\Connection;

if(!isset($_SESSION)) {
    session_start();
}
ob_start();
if($_SESSION['user'] == null){
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
    <?php include('admin-addins/head.php');?>
	<body>
		<div class="main">
            <div class="left-bar">
                <div class="content">
                    <?php include 'admin-addins/header.php'; ?>
                </div>
            </div>
            <div class="center-top">
                <div class="grid-content">
					<div class="content">
                        <h3>Post history:</h3>
                        <?php
                        $conn = (new Connection)->getConnection();
                        include 'assets/content-show.php';
                        try {
                            echo "Last post: ".last_post_title($conn)['title']."<br>";
                        } catch (Exception $e) {
                            echo "No posts yet... Do something about that! head over to add content!";
                        }
                        echo "Totalt: ".total_posts($conn)."<br>";


                        ?>
					</div>
				</div>
            </div>
            <div class="center-bottom">
                <div class="content">
                    <?php include 'admin-addins/footer.php';?>
                </div>
            </div>
        </div>
	</body>
</html>
