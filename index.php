<?php
    require('includes.php');

    if(isset($_GET['logout']))
    {
        logout();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <script src="./popper.min.js"></script>
    <script src="./bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
</head>
<body>

    <div class="container">

        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Blog</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="?home">Főoldal</a>
                        </li>
                        <?php if (!isset($_SESSION['user'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="?login">Bejelentkezés</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?register">Regisztráció</a>
                        </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="?newpost">Új bejegyzés</a>
                            </li>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['user'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $_SESSION['user']; ?></a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="?profile&id=0">Profil</a></li>
                                <li><a class="dropdown-item" href="?logout">Kijelentkezés</a></li>
                            </ul>
                        </li>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['permission']) && $_SESSION['permission'] > 0): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="?admin">Admin menü</a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>

        <?php
            if (isset($_GET['login'])) require('login.php');
            elseif (isset($_GET['register'])) require('register.php');
            elseif (isset($_GET['profile'])) require('profile.php');
            elseif (isset($_GET['admin'])) require('admin.php');
            elseif (isset($_GET['newpost'])) require('newpost.php');
            elseif (isset($_GET['viewpost'])) require('viewpost.php');
            elseif (isset($_GET['addtopic'])) require('addtopic.php');
            else require('homepage.php');
            ?>

    </div>

</body>
</html>
