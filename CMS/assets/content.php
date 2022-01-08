<?php

class PostServer {
    private $conn;
    
    public function __construct() {
        include "connection.php";
        $this->conn = dbConnection();
    }
    
    public function get_posts_latest($amnt) {
        $posts = $this->conn->prepare('SELECT * 
                                       FROM posts 
                                       ORDER BY id 
                                       DESC LIMIT :amnt');
        $posts->bindValue(':amnt', $amnt, PDO::PARAM_INT);
        $posts->execute();
        $str = "";
        while($row = $posts->fetch()) {
            $str .= "
            <div class='content'>
                <div class='content-title'>
                    ".$row['title']."
                </div>
                <div class='content-info'>
                    ".$row['poster']."<br>".$row['postdate']."<br>".$row['category']."
                    </div>".$row['content']."
                    <a class='content-link' href='page_view.php?cat=".$row['category']."&contentId=".$row['id']."'.>Read more...</a>
            </div>
            ";
        }

        return $str;
    }

    public function get_menu($amnt) {
        $posts = $this->conn->prepare('SELECT category, count(*) as NUM 
                                       FROM posts 
                                       GROUP BY category
                                       DESC LIMIT :amnt');
        $posts->bindValue(':amnt', $amnt, PDO::PARAM_INT);
        $posts->execute();
        $str = "";
        while($row = $posts->fetch()) {
            $str .= "<a class='' href='page_view.php?type=cat&category=".$row['category']."'>".$row['category']."</a>";
        }
        return $str;

    }

    public function get_posts_cat($cat) {
        $posts = $this->conn->prepare('SELECT * FROM posts WHERE category=:category');
        $data = ""; 
        try {
            $posts->bindParam(':category', $cat);
            $posts->execute();         
        } catch (Exception $e) {
            $data .= "Error: ".$e;
        }
        if ($posts->fetch()) {
            while($row = $posts->fetch()) {
                $data.= "title".$row['title']."
                    postimage".$row['postimage']."
                    author".$row['poster']."
                    postdate".$row['postdate']."
                    content".$row['content']."";
            }
        } else {
            $data .= "Error: No such category";
        }
        return $data;
    }
}