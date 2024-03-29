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
                $count = $this->countChars($arr[$i]);
                $count = ($count < 6) ? $count : 5; 
                $replace = "<h".$count.">$1</h".$count.">";
                $arr[$i] = preg_replace("/#{".$count."}(.*)/", $replace, $arr[$i]);
            } else if (preg_match("/\{.*\}/", $arr[$i])) {
                $arr[$i] = $this->citation($arr[$i], $citation);
            } else if (preg_match("/!(.*):(.*)/m", $arr[$i])) {
                $arr[$i] = str_replace(array("\r", "\n"), '', $arr[$i]);
                $arr[$i] = preg_replace("/!(.*):(.*)/", "<img class='image' src='$1' alt='$2'>", $arr[$i]);
            }
            if (is_string($arr[$i])) {
                $arr[$i] = "<p class='post-paragraph' >" . $arr[$i] . "</p>";
            }
            
        }
        if (sizeof($citation) > 0) {
            $cites = "<div><span class='content-title'>References</span><div class='citation-list'>";
            foreach ($citation as $c) {
                foreach ($c as $k => $v) {
                    $cites .= "<div><a class='citation-list-number' href='#b".$k."'id='" . $k . "'>" . $k . "</a>";

                    $cites .= "<span class='citation'>" . $v . "</span></div>";
                }
            }
            $cites .= "</div></div>";
            array_push($arr, $cites);
        }
        foreach ($arr as $ot) $str .= $ot;
        return $str;
    }

    private function citation($string, &$citation): String {
        $last = (sizeof($citation) > 0) ? sizeof($citation) + 1 : 1;
        $str = "";
        preg_match("/\{(.*)\}/", $string, $matches);
        foreach ($matches as $k => $v) {
            if ($k === 1) 
                array_push($citation, [$last => $v]); 
            if ($k === 0)
                $str = str_replace($v, "<a class='citation-number' id='b" . $last . "' href='#" . $last . "'>" . $last . "</a>", $string);
        }
        return $str;
    }

}
