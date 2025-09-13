<?php

// encription & decription function


$text="nagar701@";
echo $encpass=base64_encode($text);
echo "<br>";
echo $decpass=base64_decode($encpass);
echo "<br>";


echo $decmd5=md5($text);   // md5 no dec
echo "<br>";

echo $decsha1=sha1($text);   // sha1 no dec
echo "<br>";
?>  