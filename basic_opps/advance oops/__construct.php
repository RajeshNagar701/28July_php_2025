<?php

/*

 Advance Function 
 
	Magic Methods / Build in Function/predefined 

Magic methods are special methods which override PHP's default's 
action when certain actions are performed on an object.

__construct(),  // when obj created then automatically call
__destruct(),   // obj destroy call
__call(), 
__callStatic(), 
__get(), 
__set(), 
__isset(), 
__unset(), 
__sleep(), 
__wakeup(), 
__serialize(), 
__unserialize(), 
__toString(), 
__invoke(), 
__set_state(), 
__clone(), and __debugInfo().


=================================================================
__construct(),   call auto & first call

A constructor allows you to initialize an object's properties 
upon creation of the object. Also called magic function 

If you create a __construct() function, PHP will automatically call 
this function when you create an object from a class.

Notice that the construct function starts with two underscores (__)!

We see in the example below, that using a constructor saves us from 
calling the set_name() method which reduces the amount of code:


__destruct()    call auto & last call

destroy object of class
call in last 

*/
class abc
{
	function simple()
	{
		echo "Simple Function <br>";
	}
	function __construct()
	{
		echo "Magic function run auto matecaly<br>";
	}
	function demo()
	{
		$this->simple(); // normal function call by $this->
		abc::__construct(); // __construct function call by ::(scopeResolution)
	}
}
$obj= new abc;
$obj->demo();
?>