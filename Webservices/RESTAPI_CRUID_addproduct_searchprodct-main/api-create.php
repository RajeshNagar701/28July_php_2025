<?php

//http://localhost/students/28Dec_PHP_2023/Webservices/RESTAPI_CRUID_addproduct_searchprodct-main/api-create.php   method post

// insert api
header("Content-Type: application/json");
header("Acess-Control-Allow-Origin: *");
header("Acess-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$data_arr = json_decode(file_get_contents("php://input"), true);

$product_name =$data_arr["product_name"]; // value of price
$product_price =$data_arr["product_price"]; // value of price

require_once "dbconfig.php";

$query = "INSERT INTO tbl_product(product_name, product_price) 
                       VALUES ('".$product_name."', '".$product_price."')";

if(mysqli_query($conn, $query) or die("Insert Query Failed"))
{
	echo json_encode(array("message" => "Product Inserted Successfully", "status" => true));	
}
else
{
	echo json_encode(array("message" => "Failed Data Not Inserted ", "status" => false));	
}

?>