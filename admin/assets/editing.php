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
