<?php
require('includes.php');

if($_SERVER["REQUEST_METHOD"] == "GET")
{
    if (isset($_GET['search']))
    {
        if ($_GET['type'] == -1)
        {
            $sql = 'select posts.id, userid, title, text, type, postdate, accounts.username, topics.name, (select count(*) as n from likes_bind where postid = posts.id) as likecount from posts inner join accounts on accounts.id = posts.userid inner join topics on topics.id = posts.type where posts.title like ? order by posts.id desc';
            $sth = $pdo->prepare($sql);
            $sth->execute(["%".$_GET['title']."%"]);
            $usr = $sth->fetchAll();
            echo json_encode($usr);
        }
        else
        {
            $sql = 'select posts.id, userid, title, text, type, postdate, accounts.username, topics.name, (select count(*) as n from likes_bind where postid = posts.id) as likecount from posts inner join accounts on accounts.id = posts.userid inner join topics on topics.id = posts.type where posts.title like ? and posts.type = ? order by posts.id desc';
            $sth = $pdo->prepare($sql);
            $sth->execute(["%".$_GET['title']."%", $_GET['type']]);
            $usr = $sth->fetchAll();
            echo json_encode($usr);
        }
    }

    if (isset($_GET['deleteTopic']))
    {
        $perm = isset($_SESSION['permission']) ? $_SESSION['permission'] : 0;
        $perm = $_SESSION['permission'];
        if ($perm > 0)
        {
            $sql = 'delete from topics where id = ?';
            $sth = $pdo->prepare($sql);
            $sth->execute([$_GET['id']]);
            echo 'OK';
        }
        else
        {
            echo '403';
        }
    }

    if (isset($_GET['addTopic']))
    {
        $perm = isset($_SESSION['permission']) ? $_SESSION['permission'] : 0;
        if ($perm > 0)
        {
            $sql = 'insert into topics set name = ?';
            $sth = $pdo->prepare($sql);
            $sth->execute([$_GET['name']]);
            echo 'OK';
        }
        else
        {
            echo '403';
        }
    }
}