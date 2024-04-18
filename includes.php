<?php

session_start();
require('db.php');

function logout()
{
    session_destroy();
    session_unset();
    header('location: index.php?login');
}

function get_userid()
{
    global $pdo;
    $sql = 'select * from accounts where username = ?';
    $sth = $pdo->prepare($sql);
    $sth->execute([$_SESSION['user']]);
    $usr = $sth->fetchAll();
    return $usr[0]['id'];
}

function get_post_count()
{
    global $pdo;
    $sql = 'select count(*) as n from posts where userid = ?';
    $sth = $pdo->prepare($sql);
    $sth->execute([get_userid()]);
    $usr = $sth->fetchAll();
    return $usr[0]['n'];
}

function is_post_liked($postid)
{
    global $pdo;
    $sql = 'select count(*) n from likes_bind where userid = ? and postid = ?';
    $sth = $pdo->prepare($sql);
    $sth->execute([get_userid(), $postid]);
    $usr = $sth->fetchAll();
    return $usr[0]['n'] == 1;
}

function get_likes($postid)
{
    global $pdo;
    $sql = 'select count(*) n from likes_bind where postid = ?';
    $sth = $pdo->prepare($sql);
    $sth->execute([$postid]);
    $usr = $sth->fetchAll();
    return $usr[0]['n'];
}

function get_user_like_count($userid)
{
    global $pdo;
    $sql = 'select count(*) as n from likes_bind inner join posts on likes_bind.postid = posts.id inner join accounts on accounts.id = posts.userid where accounts.id = ?';
    $sth = $pdo->prepare($sql);
    $sth->execute([$userid]);
    $usr = $sth->fetchAll();
    return $usr[0]['n'];
}

function get_user_given_like_count($userid)
{
    global $pdo;
    $sql = 'select count(*) as n from likes_bind where userid = ?';
    $sth = $pdo->prepare($sql);
    $sth->execute([$userid]);
    $usr = $sth->fetchAll();
    return $usr[0]['n'];
}

function get_registered_users()
{
    global $pdo;
    $sql = 'select count(*) as n from accounts';
    $sth = $pdo->prepare($sql);
    $sth->execute([]);
    $usr = $sth->fetchAll();
    return $usr[0]['n'];
}

function get_most_popular_topic()
{
    global $pdo;
    $sql = 'select topics.name, count(*) as n from posts inner join topics on topics.id = posts.type group by topics.name order by n desc limit 1';
    $sth = $pdo->prepare($sql);
    $sth->execute([]);
    $usr = $sth->fetchAll();
    return $usr[0]['name'] . ' (' . $usr[0]['n'] . ' bejegyzés)';
}

function get_most_active_user()
{
    global $pdo;
    $sql = 'select accounts.id, accounts.username, count(*) as n from posts inner join accounts on accounts.id = posts.userid group by posts.userid order by n desc limit 1';
    $sth = $pdo->prepare($sql);
    $sth->execute([]);
    $usr = $sth->fetchAll();
    return '['.$usr[0]['id'].'] '.$usr[0]['username'] . ' (' . $usr[0]['n'] . ' bejegyzés)';
}

function get_most_likes_got()
{
    global $pdo;
    $sql = 'select posts.userid, accounts.username, count(*) as n from likes_bind inner join posts on posts.id = likes_bind.postid inner join accounts on accounts.id = posts.userid group by posts.userid order by n desc';
    $sth = $pdo->prepare($sql);
    $sth->execute([]);
    $usr = $sth->fetchAll();
    return '['.$usr[0]['userid'].'] '.$usr[0]['username'] . ' (' . $usr[0]['n'] . ' like)';
}

function get_topics()
{
    global $pdo;
    $sql = 'select * from topics';
    $sth = $pdo->prepare($sql);
    $sth->execute([]);
    $usr = $sth->fetchAll();
    return $usr;
}

function get_last10_reg()
{
    global $pdo;
    $sql = 'select id, username from accounts order by id desc limit 10';
    $sth = $pdo->prepare($sql);
    $sth->execute([]);
    $usr = $sth->fetchAll();
    return $usr;
}

function get_last10_posts()
{
    global $pdo;
    $sql = 'select posts.id, title, topics.name from posts inner join topics on topics.id = posts.type order by id desc limit 10';
    $sth = $pdo->prepare($sql);
    $sth->execute([]);
    $usr = $sth->fetchAll();
    return $usr;
}
