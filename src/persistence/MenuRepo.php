<?php
namespace Secret\MudCms\persistence;
use Secret\MudCms\persistence\Connection;
use PDO;
require_once ("Connection.php");

class MenuRepo {
    private PDO $conn;
    public function __construct() {
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