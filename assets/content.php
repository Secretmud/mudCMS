<?php
function getPostsCat($conn, $cat) {
    $posts = $conn->prepare("SELECT * FROM content WHERE category=:category ORDER BY id DESC");
    try {
        $posts->bindParam(':category', $cat);
        $posts->execute();
        
    } catch (Exception $e) {
        header('Location: 404page.php');
    }
    while($row = $posts->fetch()) {
        echo "<div class='content'>";
        echo "<div class='content-title'>";
        echo $row['title'];
        echo "</div>";
        echo "<div class='content-info'>";
        echo $row['poster']."<br>".$row['postdate'];
        echo "</div>";
        echo "<div class='content'>";
        echo $row['content'];
        echo "</div>";
        echo "</div>";
    }
}

                        
function getPostsLatest($conn, $amnt) {
    $posts = $conn->prepare('SELECT * 
                             FROM content 
                             ORDER BY postdate 
                             DESC LIMIT :amnt');
    $posts->bindValue(':amnt', $amnt, PDO::PARAM_INT);
    $posts->execute();
    while($row = $posts->fetch()) {
        echo "<div class='content'>";
        echo "<div class='content-title'>";
        echo $row['title'];
        echo "</div>";
        echo "<div class='content-info'>";
        echo $row['poster']."<br>".$row['postdate']."<br>".$row['category'];
        echo "</div>";
        echo implode(' ', array_slice(explode(' ', $row['content']), 0, 40))."... ";
        echo "<a class='content-link' href='content.php?category=".$row['category']."&contentId=".$row['id']."'.>";
        echo "Read more...</a>";
        echo "</div>";
        echo "</div>";
    }
}