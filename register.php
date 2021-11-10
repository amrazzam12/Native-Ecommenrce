<?php
$pagetitle = "Register";
include("init.php");

?>

<div class="headers text-center">
    <span class=" manageheading activereg">Sign Up</span>
</div>

<form class="text-center regform" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">

    <input class="form-control" type="text" name="username" placeholder="Type Your Username">
    <input class="form-control" type="password" name="password" placeholder="Type Your Password">
    <input class="form-control" type="password" name="password2" placeholder="Confirm Your Password">
    <input class="form-control" type="email" name="email" placeholder="Type Your Email">
    <input class="form-control btn" type="submit" name="subreg" value="Register">

</form>

<?php



if (isset($_POST['subreg'])) {

    $formeerrors = array(); // Get All Errors



    // Validate The Username Input 

    if (isset($_POST['username'])) {
        $username = $_POST['username'];
        $filteredUser = filter_var($username, FILTER_SANITIZE_STRING);
    } else {
        $formeerrors[] = "Username Cant Be Empty";
    }


    // Validate The Username Input 



    // Validate The Password Input 

    if (isset($_POST['password'])) {
        if ($_POST['password'] == $_POST['password2']) {
            $password = $_POST['password'];
        } else {
            $formeerrors[] = "Password Doesnt Match";
        }
    } else {
        $formeerrors[] = "Please Enter A Password";
    }


    // Validate The Username Input 


    // Validate The Email Input 
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        if (filter_var($email, FILTER_SANITIZE_EMAIL) !== true) {
            $filterdEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
        } else {
            $filterdEmail = $email;
        }
    } else {
        $formeerrors[] = "Please Enter An Email";
    }

    // Validate The Email Input 

    if (empty($formeerrors)) {
        $check = checkItem("USERNAME", "users", $username);
        if ($check == 0) {
            $stmt = $con->prepare("INSERT INTO users (USERNAME, PASSWORD, EMAIL) VALUES (?  , ? , ?)");
            $stmt->execute(array($filteredUser, sha1($password), $filterdEmail));
            $count = $stmt->rowCount();

            if ($count > 0) {
                $msg =  "<div class = 'alert alert-success'>User Added</div>";
                reDirect($msg, "login.php", 2);
                exit;
            } else {
                echo "Wrong Information";
            }
        } else {
            echo "Username Exists";
        }
    } else {
        foreach ($formeerrors as $error) {
            echo "<div class = 'alert alert-danger'>" . $error . "</div>";
        }
    }
}













include($tpl . "footer.php");
