<?php
namespace Secret\MudCms\assets;

use Secret\MudCms\persistence\PostRepo;
use Secret\MudCms\services\PostService;

class ResponseBuilder {
    private PostService $ps;
    private int $amt;
    private int $limit;
    private PostRepo $posts_repo;
    public function __construct() {
        require_once ("services/PostService.php");
        require_once("persistence/PostRepo.php");
        $this->posts_repo = new PostRepo();
        $this->ps = new PostService();
        $this->amt = 5; 
        $this->limit = floor($this->posts_repo->get_total_posts()/$this->amt);
    }

    public function page_view($page = 0): string {
        if ($page < 0) $page = 0;
        if ($page > $this->limit) $page = $this->limit;
        return $this->site_layout($this->ps->get_posts_latest($this->amt, $page), $page, 1);

    }

    public function post_view($id): string {
        return $this->site_layout($this->ps->get_single_post($id));
    }

    public function show_cat($cat, $page=0): string {
        if ($page < 0) $page = 0;
        if ($page > $this->limit) $page = $this->limit;
        return $this->site_layout($this->ps->get_posts_cat($cat, $this->amt, $page), $page, 1);
    }

    public function add_arrows($page): string {
        $type = 'latest';
        if (!empty($_GET['type'])) {
            $type = $_GET['type'];
        }

        $cat = $type == 'cat' ? $_GET['category'] : '';
        $cat_string = $cat != '' ? "&category=".$cat : '';
        $arrows = "<div class='bottom-navi'> ";
        if ($page > 0) {
            $arrows .=  "<a class='' href='page_view.php?type=".$type.$cat_string."&page=".($page-1)."'><i class='arrow left'></i></a>";
        } else {
            $arrows .= "<div class=''><i class='arrow-inactive left'></i></div>";
        }
        $arrows .= $page;
        // <a class='' href='page_view.php?type=cat&category=".$row['category']."'>".$row['category']."</a>
        if ($page < $this->limit) {
            $arrows .= "<a class='' href='page_view.php?type=".$type.$cat_string."&page=".($page+1)."'><i class='arrow right'></i></a>";
        } else {
            $arrows .= "<div class=''><i class='arrow-inactive right'></i></div>";
        }

        $arrows .= "</div>";

        return $arrows;
    }

    private function site_layout($main, $page=0, $show_arrows = 0 ): string {
        $response = "<div class='left-bar'><div class='menu menu_side'>";
        $response .= $this->ps->get_menu($this->amt);
        $response .= "</div></div><div class='center-top'><div class='grid-content'>";
        $response .= $main;
        if ($show_arrows) {
            $response .= $this->add_arrows($page);
        }
        #$response .= "</div></div>";
        return $response;
    }

}
