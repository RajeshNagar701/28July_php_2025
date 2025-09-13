<?php

$a=array("b"=>"ishita","a"=>"raj","c"=>"nagar"); // key sort accendind order

ksort($a);     // key/index sort accending order a-z
print_r($a);

echo "<br>";
krsort($a);     // key/index sort deccending order z-a
print_r($a);

?>