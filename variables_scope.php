<?php
$name="alas mohammad";
$age=20;
$height=5.9;
$isCriminal=true;
$crimes=array("theft","robbery","kidnapping");
echo "Name:$name <br>";
echo "Age:$age <br>";
echo "Height:$height <br>";
echo "Is Criminal:$isCriminal <br>";
print_r($crimes);

function localScopeExample(){
    $casenumber="CR1234";
    echo "Local scope -case number:$casenumber <br>";
}
$station="Nuzvid Central";
function globalScopeExample(){
    global $station;
    echo "Global scope-Police station:$station <br>";
}
function staticScopeExample(){
    static $recordcount=2;
    $recordcount++;
    echo "Static Scope-Record viewed:$recordcount<br>";
}

staticScopeExample();
staticScopeExample();
staticScopeExample();
globalScopeExample();
localScopeExample();


?>