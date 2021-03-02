<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

class api {

    private $rb;
    function __construct() {
        include_once "assets/responseBuilder.php";
        require_once "assets/connection.php";
        $this->rb = new responseBuilder(dbConnection());
    }

    public function getPostCat($category) {
        $this->rb->getPostsCat($category);
    }
    
    public function getPostLatest() {
        $this->rb->getPost();
    }
    
    public function getAllPost() {
        $this->rb->getPostsLatest();
    }

    public function createPost() {

    }

    public function deletePost($id) {

    }
}

$a = new api();
switch($_GET['type']) {
    case "all":
        $a->getAllPost();
        break;
    case "latest":
        $a->getPostLatest();
        break;
    case "cat":
        $a->getPostCat($_GET['cat']);
        break;
}