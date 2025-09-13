<html>
<head>
<title>$_get </title>
</head>
<body>
<!--
method='get'    $_GET /$_REQUEST (DEFAULT)
method='post'    $_POST/$_REQUEST    
use only post method // $_REQUEST

why get not ? Method get not use
1) Not secure because data display in url
2) 100 char size limit
-->
<form action="" method="post">      <?  // make form with action on $_GET function?>
	<p>Name: <input type="text" name="name" /></p>
	<p>Age: <input type="text"name="age"/></p>
	<p><input type="submit" name="submit" value="Click"/></p>
</form>

<?php
if(isset($_POST['submit']))
{
	echo $name=$_POST['name'];
	echo $age=$_POST['age'];
}


session_start();
echo $_SESSION['user'];

?>




</body>
</html>
