<?php

/*
// array is collection values


$a="raj";
$b="akash";
$c="mahesh";

$names=array("Raj","akash","mahesh");   // array("0"=>"Raj","1"=>"akash","2"=>"Mahesh");

There are 3 types of arr 

$nemeric=array("a","b","c");  index auto generate  0

$associatearray("raj"=>"a","2"=>"b","10"=>"c");  // associate

$multidemetional=array("a","b"=>array("p","q"),"c");  // multidemetional

*/
$name="a";
$name1="b";
$name2="c";

$arr=array("a","b","c","d","e","f","g");//( [0] => a [1] => b [2] => c [3] => d [4] => e [5] => f [6] => g )
print_r($arr);

echo $arr[3];

foreach($arr as $string)
{
	echo $string . "<br>";
}

// print by
for($i=0;$i<count($arr);$i++)
{
	echo $arr[$i];
}

?>