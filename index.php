<?php

$pagetitle = "Home";
include("init.php");


$stmt = $con->prepare("SELECT * FROM items WHERE approved = ? ORDER BY item_id DESC");
$stmt->execute(array(1));
$items = $stmt->fetchAll();

?>
<div class="container">
    <h1 class="text-center manageheading">All Items</h1>
    <div class="row">

        <?php foreach ($items as $item) {
        ?>


            <div class="col-12 col-md-3 item-box">
                <div class="card" style="width: 100%; height:440px; margin-bottom: 50px;">
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
                        <p class="card-text"><?php echo $item['description'] ?></p>
                        <a href="item.php?itemid=<?php echo $item['item_id'] ?>" class="btn btn-primary">Details</a>
                        <span class="price">$<?php echo $item['price']  ?></span>
                    </div>
                </div>


            </div>



        <?php }

        ?>
    </div>
</div>

<script src="jquery-3.5.1.min.js"></script>
<script>
    function getItems() {
        $.post("index.php",
            function(one, two, three) {

            });

    };
    setInterval("getItems()", 1000);
</script>

<?php













include($tpl . "footer.php");
