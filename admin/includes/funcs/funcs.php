<?php

// Get The Title Of The Page

function getTitle()
{

    global $pagetitle;

    if (isset($pagetitle)) {

        return $pagetitle;
    } else {

        return "Default";
    }
}

// Get The Title Of The Page


// Redirect v2.0


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


// Redirect


// Check If User Exists 

function checkItem($select, $from, $value)
{

    global $con;

    $stmt = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
    $stmt->execute(array($value));

    return $stmt->rowCount();
}


// Check If User Exists 


// Count Items 

function countItems($select, $table, $filter)
{

    global $con;

    $stmt = $con->prepare("SELECT COUNT($select) AS COUNTED FROM $table WHERE $filter");
    $stmt->execute(array());


    $row = $stmt->fetchColumn();
    return $row;
}



// Count Items 


// Get Last Items

function getLast($select, $from, $order = "USERID", $limit = 5)
{

    global $con;

    $stmt = $con->prepare("SELECT $select FROM $from ORDER BY $order DESC LIMIT $limit");
    $stmt->execute();
    $row = $stmt->fetchAll();

    return $row;
}



// Get Last Items