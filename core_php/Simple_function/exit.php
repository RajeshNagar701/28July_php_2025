
<form>
	<input type="submit" name="submit" value="submit">
</form>

<?php
if(isset($_REQUEST['submit']))
{
	echo "hello";
	exit(); // stop code after exit()
	
	header('location:function.php'); //you will redirected in wellcome.php page  	
	
}
else
{
	echo "Wrong condition";	
}
?>