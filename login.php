<?php
session_start();
require("connect.php");

$message = " ";
if(isset($_GET['message'])){
    $message = $_GET['message'];
}


// if(isset($_POST['btnlogin'])){

    // $username = $_POST['username'];
    // $passwordAttempt = $_POST['password'];

    // $sql = "SELECT userId, username, password FROM users WHERE username = :username";
    // $stmt = $db->prepare($sql);
    // $stmt->bindValue('username', $username);
    // $stmt->execute();
    // $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $msg = ""; 
if(isset($_POST['btnlogin'])) {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);
  if($username != "" && $password != "") {
    try {
      $query = "select * from `users` where `username`=:username and `password`=:password";
      $stmt = $db->prepare($query);
      $stmt->bindParam('username', $username, PDO::PARAM_STR);
      $stmt->bindValue('password', $password, PDO::PARAM_STR);
      $stmt->execute();
      $count = $stmt->rowCount();
      $row   = $stmt->fetch(PDO::FETCH_ASSOC);
      if($count == 1 && !empty($row)) {
        /******************** Your code ***********************/
        $_SESSION['sess_user_id']   = $row['userId'];
        $_SESSION['sess_user_name'] = $row['username'];
        // $_SESSION['sess_name'] = $row['name'];
        header('Location: home.php');
                exit;
      } else {
        $msg = "Invalid username and password!";
      }
    } catch (PDOException $e) {
      echo "Error : ".$e->getMessage();
    }
  } else {
    $msg = "Both fields are required!";
  }






    // $_SESSION['user_id'] = $user['userId'];
    // $_SESSION['logged_in'] = time();

    // if(!isset($user)){
    //     die('Incorrect username / password combination!');
    // } else{
    //     echo'User is set';

    //     $validPassword = password_verify($passwordAttempt, $user['password']);
    //     echo  $validPassword;
    //     if($validPassword){

    //         $_SESSION['user_id'] = $user['userId'];
    //         $_SESSION['logged_in'] = time();

    //         header('Location: home.php');
    //         exit;

    //     } elseif ($validPassword == null) {
    //         echo'password is null';
    //     }
    //     else{
    //         $message = 'Incorrect username / password!';
    //     }
    // }
}

echo $_SESSION['user_id'];
?>