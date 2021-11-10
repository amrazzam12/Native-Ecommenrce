<?php
$catname = $_GET['catname'];
$pagetitle = $catname;
include("init.php");








?>

<div class="container">
    <h1 class="text-center manageheading"><?php echo $catname ?></h1>

    <div class="row">
        <?php
        $items = getItems($_GET['catid']);
        foreach ($items as $item) {
            if ($item['approved'] == 1) {

        ?>
                <div class="col-12 col-md-3 item-box">
                    <div class="card" style="width: 100%; height:440px; margin-bottom: 50px;">
                        <img class="card-img-top" height="300px" src=" 
                        <?php

                        if ($item['photo'] !== "") {
                            echo $item['photo'];
                        } else {
                            echo "uploads/items/default.png";
                        } ?> " alt=" Card image cap">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $item['name'] ?></h5>
                            <p class="card-text"><?php echo $item['description'] ?></p>
                            <a href="item.php?itemid=<?php echo $item['item_id'] ?>" class="btn btn-primary">Details</a>
                            <span class="price">$<?php echo $item['price']  ?></span>
                        </div>
                    </div>
                </div>




        <?php }
        }

        ?>

    </div>

</div>





<?php







include($tpl . "footer.php");
