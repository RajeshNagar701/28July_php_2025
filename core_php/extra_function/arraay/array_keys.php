<?php
$a=array("name"=>"KEYUR","email"=>"raj@gmail.com","mobile"=>"124567891"); // saprate key and value 1 to make it 2 array
print_r($a);
echo "<br>";

$key=array_keys($a);
foreach($key as $k)
{
	echo $k."<br>";
} 

$values=array_values($a);
foreach($values as $v)
{
	echo $v."<br>";
}




?>