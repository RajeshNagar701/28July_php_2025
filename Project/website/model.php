

<?php

class model{
	
	public $conn="";
	function __construct()
	{
		$this->conn=new mysqli('localhost','root','','cake_shop');
	}
	
	function select($tbl){
		echo $sel="select * from $tbl";
	}
	
	function insert(){
		
	}
	
	function update(){
		
	}
	
	function delete(){
		
	}
	function select_where(){
		
	}
	
}
?>