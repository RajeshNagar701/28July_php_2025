<html>
<head>
<title>$_get </title>
</head>
<body>

<!--

SQL Injection
SQL injection is a code injection technique that might destroy your database.

SQL injection is one of the most common web hacking techniques.

SQL injection is the placement of malicious code in SQL statements, via web page input.


SQL in Web Pages
SQL injection usually occurs when you ask a user for input, like their username/userid, and 
instead of a name/id, the user gives you an SQL statement that you will unknowingly run on your database.


Many web applications are connected to a database. 
The database holds all the information the web application 
wish to store and use.
SQL Injection is a technique which allows attackers to manipulate the SQL 
("Structured Query Language") 

the developer of the web application is using.
 This typically happens because of lack of data sanitization.
 
SQL is used regularly by developers to access database resources. 

$first_name=real_escape_string($_REQUEST['firstname']);

This both function convert query into string than we avoid sql injection
-->

<form action="" method="post">      <?  // make form with action on $_GET function?>
<p>Name: <input type="text" name="name"/></p>
<p>Age: <input type="text"name="age"/></p>

<p><input type="submit" name="submit" value="Click"/></p>
</form>
<?php

$mysqli = new mysqli('localhost','root','','test');


if(isset($_POST['submit']))
{
	echo $firstname = $mysqli->real_escape_string($_POST['name']);

	// Escape special characters, if any
	echo $age = mysqli_real_escape_string($mysqli, $_POST['age']);
}

?>




</body>
</html>
