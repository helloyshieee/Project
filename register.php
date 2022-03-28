<?php
  require('connect.php');

  if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) 
	{
		exit('Please complete the registration form!');
	}

	// Make sure the submitted registration values are not empty.
	if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) 
	{
		exit('Please complete the registration form');
	}

	if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
	{
		exit('Email is not valid!');
	}

	if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['username']) == 0) 
	{
    	exit('Username is not valid!');
	}

	if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) 
	{
		exit('Password must be between 5 and 20 characters long!');
	}

	if (($_POST['password']) != ($_POST['passwordmatch'])){
		exit('Passwords dont match');
	}

	if($_POST && !empty($_POST['username']) && !empty($_POST['password']) &&!empty($_POST['email']))
    {

		$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $hash= password_hash($password, PASSWORD_DEFAULT);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
		

		$sql= "SELECT COUNT(username) AS num FROM users WHERE username = :username";
		$statement =$db->prepare($sql);
		$statement->bindValue(':username', $username);
		$statement->execute();
		$row = $statement->fetch(PDO::FETCH_ASSOC);

		if($row['num'] > 0){
			echo "existing";
	}
	else
	{	
		$sql = 'INSERT INTO users (username, password, email) VALUES (:username, :password, :email)';
		$statement = $db->prepare ($sql);

        $statement->bindValue(":username", $username);
        $statement->bindValue(":password", $hash);
        $statement->bindValue(":email", $email);
    
        $result = $statement->execute();
		if($result){
			header('Location: index.php');
		}
    	
	}
}
?>