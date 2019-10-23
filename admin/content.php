<?php 
session_start();
if($_SESSION['user'] == null){
    header("Location: login.php");
}
include_once 'assets/connection.php';
include_once 'assets/sales.php';
include_once 'assets/data.php';
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
                            $content = $_POST["content"];
                            $content = htmlspecialchars($content, ENT_QUOTES);
                            $title = $_POST["title"];
                            $image = $_POST["postimage"];
                            $category = $_POST["category"];
                            $replace = ["<div class='code'>$1</div>",
                                        "<span class='function'>$1(<span class='var'>$2</span>)</span>",
                                        "<span class='type'>$1</span>",
                                        "<span class='msg'>$1</span>",
                                        "<span class='numb'>$1</span>",
                                        "<a class='link' href='$1'>$2</a>"];
                            $find = ["/\[code](.*?)\[\/code\]/s",
                                     "/([a-zA-Z0-9_-]*)\((.*)\)/",
                                     "/(\bint|\bstr|\bchar|\blong|\bString|\bbyte)/",
                                     "/(\".*\")/",
                                     "/([0-9])/",
                                     "/\[link\](.*?)\:(.*?)\[\/link\]/"];
                            $content = preg_replace($find, $replace, $content);

                            var_dump($content);
                            enter_content($conn, $title, $image, $category, $content);
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
