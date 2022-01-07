<?php

class ResponseBuilder {
    private $ps;
    public function __construct() {
        include "content.php";
        $this->ps = new PostServer(); 
    }

    public function page_view() {
        $amnt = 5;
        $response = "<div class='left-bar'><div class='menu menu_side'>";
        $response .= $this->ps->get_menu($amnt);
        $response .= "</div></div><div class='center-top'><div class='grid-content'>";
        $response .= $this->ps->get_posts_latest($amnt);
        $response .= "</div></div>";
        return $response;
    }

    public function show_cat($cat) {
        return $this->ps->get_posts_cat($cat);
    }
}
