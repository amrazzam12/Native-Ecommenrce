<?php

$pagetitle = "Item";
include("init.php");



isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? $itemid = intval($_GET['itemid']) : 0;

if (isset($itemid)) {

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $getuser = $con->prepare("SELECT USERID FROM users WHERE USERNAME = ?");
        $getuser->execute(array($_SESSION['user']));
        $commnterid = $getuser->fetch();
        $comment =  filter_var($_POST['commenttxt'], FILTER_SANITIZE_STRING);
        $stmt3 = $con->prepare("INSERT INTO comments (comment, item_id , user_id) VALUES (? , ? , ?)");
        $stmt3->execute(array($comment, $itemid, $commnterid['USERID']));
    }


    $stmt = $con->prepare("SELECT items.* ,  users.USERNAME AS username  , categories.NAME AS catname FROM items INNER JOIN users ON users.USERID = items.user_id INNER JOIN categories ON items.cat_id = categories.ID WHERE item_id = ?");
    $stmt->execute(array($itemid));
    $count = $stmt->rowCount();

    if ($count > 0) {

        $row = $stmt->fetch();

?>

        <div class="container">


            <h2 class="manageheading item-h"><?php echo $row['name'] ?></h2>
            <div class="item-show">
                <div class="row">
                    <div class="col-12 col-md-6 item-image">
                        <img src="<?php echo $row['photo'] ?>" alt="alt">
                    </div>
                    <div class="col-12 col-md-6 item-desc">

                        <div class="row">

                            <div class="col-12">
                                <h2>Description: </h2><span><?php echo $row['description'] ?></span><br>
                            </div>
                            <div class="col-12 col-md-6">
                                <h2>Price: </h2><span><?php echo $row['price'] ?>$</span>
                            </div>
                            <div class="col-12 col-md-6">

                                <h2>Status: </h2><span>
                                    <?php
                                    if ($row['status'] == 0) {
                                        echo "New";
                                    } else {
                                        echo "Used";
                                    } ?></span><br>
                            </div>

                            <div class="col-12">
                                <h2>Made In: </h2><span> <?php echo $row['country'] ?></span><br>
                            </div>
                            <div class="col-12 col-md-6">
                                <h2>Category: </h2><span><?php echo $row['catname'] ?></span><br>
                            </div>
                            <div class="col-12 col-md-6">
                                <h2>Added By : </h2><span><?php echo $row['username'] ?></span><br>
                            </div>

                        </div>
                    </div>
                </div>




                <div class=" comments">
                    <h2 class="text-center">Comments</h2>
                    <?php

                    $stmt2 = $con->prepare("SELECT * , users.avatar AS avatar FROM comments INNER JOIN users ON comments.user_id = users.USERID  WHERE item_id = ?");

                    $stmt2->execute(array($itemid));
                    $countcomm = $stmt2->rowCount();

                    if ($countcomm > 0) {

                        $comms = $stmt2->fetchAll();

                        foreach ($comms as $comment) {
                            $tmp = $comment['avatar'];


                    ?>

                            <div class="comm row">
                                <div class="col-3 comm-img">

                                    <div>
                                        <img width="100%" src="<?php echo $tmp ?>" alt="" class="image-responsive">
                                    </div>


                                </div>
                                <div class="col-9 comm-txt">`<?php echo $comment['comment'] ?>`</div>

                            </div>




                    <?php }
                    } else {
                        echo "There Is No Comments";
                    }



                    ?>

                    <form class="sendcomm" action="<?php echo $_SERVER['PHP_SELF'] ?>?itemid=<?php echo $itemid ?>" method="POST">
                        <textarea class="form-control" name="commenttxt" id="" cols="100" rows="2"></textarea>
                        <input class="btn btn-primary btn-lg btn-comm" type="submit" name="sendcomm" value="Comment">
                    </form>


                </div>
            </div>
        </div>




<?php



    } else {
        echo "No Item With This This is Id";
    }
} else {
    echo "No Such ID";
}




include($tpl . "footer.php");
