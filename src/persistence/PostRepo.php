<?php

namespace Secret\MudCms\persistence;


use Secret\MudCms\persistence\Connection;
use Exception;
use PDO;
require_once ("Connection.php");

class PostRepo
{
    private PDO $conn;

    public function __construct() {
        $this->conn = (new Connection)->getConnection();
    }

    public function get_posts_latest($amnt, $offset = 0 ) {
        $posts = $this->conn->prepare('SELECT * 
                                       FROM posts 
                                       ORDER BY id 
                                       DESC LIMIT :amnt OFFSET :offset');
        $posts->bindValue(':amnt', $amnt, PDO::PARAM_INT);
        $posts->bindValue(':offset', $offset, PDO::PARAM_INT);
        $posts->execute();
        return $posts->fetchAll();
    }

    public function get_all_posts() {
        $post = $this->conn->prepare("SELECT * FROM posts ORDER BY id DESC");
        $post->execute();
        return $post->fetchAll();
    }

    public function get_total_posts(): int
    {
        $total_posts = $this->conn->prepare('SELECT count(*) FROM posts');
        $total_posts->execute();
        return $total_posts->fetch()[0];
    }

    public function get_posts_cat($cat, $amnt, $offset = 0) {
            $posts = $this->conn->prepare('SELECT * FROM posts WHERE category=:category
                                                order by id
                                                DESC LIMIT :amnt OFFSET :offset ');
            $data = "";
            try {
                $posts->bindParam(':category', $cat);
                $posts->bindValue(':amnt', $amnt, PDO::PARAM_INT);
                $posts->bindValue(':offset', $offset, PDO::PARAM_INT);
                $posts->execute();
            } catch (Exception $e) {
                $data .= "Error: ".$e;
            }
            if ($this->count_posts_in_cat($cat) > 0) {
                $data = $posts->fetchAll();
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
        return $posts->fetch();
    }

    public function add_post( $date, $title, $postimage, $content, $category){

        $this->check_login();


        $save_data = $this->conn->prepare("INSERT INTO posts(postdate, title, poster, content, postimage, category) 
								 VALUES (:postdate, :title, :poster, :content, :postimage, :category)");
        $save_data->execute([':postdate' => $date, ':title' => $title, ':poster' => $_SESSION['user'], ':content' => $content, ':postimage' => $postimage, ':category' => $category]);

    }

    public function edit_post($id, $title, $post_image, $content, $category) {

        $this->check_login();


        $save_data = $this->conn->prepare("UPDATE posts SET title =:title, content=:content, postimage=:postimage, category=:category WHERE id=:id");
        $save_data->bindParam(':title', $title);
        $save_data->bindParam(':postimage', $post_image);
        $save_data->bindParam(':content', $content);
        $save_data->bindParam(':category', $category);
        $save_data->bindParam(':id', $id);

        $save_data->execute();

    }

    public function delete_post() {

    }

    public function get_last_post_title() {
        $post_title = $this->conn->prepare('SELECT title FROM posts 
                                  ORDER BY id 
                                  DESC LIMIT 1');
        $post_title->execute();
        return $post_title->fetch(PDO::FETCH_ASSOC)['title'];
    }

    public function get_most_popular_cat() {
        $highest_cat = $this->conn->prepare('SELECT category FROM posts
                                   GROUP BY category
                                   ORDER BY count(*) DESC LIMIT 1');
        $highest_cat->execute();
        return $highest_cat->fetch(PDO::FETCH_ASSOC)['category'];
    }

    /**
     * @return void
     */
    public function check_login(): void
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        ob_start();
        if ($_SESSION['user'] == null) {
            header("Location: login.php");
        }
    }


}