<?php

// useful in reduce reusable code and remove inheritance multiple


trait abc
{
	public function test()
		{
		echo "This is test method <br>";
		}
}
trait xyz
{
	public function sample()
	{
		echo "this is sample method <br>";
	}
}
class pqr  
{
	use abc,xyz;  // multiple inherit 
}

$obj=new pqr();
$obj->test();
$obj->sample();

?>