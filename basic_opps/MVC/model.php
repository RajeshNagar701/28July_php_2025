<?php
/*

What is MVC

MVC is abbreviated as Model View Controller is a design pattern 
created for developing applications specifically web applications. 

As the name suggests, it has three major parts. The traditional software 
design pattern works in an "Input - Process - Output" pattern whereas 
MVC works as "Controller -Model - View" approach. With the emergence 
of the MVC model, creation of application takes different aspects 
individually into consideration. These aspects of the application are:


Let us discuss the three components of MVC in brief:

Model: The Model encloses the clean application related data. 
		But the model does not deal with any logic about how to present the data.
		
		MODEL CONNECTED WITH Database + Logic (crud ins/ipd/del/sel)
	

Controller: The Controller is in between the model and the view element. 
			It listens to all the incident and actions triggered in the view 
			and performs an appropriate response back to the events.

	
		
View: The View element is used for presenting the data of the model to the user. 
		This element deals with how to link up with the model's data but 
		doesn't provide any logic regarding what this data all about or how users can use these data.
*/



class model{
	
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

$obj=new model;

?>