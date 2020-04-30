<?php
function last_post_title($conn) {
    $post_title = $conn->prepare('SELECT title FROM content 
                                  ORDER BY postdate 
                                  DESC LIMIT 1');
    $post_title->execute();
    $title = $post_title->fetch(PDO::FETCH_ASSOC);
    return $title;
}

function total_posts($conn) {
    $total_posts = $conn->prepare('SELECT id FROM content');
    $total_posts->execute();
    $total = $total_posts->rowCount();
    return $total;
}

function cat_pop($conn) {
    $highest_cat = $conn->prepare('SELECT category FROM content
                                   GROUP BY category
                                   ORDER BY count(*) DESC LIMIT 1');
    $highest_cat->execute();
    $total = $highest_cat->fetch(PDO::FETCH_ASSOC);
    return $total;
}