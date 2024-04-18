<?php
if (!isset($_SESSION['user'])) logout();

$usr = null;
$error = '';
if ($_GET['id'] == 0)
{
    $sql = 'select * from accounts where username = ?';
    $sth = $pdo->prepare($sql);
    $sth->execute([$_SESSION['user']]);
    $usr = $sth->fetchAll();
}
else
{
    if (!($_SESSION['permission'] > 0))
    {
        $error = 'Nincs engedélyed megnézni más profilját.';
    }
    else
    {
        $sql = 'select * from accounts where id = ?';
        $sth = $pdo->prepare($sql);
        $sth->execute([$_GET['id']]);
        $usr = $sth->fetchAll();
    }
}
?>

<div class="w-100">
    <div class="text-center">
        <?php if ($error != ''): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php else: ?>
        <h2><i><?php echo $usr[0]['username']; ?></i> profilja</h2>
        <div class="w-25 mx-auto">
            <img src="HugoStrange.jpg" class="rounded-circle mx-auto d-block">
            <table class="w-100">
                <tr>
                    <td>id</td>
                    <td class="text-end badge text-bg-primary"><?php echo $usr[0]['id']; ?></td>
                </tr>
                <tr>
                    <td>felhasználónév</td>
                    <td class="text-end badge text-bg-primary"><?php echo $usr[0]['username']; ?></td>
                </tr>
                <tr>
                    <td>regisztráció dátuma</td>
                    <td class="text-end badge text-bg-primary"><?php echo $usr[0]['regdate']; ?></td>
                </tr>
                <tr>
                    <td>jogosultság</td>
                    <td class="text-end badge text-bg-primary"><?php echo $usr[0]['permission']; ?></td>
                </tr>
                <tr>
                    <td>bejegyzések száma</td>
                    <td class="text-end badge text-bg-primary"><?php echo get_post_count(); ?> darab</td>
                </tr>
                <tr>
                    <td>összes kapott like</td>
                    <td class="text-end badge text-bg-primary"><?php echo get_user_like_count($usr[0]['id']); ?> darab</td>
                </tr>
                <tr>
                    <td>összes adott like</td>
                    <td class="text-end badge text-bg-primary"><?php echo get_user_given_like_count($usr[0]['id']); ?> darab</td>
                </tr>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>
