<!DOCTYPE html>
<html lang="en">
<head>
    <title>File Upload & download</title>
</head>
<body>
 <h2>File Upload & download System</h2>
<?php 
$folder="uploads/";
if(!is_dir($folder)){
    mkdir($folder);
}

if(isset($_GET['download'])){
    $file=$folder.basename($_GET['download']);
    if(file_exists($file)){
        header("Content-Description: File Transfer");
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=".basename($file));
        header("Content-Length: " . filesize($file));
        readfile($file);
        exit;
    }
}

if(isset($_POST['upload'])){
    $name=$_FILES['file']['name'];
    $temp=$_FILES['file']['tmp_name'];
    $path=$folder.$name;

    if(move_uploaded_file($temp,$path)){
         echo "<p style='color:green;'>File uploaded successfully</p>";
         echo "<a href='?download=$name'>
         <button>Download File</button></a>";
    }
    else{
        echo "<p style='color:red;'>File upload failed</p>";
    }
    if(isset($_GET['delete'])){
        $filetoDelete=$folder.$_GET['delete'];


        if(file_exists($filetoDelete)){
            unlink($filetoDelete);
            echo "File deleted successfully";   
        }
    }
}
?>

<form method="post" enctype="multipart/form-data">
    Select File:
    <input type="file" name="file" required><br><br>
    <button type="submit" name="upload" value="upload file">Upload</button>

</form>
</body>
</html>

