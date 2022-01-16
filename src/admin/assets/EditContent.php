<?php

namespace Secret\MudCms\admin\assets;

use PDO;
use Secret\MudCms\persistence\PostRepo;

class EditContent {

    private PostRepo $post_repo;

    function __contructor() {
        require_once("../../persistence/PostRepo.php");
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
                </div>
            ";
        }
        echo "</div>";
        $conn = null;
    }
}
