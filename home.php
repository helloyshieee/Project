<?php 
session_start();
require("connect.php");
$id = "";
	if(!isset($_SESSION['user_id']) || !isset($_SESSION['logged_in'])){
		// header('Location: home.php');
		// exit;
	}
	$message = "";
	if(isset($_GET['error'])){
		$message = $_GET['error'];
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>A.V. Collection</title>
		<link rel="stylesheet" type="text/css" href="style/style.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Heebo&family=Montserrat:wght@500&family=Open+Sans:wght@600&family=Roboto:wght@300;400&display=swap" rel="stylesheet">
	</head>
	<body>
		<!-- <a href =register.html> Register </a>
        <a href =login.html> Log In </a> -->
		<!-- <div class="announcement">
			<p>FREE SHIPPING ON ORDERS CAD$200 (CANADA & US) </p>
		</div> -->

		<!-- Navigation bar -->
		<div class ="nav">
			<ul class="topnav">
				<li id = "logout"><a href="logout.php">Log Out</a></li>
				<li id = "logout"><a href="reviews.php">Reviews</a></li>
			</ul>
		</div>
		<!-- Header with background-image -->
		<div class="header">
			<div class = "header-text">
				<h1>A.V. COLLECTION</h1>
    			<p>Hello there, <?php echo  $_SESSION['sess_user_name'];?> ! You successfully logged in.</p>
    			<button>Shop Now</button>
			</div>
		</div>

		<div class = "vision">
			<div class = "blocks">
				<h2 class = "custom-title">Minimal</h2>
			</div>
			<div class = "custom-text">
				<p>We are all about the simplicity. 
				It makes our designs easy to use while still keeping the aesthetic that you love.</p>
			</div>
		</div>

		<div class = "container">
		<div class = "vision">
			<div class = "blocks">
				<h2 class = "custom-title">Functional</h2>
			</div>
			<div class = "custom-text">
				<p>Our planners are not just pretty, but meant to be used. 
				They are created to inspire you to be more productive and organized.</p>
			</div>
		</div>
		
		<div class = "vision">
			<div class = "blocks">
				<h2 class = "custom-title">Personalized</h2>
			</div>
			<div class = "custom-text">
				<p>Let's create your dream planner together. 
					Pitch us your ideas and we'll work our magic to help you revamp your planner with style.</p>
			</div>
		</div>
		</div>
</html>