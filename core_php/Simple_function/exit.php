
<form>
	<input type="submit" name="submit" value="submit">
</form>

<?php
if(isset($_REQUEST['submit']))
{
	
	echo "hello";
	exit();
	include('var_dump.php');
	
}
else
{
	echo "Wrong condition";	
}
?>