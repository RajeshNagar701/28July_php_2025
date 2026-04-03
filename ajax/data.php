<?php
$con=new mysqli("localhost","root","","sweetmart");
$sql="select * from users";
$res=$con->query($sql);
while($fetch=$res->fetch_object())
{
	$arr[]=$fetch;		
}

foreach($arr as $c)
{
	echo $c->id . "<br>";
	echo $c->name . "<br>";
	echo $c->email . "<br>";
	echo $c->gender . "<br><br><br>";
}


?>
 