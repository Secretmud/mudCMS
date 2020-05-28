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
        $arr = str_split($content);
        $first = true;
        $output = "";
        $code = "";
        $x = 0;
        $indexes = array();
        $i = 0;
        foreach ($arr as $a) {
            if ($a === "~") {
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
            $output .= $a;
            $x++;
        }
        print_r($indexes);
        $output = preg_replace($find, $replace, $output);
        echo $output;
        return $output;
    }
}
