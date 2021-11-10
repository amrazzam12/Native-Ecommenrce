<?php
session_start();

if(isset($_SESSION['username'])){
    header('Location: dashbord.php');
    exit;
}

$pagetitle = "Login";
$nonav = "";


include("init.php");

if($_SERVER['REQUEST_METHOD'] == "POST") {
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $hashedpass = sha1($pass);

    $stmt = $con->prepare("SELECT USERID , USERNAME , PASSWORD FROM users WHERE USERNAME = ? AND PASSWORD = ? LIMIT 1");
    $stmt->execute(array($user , $hashedpass));
    $row = $stmt->fetch();
    $count = $stmt->rowcount();

    if($count > 0 ) {
        $_SESSION['username'] = $user;
        $_SESSION['userid'] = $row["USERID"];
        header('Location: dashbord.php');
        exit;
    }

    include($tpl ."footer.php");
    
}












?>

<form class = "login text-center" action = "<?php echo $_SERVER['PHP_SELF'] ?>" method = "POST">
    <h4>Admin Login</h4>
    <input class = "form-control input-bg" type = "text" placeholder = "Username" name = "user" auto-complete = "off">
    <input class = "form-control input-bg" type = "password" placeholder = "Password" name = "pass" auto-complete = "new-password">
    <input class = "btn btn-primary btn-lg col-12" type = "submit" value = "LOGIN">

</form>

<?php include($tpl . "footer.php"); ?>