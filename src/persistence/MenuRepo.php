<?php
namespace Secret\MudCms\persistence;
use Secret\MudCms\persistence\Connection;
use PDO;

class MenuRepo {
    private $conn;
    public function __construct() {
        require_once ("Connection.php");
        $this->conn = (new Connection)->getConnection();
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

}