<?php

class ContentHandler {

    private $conn;

    function __contructor(\PDO $conn) {
        $this->conn = $conn;
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

    public function contentParser($content) {
        $arr = explode("\n", $content);
        $first = true;
        $output_tmp = array();
        $line = array();
        $output = "";
        $x = 0;
        $i = 0;
        $match = null;
        foreach ($arr as $a) {
            if (preg_match("/^~/m", $a, $match)) {
                $line[$i] = $x;
                if ($first) {
                    $a = "<div class='code'>";
                    $first = false;
                } else {
                    $a = "</div>";
                    $first = true;
                }
                $i++;
            } else if (preg_match("/^#/m", $a, $match)) {
                $replace = "";
                $count = $this->countChars($a); 
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
                $a = preg_replace("/#{".$count."}(.*)/", $replace, $a);
            } else if (preg_match("/-- (.*)/m", $a, $match)) {
                $a = preg_replace("/-- (.*)/", "<p class='citation'>$1</p>", $a);
            } else if (preg_match("/!(.*):(.*)/m", $a, $match)) {
                $a = preg_replace("/!(.*):(.*)/", "<img class='image' src='$1' alt='$2'>", $a);
            }
            $output_tmp[$x] = $a;
            $x++;
            $match = null;
        }
        for ($i = 0; $i < count($line)-1; $i+=2) {
            $ln = 1;
            for ($x = $line[$i]; $x < $line[$i+1]; $x++) {
                if ($x != $line[$i]) {
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

    public function displayImg() {
        $images = 'images';
        $files = scandir("images/");
        for ($i = 2; $i < count($files); $i++) {
            echo "<img id='imgsrc".$i."' style='height: 50px; widht: 50px' src=".$images."/".$files[$i]."></img>";
        }
    }


    /**
     * This is pretty much all from w3schools(https://www.w3schools.com/).
     * Have to solve this myself, but one should
     * give credit where credit is due.
     */

    public function addImage($file, $images) {
        $images = "../images/";
        $target_file = $images . basename($file["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        $check = getimagesize($file["tmp_name"]);
        echo " " . $check . " " . $target_file . " " . $images;
        var_dump($file);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }
        if ($uploadOk == 1) {
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                return $target_file;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
}
