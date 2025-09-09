<?php


// check value of variable is set or not
/*
$p;  
if(isset($p))
{
	echo "Var is set";
}	
else
{
	echo "Var is not set";
}
*/	
?>


<form>
	<input type="submit" name="submit" value="resgister">
</form>
<?php
if(isset($_REQUEST['submit']))
{
	echo "SUBMIT SUCCESS";
}	
?>
