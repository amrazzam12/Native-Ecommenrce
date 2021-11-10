<?php


session_start();


$pagetitle = 'Items';
if (isset($_SESSION['username'])) {
    include("init.php");

    $do = isset($_GET['do']) ? $do = $_GET['do'] : 'Manage';


    if ($do == "Manage") {


        $stmt = $con->prepare("SELECT  
                                items.* , users.USERNAME AS username , categories.NAME AS catname
                            FROM  items
                            INNER JOIN categories
                            ON categories.ID = items.cat_id
                            INNER JOIN users
                            ON users.USERID = items.user_id ");

        $stmt->execute();
        $items = $stmt->fetchAll();

?>

        <div class="container">
            <h1 class="text-center manageheading">Manage Items</h1>
            <table class="table tbl text-center">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th class="d-none d-md-block" scope="col">Description</th>
                        <th scope="col">Price</th>
                        <th class="d-none d-md-block" scope="col">Status</th>
                        <th scope="col">Country </th>
                        <th scope="col">Seller </th>
                        <th scope="col">Category </th>
                        <th class="d-none d-md-block" scope="col">Operation </th>

                    </tr>
                </thead>
                <tbody>

                    <?php



                    foreach ($items as $item) { ?>
                        <tr>
                            <th> <?php echo $item['name']; ?></th>
                            <td class="d-none d-md-block"> <?php echo $item['description']; ?></td>
                            <td> <?php echo $item['price']; ?></td>
                            <td class="d-none d-md-block">
                                <?php

                                if ($item['status'] == 1) {
                                    echo "NEW";
                                } else {
                                    echo "USED";
                                }
                                ?></td>
                            <td> <?php echo $item['country']; ?></td>
                            <td> <?php echo $item['username']; ?></td>
                            <td> <?php echo $item['catname']; ?></td>
                            <td class="d-none d-md-block">
                                <a href="?do=Edit&itemid=<?php echo $item['item_id']; ?>" class="btn btn-primary btn-bg"> Edit</a>
                                <a href="?do=Delete&itemid=<?php echo $item['item_id']; ?>" class="btn btn-danger btn-bg close"> Delete</a>
                                <?php
                                if ($item['approved'] == 0) {
                                    echo "<a href='?do=Approve&itemid= $item[item_id]' class='btn activate btn-success btn-bg close'> Approve</a>";
                                }
                                ?>
                            </td>
                        </tr>
                    <?php }






                    ?>

                </tbody>
            </table>
            <div class="btn btn-success">
                <a class="addlink" href="?do=Add">Add New Item <i class="fas fa-plus"></i></a>
            </div>




        </div>



    <?php
    } elseif ($do == "Add") {

    ?>
        <h1 class="text-center mb-5 mt-5">Add Item</h1>
        <div class="container">
            <form action="?do=Insert" method="POST" enctype="multipart/form-data">
                <div class="row mx-5 mb-4">
                    <div class="col-2">
                        <label for="name" class="col-form-label">Name</label>
                    </div>
                    <div class="col-10">
                        <input type="text" name="name" id="name" required="required" class="form-control" autocomplete="off" placeholder="Item Name">
                    </div>
                </div>
                <div class="row mx-5 mb-4">
                    <div class="col-2">
                        <label for="desc" class="col-form-label">Description</label>
                    </div>
                    <div class="col-10">
                        <input type="text" name="desc" id="desc" class="form-control text" placeholder="Description Of The Item">

                    </div>
                </div>



                <div class="row mx-5 mb-4">
                    <div class="col-2">
                        <label for="price" class="col-form-label">Price</label>
                    </div>
                    <div class="col-10">
                        <input type="text" name="price" id="price" class="form-control text" placeholder="Price Of The Item">
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


                <div class="row mx-5 mb-4">
                    <div class="col-6 col-md-2">
                        <label for="status" class="col-form-label">Status</label>
                    </div>

                    <div class="col-4 col-md-10">
                        <select name="status" class="form-control">
                            <option value="0">New</option>
                            <option value="1">Used</option>
                        </select>
                    </div>
                </div>


                <div class="row mx-5 mb-4">
                    <div class="col-2">
                        <label for="country" class="col-form-label">Country</label>
                    </div>
                    <div class="col-10">
                        <input type="text" name="country" id="country" required="required" class="form-control" autocomplete="off" placeholder="Country Of Made">
                    </div>
                </div>

                <div class="row mx-5 mb-4">
                    <div class="col-6 col-md-2">
                        <label for="user" class="col-form-label">User</label>
                    </div>

                    <div class="col-4 col-md-10">
                        <select name="user" class="form-control">
                            <?php

                            $stmt = $con->prepare("SELECT * FROM users");
                            $stmt->execute();
                            $users = $stmt->fetchAll();
                            foreach ($users as $user) {
                                echo "<option value ='$user[USERID]'>" . $user['USERNAME']   . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row mx-5 mb-4">
                    <div class="col-6 col-md-2">
                        <label for="cat" class="col-form-label">Category</label>
                    </div>

                    <div class="col-4 col-md-10">
                        <select name="cat" class="form-control">
                            <?php

                            $stmt = $con->prepare("SELECT * FROM categories");
                            $stmt->execute();
                            $cats = $stmt->fetchAll();
                            foreach ($cats as $cat) {
                                echo "<option value ='$cat[ID]'>" . $cat['NAME']   . "</option>";
                            }
                            ?>
                        </select>
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
            $name    = $_POST['name'];
            $desc    = $_POST['desc'];
            $price   = $_POST['price'];
            $status  = $_POST['status'];
            $country = $_POST['country'];
            $userid    = $_POST['user'];
            $cat     = $_POST['cat'];


            if (isset($_FILES['photo'])) {
                $photo = $_FILES['photo'];
                $random = rand(0, 10000);
                $photoname = $photo['name'] . "-" . $random;
                $photo_tmp = $photo['tmp_name'];


                move_uploaded_file($photo_tmp, "uploads/items/$photoname");
            }




            $erros = array();


            if (empty($name)) {
                $erros[] = "Name Can't Be Empty";
            }
            if (empty($desc)) {
                $erros[] = "Description Can't Be Empty";
            }
            if (empty($user)) {
                $erros[] = "Seller Username Can't Be Empty";
            }
            if (empty($cat)) {
                $erros[] = "Category Name Can't Be Empty";
            }
            if (empty($price)) {
                $erros[] = "Price Can't Be Empty";
            }
            if (empty($country)) {
                $erros[] = "Country Can't Be Less Than 2 Characters";
            }

            if (empty($erros)) {
                $stmt = $con->prepare("INSERT INTO items (name, description, price, photo  ,status, country , user_id , cat_id) VALUES ( ?, ?, ?, ? , ? , ? , ? , ?)");
                $stmt->execute(array($name, $desc, $price, "admin/uploads/items/$photoname", $status, $country, $userid, $cat));
                $msg = "<div class = 'alert alert-success' > Item Added </div>";
                reDirect($msg, "items.php",  2);
            } else {
                foreach ($erros as $error) {
                    echo "<div class = 'alert alert-danger container'> " . $error . "</div";
                }
                reDirect("", "back", 4);
            }
        } else {
            $msg =  "You Cant Direct";
            reDirect($msg);
        }
    } elseif ($do == "Edit") {


        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

        $stmt = $con->prepare("SELECT * FROM items WHERE item_id = ? LIMIT 1");
        $stmt->execute(array($itemid));
        $row = $stmt->fetch();
        $count = $stmt->rowcount();

        if ($count > 0) { ?>

            <h1 class="text-center mb-5 mt-5">Edit Item</h1>
            <div class="container">
                <form action="?do=Update&itemid=<?php echo $itemid ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="itemid" value=<?php echo $itemid ?>>
                    <div class="row mx-5 mb-4">
                        <div class="col-2">
                            <label for="itemname" class="col-form-label">Name </label>
                        </div>
                        <div class="col-10">
                            <input type="text" name="itemname" id="itemname" required="required" class="form-control" autocomplete="off" value="<?php echo $row['name']  ?>">
                        </div>
                    </div>
                    <div class="row mx-5 mb-4">
                        <div class="col-2">
                            <label for="itemdesc" class="col-form-label">Description</label>
                        </div>
                        <div class="col-10">

                            <input type="text" name="itemdesc" id="itemdesc" class="form-control text" value="<?php echo $row["description"]; ?>">

                        </div>
                    </div>

                    <div class="row mx-5 mb-4">
                        <div class="col-5 col-md-2">
                            <label for="price" class="col-form-label">Price</label>
                        </div>
                        <div class="col-10">
                            <input type="text" name="price" id="price" class="form-control  text" value="<?php echo $row['price'] ?>">
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

                    <div class="row mx-5 mb-4">
                        <div class="col-6 col-md-2">
                            <label for="status" class="col-form-label">Status</label>
                        </div>

                        <div class="col-4 col-md-10">
                            <select name="status" class="form-control">
                                <option value="0">New</option>
                                <option value="1">Used</option>
                            </select>
                        </div>
                    </div>


                    <div class="row mx-5 mb-4">
                        <div class="col-6 col-md-2">
                            <label for="country" class="col-form-label">Country</label>
                        </div>

                        <div class="col-10">
                            <input type="text" name="country" id="country" class="form-control text" value="<?php echo $row['country'] ?>">
                        </div>


                    </div>

                    <div class="row mx-5 mb-4">
                        <div class="col-6 col-md-2">
                            <label for="User" class="col-form-label">Seller</label>
                        </div>

                        <div class="col-4 col-md-10">

                            <?php
                            $stmt = $con->prepare("SELECT USERNAME FROM users WHERE USERID = ?");
                            $stmt->execute(array($row['user_id']));
                            $username = $stmt->fetch(); ?>

                            <select name="user" class="form-control">
                                <option selected="selected"></option>

                                <?php

                                $stmt = $con->prepare("SELECT * FROM users");
                                $stmt->execute();
                                $users = $stmt->fetchAll();
                                foreach ($users as $user) {
                                    echo "<option value ='$user[USERID]'>" . $user['USERNAME']   . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>


                    <div class="row mx-5 mb-4">
                        <div class="col-6 col-md-2">
                            <label for="cat" class="col-form-label">Category</label>
                        </div>

                        <div class="col-4 col-md-10">
                            <select name="cat" class="form-control">
                                <option selected="selected"></option>

                                <?php

                                $stmt = $con->prepare("SELECT * FROM categories");
                                $stmt->execute();
                                $cats = $stmt->fetchAll();
                                foreach ($cats as $cat) {
                                    echo "<option value='$cat[ID]'>" . $cat['NAME'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-5">
                            <button type="submit" class="btn btn-primary btn-lg  mx-5" style="width:100%">Save</button>
                        </div>
                    </div>
                </form>

                <!-- For Comments -->
                <?php

                $stmt = $con->prepare("SELECT comments.* , users.USERNAME AS username , items.name AS itemname FROM comments INNER JOIN users ON users.USERID = comments.user_id INNER JOIN items ON items.item_id = comments.item_id ");
                $stmt->execute();
                $count = $stmt->rowCount();
                $comms = $stmt->fetchAll();

                ?>
                <div class="container">
                    <h1 class="text-center manageheading">Manage [<?php echo $row['name'] ?>] Comments</h1>
                    <table class="table tbl text-center">
                        <thead>
                            <tr>

                                <th scope="col">Comment</th>
                                <th scope="col">Status</th>
                                <th scope="col">User</th>
                                <th scope="col">Operation </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php



                            foreach ($comms as $info) { ?>
                                <tr>

                                    <td> <?php echo $info['comment']; ?></td>
                                    <td> <?php
                                            if ($info['status'] == 0) {
                                                echo "Pending";
                                            } else {
                                                echo "Approved";
                                            }
                                            ?></td>

                                    <td> <?php echo $info['username']; ?></td>

                                    <td> <a href="comments.php?do=Edit&commid=<?php echo $info['comm_id']; ?>" class="btn btn-primary btn-bg"> Edit</a>
                                        <a href="comments.php?do=Delete&commid=<?php echo $info['comm_id']; ?>" class="btn btn-danger btn-bg close"> Delete</a>
                                        <?php
                                        if ($info['status'] == 0) { ?>

                                            <a href="?do=Approve&commid=<?php echo $info['comm_id']; ?>" class="btn activate btn-success btn-bg close"> Approve</></a>

                                        <?php }
                                        ?>
                                    </td>
                                </tr>
                            <?php }






                            ?>

                        </tbody>
                    </table>

                </div>









                <!-- For Comments -->



            </div>



<?php }
    } elseif ($do == "Update") {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $id         = $_POST['itemid'];
            $name       = $_POST['itemname'];
            $desc       = $_POST['itemdesc'];
            $price      = $_POST['price'];
            $status     = $_POST['status'];
            $country    = $_POST['country'];
            $user       = $_POST['user'];
            $cat        = $_POST['cat'];


            if (isset($_FILES['photo'])) {
                $photo = $_FILES['photo'];
                $random = rand(0, 10000);
                $photoname = $photo['name'] . "-" . $random;
                $photo_tmp = $photo['tmp_name'];


                move_uploaded_file($photo_tmp, "uploads/items/$photoname");
            }




            $erros = array();
            if (empty($name)) {
                $erros[] = "Name Can't Be Empty";
            }
            if (empty($desc)) {
                $erros[] = "Description Can't Be Empty";
            }
            if (empty($user)) {
                $erros[] = "Seller Username Can't Be Empty";
            }
            if (empty($cat)) {
                $erros[] = "Category Name Can't Be Empty";
            }
            if (empty($price)) {
                $erros[] = "Price Can't Be Empty";
            }
            if (empty($country)) {
                $erros[] = "Country Can't Be Less Than 2 Characters";
            }

            if (count($erros) == 0) {
                $stmt = $con->prepare("UPDATE items SET name = ? , description = ? , price = ? , photo , status = ? , country = ? , user_id = ? , cat_id = ?  WHERE item_id = ?");
                $stmt->execute(array($name,  $desc, $price, "uploads/items/$photoname", $status, $country, $user, $cat, $id));
                $msg =  "<div class = 'alert alert-success'> Item Updated </div>";
                reDirect($msg, "back");
            } else {
                foreach ($erros as $error) {
                    echo "<div class = 'alert alert-danger container'> " . $error . "</div";
                }
                reDirect("Edit Them", "back", 4);
            }
        } else {
            $msg = "<div class = 'alert alert-danger'>You cant Access Direct</div>";
            reDirect($msg);
        }
    } elseif ($do == "Delete") {

        if (isset($_GET['itemid'])) {

            $itemid = $_GET['itemid'];

            $stmt = $con->prepare("DELETE FROM items WHERE item_id = ?");
            $stmt->execute(array($itemid));
            $count = $stmt->rowCount();

            if ($count > 0) {
                $msg = "<div class = 'alert alert-success'>Item DELETED</div>";
                reDirect($msg, "back");
            }
        } else {
            $msg = "<div class = 'alert alert-danger'>No Id Entered</div>";
            reDirect($msg);
        }
    } elseif ($do == "Approve") {

        $itemid = $_GET['itemid'];
        $stmt = $con->prepare("UPDATE items SET approved = 1 WHERE item_id = ? ");
        $stmt->execute(array($itemid));

        $msg = "<div class = 'alert alert-success'> Item Approved </div>";
        reDirect($msg, "back");
    } else {
        header("Location:dashboard.php");
        exit;
    }

    include($tpl . "footer.php");
} else {
    include("index.php");
}
