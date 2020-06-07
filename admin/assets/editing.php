<?php
function newPassword($conn, $user_email, $password) {
    $pass_hashed = password_hash($password, PASSWORD_DEFAULT);
    $pass_change = $conn->prepare('UPDATE users SET pass = :pass WHERE email = :email');
    $pass_change->execute(array(':pass' => $pass_hashed, ':email:' => $user_email));
}
function createUser($conn, $email, $password, $rights) {
    $pass_hashed = password_hash($password, PASSWORD_DEFAULT);
    $add_user = $conn->prepare('INSERT INTO users (email, pass, rights) VALUES (:email, :pass, :rights)');
    $add_user->execute(array(':email' => $email, ':pass' => $pass_hashed, ':rights' => $rights));
    echo 'User has been added to the database';
}

class EditContent {

    public function getPost($conn, $id) {
        $post = $conn->prepare('SELECT * FROM content WHERE id=:id');
        $post->excecute([":id" => $id]);
        $postarr = $post->fetch(PDO::FETCH_ASSOC);
        return $postarr;
    }

    public function listPosts($conn) {
        $post = $conn->prepare('SELECT * FROM content');
        $post->excecute();
        $postarr = $post->fetchAll();
        foreach ($postarr as $pa) {
            echo "
                <div class='list'>
                    <div class='id'>
                        ".$pa['id']."
                    </div>
                    <div class='title'>
                        ".$pa['title']."
                    </div>
                    <div class='date'>
                        ".$pa['date']."
                    </div>
                    <div class='poster'>
                        ".$pa['poster']."
                    </div>
                </div>
            ";
        }
    }
}