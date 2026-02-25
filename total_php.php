<?php 
setcookie("fav_food","pizza",time()-0,"/");
setcookie("fav_drink","coffee",time()+(86400*3),"/");
setcookie("fav_desert","ice cream",time()+(86400*4),"/");





?>















<?PHP

//DAY1
//arithmetic operators
//* + - / % **

$x=10;
$y=5;
$z=null;
$z=$x+$y;
echo "The sum of x and y is:  {$z}<br>";
$z=$x-$y;
echo "The difference of x and y is:{$z} <br>";
$z=$x*$y;
echo "The product of x and y is: {$z} <br>";
$z=$x/$y;
echo "The quotient of x and y is: {$z} <br>";
$z=$x%$y;
echo "The modulus of x and y is: {$z} <br>";
$z=$x**$y;
echo "The exponent of x and y is: {$z} <br>";

//increment and decrement operators
$count=10;
$hii=8;
$count++;
echo "{$count}<br>";
$hii--;
echo $hii;


//oprator precedence
//() ** * (/) +-

$total= 1 + 2 - 3 * 4 / 5 ** 6;
echo "<br> {$total}";



?>

<?php

//DAY2
echo"<br>";
$age=21;
 if($age>=18){
    echo"you are major";
 }
 elseif($age<=0){
    echo"not valid age";
 }
 else{
    echo"you are minor";
 }
echo"<br>";
$adult=true;
if($adult==true){
    echo"you may enter";
}
else{
    echo"can't enter";
}
echo"<br>";
$hours=50;
$rate=15;
$weekly_pay=null;
if($hours<=0){
    $weekly_hours=0;
}
if($hours<=40){
    $weekly_pay=$hours*$rate;
}
else{
    $weekly_pay=($rate*40)+($hours-40)*$rate;
}
echo "you have earned\${$weekly_pay}";
?>

<?php
//DAY2 CONTINUTION
//MATH_FUNCTIONS
if(isset($_POST['username']) && isset($_POST['password'])){
    echo $_POST['username']."<br>";
    echo $_POST['password']."<br>";
}
    

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
        <label>radius:</label><br>
        <input type="number" name="radius" placeholder="Enter radius"><br><br>
        <input type="submit" value="calculate">
    </form>
</body>
</html>



<?php
$grade="A";
switch($grade){
    case"A":
        echo"you did great";
        break;
    case"B":
        echo"you did good";
        break;
    case"C":
        echo"you did well";
        break;
    case"D":
        echo"you did nice";
        break;
    case"E":
        echo"you are poor";
        break;
    case"F":
        echo"you failed";
        break;
    default:
        echo"not valid grade";
}

?>
<?php
$date= date("1");

switch($date){
    case "Monday":
        echo"i hate mondays";
        break;
}
?>