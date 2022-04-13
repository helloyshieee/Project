<?php
session_start();
require("../connect.php");
$id = "";
	if(!isset($_SESSION['sess_user_id']) || !isset($_SESSION['logged_in'])){
		// header('Location: home.php');
		// exit;
	}
	$message = "";
	if(isset($_GET['error'])){
		$message = $_GET['error'];
	}

if ($_POST && !empty($_POST['category']))
{
    $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    // $categoryId = filter_input(INPUT_POST, 'categoryid', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $query = "INSERT INTO category (categoryname) VALUES (:categoryname) ";
    $statement = $db->prepare($query);

    // $statement->bindValue(":categoryId", $categoryId);
    $statement->bindValue(":categoryname", $category);

    if($statement->execute()){
        header('Location: admin.php');
        exit;
    }
}

?>