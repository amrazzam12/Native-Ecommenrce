<?php



function getTitle()
{

    global $pagetitle;

    if (isset($pagetitle)) {

        return $pagetitle;
    } else {

        return "Default";
    }
}


function reDirect($msg, $url  = null, $seconds = 2)
{

    if ($url == null) {

        $url = "index.php";
    } elseif ($url == "back") {
        if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== "") {
            $url = $_SERVER['HTTP_REFERER'];
        } else {
            $url = "index.php";
        }
    }

    echo $msg;
    header("refresh:$seconds;url=$url");
}





function getCats()
{
    global $con;
    $stmt = $con->prepare("SELECT * FROM categories");
    $stmt->execute();
    $cats = $stmt->fetchAll();
    return $cats;
}


function getItems($value)
{
    global $con;
    $stmt = $con->prepare("SELECT * FROM items WHERE cat_id = ?");
    $stmt->execute(array($value));
    $items = $stmt->fetchAll();
    return $items;
}



function viewItem($val)
{
    global $con;
    $stmt = $con->prepare("SELECT * FROM items WHERE item_id = ?");
    $stmt->execute(array($val));
    $item = $stmt->fetchAll();
    return $item;
}


function checkItem($select, $from, $value)
{

    global $con;

    $stmt = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
    $stmt->execute(array($value));

    return $stmt->rowCount();
}
