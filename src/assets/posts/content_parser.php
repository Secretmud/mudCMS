<?php

class ContentParser {


    private function code_block_builder(array $list) : String {

        return $code_block;
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

    public function content_parser($content) {
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
        /*
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
        */
        foreach ($arr as $ot) $str .= $ot;
        return $str;
    }

}