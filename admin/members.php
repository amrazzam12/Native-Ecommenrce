<?php

session_start();


$pagetitle = 'Members';
if (isset($_SESSION['username'])) {
    include("init.php");

    $do = isset($_GET['do']) ? $do = $_GET['do'] : 'Manage';

    $query = "";

    if ($do == "Manage") {

        if (isset($_GET['pen']) && $_GET['pen'] == "Pending") {

            $query = "AND REGSTATUS = 0";
        }





        $stmt = $con->prepare("SELECT * FROM users WHERE GROUPID = 0 $query");
        $stmt->execute();
        $count = $stmt->rowCount();
        $row = $stmt->fetchAll();

?>
        <div class="container">
            <h1 class="text-center manageheading">Manage Members</h1>
            <table class="table tbl">
                <thead>
                    <tr>
                        <th scope="col">Userid</th>

                        <th scope="col">Username</th>
                        <th scope="col">Fullname</th>
                        <th class="d-none d-md-block" scope="col">Email</th>
                        <th scope="col">Operation </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>

                        <td>Azzam</td>
                        <td>Amr Azzam</td>
                        <td class="d-none d-md-block">amrazzm@gmail.com</td>
                        <td>ADMIN</td>
                    </tr>

                    <?php



                    foreach ($row as $info) { ?>
                        <tr>
                            <th> <?php echo $info['USERID']; ?></th>

                            <td> <?php echo $info['USERNAME']; ?></td>
                            <td> <?php echo $info['FULLNAME']; ?></td>
                            <td class="d-none d-md-block"> <?php echo $info['EMAIL']; ?></td>
                            <td> <a href="?do=Edit&userid=<?php echo $info['USERID']; ?>" class="btn btn-primary btn-bg"> Edit</a>
                                <a href="?do=Delete&userid=<?php echo $info['USERID']; ?>" class="btn btn-danger btn-bg close"> Delete</a>
                                <?php
                                if ($info['REGSTATUS'] == 0) { ?>

                                    <a href="?do=Activate&userid=<?php echo $info['USERID']; ?>" class="btn activate btn-success btn-bg close"> Activate</></a>

                                <?php }
                                ?>
                            </td>
                        </tr>
                    <?php }






                    ?>

                </tbody>
            </table>
            <div class="btn btn-success">
                <a class="addlink" href="?do=Add">Add New Member <i class="fas fa-plus"></i></a>
            </div>

        </div>




        <?php
    } elseif ($do == "Edit") {

        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

        $stmt = $con->prepare("SELECT *  FROM users WHERE USERID = ? LIMIT 1");
        $stmt->execute(array($userid));
        $row = $stmt->fetch();
        $count = $stmt->rowcount();

        if ($count > 0) { ?>

            <h1 class="text-center mb-5 mt-5">Edit Member</h1>
            <div class="container">
                <form action="?do=Update" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="userid" value=<?php echo $userid; ?>>
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
                            <input type="hidden" name="oldpass" value="<?php echo $row['PASSWORD']; ?>">
                            <input type="password" name="password" id="inputPassword" class="form-control text" autocomplete="new-password" value="<?php echo $row["PASSWORD"]; ?>">

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
                            <label for="avatar" class="col-form-label">Avatar</label>
                        </div>
                        <div class="col-10">
                            <input type="file" name="avatar" id="avatar" class="form-control text">
                        </div>
                    </div>


                    <div class="row justify-content-center">
                        <div class="col-5">
                            <button type="submit" class="btn btn-primary btn-lg  mx-5" style="width:100%">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        <?php } else {
            $msg  = "<div class='alert alert-danger'>There Is No User With This ID PLease Register</div> ";
            reDirect($msg, 4);
        }
    } elseif ($do == "Update") {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $userid     = $_POST['userid'];
            $username   = $_POST['username'];
            $email      = $_POST['email'];
            $fullname   = $_POST['fullname'];
            $pass = "";

            $avatar = $_FILES['avatar'];
            $imgname1 = $avatar['name'];
            $random = rand(0, 10000);
            $imgname = $random . "-" . $imgname1;
            $img_tmp = $avatar['tmp_name'];


            if (isset($avatar)) {
                move_uploaded_file($img_tmp, "uploads/avatars/$imgname");
            }


            if (empty($_POST['password'])) {
                $pass = $_POST['oldpass'];
            } else {
                $pass  = sha1($_POST['password']);
            }

            $erros = array();

            if (empty($username)) {
                $erros[] = "Username Can't Be Empty";
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

            $count =  checkItem("USERNAME", "users", $username);

            if ($count == 0) {
                if (count($erros) == 0) {
                    $stmt = $con->prepare("UPDATE users SET USERNAME = ? , PASSWORD = ? , EMAIL = ? , FULLNAME = ? , avatar = ? WHERE USERID = ?");
                    $stmt->execute(array($username,  $pass, $email, $fullname, "uploads/avatars/$imgname",  $userid));
                    $msg =  "<div class = 'alert alert-success'> User Updated </div>";
                    reDirect($msg, "back");
                } else {
                    foreach ($erros as $error) {
                        echo "<div class = 'alert alert-danger container'> " . $error . "</div";
                    }
                    reDirect("Edit Them", "back", 4);
                }
            } else {

                $msg = "<div class = 'alert alert-danger'>Username Exists</div>";
                reDirect($msg, "back");
            }
        } else {
            $msg = "<div class = 'alert alert-danger'>You cant Access Direct</div>";
            reDirect($msg);
        }
    } elseif ($do == "Add") { ?>

        <h1 class="text-center mb-5 mt-5">Add Member</h1>
        <div class="container">
            <form action="?do=Insert" method="POST" enctype="multipart/form-data">
                <div class="row mx-5 mb-4">
                    <div class="col-2">
                        <label for="username" class="col-form-label">Username</label>
                    </div>
                    <div class="col-10">
                        <input type="text" name="username" id="username" required="required" class="form-control" autocomplete="off" placeholder="Username">
                    </div>
                </div>
                <div class="row mx-5 mb-4">
                    <div class="col-2">
                        <label for="inputPassword" class="col-form-label">Password</label>
                    </div>
                    <div class="col-10">
                        <input type="password" name="password" id="inputPassword" class="form-control text" autocomplete="new-password" placeholder="Password">

                    </div>
                </div>

                <div class="row mx-5 mb-4">
                    <div class="col-2">
                        <label for="email" class="col-form-label">Email</label>
                    </div>
                    <div class="col-10">
                        <input type="email" name="email" id="email" required="required" class="form-control text" autocomplete="off" placeholder="Email">
                    </div>
                </div>

                <div class="row mx-5 mb-4">
                    <div class="col-2">
                        <label for="fullname" class="col-form-label">Fullname</label>
                    </div>
                    <div class="col-10">
                        <input type="text" name="fullname" id="fullname" required="required" class="form-control text" autocomplete="new" placeholder="FullName">
                    </div>
                </div>

                <div class="row mx-5 mb-4">
                    <div class="col-2">
                        <label for="avatar" class="col-form-label">Avatar</label>
                    </div>
                    <div class="col-10">
                        <input type="file" name="avatar" id="avatar" class="form-control text">
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-5">
                        <button type="submit" class="btn btn-primary btn-lg  mx-5" style="width:100%">Add</button>
                    </div>
                </div>
            </form>
        </div>

<?php


    } elseif ($do == "Insert") {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $username = $_POST['username'];
            $password = $_POST['password'];
            $email    = $_POST['email'];
            $fullname = $_POST['fullname'];

            // Avatar
            $avatar = $_FILES['avatar'];
            $imgname1 = $avatar['name'];
            $img_tmp = $avatar['tmp_name'];
            $random = rand(0, 10000);
            $imgname = $random . "-" . $imgname1;


            if (isset($avatar)) {
                move_uploaded_file($img_tmp, "uploads/avatars/$imgname");
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


            $count = checkItem("USERNAME", "users", $username);

            if ($count == 0) {

                if (empty($erros)) {
                    $stmt = $con->prepare("INSERT INTO users (USERID, USERNAME, PASSWORD, EMAIL, FULLNAME , REGSTATUS , avatar) VALUES (NULL, ?, SHA1(?), ?, ? , ? , ?)");
                    $stmt->execute(array($username, $password, $email, $fullname, 1, "uploads/avatars/$imgname"));
                    $msg = "<div class = 'alert alert-success' > User Added </div>";
                    reDirect($msg, "members.php",  2);
                } else {
                    foreach ($erros as $error) {
                        echo "<div class = 'alert alert-danger container'> " . $error . "</div";
                    }
                    reDirect("Go Back", 4);
                }
            } else {
                $msg = "<div class = 'alert alert-danger'>User Exists</div>";
                reDirect($msg, "back", 3);
            }
        } else {
            $msg = "<div class = 'alert alert-danger'>You Cant Direct</div>";
            reDirect($msg, 3);
        }
    } elseif ($do == 'Delete') {

        if (isset($_GET['userid'])) {

            $userid = $_GET['userid'];

            $stmt = $con->prepare("DELETE FROM users WHERE USERID = ?");
            $stmt->execute(array($userid));
            $count = $stmt->rowCount();

            if ($count > 0) {
                $msg = "<div class = 'alert alert-success'>USER DELETED</div>";
                reDirect($msg, "back");
            }
        } else {
            $msg = "<div class = 'alert alert-danger'>No Id Entered</div>";
            reDirect($msg);
        }
    } elseif ($do == "Activate") {
        $userid = $_GET['userid'];
        $stmt = $con->prepare("UPDATE users SET REGSTATUS = 1 WHERE USERID = ? ");
        $stmt->execute(array($userid));

        $msg = "<div class = 'alert alert-success'> User Activated </div>";
        reDirect($msg, "back");
    }
    include($tpl . "footer.php");
} else {
    header("Location: index.php");
    exit;
}
