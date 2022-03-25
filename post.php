<?php
require('connect.php');

if ($_POST && !empty($_POST['name']) && !empty($_POST['content']))
{
    $name  = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $query = "INSERT INTO reviews (name, content) VALUES (:name, :content) ";
    $statement = $db->prepare($query);

    $statement->bindValue(":name", $name);
    $statement->bindValue(":content", $content);

    if($statement->execute()){
        header("Location:./reviews.php");
        exit();
    }
}
