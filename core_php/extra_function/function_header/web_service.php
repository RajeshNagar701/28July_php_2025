
<?php
/*
What are web services ?
A Web Service is can be defined by following ways:
● It is a client-server application or application component for communication.
● The method of communication between two devices over the network.
● It is a software system for the interoperable machine to machine communication.
● It is a collection of standards or protocols for exchanging information between
two devices or application.

Types of Web Services
There are mainly two types of web services.

web-based/website application using the REST, SOAP, WSDL, and UDDI over the

network. For example, Java web service can communicate with .Net application




1) SOAP Web Services
data transfer in xml files
SOAP stands for Simple Object Access Protocol. It is a XML-based protocol for accessing web
services.
SOAP is a W3C recommendation for communication between two applications.
SOAP is XML based protocol. It is platform independent and language independent. By using SOAP,
you will be able to interact with other programming language application

2)Restfull Web Services API Application Programming Interface
(API)

RESTful Web Services are basically REST Architecture based Web Services. In REST Architecture
everything is a resource.
RESTful web services are lightweight, highly scalable and maintainable and are very commonly
used to create APIs for web-based applications.

Json_encode & jason_decode func with example ?


$arr=array(“name”=>”Rajesh”, ”age”=>31); arr to json
json={ “name”: “Rajesh” , ”age”:”31”}

*/

/*
$users=array("name"=>"KEYUR","email"=>"raj@gmail.com","mobile"=>"124567891");

print_r($users);

echo "<br><br><br>";

echo $json=json_encode($users);

echo "<br><br><br>";

print_r(json_decode($json));

*/


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");



$json=file_get_contents('https://jsonplaceholder.typicode.com/posts');

$phparr=json_decode($json); // json econvert to arr

//print_r($phparr);
/*
foreach($phparr as $data)
{
	echo "<p>".$data->title."</p>";
}
*/

?>

<table border="1">
	<tr>
		<th>Id</th>
		<th>Title</th>
		<th>Body</th>
	</tr>
	<?php
	foreach($phparr as $data)
	{
	?>
		<tr>
			<td><?php echo $data->id?></td>
			<td><?php echo $data->title?></td>
			<td><?php echo $data->body?></td>
		</tr>
	<?php
	}
	?>
</table>