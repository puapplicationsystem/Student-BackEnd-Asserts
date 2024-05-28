<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $targetDirectory = "uploads/";
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($_FILES["file"]["name"],PATHINFO_EXTENSION));
    
    $newFileName = uniqid().'.'.$fileType;
    $targetFilePath = $targetDirectory . $newFileName;

    if (file_exists($targetFilePath)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    if ($_FILES["file"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    $allowedTypes = array('jpg', 'jpeg', 'png', 'gif', 'pdf');
    if (!in_array($fileType, $allowedTypes)) {
        echo "Sorry, only JPG, JPEG, PNG, GIF, and PDF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["file"]["name"])). " has been uploaded as $newFileName.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
