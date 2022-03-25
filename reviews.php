<?php 
 require('connect.php');
 session_start();
 $query = "SELECT reviewId, name, content FROM reviews ORDER BY reviewId DESC LIMIT 25";

    $statement = $db->prepare($query);
    $statement->execute();
    $row = $statement->fetchAll(PDO::FETCH_ASSOC);

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
		<!-- Navigation bar -->
		<div class ="nav">
			<ul class="topnav">
				<li id = "login"><a class ="active">Log In</a></li>
  				<li id = "signup"><a class="active">Sign Up</a></li>
				<li class ="right-links"><a href ="reviews.php">Reviews</a></li>
				<li class ="right-links"><a href ="productcatalog.php">Product Catalog</a></li>
				<li class ="right-links"><a href ="##">Home</a></li>
			</ul>
		</div>

		<!-- Sign-up form -->
		<div class ="pop" id = "form">
			<form action = "register.php" method="post" autocomplete="off" class="form-container">

			<label for="email">
					<i class="fas fa-envelope"></i>
			</label>
				<input type="email" name="email" placeholder="Email" id="email" required>

			<label for="username">
				<i class="fas fa-user"></i>
			</label>
				<input type="text" name="username" placeholder="Username" id="username" required>

			<label for="password">
				<i class="fas fa-lock"></i>
			</label>
				<input type="password" name="password" placeholder="Password" id="password" required>

			<label for="password1">
				<i class="fas fa-lock"></i>
			</label>
				<input type="passwordmatch" name="passwordmatch" placeholder="Password" id="passwordmatch" required>

				<button type="submit" class= "btn"> Sign Up </button> 
				<button type="button" class= "btn" id ="close"> Close </button>
			</form>
		</div>


		<!-- Log-In Form -->
		<div class ="pop" id = "logform">
		<form action = "login.php" method="post" autocomplete="off" class="form-container">
			<label for="username">
				<i class="fas fa-user"></i>
			</label>
				<input type="text" name="username" placeholder="Username" id="username" required>

			<label for="password">
				<i class="fas fa-lock"></i>
			</label>
				<input type="password" name="password" placeholder="Password" id="password" required>

			<button type="submit" class= "btn" id = "btnlogin" name="btnlogin"> Log In </button> 
			<button type="button" class= "btn" id ="cancel"> Cancel </button>
		</div>


		<!-- Header with background-image -->
		<div class="header">
			<div class = "header-text">
				<h1>A.V. COLLECTION</h1>
    			<p>Hello there!</p>
    			<button>Shop Now</button>
			</div>
		</div>

<div id="all_blogs">
  <form action="post.php" method="post">
    
      <p>
        <label for="name">Name</label>
        <input name="name" id="name" />
      </p>
      <p>
        <label for="content">Content</label>
        <textarea name="content" id="content"></textarea>
      </p>
      <p>
        <input type="submit" name="command" value="Create" />
      </p>
    
  </form>
</div>

<div id="all_blogs">
    <ul id = bloglist>
        <?php if($statement->rowCount() >0)
            {
                foreach ($row as $rows)
                    {
                            echo "<li><h4 id='name'>"."<a href='view.php?postID=".$rows['reviewId']."' id='nonCurrent'>".$rows['name']."</a>"."</h4><p id='postDate'>"."<p id='postContent'>".substr($rows['content'], 0, 200)."</p>"."<a href='view.php?postID=".$rows['reviewId']."'></a></li>"; 
                    }
            } else{
				echo 'No Reviews Found';
			}
        ?>  
    </ul>
</div> 
	<!-- Javascript for modal -->
	<script>
	
	// Sign-up pop up form
	document.getElementById("signup").addEventListener("click", openForm);
	function openForm(){
		document.getElementById("form").style.display = "block";
	}

	document.getElementById("close").addEventListener("click", closeForm);
	function closeForm()
	{
		document.getElementById("form").style.display = "none";
	}

	document.getElementById("login").addEventListener("click", logForm);
	function logForm(){
		document.getElementById("logform").style.display = "block";
	}

	document.getElementById("cancel").addEventListener("click", cancelForm);
	function cancelForm()
	{
		document.getElementById("logform").style.display = "none";
	}
	</script>
	</body>
</html>