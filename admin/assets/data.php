<?php
if(!isset($_SESSION)) {
    session_start();
}
ob_start();
if($_SESSION['user'] == null){
    header("Location: login.php");
}
function enter_content($conn, $date, $title, $postimage, $content, $category) {
    echo $conn;
	$save_data = $conn->prepare("INSERT INTO content(postdate, title, poster, content, postimage, category) 
								 VALUES (:postdate, :title, :poster, :content, :postimage, :category)");
    $save_data->execute([':postdate' => $date, ':title' => $title, ':poster' => $_SESSION['user'], ':content' => $content, ':postimage' => 0, ':category' => $category]);
}
