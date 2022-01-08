<?php

class ResponseBuilder {
    private $ps;
    private $amt;
    public function __construct() {
        include "content.php";
        $this->ps = new PostServer();
        $this->amt = 5; 
    }

    public function page_view() {
        return $this->site_layout($this->ps->get_posts_latest($this->amt));
    }

    public function show_cat($cat) {
        return $this->site_layout($this->ps->get_posts_cat($cat));
    }

    private function site_layout($main) {
        $response = "<div class='left-bar'><div class='menu menu_side'>";
        $response .= $this->ps->get_menu($this->amt);
        $response .= "</div></div><div class='center-top'><div class='grid-content'>";
        $response .= $main;
        $response .= "</div></div>";
        return $response;
    }
}
