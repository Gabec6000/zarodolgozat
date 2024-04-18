<?php

$error = '';
if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$username = $_POST['username'];
    $password = $_POST['password'];

    if (!$username || !(strlen($username) > 0))
    {
        $error = 'Felhasználónév üres';
    }
    else {
        if (!$password || !(strlen($password) > 0))
        {
            $error = 'Jelszó üres';
        }
        else
        {
            $sql = 'select * from accounts where username = ? and password = ?';
            $sth = $pdo->prepare($sql);
            $sth->execute([$username, hash('sha512', $password)]);
            $usr = $sth->fetchAll();
            if (count($usr) == 1)
            {
                $_SESSION['user'] = $usr[0]['username'];
                $_SESSION['permission'] = $usr[0]['permission'];
                header('location: index.php');
            }
            else
            {
                $error = 'Hibás adatok';
            }
        }
    }
}
?>

<div class="w-100">
    <div class="mx-auto w-50">
        <h1>bejelentkezés</h1>
        <form method="post">
            <div class="mb-3 row">
                <label for="username" class="col-sm-2 col-form-label">Felhasználónév</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="username" name="username">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="password" class="col-sm-2 col-form-label">Jelszó</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="password" name="password">
                </div>
            </div>

            <?php if (strlen($error) > 0) echo '<div class="alert alert-danger">' . $error . '</div>'; ?>

            <input type="submit" value="Bejelentkezés" class="btn btn-primary">
        </form>
    </div>
</div>
