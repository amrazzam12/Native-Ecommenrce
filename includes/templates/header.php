<!DOCTYPE html>
<html>

<head>
    <meta charshet="UTF-8">
    <title><?php echo getTitle(); ?></title>
    <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $css; ?>all.min.css">
    <link rel="stylesheet" href="<?php echo $css; ?>front.css">
</head>

<body>
    <div class="uppernav">
        <div class="container">

            <?php

            session_start();

            if (isset($_SESSION['user'])) {

                echo "Hello " . $_SESSION['user'] . " | ";

                echo "<a class = 'log activereg' href = 'newad.php'>New Ad</a>" . " | ";
                echo "<a class = 'log login' href = 'logout.php'>Logout</a>";
            } else {

                echo "<a class = 'log login' href = 'login.php'>Login</a>";
                echo " / " . "<a class = 'log register' href = 'register.php'>Register</a>";
            }

            ?>
        </div>
    </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

        <div class="container">
            <a class="navbar-brand" href="index.php">Souq</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <?php

                    $cats = getCats();
                    foreach ($cats as $cat) {
                    ?> <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="cats.php?catid=<?php echo $cat['ID'] ?>&catname=<?php echo $cat['NAME'] ?>"><?php echo $cat['NAME'] ?></a>
                        </li>;
                    <?php }

                    ?>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="profile.php">Profile</a>
                    </li>

                    <?php

                    $stmtuser = $con->prepare("SELECT GROUPID FROM users WHERE USERNAME = ?");
                    $stmtuser->execute(array($_SESSION['user']));
                    $user = $stmtuser->fetch();

                    if ($user[0] > 0) {
                    ?>

                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="admin/index.php">Dashboard</a>
                        </li>
                    <?php } ?>
                </ul>


            </div>
        </div>
    </nav>