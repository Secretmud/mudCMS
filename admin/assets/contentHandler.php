<?php

class ContentHandler {

    private $conn;

    function __contructor(\PDO $conn) {
        $this->conn = $conn;
    }

    public function contentParser($content) {
        $replace = ["<span class='function'>$1(<span class='var'>$2</span>)</span>",
                    "<span class='type'>$1</span>",
                    "<span class='msg'>$1</span>",
                    "<span class='numb'>$1</span>",
                    "<a class='link' href='$1' target='_blank'>$2</a>"];
        $find = ["/([a-zA-Z0-9_-]*)\((.*)\)/",
                 "/(\bint|\bstr|\bchar|\blong|\bString|\bbyte)/",
                 "/(\".*\")/",
                 "/([0-9])/",
                 "/\[link\](.*)\:(.*)\[\/link\]/"];
        $arr = explode("\n", $content);
        $first = true;
        $output = "";
        $code = "";
        $x = 0;
        $indexes = array();
        $i = 0;
        foreach ($arr as $a) {
            if (preg_match("/~/", $a, $match)) {
                if ($first) {
                    $a = "<div class='code'>";
                    $first = false;
                    $indexes[$i] = [$x];
                    $i++;
                } else {
                    $a = "</div>";
                    $first = true;
                    $indexes[$i] = [$x];
                    $i++;
                }
            }
            $x++;
            $output .= $a;
        }
        /*
        for ($i = 0; $i < count($indexes); $i++) {
            for ($x = $indexes[$i]; $x < $indexes[$i + 1]; $x++) {
                $output .= preg_replace($find, $replace, $arr[$x]);
            }
        }
        */
        print_r($indexes);
        echo $output;
        return $output;
    }
}
