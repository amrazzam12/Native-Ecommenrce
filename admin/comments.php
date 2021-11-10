<?php


session_start();


$pagetitle = 'Comments';
if (isset($_SESSION['username'])) {
    include("init.php");
    $do = isset($_GET['do']) ? $do = $_GET['do'] : 'Manage';



    if ($do == "Manage") {


        $stmt = $con->prepare("SELECT comments.* , users.USERNAME AS username , items.name AS itemname FROM comments INNER JOIN users ON users.USERID = comments.user_id INNER JOIN items ON items.item_id = comments.item_id ");
        $stmt->execute();
        $count = $stmt->rowCount();
        $row = $stmt->fetchAll();

?>
        <div class="container">
            <h1 class="text-center manageheading">Manage Comments</h1>
            <table class="table tbl text-center">
                <thead>
                    <tr>
                        <th scope="col">CommentID</th>
                        <th scope="col">Comment</th>
                        <th scope="col">Status</th>
                        <th scope="col">User</th>
                        <th scope="col">Item</th>
                        <th scope="col">Operation </th>
                    </tr>
                </thead>
                <tbody>
                    <?php



                    foreach ($row as $info) { ?>
                        <tr>
                            <th> <?php echo $info['comm_id']; ?></th>
                            <td> <?php echo $info['comment']; ?></td>
                            <td> <?php
                                    if ($info['status'] == 0) {
                                        echo "Pending";
                                    } else {
                                        echo "Approved";
                                    }
                                    ?></td>

                            <td> <?php echo $info['username']; ?></td>
                            <td> <?php echo $info['itemname']; ?></td>

                            <td> <a href="?do=Edit&commid=<?php echo $info['comm_id']; ?>" class="btn btn-primary btn-bg"> Edit</a>
                                <a href="?do=Delete&commid=<?php echo $info['comm_id']; ?>" class="btn btn-danger btn-bg close"> Delete</a>
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




        <?php
    } elseif ($do == "Edit") {

        $commid = isset($_GET['commid']) && is_numeric($_GET['commid']) ? intval($_GET['commid']) : 0;

        $stmt = $con->prepare("SELECT *  FROM comments WHERE comm_id = ? LIMIT 1");
        $stmt->execute(array($commid));
        $row = $stmt->fetch();
        $count = $stmt->rowcount();

        if ($count > 0) { ?>

            <h1 class="text-center mb-5 mt-5">Edit Comment</h1>
            <div class="container">
                <form action="?do=Update" method="POST">
                    <input type="hidden" name="commid" value=<?php echo $commid; ?>>
                    <div class="row mx-5 mb-4">
                        <div class="col-2">
                            <label for="comment" class="col-form-label">Comment</label>
                        </div>
                        <div class="col-10">
                            <textarea class="form-control" name="comment" id="comment"> <?php echo $row['comment'] ?></textarea>
                        </div>
                    </div>


                    <div class="row justify-content-center">
                        <div class="col-5">
                            <button type="submit" class="btn btn-primary btn-lg  mx-5" style="width:100%">Edit</button>
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

            $commid     = $_POST['commid'];
            $comment   = $_POST['comment'];




            $stmt = $con->prepare("UPDATE comments SET comment = ?  WHERE comm_id = ?");
            $stmt->execute(array($comment, $commid));
            $msg =  "<div class = 'alert alert-success'> Comment Updated </div>";
            reDirect($msg, "back");
        } else {
            $msg = "<div class = 'alert alert-danger'>You cant Access Direct</div>";
            reDirect($msg);
        }
    } elseif ($do == 'Delete') {

        if (isset($_GET['commid'])) {

            $commid = $_GET['commid'];

            $stmt = $con->prepare("DELETE FROM comments WHERE comm_id = ?");
            $stmt->execute(array($commid));
            $count = $stmt->rowCount();

            if ($count > 0) {
                $msg = "<div class = 'alert alert-success'>Comment DELETED</div>";
                reDirect($msg, "back");
            }
        } else {
            $msg = "<div class = 'alert alert-danger'>No Id Entered</div>";
            reDirect($msg);
        }
    } elseif ($do == "Approve") {
        $commid = $_GET['commid'];
        $stmt = $con->prepare("UPDATE comments SET status = 1 WHERE comm_id = ? ");
        $stmt->execute(array($commid));

        $msg = "<div class = 'alert alert-success'> Comment Approved </div>";
        reDirect($msg, "back");
    }
    include($tpl . "footer.php");
} else {
    header("Location: index.php");
    exit;
}
