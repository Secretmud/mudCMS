<?php

class ContentVerify {

    public function verify_code_tags(array $block) : bool {
        $end = FALSE; 
        $counter = 0;
        $seeker = 0;
        while (!$end) {
            if ($counter >= sizeof($block)) break;
            if (preg_match("/^~/", $block[$counter])) {
                if ($counter + 1 >= sizeof($block)) return false;
                $seeker = $counter + 1;
                while (!preg_match("/^~/", $block[$seeker])) {
                    $seeker++;
                    if ($seeker >= sizeof($block)) return false;
                }
                $counter = $seeker;
            } 
            $counter++;
        }

        return TRUE;
    }

    public function verify_image(String $image) : bool {
        return preg_match("/!(.*):(.*)/", $image);
    }

    public function verify_citation(String $citation) : bool {
        return preg_match("/--\((.*)\)/", $citation);
    }

}
