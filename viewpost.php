<?php
    $sql = 'select posts.id, userid, title, text, type, postdate, accounts.username, topics.name from posts inner join accounts on accounts.id = posts.userid inner join topics on topics.id = posts.type where posts.id = ?';
    $sth = $pdo->prepare($sql);
    $sth->execute([$_GET['id']]);
    $usr = $sth->fetchAll()[0];

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (!isset($_SESSION['user'])) {
            echo 'Ehhez be kell jelentkezni!';
        }
        else
        {
            if (is_post_liked($_GET['id']))
            {
                $sql = 'delete from likes_bind where userid = ? and postid = ?';
                $sth = $pdo->prepare($sql);
                $sth->execute([get_userid(), $_GET['id']]);
                header('location: index.php?viewpost&id=' . $_GET['id']);
            }
            else
            {
                $sql = 'insert into likes_bind set userid = ?, postid = ?';
                $sth = $pdo->prepare($sql);
                $sth->execute([get_userid(), $_GET['id']]);
                header('location: index.php?viewpost&id=' . $_GET['id']);
            }
        }
    }
?>

<div class="card mb-3" style="">
    <div class="row g-0">
        <div class="col-md-2">
            <img src="scroll.png" class="img-fluid rounded-start">
        </div>
        <div class="col-md-10">
            <div class="card-body">
                <h5 class="card-title"><?php echo $usr['title'] . ' <i>('.$usr['name'].')</i>' ?></h5>
                <p class="card-text"><?php echo str_replace('\\n', '<br>', $usr['text']) ?></p>
                <?php if (isset($_['permission']) && $_SESSION['permission'] > 0): ?>
                    <p class="card-text"><small class="text-body-secondary">Bejegyzést írta: <?php echo '<a href="?profile&id='.$usr['userid'].'">'.$usr['username'] . '</a> - ' . $usr['postdate']?></small></p>
                <?php else: ?>
                    <p class="card-text"><small class="text-body-secondary">Bejegyzést írta: <?php echo $usr['username'] . ' - ' . $usr['postdate']?></small></p>
                <?php endif; ?>

                <form method="post">
                    <div class="input-group mb-3" style="width: 110px">
                        <input type="submit" value="Like" class="btn btn-primary" <?php if (!(isset($_SESSION['user']))) echo 'disabled'; ?>>
                        <input type="text" class="form-control" aria-label="Username" aria-describedby="basic-addon1" value="<?php echo get_likes($_GET['id']); ?>" disabled>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>