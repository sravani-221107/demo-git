<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Php complete File & Folder demo</title>
</head>
<body>
    <h2>PHP File Functions Demonstration</h2>
    <?php
    $name='data.txt';
    $fp=fopen($name,"w");
    fwrite($fp,"Hello, this is a demonstration of PHP file handling functions.\n");
    fwrite($fp,"This file is created using fopen and fwrite functions.\n");
    fclose($fp);
    echo "<b>File created successfully!</b>\n";
    //Append data
    file_put_contents($name,"This line is appended to the file.\n",FILE_APPEND);
    echo "<b>Data appended successfully!</b>\n";
    if(file_exists($name)){
        echo "<h3>Reading File data</h3>";
        $fp=fopen($name,"r");
        echo "<b>Using fread():</b><br>";
        echo nl2br(fread($fp,filesize($name)));
        fclose($fp);
        
        echo "<br><br>";
        echo "<b>Using file()(line by line):</b><br>";
        $arr=file($name);
        foreach($arr as $line){
            echo nl2br($line);
        }
    }
    echo "<h3> File Informmation</h3>";

    echo"File Exists:".(file_exists($name)?"YES":"NO")."<br>";
    echo "File Size:".filesize($name)." bytes<br>";
    echo "File Type:".filetype($name)."<br>";
    echo "Last Accessed:".date("F d Y H:i:s.",fileatime($name))."<br>";
    echo "Last Modified:".date("F d Y H:i:s.",filemtime($name))."<br>";
    echo "Creation time:".date("F d Y H:i:s.",filectime($name))."<br>";
    echo "Permissions:".substr(sprintf('%o',fileperms($name)),-4)."<br>";
    echo "Owner ID:".fileowner($name)."<br>";
    echo "Group ID:".filegroup($name)."<br>";
    echo "Inode Number:".fileinode($name)."<br>";

 //part 2-FILE & FOLDER MANAGEMENT

 echo "<h2>PHP File & Folder Management</h2>";
 $dir="testfolder";
 //CREATING A FOLDER
    if(!is_dir($dir)){
        mkdir($dir);
        echo "Directory '$dir' created successfully.<br>";
    } 
 //SHOW CURRENT DIRECTORY
    echo "Current Directory: ".getcwd()."<br>";
 //CHANGE DIRECTORY
    chdir($dir);
    echo "Directory changed to: ".getcwd()."<br>";

 //Create file with locking
$file="sample.txt";
$f=fopen($file,"w");

flock($f,LOCK_EX);
fwrite($f,"This is a sample file created in '$dir' directory.\n");
fwrite($f,"Learning PHP file handling");
flock($f,LOCK_UN);

fclose($f);

echo "File '$file' created successfully in '$dir' directory.<br>";

//DISPLAY CONTENT

echo "<b>File Content:</b><br>";
echo nl2br(file_get_contents($file));
echo "<br><br>";

//FILE INFO

echo "<b> File Information:</b><br>";

echo "is File:".(is_file($file)?"YES":"NO")."<br>";
echo "is Readable:".(is_readable($file)?"YES":"NO")."<br>";
echo "is Writable:".(is_writable($file)?"YES":"NO")."<br>";
echo "File Size:".filesize($file)." bytes<br>";
echo "File type:".filetype($file)."<br>";
echo "Last Access:".date("F d Y H:i:s.",fileatime($file))."<br>";
echo "Last Modified:".date("F d Y H:i:s.",filemtime($file))."<br>";
echo "Permissions:".substr(sprintf('%o',fileperms($file)),-4)."<br>";

//COPY&RENAME
copy($file,"copy.txt");
echo "File Copied.<br>";

rename("copy.txt","newname.txt");
echo "File renamed><br><br>";

//DIRECTORY LISTING
echo "<b>Files using scandir():</b><br>";
$d=opendir(".");
while(($y=readdir($d))!==false){
    echo $y."<br>";
}

//DELETE RENAMED FILE

unlink("newname.txt");
echo "Renamed file deleted.<br><br>";

//RETURN TO PARENT fOLDER
chdir("..");
echo "Returned to Directory: ".getcwd()."<br>";

//DELETE FOLDER

unlink($dir."/sample.txt");
rmdir($dir);
echo "Directory '$dir' and its contents deleted successfully.<br>";

?>   
<?php

$file = "modes.txt";

fopen($file, "w");  // Write (overwrite)
fopen($file, "a");  // Append
fopen($file, "r");  // Read
fopen($file, "r+"); // Read & Write
fopen($file, "w+"); // Write & Read (erase old)
fopen($file, "a+"); // Append & Read
fopen("newfile.txt", "x"); // Create new
fopen("newfile2.txt", "x+"); // Create new Read+Write

echo "All file modes executed successfully!";

?>
</body>
</html>