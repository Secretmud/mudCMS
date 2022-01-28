<?php

namespace Secret\MudCms\assets\posts;

class ContentParser {


    private function code_block_builder(array $list) : String {

        $code_block = "";
        return $code_block;
    }

    private function countChars($var): int {
        $amt = 0;
        foreach (str_split($var) as $x) {
            if ($x === "#")
                $amt++;
            else 
                break;
        }
        return $amt;
    }

    public function content_parser($content): string {
        $arr = explode("\n", $content);
        $str = "";
        $first = true;
        $code = array();
        $ln = 0;
        $citation = [];
        foreach ($arr as $a) {
            if (preg_match("/^~/", $a)) {
                array_push($code, $ln);
            }
            $ln++;
        }
        for ($i = 0; $i < sizeof($code); $i+=2) {
            $arr[$code[$i]] = preg_replace("/^~(.*)/", "<div class='code'>$1", $arr[$code[$i]]);
            $arr[$code[$i+1]] = preg_replace("/^~/", "</div>", $arr[$code[$i+1]]);
            for ($x = $code[$i]; $x < $code[$i+1]; $x++) {
                $find = ["/([a-zA-Z0-9_-]*)\((.*)\)/",
                        "/(\bint|\bstr|\bchar|\blong|\bString|\bbyte)/",
                        "/(\".*\")/",
                        "/([0-9])/",
                        ];
                $replace = ["<span class='function'>$1(<span class='var'>$2</span>)</span>",
                            "<span class='type'>$1</span>",
                            "<span class='msg'>$1</span>",
                            "<span class='numb'>$1</span>"];
                //$tmp = ($arr[$x] == "") ? "<div></div>" : preg_replace($find, $replace, $arr[$x]);
                $arr[$x] = preg_replace($find, $replace, $arr[$x]);
            }
        }
        $x = 0;
        for ($i = 0; $i < sizeof($arr); $i++) {
            if (strlen($arr[$i]) === 1) {
                $arr[$i] == "<p>";
            }
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
            } else if (preg_match("/\{.*\}/", $arr[$i])) {
                $last = (sizeof($citation) > 0) ? sizeof($citation) + 1 : 1;
                preg_match("/\{(.*)\}/", $arr[$i], $matches);
                foreach ($matches as $k => $v) {
                    if ($k === 1) 
                        array_push($citation, [$last => $v]); 
                    if ($k === 0)
                        $arr[$i] = str_replace($v, "<a class='citation-number' href='#" . $last . "'>" . $last . "</a>", $arr[$i]);
                }
            } else if (preg_match("/!(.*):(.*)/m", $arr[$i])) {
                $arr[$i] = str_replace(array("\r", "\n"), '', $arr[$i]);
                $arr[$i] = preg_replace("/!(.*):(.*)/", "<img class='image' src='$1' alt='$2'>", $arr[$i]);
            }
        }
        if (sizeof($citation) > 0) {
            $cites = "<div><h2>References</h2><div class='citation-list'>";
            foreach ($citation as $c) {
                foreach ($c as $k => $v) {
                    $cites .= "<div><a id='" . $k . "'>" . $k . "</a>";

                    $cites .= "<span class='citation'>" . $v . "</span></div>";
                }
            }
            $cites .= "</div></div>";
            array_push($arr, $cites);
        }
        foreach ($arr as $ot) $str .= $ot;
        return $str;
    }
}