<?php

class responseBuilder {

    private $conn;
    private $ch;
    function __construct(\PDO $conn) {
        require_once "contentBuilder.php";
        $this->conn = $conn;
        $this->ch = new ContentHandler($this->conn);
    }

    public function getPostsCat($cat) {
        $posts = $this->conn->prepare("SELECT * FROM posts WHERE category=:category ORDER BY id DESC");
        $data = array();
        try {
            $posts->bindParam(':category', $cat);
            $posts->execute();         
        } catch (Exception $e) {
            array_push($data, ["Error" => "$e"]);
        }
        if ($posts->fetch()) {
            while($row = $posts->fetch()) {
                array_push($data, [
                    "title" => $row['title'],
                    "postimage" => $row['postimage'],
                    "author" => $row['poster'],
                    "postdate" => $row['postdate'],
                    "content" => $this->ch->ContentParser($row['content'])]);
            }
        } else {
            array_push($data, ["Error" => "No such category"]);
        }
        echo json_encode($data);
    }
    
    public function getPost() {
        $posts = $this->conn->prepare("SELECT * FROM posts ORDER BY id DESC LIMIT 1");
        $posts->execute();
        $row = $posts->fetch();
        $data = [
            "title" => $row['title'],
            "postimage" => $row['postimage'],
            "author" => $row['poster'],
            "postdate" => $row['postdate'],
            "content" => $this->ch->ContentParser($row['content'])];
        echo json_encode($data);
    }
                            
    public function getPostsLatest() {
        $posts = $this->conn->prepare('SELECT * 
                                 FROM posts
                                 ORDER BY postdate DESC');
        $posts->execute();
        $data = array();
        while($row = $posts->fetch()) {
            array_push($data, [
                "title" => $row['title'],
                "author" => $row['poster'],
                "postdate" => $row['postdate'],
                "content" => $this->ch->ContentParser($row['content']),
                "category" => $row['category'],
                "id" => $row['id']]);
        }
        echo json_encode($data);
    }
}