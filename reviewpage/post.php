<?php
session_start();
require("../connect.php");
$id = "";
require 'php-image-resize-master/lib/ImageResize.php';
require 'php-image-resize-master/lib/ImageResizeException.php';

use \Gumlet\ImageResize;
use \Gumlet\ImageResizeException;
$imagename = "";
if(isset($_SESSION['sess_user_id']))
{
    $user = $_SESSION['sess_user_id'];
    $aka =  $_SESSION['sess_user_name'];
}

//delete
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

if ($_POST){
    if(!empty($_POST['headline']) && strlen($_POST['headline']) >= 1 && 
            !empty($_POST['content']) && strlen($_POST['content']) >= 1)
    {
        $headline  = filter_input(INPUT_POST, 'headline', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $name = $aka;

        $query = " INSERT INTO review (name, content, userId, headline,image) VALUES (:name, :content, :userId, :headline,:image) ";
        $statement = $db->prepare($query);
        $image ="";
     // file_upload_path() - Safely build a path String that uses slashes appropriate for our OS.
        // Default upload path is an 'uploads' sub-folder in the current folder.
        function file_upload_path($original_filename, $upload_subfolder_name = 'images') {
            $current_folder =dirname(__FILE__);
            
            // Build an array of paths segment names to be joins using OS specific slashes.
            $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
            
            // The DIRECTORY_SEPARATOR constant is OS specific.
            return join(DIRECTORY_SEPARATOR, $path_segments);
        }

        // file_is_an_image() - Checks the mime-type & extension of the uploaded file for "image-ness".
        function file_is_an_image($temporary_path, $new_path) {

            $images_mine_types       = ['image/gif', 'image/jpeg', 'image/png'];
            $image_file_extensions   = ['gif', 'jpg', 'jpeg', 'png'];
            
            $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
            
            // minme is from tmp folder, while actual file in the path set in file_upload_path, in this case 'uploads' folder in the current folder.
            $actual_mime_type        = mime_content_type($temporary_path);
            
            $file_extension_is_img = in_array($actual_file_extension, $image_file_extensions);

            $mime_type_is_img      = in_array($actual_mime_type, $images_mine_types);
            
            return $file_extension_is_img && $mime_type_is_img;
        }
        
        $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);
        $upload_error_detected = isset($_FILES['image']) && ($_FILES['image']['error'] > 0);

        if ($image_upload_detected) { 

            $image_filename        = $_FILES['image']['name'];
            $image_filename_lowercase = strtolower($image_filename);        
            $temporary_image_path  = $_FILES['image']['tmp_name'];
            $new_image_path        = file_upload_path($image_filename_lowercase);
            
            // This is only for checking images
            if (file_is_an_image($temporary_image_path, $new_image_path)){

                // has to check allowed file types and image types before move, otherwise the $temporary_image_path will be moved and error.
                move_uploaded_file($temporary_image_path, $new_image_path);

                $new_resized_filename = str_replace(array('.jpg', 'jpeg', '.png', '.gif', '.PNG', '.JPG', '.JPEG', '.GIF'), '', $_FILES['image']['name']);
                $actual_resized_file_extension   = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $lowercase_ext = strtolower($actual_resized_file_extension);

                $image = new ImageResize('images'.DIRECTORY_SEPARATOR.$_FILES['image']['name']);
                $image->resizeToWidth(400);
                $image  ->save( 'images'.DIRECTORY_SEPARATOR.$new_resized_filename."_thumbnail.".$lowercase_ext);
                $image = 'images'.DIRECTORY_SEPARATOR.$new_resized_filename."_thumbnail.".$lowercase_ext;
                
            }  
        }

        $statement->bindValue(":name", $name);
        $statement->bindValue(":content", $content);
        $statement->bindValue(":headline", $headline);
        $statement->bindValue(":userId", $id);
        $statement->bindValue(":image", $image);
        if($statement->execute()){
            $message = "success!";
        }
        else{
            $message = "Sorry, page creation failed. Please contact an admin";
        }
    }
}
?>



<!DOCTYPE html>
<html  lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="Styles/style.css" type="text/css">
</head>
<body>
    <section>


        <article>
      
            <form action="post.php" method="post" enctype='multipart/form-data'>
                <fieldset>
                    <legend>Leave a review!</legend>
                    <p>
                        <label for="headline">Headline</label><br />
                        <input name="headline" id="headline" />
                    </p>
                    <p>
                        <label for="content">Leave a review!</label><br />
                        <textarea name="content" id="content" class="content"></textarea>
                    </p>
                    <p>
                         <input type="file" name="image" id="image"><br>
                        <!-- <input type="submit" value="Upload Image" name="submit"> -->
                        <input type="submit" name="submit" value="Leave Feedback" />
                        <li id = "logout"><a href="view.php">Home</a></li>
                    </p>
                </fieldset>
            </form>
          
        </article>
    </section>
</body>
</html>