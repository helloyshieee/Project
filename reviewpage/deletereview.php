<?php
session_start();
require("../connect.php");
$id = "";

if(isset($_SESSION['sess_user_id']))
{
    $user = $_SESSION['sess_user_id'];
    $aka =  $_SESSION['sess_user_name'];
}

if(isset($_GET['item']))
{
    $product = filter_input(INPUT_GET, 'item', FILTER_VALIDATE_INT);
    $sql = "DELETE FROM review WHERE id = '$product'";
    $del = $db->prepare($sql);
    if ($del->execute()) {
        header("Location: view.php?update=Deleted");
    }else{
        header("Location: view.php?update=Not Deleted");
    }
}

?>
