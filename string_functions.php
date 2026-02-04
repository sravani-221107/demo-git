<?php
echo "<h2>Criminal Records Management - String Functions</h2>";
$criminal="jhon doe";
$crime="robbery";
echo "Criminal Name: $criminal <br>";
echo "Crime Committed: $crime <br>";
echo "length: ".strlen($criminal)."<br>";
echo "word count: ".str_word_count($crime)."<br>";
echo "reverse crime: ".strrev($crime)."<br>";
echo "position of 'doe' in criminal name: ".strpos($criminal,"doe")."<br>";
echo "replace 'jhon' with 'john': ".str_replace("jhon","john",$criminal)."<br>";
echo strtoupper($criminal)."<br>";
echo strtolower($criminal)."<br>";
echo ucfirst($criminal)."<br>";
echo ucwords($criminal)."<br>";
echo trim("  $criminal  ")."<br>";
echo "Substring of criminal name: ".substr($criminal,0,4)."<br>";   
echo ltrim($criminal)."<br>";
echo rtrim($criminal)."<br>";

echo strcmp("jhon","john")."<br>";
echo htmlspecialchars("<script>alert('Hacked')</script>")."<br>";
echo addslashes("Criminal's weapon")."<br>";
?>