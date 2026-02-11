<?php
/*
if(isset($_POST['username']) && isset($_POST['password'])){
    echo $_POST['username']."<br>";
    echo $_POST['password']."<br>";
}
    */

$x=$_POST["x"];
$y=$_POST["y"];
$total=null;
//$total=abs($x);
//$total=round($x);
//$total=ceil($x);
//$total=floor($x);
//$total=pow($x,$y);
//$total=sqrt($x);
//$total=max($x,$y,$z);
//$total=min($x,$y,$z);
//total=pi();
//total=rand(1,100);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              
//echo "the power of x and y is: {$total}";
//echo "the square root of x is: {$total}";
//echo "The maximum value is: {$total}";

$radius=$_POST["radius"];
$circumferance=null;
$volume=null;
$area=pi()*pow($radius,2);
$area=round($area,2);
echo "The area of the circle is: {$area}cm^2";
$circumferance=2*pi()*$radius;
$circumferance=round($circumferance,2);
echo "<br>The circumference of the circle is: {$circumferance}cm";
$volume=(4/3)*pi()*pow($radius,3);
$volume=round($volume);
echo "<br>the volume of a circle is{$volume}cm^3";

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="hel.php" method="post" autocomplete="off">
        <!--
        <label>username:</label><br>
        <input type="text" name="username" placeholder="Enter username"><br>
        <label>password:</label><br>
        <input type="password" name="password" placeholder="Enter password"><br><br>
        <input type="submit" value="submit">

        <label>x:</label><br>
        <input type="number" name="x" placeholder="Enter x"><br>
        <label>y:</label><br>
        <input type="number" name="y" placeholder="enter y:">
        <label>z:</label><br>
        <input type="number" name="z" placeholder="enter z:"><br>
        <input type="submit" value="total">
-->
        <label>radius:</label><br>
        <input type="number" name="radius" placeholder="Enter radius"><br><br>
        <input type="submit" value="calculate">
    </form>
</body>
</html>

