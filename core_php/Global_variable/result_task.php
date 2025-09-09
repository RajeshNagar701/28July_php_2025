<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container mt-3">
  <h2>Enter your Marks & Get Your Result</h2>
	<form action="" method="post">
		<p>Hindi: <input type="number" name="hindi" required min="0" max="100" /></p>
		<p>English: <input type="number"name="english" required min="0" max="100" /></p>
		<p>Gujarati: <input type="number"name="gujarati" required min="0" max="100" /></p>
		<p><input type="submit" name="submit"value="Submit"/></p>
	</form>
</div>


</body>
</html>
<?php
if(isset($_REQUEST['submit']))
{
	$hindi=$_REQUEST['hindi'];
	$english=$_REQUEST['english'];
	$gujarati=$_REQUEST['gujarati'];
	
	$total=$hindi+$english+$gujarati;
	
	echo "<h1>You total marks is : ". $total. "</h1>";
	
	
	$per=($total*100)/300;
	echo "<h1>You perce is : ". $per. "%</h1>";
	
	if($per>90)
	{
		echo $grade="<h1>A+ Garde</h1>";
	}
	elseif($per>80)
	{
		echo $grade="<h1>A Garde</h1>";
	}
	elseif($per>70)
	{
		echo $grade="<h1>B+ Garde</h1>";
	}
	elseif($per>60)
	{
		echo $grade="<h1>B Garde</h1>";
	}
	elseif($per>50)
	{
		echo $grade="<h1>C+ Garde</h1>";
	}
	elseif($per>40)
	{
		echo $grade="<h1>C Garde</h1>";
	}
	else
	{
		echo $grade="Fail";
	}	
}




?>
</div>