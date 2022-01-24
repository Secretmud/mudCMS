<?php


use Secret\MudCms\admin\assets\EditContent;
use Secret\MudCms\persistence\PostRepo;

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
    <?php include('admin-addins/head.php');

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    ?>

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
                        <?php
                        require_once("assets/EditContent.php");
                        $ed = new EditContent();
                        $ed->listPosts();
//                        $ed->listPosts($conn);
                        if (isset($_GET['search'])) {
                            $id = $_GET["search"];
                            require_once("../persistence/PostRepo.php");
                            $post_repo = new PostRepo();
                            $contentarr = $post_repo->get_single_post($id);
                            echo "
                                <form method='POST' enctype='multipart/form-data'>
                                    <input type='text' name='title' placeholder='title' required value='".$contentarr['title']."'/> <br>
                                    <input type='text' name='postimage' placeholder='path/to/image' value='".$contentarr['postimage']."'/><br>
                                    <input type='text' name='category' placeholder='category' required value='".$contentarr['category']."'/><br>
                                    <textarea required name='content' id='contentBox' style='height: 300px; width: 100%; resize: none;'>".$contentarr['content']."</textarea>
                                    <input type='submit' value='submit change' name='submit_change'>
                                </form>
                            ";
                            if (isset($_POST["submit_change"])) {
                                $title = $_POST['title'];
                                $postImage = $_POST['postimage'];
                                $category = $_POST['category'];
                                $content = $_POST['content'];

                                $post_repo->edit_post($id, $title, $postImage, $content, $category);
                                header("Refresh:0");
//                                enter_content($conn, $date, $title, $image, $content, $category);
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
