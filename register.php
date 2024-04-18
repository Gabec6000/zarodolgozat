<?php

$error = '';
if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$username = $_POST['username'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

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
            if (!$password2 || !(strlen($password2) > 0))
            {
                $error = 'Jelszó2 üres';
            }
            else
            {
                if ($password != $password2)
                {
                    $error = 'A két megadott jelszó nem egyezik.';
                }
                else
                {
                    $sql = 'select * from accounts where username = ?';
                    $sth = $pdo->prepare($sql);
                    $sth->execute([$username]);
                    $usr = $sth->fetchAll();
                    if (count($usr) > 0)
                    {
                        $error = 'Már használatban van a megadott felhasználónév.';
                    }
                    else
                    {
                        $sql = 'insert into accounts set username = ?, password = ?';
                        $sth = $pdo->prepare($sql);
                        $sth->execute([$username, hash('sha512', $password)]);
                        $usr = $sth->fetchAll();
                        $_SESSION['user'] = $username;
                        $_SESSION['permission'] = 0;
                        header('location: index.php');
                    }
                }
            }
        }
    }
}
?>

<div class="w-100">
    <div class="mx-auto w-50">
        <h1>regisztráció</h1>
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
            <div class="mb-3 row">
                <label for="password" class="col-sm-2 col-form-label">Jelszó mégegyszer</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="password2" name="password2">
                </div>
            </div>

            <?php if (strlen($error) > 0) echo '<div class="alert alert-danger">' . $error . '</div>'; ?>

            <input type="submit" value="Regisztrálás" class="btn btn-primary">
        </form>
    </div>
</div>
