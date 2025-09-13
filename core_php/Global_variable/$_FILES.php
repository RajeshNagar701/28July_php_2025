<html>
<head>
<title></title>
</head>
<body>

<!-- img upload / resume upload / file upload-->
<!-- 

Normal input =  $_GET[]/$_POST[]/$_REQUEST[]

FILE input : $_FILES['file1']['name'];


first add ti form tag enctype="multipart/form-data"


 -->

<form action="" method="post" enctype="multipart/form-data">      <?  // make form with action on $_GET function?>
	<p>Name: <input type="text" name="username"/></p>
	<p>File: <input type="file" name="file1"/></p>

	<p><input type="submit" name="submit" value="Click"/></p>
</form>
<?php
if(isset($_POST['submit']))
{
	echo $username=$_POST['username']."<br>";
	
	echo $file1=$_FILES['file1']['name'];
	
	if($_FILES['file1']['size']>0)
	{
		$path="img/upload/".$file1;  // path where we upload img
		$dup_file1=$_FILES['file1']['tmp_name']; // get duplicate file
		move_uploaded_file($dup_file1,$path); // move dupl image in path
	}
	
}



session_start();
echo $_SESSION['user'];

echo $_COOKIE['user'];

?>






</body>
</html>
