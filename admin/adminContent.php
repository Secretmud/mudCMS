<?php 
session_start();
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
                        <h3>Add new page content</h3>
                        <form method="POST" enctype="multipart/form-data">
                            <input type="text" name="title" placeholder="title" required> <br>
                            <input type="file" name="postimage" placeholder="postimage" ><br>
                            <input type="text" name="category" placeholder="category" required><br>
                            <input type="button" value="code" id="code">
                            <input type="button" value="link" id="link">
                            <input type="button" value="test" id="test">
                            <textarea required placeholder="content" name="content" id="contentBox" style="height: 300px; width: 100%; resize: none;"></textarea>
                            <input type="submit" value="submit" name="submit">
                        </form>
                        <?php
                        if(isset($_POST["submit"])) {
                            require("../assets/connection.php");
                            include("assets/data.php");
                            include("assets/contentHandler.php");
                            $ch = new contentHandler($conn);
                            $content = $_POST["content"];
                            $content = htmlspecialchars($content);
                            $title = $_POST["title"];
                            $date = date("Ymd");
                            $image = addslashes(file_get_contents($_FILES['postimage']['tmp_name']));
                            echo $image;
                            $category = $_POST["category"];
                            $content = $ch->contentParser($content);
                            enter_content(dbConnection(), $date, $title, $image, $content, $category);
                        }
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
    <script src="js/main.js"></script>
</html>
