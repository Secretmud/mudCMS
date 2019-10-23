<?php
function last_post_title($conn) {
    $post_title = $conn->prepare('SELECT title FROM content ORDER BY postdate DESC LIMIT 1');
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
