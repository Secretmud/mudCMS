<?php

use Secret\MudCms\persistence\MenuRepo;
use Secret\MudCms\persistence\PostRepo;

class PostServer {
    private $posts_repo;
    private $menu_repo;

    public function __construct() {
        require_once("persistence/MenuRepo.php");
        $this->posts_repo = new PostRepo();
        $this->menu_repo = new MenuRepo();
        include "posts/content_parser.php";
        $this->cp = new ContentParser();
    }

    public function get_posts_latest($amnt, $page = 0) {
        $offset = $page * $amnt;
        return $this->create_content($this->posts_repo->get_posts_latest($amnt, $offset));
    }


    private function create_content($posts) {
        $str = "";
        foreach ($posts as $post) {
            $str .= "
            <div class='post'>
                <div class='content-title'>".$post['title']."</div> ";
            if ($post['postimage'] != null) {
                $str .= "<img class='image-post' src='".$post['postimage']."'></img>";
            }
            $str .="<div class='content-info'>".$post['poster']."<br>".$post['postdate']."<br>".$post['category']."
                </div>
                <div class='content'>".$this->cp->content_parser($this->get_content($post['content']))."</div>
                
                <a class='content-link' href='page_view.php?contentId=".$post['id']."'>Read more...</a>
                </div>";
        }

        return $str;
    }

    private function create_single_post_content($post) {
        $str = "<div class='post'><div class='content-title'>".$post['title']."</div>";
        if ($post['postimage'] != null) {
            $str .= "<img class='image-post' src='".$post['postimage']."'></img>";
        }
        $str .= "<div class='content'>".$this->cp->content_parser($post['content'])."</div> ";

        return $str;
    }

    private function get_content($content) {
        $lines = explode("\n", $content);
        $new_content = "";
        $size = 3;
        $end = 0;
        foreach ($lines as $line) {
            if (preg_match("/!(.*):(.*)/", $line) == 1) {
                continue;
            }
            $new_content .= $line."\n";
            if ($end == $size) break;
            $end ++;
        }
        return $new_content;

    }


    public function get_menu($amnt) {
        return $this->menu_repo->get_menu($amnt);

    }

    public function get_posts_cat($cat, $amnt, $page=0): string
    {
        $offset = $page * $amnt;
        return $this->create_content($this->posts_repo->get_posts_cat($cat, $amnt, $offset));
    }

    public function get_single_post($id) {
        return $this->create_single_post_content($this->posts_repo->get_single_post($id));
    }
}