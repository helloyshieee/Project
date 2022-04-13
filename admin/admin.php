<?php 
session_start();
 require("../connect.php");
 $id = "";
 if(!isset($_SESSION['sess_user_id']) || !isset($_SESSION['logged_in']))
 {
	 $user = $_SESSION['sess_user_id'];
 }

 $id = $_SESSION['sess_user_id'];
 $sql = "SELECT userId, username, role  FROM users WHERE userId = :userId";
 $stmt = $db->prepare($sql);
 $stmt->bindValue(':userId', $id);
 $stmt->execute();
 $user = $stmt->fetch(PDO::FETCH_ASSOC);
 $userName = $user['username'];
 $message = "";
 $userLevel = $user['role'];
 if($userLevel == 'admin'){
	 echo'Hello Admin';
 }

	$query = "SELECT categoryId, categoryname FROM category";
    $statement = $db->prepare($query);
    $statement->execute();
    $row = $statement->fetchAll(PDO::FETCH_ASSOC);

    $error = 0;
    $message = "";
    if(isset($_GET['error'])){
        $error = filter_input(INPUT_GET, 'error', FILTER_VALIDATE_INT);
        if(isset($_GET['message'])){
            $message = filter_input(INPUT_GET, 'message', FILTER_SANITIZE_SPECIAL_CHARS);
        }
    }

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>A.V. Collection</title>
		<link rel="stylesheet" type="text/css" href="../style/adminstyle.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Heebo&family=Montserrat:wght@500&family=Open+Sans:wght@600&family=Roboto:wght@300;400&display=swap" rel="stylesheet">
	</head>
	<body>
		<!-- Navigation bar -->
		<div class ="nav">
			<ul class="topnav">
				<li id = "logout"><a href="admin/admin.php">Home</a></li>
				<li id = "logout"><a href="products.php">Products</a></li>
				<!-- <li id = "logout"><a href="##">Products</a>Orders</li> -->
				<!-- <li id = "logout"><a href="../review/review.php">Reviews</a></li> -->
				<li id = "logout"><a href="../logout.php">Log Out</a></li>
				
				<li id = "logout"><a href="../reviewpage/view.php">Reviews</a></li>
				<li id = "logout"><a href="../test/addpage.php">Add</a></li>
			</ul>
		</div>

		<div>
			<h2>Category</h2>
			<!-- Category Form -->
			<div class ="form" id = "categoryform">
			<form action = "addcategory.php" method="post" autocomplete="off" class="form-container">
			<label for="Category">
			</label>
				<input type="text" name="category" placeholder="Category Name" id="category">
				<!-- <input type="text" name="categoryid" placeholder="Category Id" id="categoryid"> -->
			<button type="submit" class= "btn" id = "btnadd" name="btnadd"> Add </button> 
			</div>
		</div>

		<div id="mainContent">
            <ul id="list">
                <?php if($statement->rowCount() >0)
                {
                    foreach ($row  as $rows)
                    {
                        echo "<li><h4><a href='view.php?postID={$rows['categoryId']}'>{$rows['categoryname']}</a></H4><p>"."
						 <a href='editcategory.php?id={$rows['categoryId']}'>Edit</a>";
                    }
                }?>
            </ul>
        </div>
    </body>
</html>