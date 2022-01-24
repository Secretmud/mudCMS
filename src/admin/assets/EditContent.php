<?php

namespace Secret\MudCms\admin\assets;


use Secret\MudCms\persistence\PostRepo;

class EditContent {

    private PostRepo $post_repo;

    function __construct() {
        require_once("../persistence/PostRepo.php");
        $this->post_repo = new PostRepo();
    }

    public function listPosts() {
        $postarr = $this->post_repo->get_all_posts();
        echo "<div class='list-edit-parent'>";
        foreach ($postarr as $pa) {
            echo "
                <div class='list-edit'>
                    <div class='id'>
                        ".$pa['id']."
                    </div>
                    <div class='title'>
                        ".$pa['title']."
                    </div>
                    <div class='date'>
                        ".$pa['postdate']."
                    </div>
                    <div class='poster'>
                        ".$pa['poster']."
                    </div>
                    <div>
                        <form method='get'>
                        <input type='text' style='display: none' value='".$pa['id']."' name='search'>
                        <input type='submit' value='select'>
                        </form>
                    </div>
                  
                </div>
            ";
        }
        echo "</div>";
    }

    private function addOrUpdateUrlParam($name, $value)
    {
        $params = $_GET;
        unset($params[$name]);
        $params[$name] = $value;
        return basename($_SERVER['PHP_SELF']).'?'.http_build_query($params);
    }
}
