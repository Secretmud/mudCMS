<?php

class PostServer {
    private $conn;

    public function __construct() {
        include "connection.php";
        $this->conn = dbConnection();
    }

    public function get_posts_latest($amnt, $page = 0) {
        $offset = $page * $amnt;
        $posts = $this->conn->prepare('SELECT * 
                                       FROM posts 
                                       ORDER BY id 
                                       DESC LIMIT :amnt OFFSET :offset');
        $posts->bindValue(':amnt', $amnt, PDO::PARAM_INT);
        $posts->bindValue(':offset', $offset, PDO::PARAM_INT);
        $posts->execute();
        $str = $this->create_content($posts->fetchAll());

        return $str;
    }

    public function get_total_posts() {
        $total_posts = $this->conn->prepare('SELECT id
                                             FROM posts');

        $total_posts->execute();
        return $total_posts->rowCount();
    }

    private function create_content($posts) {
        $str = "";
        foreach ($posts as $post) {
            $str .= "
            <div class='post'>
                <div class='content-title'>".$post['title']."</div> ";
            if ($post['postimage'] != null) {
                $str .= "<img class='image-post' src='".$post['postimage']."'></img>";
            }
            $str .="<div class='content-info'>".$post['poster']."<br>".$post['postdate']."<br>".$post['category']."
                </div>
                <div class='content'>".$this->content_parser($this->get_content($post['content']))."</div>
                
                <a class='content-link' href='page_view.php?contentId=".$post['id']."'>Read more...</a>
                </div>";
        }

        return $str;
    }

    private function create_single_post_content($post) {
        $str = "<div class='post'><div class='content-title'>".$post['title']."</div>";
        if ($post['postimage'] != null) {
            $str .= "<img class='image-post' src='".$post['postimage']."'></img>";
        }
        $str .= "<div class='content'>".$this->content_parser($post['content'])."</div> ";

        return $str;
    }

    private function get_content($content) {
        $lines = explode("\n", $content);
        $new_content = "";
        $size = 3;
        $end = 0;
        foreach ($lines as $line) {
            if (preg_match("/!(.*):(.*)/", $line) == 1) {
                continue;
            }
            $new_content .= $line."\n";
            if ($end == $size) break;
            $end ++;
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

    public function get_posts_cat($cat, $amnt, $page=0): string
    {
        $offset = $page * $amnt;
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

    private function countChars($var) {
        $amt = 0;
        foreach (str_split($var) as $x) {
            if ($x === "#")
                $amt++;
            else 
                break;
        }
        return $amt;
    }

    private function content_parser($content) {
        $arr = explode("\n", $content);
        $str = "";
        $first = true;
        $code = array();
        $ln = 0;
        foreach ($arr as $a) {
            if (preg_match("/^~/m", $a)) {
                array_push($code, $ln);
            }
            $ln++;
        }

        for ($i = 0; $i < sizeof($code); $i+=2) {
            $arr[$code[$i]] = preg_replace("/^~(.*)/", "<div class='code'>$1", $arr[$code[$i]]);
            $arr[$code[$i+1]] = preg_replace("/^~/", "</div>", $arr[$code[$i+1]]);
            $start = $code[$i];
            while ($start != $code[$i+1]) {
                $find = ["/([a-zA-Z0-9_-]*)\((.*)\)/",
                        "/(\bint|\bstr|\bchar|\blong|\bString|\bbyte)/",
                        "/(\".*\")/",
                        "/([0-9])/",
                        "/\[link\](.*)\:(.*)\[\/link\]/",
                        ];
                $replace = ["<span class='function'>$1(<span class='var'>$2</span>)</span>",
                            "<span class='type'>$1</span>",
                            "<span class='msg'>$1</span>",
                            "<span class='numb'>$1</span>",
                            "<a class='link' href='$1' target='_blank'>$2</a>"];
                //$tmp = ($arr[$x] == "") ? "<div></div>" : preg_replace($find, $replace, $arr[$x]);
                $arr[$start] = preg_replace($find, $replace, $arr[$start]);
                $start++;
            }
        }
        $x = 0;
        for ($i = 0; $i < sizeof($arr); $i++) {
            if (in_array($i, $code)) {
                $i = $code[$x+1];
                $x+=2;
            }
            if (preg_match("/^#/m", $arr[$i])) {
                $replace = "";
                $count = $this->countChars($arr[$i]); 
                switch($count) {
                    case 1:
                        $replace = "<h1>$1</h1>";
                        break;
                    case 2:
                        $replace = "<h2>$1</h2>";
                        break;
                    case 3:
                        $replace = "<h3>$1</h3>";
                        break;
                    default:
                        $replace = "<h1>$1</h1>";
                        break;
                }
                $arr[$i] = preg_replace("/#{".$count."}(.*)/", $replace, $arr[$i]);
            } else if (preg_match("/-- (.*)/m", $arr[$i])) {
                $arr[$i] = preg_replace("/-- (.*)/", "<p class='citation'>$1</p>", $arr[$i]);
            } else if (preg_match("/!(.*):(.*)/m", $arr[$i])) {
                $arr[$i] = str_replace(array("\r", "\n"), '', $arr[$i]);
                $arr[$i] = preg_replace("/!(.*):(.*)/", "<img class='image' src='$1' alt='$2'>", $arr[$i]);
            }
        }
        foreach ($arr as $ot) $str .= $ot;
        return $str;
    }
}