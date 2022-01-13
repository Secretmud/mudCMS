<?php
function last_post_title($conn) {
    $post_title = $conn->prepare('SELECT title FROM posts 
                                  ORDER BY postdate 
                                  DESC LIMIT 1');
    $post_title->execute();
    $title = $post_title->fetch(PDO::FETCH_ASSOC);
    return $title;
}

function total_posts($conn) {
    $total_posts = $conn->prepare('SELECT count(*) FROM posts');
    $total_posts->execute();
    $total = $total_posts->fetch()[0];
    return $total;
}

function cat_pop($conn) {
    $highest_cat = $conn->prepare('SELECT category FROM posts
                                   GROUP BY category
                                   ORDER BY count(*) DESC LIMIT 1');
    $highest_cat->execute();
    $total = $highest_cat->fetch(PDO::FETCH_ASSOC);
    return $total;
}
