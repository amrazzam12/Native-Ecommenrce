<?php
$pagetitle = "Add Item";
include("init.php");


if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $itemname = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $itemndesc = filter_var($_POST['desc'], FILTER_SANITIZE_STRING);
    $itemprice = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
    $itemstatus = $_POST['status'];
    $itemcountry = filter_var($_POST['country'], FILTER_SANITIZE_STRING);
    $itemcat = $_POST['cat'];


    $stmtuser = $con->prepare("SELECT USERID FROM users WHERE USERNAME = ?");
    $stmtuser->execute(array($_SESSION['user']));
    $sessuser = $stmtuser->fetch();
    print_r($sessuser);
    $userid = $sessuser['USERID'];


    if (isset($_FILES['photo'])) {
        $photo = $_FILES['photo'];
        $random = rand(0, 10000);
        $photoname = $photo['name'] . "-" . $random;
        $photo_tmp = $photo['tmp_name'];


        move_uploaded_file($photo_tmp, "admin/uploads/items/$photoname");
    }







    $erros = array();


    if (empty($itemname)) {
        $erros[] = "Name Can't Be Empty";
    }
    if (empty($itemndesc)) {
        $erros[] = "Description Can't Be Empty";
    }

    if (empty($itemcat)) {
        $erros[] = "Category Name Can't Be Empty";
    }
    if (empty($itemprice)) {
        $erros[] = "Price Can't Be Empty";
    }
    if (empty($itemcountry)) {
        $erros[] = "Country Can't Empty";
    }

    if (empty($erros)) {
        $stmt = $con->prepare("INSERT INTO items (name, description, price , photo, status, country , user_id , cat_id) VALUES ( ?,? , ?, ?, ? , ? , ? , ?)");
        $stmt->execute(array($itemname, $itemndesc, $itemprice, "admin/uploads/items/$photoname", $itemstatus, $itemcountry, $userid, $itemcat));
        $msg = "<div class = 'alert alert-success' > Item Added </div>";
        reDirect($msg, "profile.php",  2);
        exit;
    } else {
        foreach ($erros as $error) {
            echo "<div class = 'alert alert-danger container'> " . $error . "</div";
        }
        reDirect("", "profile.php", 4);
        exit;
    }
} else {


?>

    <h1 class="text-center manageheading mb-5 mt-5">Add Item</h1>
    <div class="container">
        <div class="row">
            <!-- First Row -->


            <div class="col-12 col-md-7">


                <form class="newitem" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                    <div class="row mx-5 mb-4">
                        <div class="col-2">
                            <label for="name" class="col-form-label">Name</label>
                        </div>
                        <div class="col-10">
                            <input type="text" name="name" id="name" required="required" class="form-control title" autocomplete="off" placeholder="Item Name">
                        </div>
                    </div>
                    <div class="row mx-5 mb-4">
                        <div class="col-2">
                            <label for="desc" class="col-form-label">Description</label>
                        </div>
                        <div class="col-10">
                            <input type="text" name="desc" id="desc" class="form-control text desc" placeholder="Description Of The Item">

                        </div>
                    </div>

                    <div class="row mx-5 mb-4">
                        <div class="col-2">
                            <label for="price" class="col-form-label">Price</label>
                        </div>
                        <div class="col-10">
                            <input type="text" name="price" id="price" class="form-control text price" placeholder="Price Of The Item">
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



            <div class="col-12 col-md-4 ms-auto item-box">
                <div class="card live" style="width: 100%;height:400px; margin-bottom: 50px;">
                    <img style="height: 300px;" class="card-img-top" src="laptop.png" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title live-title">Item1</h5>
                        <p class="card-text desc live-desc">Desc</p>

                        <span class="price live-price">$100</span>
                    </div>
                </div>
            </div>





        </div> <!-- First Row -->





    </div>


<?php




}
?>









<?php
include($tpl . "footer.php");
