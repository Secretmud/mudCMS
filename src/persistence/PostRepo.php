<?php

namespace Secret\MudCms\persistence;


use Connection;
use Exception;
use PDO;

class PostRepo
{
    private $conn;

    public function __construct() {
        require_once ("Connection.php");
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

    public function get_total_posts(): int
    {
        $total_posts = $this->conn->prepare('SELECT id
                                             FROM posts');

        $total_posts->execute();
        return $total_posts->rowCount();
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

}