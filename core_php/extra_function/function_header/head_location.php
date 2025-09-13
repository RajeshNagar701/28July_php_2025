
<form>
	<input type="submit" name="submit" value="submit">
</form>

<?php
if(isset($_REQUEST['submit']))
{
	
	header('location:wellcome_location.php'); 
	//you will redirected in wellcome.php page  	
	/*	
	echo "<script>
		window.location='wellcome_location.php';
	</script>";
	*/
}
?>
