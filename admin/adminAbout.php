<?php 
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
                        <h1>About you:</h1>
                        <form method="POST" enctype="multipart/form-data">
                            <input type="text" name="name" placeholder="name" required>
                            <input type="file" name="profilepic" placeholder="profileimg" >
                            <textarea required placeholder="about" name="about" id="contentBox" style="height: 300px; width: 100%; resize: none;"></textarea>
                            <input type="submit" value="submit" name="submit">
                        </form>
                        <?php
                        require("../assets/connection.php");
                        $username = $_POST["name"];
                        $about = $_POST["about"];
                        $images = "images/";
                        if(isset($_POST['submit'])) {
                            $loc = addImage($_FILES["profilepic"], $images);

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
</html>
