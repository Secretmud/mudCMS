<?php

use Secret\MudCms\persistence\Connection;

if(!isset($_SESSION)) {
    session_start();
}
ob_start();
if($_SESSION['user'] == null){
    header("Location: login.php");
}
include("assets/contentHandler.php");
include("assets/data.php");
require_once("../persistence/Connection.php");
$ch = new contentHandler();
?>
<!DOCTYPE html>
<html lang="en">
    <?php include('admin-addins/head.php');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);?>
	<body>

		<div class="main">
            <div class="left-bar">
                <div class="content">
                    <?php include('admin-addins/header.php'); ?>
                </div>
            </div>
            <div class="center-top">
                <div class="grid-content">
					<div class="content">
                        <h3>Add new page content</h3>
                        <form method="POST" enctype="multipart/form-data">
                            <input type="text" name="title" placeholder="title" required> <br>
                            <input type="text" name="postimage" placeholder="/path/to/file" ><br>
                            <input type="text" name="category" placeholder="category" required><br>
                            <a type="submit" class="button" id="btnModal">Insert images</a>
                            <textarea required placeholder="content" name="content" id="contentBox" style="height: 300px; width: 100%; resize: none;"></textarea>
                            <input type="submit" value="submit" name="submit">
                        </form>
                        <?php
                        if(isset($_POST["submit"])) {
                            $content = $_POST["content"];
                            $content = htmlspecialchars($content);
                            $title = $_POST["title"];
                            $date = date("Ymd");
                            $image = $_POST["postimage"];
                            $category = $_POST["category"];
                            enter_content((new Connection)->getConnection(), $date, $title, $image, $content, $category);
                        }
                        ?>
					</div>
				</div>
            </div>
            <div class="center-bottom">
                <div class="content">
                    <?php include('admin-addins/footer.php');?>
                </div>
            </div>
        </div>
        <div class="imgModal" id="imgModal">
            <div class="modalContent">
                <?php
                    $ch->displayImg();
                ?>
            </div>
            <div class="modalImgLoc">
                <p>Image location:</p>
                <p id="imgLocation"></p>
                <p>Image name:</p>
                <p id="imgName"></p>
                <p>Image description:</p>
                <p id="imgDesc"></p>
                <p>Image size:</p>
                <p id="imgSize"></p>
                <p>Image extension:</p>
                <p id="imgExtension"></p>
            </div>
            <div class="modalBottom" id="imgInc">
                <p id="imgInc"></p>
            </div>
        </div>
        <script src="js/main.js"></script>
	</body>
</html>
