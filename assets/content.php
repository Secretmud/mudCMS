<?php
function getPostsCat($conn, $cat) {
    $posts = $conn->prepare("SELECT *
                             FROM content
                             WHERE category=:category
                             ORDER BY id DESC"
                             );
    $posts->bindParam(':category', $cat);
    $posts->execute();
    while($row = $posts->fetch()) {
        echo "<div class='content'>";
        echo "<div class='content-title'>";
        echo $row['title'];
        echo "</div>";
        echo "<div class='content-info'>";
        echo $row['poster']."<br>".$row['postdate'];
        echo "</div>";
        if(!$row['postimage']) {
        } else {
            echo '<img class="image-post" src="data:/png;base64,'.base64_encode( $row['postimage'] ).'"/>';
        }
        echo "<div class='content'>";
        echo $row['content'];
        echo "</div>";
        if(!$row['code']){
        } else {
            echo "<div class='code'>";
            echo $row['code'];
            echo "</div>";
        }
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
        if(!$row['postimage']) {
        } else {
            echo '<img class="image-post" src="data:/png;base64,'.base64_encode( $row['postimage'] ).'"/>';
        }        echo "<div class='content'>";
        echo implode(' ', array_slice(explode(' ', $row['content']), 0, 40))."... ";
        echo "<a class='content-link' href=".$row['category'].".php>";
        echo "Read more...</a>";
        echo "</div>";
        echo "</div>";
    }
}