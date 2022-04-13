<?php
session_start();
require("../connect.php");
$id = "";

if(isset($_SESSION['sess_user_id']))
{
    $user = $_SESSION['sess_user_id'];
    $aka =  $_SESSION['sess_user_name'];
}

$id = $_GET['item'];
$query = "SELECT id, headline, userId, content, image FROM review WHERE id = :id";
$stmt = $db->prepare($query);
$stmt->bindValue(':id', $id);
$stmt->execute();
$items = $stmt->fetch(PDO::FETCH_ASSOC);

$name = $items['headline'];
$description = $items['content'];
$thisitem = $items['id'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
		<article>


            <h2>Edit your review</h2>
            <form action="updatereview.php?id=<?=$thisitem ?>" method="post">
                <label for="headline">Headline</label><br>
                <input type="headline" id="headline" name="headline" value= "<?=  $items['headline'] ?>"><br>
                <label for="content">Content</label><br>
                <input type="text" id="content" name="content" value= "<?=  $items['content'] ?>"><br><br>
                <input type="submit" value="Submit">
            </form>
        </article>
	</section>

</body>
</html>
