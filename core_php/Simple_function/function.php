<?php

/*
 

	$a=20;
	$b=10;
	echo $sum=$a+$b;

	What is function ?
	
	function is block of code 

	function sum(){
		$a=20;
		$b=10;
		echo $sum=$a+$b;
	}
	sum();
	sum();
	sum();

 2 Type of function_exists
 
 1) BUILD IN function  predifined count()
 2) USER defined  function sum()
 
*/




// user defined function

/*
function sum()
{
	$a=10;
	$b=20;
	echo $sum=$a+$b."<br>";
}
sum();
sum();
sum();
*/



// function with parameter / argument

/*
function sum($a,$b)
{
	echo $sum=$a+$b."<br>";
}
sum(5,10);
sum(30,20);
sum(25,20)
*/

// function with parameter with default value
/*
function sum($a=0,$b=0)
{
	echo $sum=$a+$b."<br>";
}
sum(50,10);
sum(30);
sum();
*/



// return
/*
function sum()
{
	return 5+7;
}
echo sum();
//$ans=sum();
*/

//=================== Buildin function


$a=25;
$name="Raj nagar";

echo var_dump($a)."</br>";  // find data type
echo var_dump($name)."</br>";

echo "name length is : ". strlen($name); // find length of variable

?>