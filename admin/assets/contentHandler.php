<?php

class ContentHandler {

    private $conn;

    function __contructor(\PDO $conn) {
        $this->conn = $conn;
    }

    public function contentParser($content) {
        $replace = ["<div class='code'>$1</div>",
                    "<span class='function'>$1(<span class='var'>$2</span>)</span>",
                    "<span class='type'>$1</span>",
                    "<span class='msg'>$1</span>",
                    "<span class='numb'>$1</span>",
                    "<a class='link' href='$1' target='_blank'>$2</a>"];
        $find = ["/\[code](.*?)\[\/code\]/s",
                 "/([a-zA-Z0-9_-]*)\((.*)\)/",
                 "/(\bint|\bstr|\bchar|\blong|\bString|\bbyte)/",
                 "/(\".*\")/",
                 "/([0-9])/",
                 "/\[link\](.*)\:(.*)\[\/link\]/"];
        $content = preg_replace($find, $replace, $content);
        return $content;
    }
}
