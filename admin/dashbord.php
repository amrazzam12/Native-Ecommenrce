<?php
session_start();

if (isset($_SESSION['username'])) {

    $pagetitle = "Dashboard";
    include('init.php');


?>
    <section class="dashboard text-center">
        <div class="container">
            <h1>Dashboard</h1>
            <div class="row">
                <div class="col-12 col-md-3 mb-3 mb-md-0">
                    <div class="stat members">
                        <h3>Total Members</h3>
                        <span><a href="members.php?do=Manage"><?php echo countItems("USERID", "users", 1); ?></a></span>
                    </div>
                </div>

                <div class="col-12 col-md-3 mb-3 mb-md-0">
                    <div class="stat pending">
                        <h3>Pending Members</h3>
                        <span><a href="members.php?do=Manage&pen=Pending"> <?php echo countItems("USERID", "users", "REGSTATUS = 0"); ?></a></span>
                    </div>
                </div>

                <div class="col-12 col-md-3 mb-3 mb-md-0">
                    <div class="stat items">
                        <h3> Items</h3>
                        <span><a href="items.php"><?php echo countItems("item_id", "items", "1") ?></a></span>
                    </div>
                </div>

                <div class="col-12 col-md-3 mb-3 mb-md-0">
                    <div class="stat comments">
                        <h3>Comments</h3>
                        <span><a href="comments.php"><?php echo countItems("comm_id", "comments", "1") ?></a></span>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="last col-12 col-md-6">
                    <p>
                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapsemembers" aria-expanded="false" aria-controls="collapseWidthExample">
                            Last Members
                        </button>
                    </p>
                    <div style="min-height: 120px;">
                        <div class="collapse collapse-horizontal" id="collapsemembers">
                            <div class="card card-body" style="width: 300px;">
                                <?php

                                $lastmembers = getLast("*", "users", "USERID");

                                foreach ($lastmembers as $member) { ?>

                                    <div class="row">

                                        <div class="col-5"> <?php echo $member['USERNAME']; ?> </div>
                                        <div class="col-7 row  last-mem">

                                            <a href="members.php?do=Edit&userid=<?php echo $member['USERID']; ?>" class=' edit col-5 btn btn-sm btn-primary'>Edit </a>
                                            <a href="members.php?do=Delete&userid=<?php echo $member['USERID']; ?>" class=' edit col-6 btn btn-sm btn-danger'>Delete </a>


                                        </div>
                                        <hr>

                                    </div>

                                <?php




                                }


                                ?>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="last col-12 col-md-6">
                    <p>
                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample" aria-expanded="false" aria-controls="collapseWidthExample">
                            Last Items
                        </button>
                    </p>
                    <div style="min-height: 120px;">
                        <div class="collapse collapse-horizontal" id="collapseWidthExample">
                            <div class="card card-body" style="width: 300px;">
                                <?php

                                $lastitems = getLast("*", "items", "5");

                                foreach ($lastitems as $item) { ?>
                                    <div class="row">

                                        <div class="col-5"> <?php echo $item['name']; ?> </div>
                                        <div class="col-7 row  last-mem">

                                            <a href="items.php?do=Edit&itemid=<?php echo $item['item_id']; ?>" class=' edit col-5 btn btn-sm btn-primary'>Edit </a>
                                            <a href="items.php?do=Delete&itemid=<?php echo $item['item_id']; ?>" class=' edit col-6 btn btn-sm btn-danger'>Delete </a>


                                        </div>
                                        <hr>

                                    </div>
                                <?php }

                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




<?php
    include($tpl . "footer.php");
} else {
    header('Location: index.php');
    exit;
}
