<?php
namespace Secret\MudCms\services;
use Secret\MudCms\assets\posts\ContentParser;
use Secret\MudCms\persistence\MenuRepo;
use Secret\MudCms\persistence\PostRepo;

class PostService {
    private PostRepo $posts_repo;
    private MenuRepo $menu_repo;
    private ContentParser $cp;

    public function __construct() {
        require_once("persistence/MenuRepo.php");
        require_once("persistence/PostRepo.php");
        $this->posts_repo = new PostRepo();
        $this->menu_repo = new MenuRepo();
        include "assets/posts/ContentParser.php";
        $this->cp = new ContentParser();
    }

    public function get_posts_latest($amnt, $page = 0): string {
        $offset = $page * $amnt;
        return $this->create_content($this->posts_repo->get_posts_latest($amnt, $offset));
    }


    private function create_content($posts): string {
        $str = "";
        foreach ($posts as $post) {
            $str .= "
            <div class='post'>
                <div class='content-title'>".$post['title']."</div> ";
            if ($post['postimage'] != null) {
                $str .= "<img class='image-post' src='".$post['postimage']."'></img>";
            }
            $str .="<div class='content-info'>
                        <span>".$post['poster']."</span>
                        <span>".$post['postdate']."</span>
                        <span>".$post['category']."</span>
                    </div>
                    <div class='content'>".$this->cp->content_parser($this->get_content($post['content']))."</div>
                    <a class='content-link' href='page_view.php?contentId=".$post['id']."'>Read more...</a>
                    </div>";
        }

        return $str;
    }

    private function create_single_post_content($post): string {
        $str = "<div class='post'><div class='content-title'>".$post['title']."</div>";
        $str .="<div class='content-info'><span>".$post['poster']."</span><span>".$post['postdate']."</span><span>".$post['category']."</span></div>";
        if ($post['postimage'] != null) {
            $str .= "<img class='image-post' src='".$post['postimage']."'></img>";
        }
        $str .= "<div class='content'>".$this->cp->content_parser($post['content'])."</div> ";

        return $str;
    }

    private function get_content($content): string {
        $lines = explode("\n", $content);
        $new_content = "";
        $size = 3;
        $end = 0;
        for ($i = 0; $i < sizeof($lines); $i++) {
            if (preg_match("/!(.*):(.*)/", $lines[$i]) == 1) {
                continue;
            }
            if (preg_match("/^~/", $lines[$i])) {
                $i++;
                while ($i < sizeof($lines)) {
                    if (preg_match("/^~/", $lines[$i])) {
                        $i++;
                        if ($i >= sizeof($lines)) return $new_content;
                    }
                    $i++;
                }
            }
            $new_content .= $lines[$i]."\n";
            if ($end == $size) break;
            $end ++;
        }
        return $new_content;

    }


    public function get_menu($amnt): string {
        return $this->menu_repo->get_menu($amnt);

    }

    public function get_posts_cat($cat, $amnt, $page=0): string {
        $offset = $page * $amnt;
        return $this->create_content($this->posts_repo->get_posts_cat($cat, $amnt, $offset));
    }

    public function get_single_post($id): string {
        return $this->create_single_post_content($this->posts_repo->get_single_post($id));
    }
}