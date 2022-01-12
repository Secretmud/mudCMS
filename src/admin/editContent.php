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
                    <?php include('admin-addins/header.php'); ?>
                </div>
            </div>
            <div class="center-top">
                <div class="grid-content">
					<div class="content">
                        <h3>Edit content:</h3>
                        <form method="post">
                            <input type="text" name="search">
                            <input type="submit" value="submit">
                        </form>
                        <?php
                        $conn = (new Connection)->getConnection();
                        include("assets/data.php");
                        require("assets/editing.php");
                        $ed = new EditContent();
                        $ed->listPosts($conn);
                        if (isset($_POST['submit'])) {
                            $contentarr = $ch->getPost($conn, $id);
                            echo "
                                <form method='POST' enctype='multipart/form-data'>
                                    <input type='text' name='title' required>".$contentarr['title']."</input> <br>
                                    <input type='file' name='postimage' >".$contentarr['postimage']."</input><br>
                                    <input type='text' name='category'required>".$contentarr['category']."</input><br>
                                    <textarea required name='content' id='contentBox' style='height: 300px; width: 100%; resize: none;'>".$contentarr['content']."</textarea>
                                    <input type='submit' value='submit change' name='submit_change'>
                                </form>
                            ";
                            if (isset($_POST["submit_change"])) {
                                enter_content($conn, $date, $title, $image, $content, $category);
                            }
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
	</body>
    <script src="js/main.js"></script>
</html>
