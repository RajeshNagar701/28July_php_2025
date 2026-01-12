<?php

header("Content-Type: application/json");
header("Acess-Control-Allow-Origin: *");


$data = json_decode(file_get_contents("php://input"), true);

$product_name = $data["product_name"];

require_once "dbconfig.php";

$query = "SELECT * FROM tbl_product WHERE product_name LIKE '".$product_name."%' ";

$result = mysqli_query($conn, $query) or die("Search Query Failed.");

$count = mysqli_num_rows($result);

if($count > 0)
{	
	$output = mysqli_fetch_all($result, MYSQLI_ASSOC);
	echo json_encode($output);
}
else
{	
	
	echo json_encode(array("message" => "No Data Found.", "status" => false));
}

?>