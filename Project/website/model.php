

<?php

class model{
	
	public $conn="";
	function __construct()
	{
		$this->conn=new mysqli('localhost','root','','cake_shop');
	}
	
	function select($tbl){
		
		$sel="select * from $tbl";  // query generate
		$run=$this->conn->query($sel);    // query run of db
		while($fetch=$run->fetch_object())           // fetch all data which query generate
		{
			$arr[]=$fetch;
		}
		return $arr;
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