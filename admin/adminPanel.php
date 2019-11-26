<?php 
session_start();
if($_SESSION['user'] == null){
    header("Location: login.php");
}
include_once 'assets/sales.php';
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
                        require('../assets/connection.php');
                        include('assets/content-show.php');
                        echo "Last post: ".last_post_title(dbConnection())['title']."<br>";
                        echo "Totalt: ".total_posts(dbConnection())."<br>";
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
