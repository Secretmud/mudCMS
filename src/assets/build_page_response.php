<?php

class ResponseBuilder {
    private $ps;
    private $amt;
    public function __construct() {
        include "content.php";
        $this->ps = new PostServer();
        $this->amt = 5; 
    }

    public function page_view($page = 0) {
        return $this->site_layout($this->ps->get_posts_latest($this->amt, $page), $page, 1);

    }

    public function post_view($id) {
        return $this->site_layout($this->ps->get_single_post($id));
    }

    public function show_cat($cat) {
        return $this->site_layout($this->ps->get_posts_cat($cat));
    }

    public function add_arrows($page) {

       $arrows = "<div class='bottom-navi'> 
                    <a class='' href='page_view.php?type=latest&page=".($page-1)."'><i class='arrow left'></i></a>";
       // <a class='' href='page_view.php?type=cat&category=".$row['category']."'>".$row['category']."</a>
       $arrows .= "<a class='' href='page_view.php?type=latest&page=".($page+1)."'><i class='arrow right''></i></a></div>";

        return $arrows;
    }

    private function site_layout($main, $page=0, $show_arrows = 0 ) {
        $response = "<div class='left-bar'><div class='menu menu_side'>";
        $response .= $this->ps->get_menu($this->amt);
        $response .= "</div></div><div class='center-top'><div class='grid-content'>";
        $response .= $main;
        if ($show_arrows) {
            $response .= $this->add_arrows($page);
        }
        $response .= "</div></div>";
        return $response;
    }
}
