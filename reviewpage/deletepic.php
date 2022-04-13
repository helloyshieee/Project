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
	    $id = $_GET['item'];
		$query = "SELECT id, name, content, date, headline, image, userId FROM review WHERE id = :id";
	    $statement = $db -> prepare($query);
		$statement->bindValue(':id', $id);
	    $statement -> execute();
	    $row = $statement -> fetch();

		$query2 = " UPDATE review SET image = null WHERE id = :id" ;
		$statement2 = $db->prepare($query2);
		$statement2->bindValue(':id', $id);
		$statement2->execute();
		$image = "images".$row['image'];

	    unlink($image);
		header('Location: view.php?update=Picture removed');
	}
	else
	{
		header('Location: view.php?update=Picture not removed');
	}

?>
