<?php

$n=$_POST["n"];

for($i=0;$i<=$n;$i++){
    echo $i."<br>";
}

$i=0;
while($i<$n){
    echo $i."<br>";
    $i++;

}


//array="variable" which can hold more than one value

$foods=array("apple","banana","orange","coconut");
$foods[0]="pineapple";
array_push($foods,"apple");
array_pop($foods);//for this last one will pop
array_shift($foods);//for this first one will disappear
//array_reverse($foods);//not works

$reversed_foods=array_reverse($foods);
foreach($reversed_foods as $food){
    echo $food."<br>";
}

foreach($foods as $food){
    echo $food."<br>";
}
echo count($foods);
echo"<br>";
//assosiative array=an array made of key=>value pairs

$capitals=array("USSR"=>"moscow",
                "japan"=>"kyoto",
                "south korea"=>"seoul",
                "india"=>"new delhi");

$capitals["india"]="hello";
array_pop($capitals);

$keys=array_keys($capitals);
foreach($keys as $key){
    echo "{$key}<br>";
}
$values=array_values($capitals);
foreach($values as $value){
    echo "{$value}<br>";
}
foreach($capitals as $key=>$value){
    echo "{$key}=>{$value}<br>";
}

//$capitals=array_flip($capitals);
$capitals=array_reverse($capitals);
foreach($capitals as $keys=>$values){
    echo "{$keys}=>{$values}<br>";
}
echo count($capitals);
echo "<br>";
$capital=$capitals[$_POST["country"]];
echo "$capital";


if(isset($_POST['login'])){
    $username=$_POST['username'];
    $password=$_POST['password'];

    echo $username."<br>";
    echo $password."<br>";
    if(empty($username) || empty($password)){
        die("Username and password cannot be empty");
    }

}
    


foreach($_POST as $key=>$value){
    echo "{$key}=>{$value}<br>";
}


$branch=null;
if(isset($_POST['submit'])){
    $branch=$_POST['branch'];
    echo "you have selected {$branch}";
}
else{
    echo "please select a branch";
}
?>

<!DOCTYPE html>
<html lang="en">
<body>
    
    <form action="loops.php" method="post" autocomplete="off">
        
        <label>n:</label>
        <input type="number" name="n">

    <label>country</label><br>
    <input type="text" name="country">
    </form>
    
    <label>username:</label>
    <input type="text" name="username"><br>
    <label>password:</label>
    <input type="password" name="password"><br>
    <input type="submit" name="login">

    <input type="radio" name="branch" value="CSE"> CSE<br>
    <input type="radio" name="branch" value="ECE">ECE<br>
    <input type="radio" name="branch" value="MECH">MECH<br>
    <input type="radio" name="branch" value="CIVIL">CIVIL<br>
    <input type="submit" name="submit">

</body>
</html>