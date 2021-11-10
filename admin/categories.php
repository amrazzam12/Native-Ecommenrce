<?php


session_start();


$pagetitle = 'Categories';
if (isset($_SESSION['username'])) {
    include("init.php");

    $do = isset($_GET['do']) ? $do = $_GET['do'] : 'Manage';


    if ($do == "Manage") {
?>



        <div class="container">

            <h1 class=" text-center manageheading">Manage Categories</h1>
            <table class="table tbl-cat text-center">
                <thead>
                    <tr>
                        <th scope="col">Categorie</th>
                        <th class="d-none d-md-block" scope="col">Description</th>
                        <th scope="col">Visibility</th>
                        <th class="d-none d-md-block" scope="col">Comments</th>
                        <th scope="col">Ads </th>
                        <th class="d-none d-md-block" scope="col">Order </th>
                        <th scope="col">Operation </th>
                    </tr>
                </thead>
                <tbody>


                    <?php

                    $stmt = $con->prepare("SELECT * FROM categories");
                    $stmt->execute();
                    $cats = $stmt->fetchAll();




                    foreach ($cats as $cat) { ?>
                        <tr>
                            <th> <?php echo $cat['NAME']; ?></th>
                            <td class="d-none d-md-block"> <?php echo $cat['DESCRIPTION']; ?></td>
                            <td> <?php

                                    if ($cat['VISIBILTY'] == 0) {
                                        echo "<div class =  'btn btn-danger' >Hidden</div>";
                                    } else {
                                        echo "<div class =  'btn btn-success' >Visible</div>";
                                    }

                                    ?></td>
                            <td class="d-none d-md-block">
                                <?php if ($cat['ALLOWCOMM'] == 0) {
                                    echo "<div class =  'btn btn-danger' >Not Allowed</div>";
                                } else {
                                    echo "<div class =  'btn btn-success' >Allowed</div>";
                                } ?></td>
                            <td>
                                <?php if ($cat['ALLOWADS'] == 0) {
                                    echo "<div class =  'btn btn-danger' >Not Allowed</div>";
                                } else {
                                    echo "<div class =  'btn btn-success' >Allowed</div>";
                                } ?></td>
                            <td class="d-none d-md-block">
                                <?php
                                if ($cat['ORDERING'] == 0) {
                                    $cat['ORDERING'] = $cat['ID'];
                                    echo $cat['ORDERING'];
                                }
                                ?></td>
                            <td> <a href="?do=Edit&catid=<?php echo $cat['ID']; ?>" class="btn btn-primary btn-bg"> Edit</a>
                                <a href="?do=Delete&catid=<?php echo $cat['ID']; ?>" class="btn btn-danger btn-bg close"> Delete</a>




                                <?php
                                ?>
                            </td>
                        </tr>
                    <?php }






                    ?>

                </tbody>
            </table>
            <div class="btn-add btn btn-success">
                <a class="addlink" href="?do=Add">Add New Categorie <i class="fas fa-plus"></i></a>
            </div>

        </div>





    <?php
    } elseif ($do == "Add") { ?>
        <h1 class="text-center mb-5 mt-5">Add Categorie</h1>
        <div class="container">
            <form action="?do=Insert" method="POST">
                <div class="row mx-5 mb-4">
                    <div class="col-2">
                        <label for="name" class="col-form-label">Name</label>
                    </div>
                    <div class="col-10">
                        <input type="text" name="name" id="name" required="required" class="form-control" autocomplete="off" placeholder="Name">
                    </div>
                </div>
                <div class="row mx-5 mb-4">
                    <div class="col-2">
                        <label for="desc" class="col-form-label">Description</label>
                    </div>
                    <div class="col-10">
                        <input type="text" name="desc" id="desc" class="form-control text" placeholder="Description">

                    </div>
                </div>

                <div class="row mx-5 mb-4">
                    <div class="col-5 col-md-2">
                        <label for="Order" class="col-form-label">Order</label>
                    </div>
                    <div class="col-2">
                        <input type="number" name="order" id="Order" class="form-control text">
                    </div>
                </div>

                <div class="row mx-5 mb-4">
                    <div class="col-6 col-md-2">
                        <label for="fullname" class="col-form-label">Visibility</label>
                    </div>

                    <div class="col-4 col-md-10">
                        <div>
                            <label for="comm-ys">Yes</label>
                            <input id="comm-ys" type="radio" name="vis" value="1" checked>
                        </div>
                        <div>
                            <label for="comm-no">No</label>
                            <input id="comm-no" type="radio" name="vis" value="0">

                        </div>
                    </div>
                </div>


                <div class="row mx-5 mb-4">
                    <div class="col-6 col-md-2">
                        <label for="fullname" class="col-form-label">Comments</label>
                    </div>

                    <div class="col-4 col-md-10">
                        <div>
                            <label for="comm-ys">Yes</label>
                            <input id="comm-ys" type="radio" name="comm" value="1" checked>
                        </div>
                        <div>
                            <label for="comm-no">No</label>
                            <input id="comm-no" type="radio" name="comm" value="0">

                        </div>
                    </div>
                </div>

                <div class="row mx-5 mb-4">
                    <div class="col-6 col-md-2">
                        <label for="fullname" class="col-form-label">Ads</label>
                    </div>

                    <div class="col-4 col-md-10">
                        <div>
                            <label for="comm-ys">Yes</label>
                            <input id="comm-ys" type="radio" name="ads" value="1" checked>
                        </div>
                        <div>
                            <label for="comm-no">No</label>
                            <input id="comm-no" type="radio" name="ads" value="0">

                        </div>
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

            $name       = $_POST['name'];
            $desc       = $_POST['desc'];
            $order      = $_POST['order'];
            $vis        = $_POST['vis'];
            $allowcomm  = $_POST['comm'];
            $allowads   = $_POST['ads'];


            $count = checkItem("name", "categories", $name);

            if ($count == 0) {

                if (empty($name)) {

                    echo "Name Cant Be Empty";
                } else {




                    $stmt = $con->prepare("INSERT INTO categories(NAME , DESCRIPTION , ORDERING , VISIBILTY , ALLOWCOMM , ALLOWADS) VALUES (? , ? , ? , ? , ? , ?)");
                    $stmt->execute(array($name, $desc, $order, $vis,  $allowcomm, $allowads));
                    $rowcount = $stmt->rowCount();

                    if ($rowcount > 0) {
                        $msg = "<div class='alert alert-success'>Categorie Inserted</div>";
                        reDirect($msg, "categories.php");
                    }
                }
            } else {
                $msg = "<div class = 'alert alert-danger'>Categorie Exists</div>";
                reDirect($msg, "back", 3);
            }
        } else {
            $msg = "<div class = 'alert alert-danger'>You Cant Direct</div>";
            reDirect($msg, 3);
        }
    } elseif ($do == "Edit") {
        $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

        $stmt = $con->prepare("SELECT *  FROM categories WHERE ID = ? LIMIT 1");
        $stmt->execute(array($catid));
        $row = $stmt->fetch();
        $count = $stmt->rowcount();

        if ($count > 0) { ?>

            <h1 class="text-center mb-5 mt-5">Edit Categorie</h1>
            <div class="container">
                <form action="?do=Update&catid=<?php echo $catid ?>" method="POST">
                    <input type="hidden" name="catid" value=<?php echo $catid; ?>>
                    <div class="row mx-5 mb-4">
                        <div class="col-2">
                            <label for="catname" class="col-form-label">Name </label>
                        </div>
                        <div class="col-10">
                            <input type="text" name="name" id="catname" required="required" class="form-control" autocomplete="off" value="<?php echo $row['NAME']  ?>">
                        </div>
                    </div>
                    <div class="row mx-5 mb-4">
                        <div class="col-2">
                            <label for="catdesc" class="col-form-label">Description</label>
                        </div>
                        <div class="col-10">

                            <input type="text" name="desc" id="inputPassword" class="form-control text" autocomplete="new-password" value="<?php echo $row["DESCRIPTION"]; ?>">

                        </div>
                    </div>

                    <div class="row mx-5 mb-4">
                        <div class="col-5 col-md-2">
                            <label for="Order" class="col-form-label">Order</label>
                        </div>
                        <div class="col-2">
                            <input type="number" name="order" id="Order" class="form-control text">
                        </div>
                    </div>

                    <div class="row mx-5 mb-4">
                        <div class="col-6 col-md-2">
                            <label for="fullname" class="col-form-label">Visibility</label>
                        </div>

                        <div class="col-4 col-md-10">
                            <div>
                                <label for="comm-ys">Yes</label>
                                <input id="comm-ys" type="radio" name="vis" value="1" checked>
                            </div>
                            <div>
                                <label for="comm-no">No</label>
                                <input id="comm-no" type="radio" name="vis" value="0">

                            </div>
                        </div>
                    </div>


                    <div class="row mx-5 mb-4">
                        <div class="col-6 col-md-2">
                            <label for="fullname" class="col-form-label">Comments</label>
                        </div>

                        <div class="col-4 col-md-10">
                            <div>
                                <label for="comm-ys">Yes</label>
                                <input id="comm-ys" type="radio" name="comm" value="1" checked>
                            </div>
                            <div>
                                <label for="comm-no">No</label>
                                <input id="comm-no" type="radio" name="comm" value="0">

                            </div>
                        </div>
                    </div>

                    <div class="row mx-5 mb-4">
                        <div class="col-6 col-md-2">
                            <label for="fullname" class="col-form-label">Ads</label>
                        </div>

                        <div class="col-4 col-md-10">
                            <div>
                                <label for="comm-ys">Yes</label>
                                <input id="comm-ys" type="radio" name="ads" value="1" checked>
                            </div>
                            <div>
                                <label for="comm-no">No</label>
                                <input id="comm-no" type="radio" name="ads" value="0">

                            </div>
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


            $catid      = $_GET['catid'];
            $name       = $_POST['name'];
            $desc       = $_POST['desc'];
            $order      = $_POST['order'];
            $vis        = $_POST['vis'];
            $comm       = $_POST['comm'];
            $ads        = $_POST['ads'];




            $count =  checkItem("NAME", "categories", $name);

            if ($count == 0) {
                if ($name !== "") {
                    $stmt = $con->prepare("UPDATE categories SET NAME = ? , DESCRIPTION = ? , ORDERING = ? , VISIBILTY = ? , ALLOWADS = ? , ALLOWCOMM = ? WHERE ID = ?");
                    $stmt->execute(array($name,  $desc, $order, $vis, $ads, $comm, $catid));
                    $msg =  "<div class = 'alert alert-success'> Categorie Updated </div>";
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
    } elseif ($do == "Delete") {

        $catid = $_GET['catid'];

        $stmt = $con->prepare("DELETE FROM categories WHERE ID = ?");
        $stmt->execute(array($catid));
        $count = $stmt->rowCount();
        if ($count > 0) {
            $msg = "<div class = 'alert alert-success'>Categorie Deleted</div>";
            reDirect($msg, "categories.php");
        } else {
            "no Cat";
        }
    } else {
        header("Location:dashboard.php");
        exit;
    }




    include($tpl . "footer.php");
} else {

    include("index.php");
}
