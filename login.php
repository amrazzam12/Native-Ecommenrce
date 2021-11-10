<?php

$pagetitle = "Login";
include("init.php");

if (isset($_SESSION['user'])) {
    header('Location:index.php');
    exit;
} else {



?>
    <div class="headers text-center">
        <span class="manageheading activelog">Login</span>
    </div>
    <form class="text-center loginform active-form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">

        <input class="form-control" type="text" name="username" placeholder="Type Your Username">
        <input class="form-control" type="password" name="password" placeholder="Type Your Password">
        <input class="form-control btn" type="submit" name="sublog" value="Login">
    </form>
    </div>
<?php }

if (isset($_POST['sublog'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $stmt = $con->prepare("SELECT * FROM users WHERE USERNAME = ? AND PASSWORD = ?");
    $stmt->execute(array($username, sha1($password)));
    $count = $stmt->rowCount();

    if ($count > 0) {
        $_SESSION['user'] = $username;
        header("Location: index.php");
        exit;
    } else {
        echo "Wrong Information";
    }
}







?>






<?php
include($tpl . "footer.php");
