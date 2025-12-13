

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
	
	function insert($tbl,$arr){ //$arr=array("name"=>$name,"email"=>$email,"comment"=>$comment);
		
		$key=array_keys($arr); // $key=array("name","email","comment")
		$col=implode(",",$key); //  "name","email","comment"
		
		$value_arr=array_values($arr); // $value=array($name,$email,$comment)
		$value=implode("','",$value_arr); //  raj,raj@gmail.com,hello
		
		echo $ins="insert into $tbl($col) values('$value')"; //'raj','raj@gmail.com','hello'
		$run=$this->conn->query($ins); // query run
		return $run;
		
	}	
	
	function select_where($tbl,$where){
		
		$sel="select * from $tbl where 1=1"; // query continue
		//$where=array("email"=>$email,"password"=>$password);
		$col_arr=array_keys($where); // array("0"=>"email","1"=>"pasword")
		$value_arr=array_values($where); // array("0"=>"raj@gmail.com","1"=>"sdsd45454")
		$i=0;
		foreach($where as $w)
		{
			$sel.=" and $col_arr[$i]='$value_arr[$i]'";
			$i++;
		}
		
		$run=$this->conn->query($sel);// run query
		return $run;
		
		//$chk=$run->num_rows; // ans true or false;   // login
		
		/*
		while($fetch=$run->fetch_object())           // fetch all data which query generate
		{
			$arr[]=$fetch;
		}
		*/
	}
	
	
	function delete($tbl,$where){
		$del="delete from $tbl where 1=1"; // query continue
		//$where=array("id"=>$id);
		$col_arr=array_keys($where); // array("0"=>"email","1"=>"pasword")
		$value_arr=array_values($where); // array("0"=>"raj@gmail.com","1"=>"sdsd45454")
		$i=0;
		foreach($where as $w)
		{
			$del.=" and $col_arr[$i]='$value_arr[$i]'";
			$i++;
		}
		
		$run=$this->conn->query($del);// run query
		return $run;
	}
	
	
	function update($tbl,$arr,$where){
		
		// update cstomer set col1=value1,col2=value2,col3=value3, where wcol=wvalue
		$upd="update $tbl set "; // query continue
		
		$col=array_keys($arr); // array("0"=>"email","1"=>"pasword")
		$value=array_values($arr); 
		$j=0;
		$count=count($arr); // count total no of arr
		foreach($arr as $d)
		{
			if($count==$j+1)
			{
				$upd.=" $col[$j]='$value[$j]'";
			}
			else
			{
				$upd.=" $col[$j]='$value[$j]',";
				$j++;
			}
		}
		$upd.=" where 1=1";
		//$where=array("id"=>$id);
		$col_arr=array_keys($where); // array("0"=>"email","1"=>"pasword")
		$value_arr=array_values($where); // array("0"=>"raj@gmail.com","1"=>"sdsd45454")
		$i=0;
		foreach($where as $w)
		{
		echo	$upd.=" and $col_arr[$i]='$value_arr[$i]'";
			$i++;
		}
		$run=$this->conn->query($upd);// run query
		return $run;
		
	}

}
?>