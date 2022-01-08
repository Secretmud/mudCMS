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
        $str = $this->create_content($posts->fetchAll());

        return $str;
    }

    private function create_content($posts) {
        $str = "";
        foreach ($posts as $post) {
            $str .= "<div class='content'><div class='content-title'>".$post['title']."</div> ";
            if ($post['postimage'] != null) {
                $str .= "<img class='image-post' src='".$post['postimage']."'></img>";
            }
            $str .="<div class='content-info'>".$post['poster']."<br>".$post['postdate']."<br>".$post['category']."
                </div>".$this->get_content($post['content'])."
                <a class='content-link' href='page_view.php?contentId=".$post['id']."'>Read more...</a>
                </div>";
        }

        return $str;
    }

    private function create_single_post_content($post) {
        $str = "<div class='content'><div class='content-title'>".$post['title']."</div>";
        if ($post['postimage'] != null) {
            $str .= "<img class='image-post' src='".$post['postimage']."'></img>";
        }
        $str .= "<div class='content'>".$post['content']."</div> ";

        return $str;
    }

    private function get_content($content) {
        $lines = explode("\n", $content);
        $new_content = "";
        $len = 30;
        $end = (strlen($content) > $strlen) ? $strlen : strlen($content);
        foreach ($lines as $line) {
            if (preg_match("/img/", $line) == 1) {
                continue;
            }

            for ($i = 0; $i < $end ; $i++) {
                $new_content .= $line[$i];
            }
        }
        return $new_content;

    }


    public function get_menu($amnt) {
        $posts = $this->conn->prepare('SELECT category, count(*) as NUM 
                                       FROM posts 
                                       GROUP BY category
                                       DESC LIMIT :amnt');
        $posts->bindValue(':amnt', $amnt, PDO::PARAM_INT);
        $posts->execute();
        $str = "<a class='' href='page_view.php'>Home</a>";
        while($row = $posts->fetch()) {
            $str .= "<a class='' href='page_view.php?type=cat&category=".$row['category']."'>".$row['category']."</a>";
        }
        return $str;

    }

    public function get_posts_cat($cat): string
    {
        $posts = $this->conn->prepare('SELECT * FROM posts WHERE category=:category');
        $data = "";
        try {
            $posts->bindParam(':category', $cat);
            $posts->execute();
        } catch (Exception $e) {
            $data .= "Error: ".$e;
        }
        if ($this->count_posts_in_cat($cat) > 0) {
            $data = $this->create_content($posts->fetchAll());
        } else {
            $data .= "Error: No such category";
        }
        return $data;
    }

    private function count_posts_in_cat($cat) {
        $count = $this->conn->prepare('SELECT COUNT(*) FROM posts WHERE category=:category');
        $count->bindParam(':category', $cat);
        $count->execute();
        return $count->fetch();

    }


    public function get_single_post($id) {
        $posts = $this->conn->prepare('SELECT * 
                                       FROM posts 
                                       WHERE id = :id');
        $posts->bindValue(':id', $id, PDO::PARAM_INT);
        $posts->execute();
        return $this->create_single_post_content($posts->fetch());
    }
}