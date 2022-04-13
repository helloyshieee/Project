<?php
session_start();
require("../connect.php");
require 'php-image-resize-master/lib/ImageResize.php';
require 'php-image-resize-master/lib/ImageResizeException.php';

use \Gumlet\ImageResize;
use \Gumlet\ImageResizeException;

$id="";
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

	$message = "";
	if(isset($_GET['error'])){
		$message = $_GET['error'];
	}

    if ($_POST){
if ($_POST && !empty($_POST['productname']) && !empty($_POST['description']))
{
    $products = filter_input(INPUT_POST, 'productname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description= filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $cost = filter_input(INPUT_POST, 'cost', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
 

    $query = "INSERT INTO products (productname, description, cost, categoryname, userId, image ) 
        VALUES (:productname, :description, :cost, :categoryname, :userId, :image) ";
    $statement = $db->prepare($query);
    $image ="";
   
    // Default upload path is an 'uploads' sub-folder in the current folder.
    function file_upload_path($original_filename, $upload_subfolder_name = 'products') {
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

$image_upload_detected = isset($_FILES['fileimage']) && ($_FILES['fileimage']['error'] === 0);
$upload_error_detected = isset($_FILES['fileimage']) && ($_FILES['fileimage']['error'] > 0);

if ($image_upload_detected) { 

    $image_filename        = $_FILES['fileimage']['name'];
    $image_filename_lowercase = strtolower($image_filename);        
    $temporary_image_path  = $_FILES['fileimage']['tmp_name'];
    $new_image_path        = file_upload_path($image_filename_lowercase);
    
    // This is only for checking images
    if (file_is_an_image($temporary_image_path, $new_image_path)){

        // has to check allowed file types and image types before move, otherwise the $temporary_image_path will be moved and error.
        move_uploaded_file($temporary_image_path, $new_image_path);

        $new_resized_filename = str_replace(array('.jpg', 'jpeg', '.png', '.gif', '.PNG', '.JPG', '.JPEG', '.GIF'), '', $_FILES['fileimage']['name']);
        $actual_resized_file_extension   = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $lowercase_ext = strtolower($actual_resized_file_extension);

        $image = new ImageResize('products'.DIRECTORY_SEPARATOR.$_FILES['fileimage']['name']);
        $image->resizeToWidth(400);
        $image  ->save( 'products'.DIRECTORY_SEPARATOR.$new_resized_filename."_thumbnail.".$lowercase_ext);
        $image = 'products'.DIRECTORY_SEPARATOR.$new_resized_filename."_thumbnail.".$lowercase_ext;
        
    }  
}

    $statement->bindValue(":productname", $products);
    $statement->bindValue(":categoryname", $category);
    $statement->bindValue(":description", $description);
    $statement->bindValue(":cost", $cost);
    $statement->bindValue(":userId", $id);
    $statement->bindValue(":image", $images);
   
    if($statement->execute()){
        header('Location: products.php');
        exit;
    }
}
else{
    echo 'error';
}

}
?>

