<?php
session_start();
if($_SESSION['user'] == null) {
	header("Location: login.php");
}
function enter_content($conn, $title, $postimage, $category, $content) {
	$save_data = $conn->prepare("INSERT INTO content(postdate, title, poster, content, postimage, category) 
								 VALUES (CURRENT_DATE, :title, :poster, :content, :postimage, :category)");
	$save_data->execute([':title' => $title, ':poster' => $_SESSION['user'], ':content' => $content, ':postimage', ':category' => $category]);
}
