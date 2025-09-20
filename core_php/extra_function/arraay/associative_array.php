<?php
$associate=array("id"=>"1","name"=>"rajesh","email"=>"raj@gmail.com");  // associate
print_r($associate);
echo "<br>";


echo $associate['email']. "<br>";


foreach($associate as $string)
{
	echo "<h1>" .$string ."<h1>";
}
?>