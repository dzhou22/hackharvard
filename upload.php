<?php
session_start();
require 'includes/dbh.inc.php';
$id = $_SESSION['userId'];

if (isset($_POST['submit-photo'])) {
    $file = $_FILES['file'];

    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png', 'pdf');

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 1000000000) {
                $fileNameNew = "profile".$id.".".$fileActualExt;
                $fileDestination = './uploads/'.$fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                $sql = "UPDATE profileimg SET status=0 WHERE idUsers=?";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ./profile.php?error=sqlerror");
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, 's', $id);
                    mysqli_stmt_execute($stmt);
                    header("Location: ./profile.php?uploadsuccess");
                }
                
            } else {
                echo "Your file is too big!";
            }
        } else {
            echo "There was an error uploading your file.";
        }
    } else {
        echo 'You cannot upload files of this type.';
    }
}