<?php
/*

public a    in class & out of class
private a   only in class
protected a  only in class & inheritance class

$this->a  we can access all variables in class
$obj->a public variable access out class by object

========================= >  Advance Vaibale 

declared by static keyword 
value changeble
public visiblity
call by :: 
call withaout object by (::) scope Resolution

Static properties can be called directly - 
without creating an instance(object) of a class.
Static properties are declared with the static keyword:
To access a static property use the class name, 
double colon (::), and the property name:
visiblity all time public must

*/
class abc
{	
	public static $my_static="i m static"; 
	public $simple_var="hello";
	
	public function static_foo()
	{
		echo $this->simple_var; // normal var call by $this
		echo abc::$my_static;
		
		//echo self::$my_static;  // foo::$my_static;
	}
}
class xyz extends abc
{
	public function static_bar()
	{
		echo $this->$simple_var;
		echo abc::$my_static;
		//echo parent::$my_static;
	}
}
echo abc::$my_static;  
 
 
?>