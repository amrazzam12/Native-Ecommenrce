<?php
$pagetitle = "Profile";
include("init.php");
$user = $_SESSION['user'];

if (isset($_SESSION['user'])) {


    if (isset($_POST['subedit'])) {

        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $fullname = $_POST['fullname'];

        if (isset($_FILES['photo'])) {
            $photo = $_FILES['photo'];
            $random = rand(0, 10000);
            $photoname = $photo['name'] . "-" . $random;
            $photo_tmp = $photo['tmp_name'];


            move_uploaded_file($photo_tmp, "admin/uploads/avatars/$photoname");
        }

        $erros = array();

        if (empty($username)) {
            $erros[] = "Username Can't Be Empty";
        }
        if (empty($password)) {
            $erros[] = "Password Can't Be Empty";
        }
        if (empty($email)) {
            $erros[] = "Email Can't Be Empty";
        }
        if (empty($fullname)) {
            $erros[] = "Fullname Can't Be Empty";
        }
        if (strlen($username) < 2) {
            $erros[] = "Username Can't Be Less Than 2 Characters";
        }


        if (count($erros) == 0) {
            $stmt3 = $con->prepare("UPDATE users SET USERNAME = ? , PASSWORD = ? , EMAIL = ? , FULLNAME = ?  , avatar = ? WHERE USERNAME = ?");
            $stmt3->execute(array($username,  sha1($password), $email, $fullname, "admin/uploads/avatars/$photoname",  $user));
            $_SESSION['user'] = $username;
            header("Location:profile.php");
            exit;
        } else {
            foreach ($erros as $error) {
                echo "<div class = 'alert alert-danger container'> " . $error . "</div";
            }
            reDirect("Edit Them", "back", 4);
        }
    }


    $stmt = $con->prepare("SELECT * FROM users WHERE USERNAME = ?");
    $stmt->execute(array($user));
    $count = $stmt->rowCount();
    $row = $stmt->fetch();
    if ($count > 0) { ?>

        <h1 class="text-center mb-5 mt-5">Your Profile</h1>
        <div class="container">

            <div class=" text-center profile-photo">
                <img width="300px" height="300px" src="<?php echo $row['avatar'] ?>" alt="">
            </div>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                <div class="row mx-5 mb-4">
                    <div class="col-2">
                        <label for="username" class="col-form-label">Username</label>
                    </div>
                    <div class="col-10">
                        <input type="text" name="username" id="username" required="required" class="form-control" autocomplete="off" value="<?php echo $row['USERNAME']  ?>">
                    </div>
                </div>
                <div class="row mx-5 mb-4">
                    <div class="col-2">
                        <label for="inputPassword" class="col-form-label">Password</label>
                    </div>
                    <div class="col-10">
                        <input type="password" name="password" id="inputPassword" class="form-control text" autocomplete="new-password">


                    </div>
                </div>

                <div class="row mx-5 mb-4">
                    <div class="col-2">
                        <label for="email" class="col-form-label">Email</label>
                    </div>
                    <div class="col-10">
                        <input type="email" name="email" id="email" required="required" class="form-control text" autocomplete="off" value="<?php echo $row['EMAIL'];  ?>">
                    </div>
                </div>

                <div class="row mx-5 mb-4">
                    <div class="col-2">
                        <label for="fullname" class="col-form-label">Fullname</label>
                    </div>
                    <div class="col-10">
                        <input type="text" name="fullname" id="fullname" required="required" class="form-control text" autocomplete="new" value="<?php echo $row['FULLNAME'];  ?>">
                    </div>
                </div>

                <div class="row mx-5 mb-4">
                    <div class="col-2">
                        <label for="photo" class="col-form-label">Photo</label>
                    </div>
                    <div class="col-10">
                        <input type="file" name="photo" id="photo" class="form-control text">

                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-5">
                        <input name="subedit" type="submit" class="btn btn-primary btn-lg  mx-5" style="width:100%" value="Edit"></input>
                    </div>
                </div>
            </form>
        </div>


<?php }
} else {
    header("Location:login.php");
    exit;
}






$stmt2 = $con->prepare("SELECT items.* , users.USERNAME FROM items INNER JOIN users ON items.user_id = users.USERID WHERE users.USERNAME = ?");
$stmt2->execute(array($user));
$res = $stmt2->fetchAll();



?>
<div class="items prof-items">
    <div class="container text-center">
        <h2><?php echo $user ?>'s Items</h2>
        <div class="row">
            <?php

            foreach ($res as $item) { ?>

                <div class="col-12 col-md-3 item-box">
                    <div class="card" style="width: 100%;height:500px; margin-bottom: 50px;">

                        <img class="card-img-top" height="300px" src="
                        
                        <?php

                        if ($item['photo'] !== "") {
                            echo $item['photo'];
                        } else {
                            echo "uploads/items/default.png";
                        } ?>
                        
                        
                        " alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $item['name'] ?></h5>
                            <p class="card-text"><?php echo $item['description']; ?></p>
                            <a href="item.php?itemid=<?php echo $item['item_id'] ?>" class="btn btn-primary">Details</a>
                            <span class="price">$<?php echo $item['price'] ?></span>
                            <?php
                            if ($item['approved'] == 0) {
                                echo "<span class = 'notAppr'>Pending</span>";
                            }

                            ?>
                        </div>
                    </div>
                </div>



            <?php }



            ?>


        </div>


    </div>

</div>

<?php

include($tpl . "footer.php");
