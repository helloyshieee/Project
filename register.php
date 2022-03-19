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

    if($_POST && !empty($_POST['username']) && !empty($_POST['password']) &&!empty($_POST['email']))
    {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

        $query = "INSERT INTO users (username, password, email) VALUES (:username, :password, :email) ";
        $statement = $db->prepare($query);
    
        $statement->bindValue(":username", $username);
        $statement->bindValue(":password", $password);
        $statement->bindValue(":email", $email);
    
        if($statement->execute()){
            // header("Location:register.php");
            exit();
        }
    }
	// We need to check if the account with that username exists.
	// if ($stmt = $con->prepare('SELECT username, password FROM users WHERE username = ?')) 
	// {
	// 	$stmt->bind_param('s', $_POST['username']);
	// 	$stmt->execute();
	// 	$stmt->store_result();
	// 	// Store the result so we can check if the account exists in the database.
	// 	if ($stmt->num_rows > 0) 
	// 	{
	// 		// Username already exists
	// 		echo 'Username exists, please choose another!';
	// 	} 
	// 	else 
	// 	{
	// 		// Username doesnt exists, insert new account
	// 		if ($stmt = $con->prepare('INSERT INTO users (username, password, email,) VALUES (?, ?, ?)'))  
	// 		{
	// 			$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	// 			$stmt->bind_param('sss', $_POST['username'], $password, $_POST['email']);
	// 			$stmt->execute();
	// 			echo 'You have successfully registered, you can now login!';
	// 		} 
	// 		else 
	// 		{
	// 			echo 'Could not prepare statement!';
	// 		}
	// 	}
	// 	$stmt->close();
	// 	} 
	// 	else 
	// 	{
	// 	// Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
	// 	echo 'Could not prepare statement!';
	// 	}
	// 	$con->close();
?>