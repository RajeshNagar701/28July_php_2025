<?php

/*

PHP Check End-Of-File - feof()

$myfile = fopen("webdictionary.txt", "r")
while(!feof($myfile)) {
  echo fgets($myfile) . "<br>";
}
fclose($myfile);

*/

// Output one line until end-of-file
$myfile = fopen("users.txt", "r");
while(!feof($myfile)) {
 echo fgetc($myfile) . "<br>"; //echo fgets($myfile) . "<br>";
}
fclose($myfile);
?>