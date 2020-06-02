<?php

class ContentHandler {

    private $conn;

    function __contructor(\PDO $conn) {
        $this->conn = $conn;
    }

    public function contentParser($content) {
        $arr = explode("\n", $content);
        $first = true;
        $output_tmp = array();
        $line = array();
        $output = "";
        $x = 0;
        $i = 0;
        foreach ($arr as $a) {
            if (preg_match("/^~/m", $a, $match)) {
                $line[$i] = $x;
                if ($first) {
                    $a = "<div class='code'>";
                    $first = false;
                    $i++;
                } else {
                    $a = "</div>";
                    $first = true;
                    $i++;
                }
            }
            $output_tmp[$x] = $a;
            $x++;
        }
        for ($i = 0; $i < count($line)-1; $i+=2) {
            $ln = 1;
            for ($x = $line[$i]; $x < $line[$i+1]; $x++) {
                if ($x != $line[$i]) {
                    $find = ["/([a-zA-Z0-9_-]*)\((.*)\)/",
                             "/(\bint|\bstr|\bchar|\blong|\bString|\bbyte)/",
                             "/(\".*\")/",
                             "/([0-9])/",
                             "/\[link\](.*)\:(.*)\[\/link\]/"];
                    $replace = ["<span class='function'>$1(<span class='var'>$2</span>)</span>",
                             "<span class='type'>$1</span>",
                             "<span class='msg'>$1</span>",
                             "<span class='numb'>$1</span>",
                             "<a class='link' href='$1' target='_blank'>$2</a>"];
                    //$tmp = ($arr[$x] == "") ? "<div></div>" : preg_replace($find, $replace, $arr[$x]);
                    $output_tmp[$x] = preg_replace($find, $replace, $arr[$x]);
                    $ln++;
                }
            }
        }
        foreach ($output_tmp as $ot) {
            $output .= $ot;
        }
        return $output;
    }
}
