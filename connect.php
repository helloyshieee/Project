<?php
  define('DB_DSN','mysql:host=localhost;dbname=wdproject;charset=utf8');
  define('DB_USER','aira');
  define('DB_PASS','ashley');
  
  try 
  {
      $db = new PDO(DB_DSN, DB_USER, DB_PASS);
  } catch (PDOException $e) {
      print "Error: " . $e->getMessage();
      die();
  }
?>