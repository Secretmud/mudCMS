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
        echo "<div class='content'>
                  <div class='content-title'>
                  ".$row['title']."
                  </div>
                  <img src=".$row['postimage']."></img>
                  <div class='content-info'>
                      ".$row['poster']."<br>".$row['postdate']."
                  </div>
                  <div class='content'>
                      ".$row['content']."
                  </div>
              </div>";
    }
}

                        
function getPostsLatest($conn, $amnt) {
    $posts = $conn->prepare('SELECT * 
                             FROM content 
                             ORDER BY id 
                             DESC LIMIT :amnt');
    $posts->bindValue(':amnt', $amnt, PDO::PARAM_INT);
    $posts->execute();
    while($row = $posts->fetch()) {
        echo "<div class='content'>
                <div class='content-title'>
                    ".$row['title']."
                </div>
                <div class='content-info'>
                    ".$row['poster']."<br>".$row['postdate']."<br>".$row['category']."
                    </div>".$row['content']."
                    <a class='content-link' href='content.php?category=".$row['category']."&contentId=".$row['id']."'.>Read more...</a>
                </div>";
    }
}