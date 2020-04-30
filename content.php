<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>OS</title>
		<meta name="description" content="">
        <?php include 'addins/head.php' ?>
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
                    //    include_once('assets/connection.php');
                    //    include_once('assets/content.php');
                    //    $cat = $_GET['category'];
                    //    $id = $_GET['contentId'];
                    //    getPostsCat(dbConnection(), $cat);
                    include("assets/init.php");
                    include("assets/connection.php");
                    $start = new StartCheck(dbConnection(), "blog");
                    $start->writeConfig();
                    ?>
                </div>
            </div>
            <div class="center-bottom">
                <div class="content">
					<?php include('addins/footer.php')?>
                </div>
            </div>
        </div>
	</body>
</html>
