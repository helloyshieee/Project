<?php
session_start();
require("connect.php");

$msg = ""; 

if(isset($_POST['btnlogin'])) {
  $success = 0;
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

          
            $_SESSION['sess_user_id']   = $row['userId'];
            $_SESSION['sess_user_name'] = $row['username'];
            header('Location: home.php');
                    exit;
            $success =1;
          
      } 
      if($success == 0)
      {
        echo'Invalid username or Password';
      }
      else{
        echo'Test';
      }
    } catch (PDOException $e) {
      echo "Error : ".$e->getMessage();
    }
  } else {
    $msg = "Both fields are required!";
  }
}
?>