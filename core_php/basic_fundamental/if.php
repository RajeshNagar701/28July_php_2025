<html>
<head>
</head>
<body>
<?php
/*
condi statement 5 types 

if(cond)
{
	echo "cond is true"
}	

if()
{
	
}else
{
	
}

if elseif else
nested if
switch	

*/


/*
$a=50;
$b=50;
if($a>=$b)
{
	echo "a is equal  to b";
}
*/


/*
$a=50;
$b=40;
if($a>$b)
{
	echo "a is greater than b";
}
else
{
	echo "a is less than b";
}
*/

/*

$a=20;
$b=30;
$c=40;
if($a>$b)
{
	echo "a is greater than b";
}
elseif($a>$c)
{
	echo "a is greater than c";
}
elseif($b>$c)
{
	echo "b is greater than c";
}
else
{
	echo "a is less than b & c";
}

*/
/*
$a=60;

switch($a)
{
	case '10':
	echo "Ans is 10";
	break;
	
	case '30':
	echo "Ans is 30";
	break;
	
	case '50':
	echo "Ans is 50";
	break;
	
	case '60':
	echo "Ans is 60";
	break;
	
	default:
	echo "all cond false";
	break;
}
*/




$a=20;
$b=20;

if($a<$b)
{
	if($a==$b)
	{
		echo "a equal to b";
	}
	else
	{
		echo "a not equal to b";
	}
}
else
{
	echo "all cond false";
}



$a=40;
$b=20;
$sum=$a+$b;

echo $sum;

if($sum>40)
{
	echo "You are pass";
}
else
{
	echo "You are fail";
}




?>


</body>
</html>