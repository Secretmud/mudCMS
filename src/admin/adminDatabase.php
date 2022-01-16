<?php

use Secret\MudCms\persistence\PostRepo;

require_once("../persistence/Connection.php");
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
                        <h3>Posts:</h3>
                        <?php
                        $post_repo = new PostRepo();
                        echo "Last post title: ";
                        echo ucfirst($post_repo->get_last_post_title());
                        echo "<br>Total posts: ";
                        echo $post_repo->get_total_posts();
                        echo "<br>Most popular category: ";
                        echo ucfirst($post_repo->get_most_popular_cat());
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
