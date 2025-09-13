<?php
date_default_timezone_set('asia/calcutta');


echo $d=date("d/m/y")."<br/>";

$future_date=mktime(0,0,0,date('m')+2,date('d')+15,date('y')+2);
echo date("d/m/y",$future_date)."<br/>";


$future_time=mktime(date('h')+2,date('i')+15,date('s')+2);
echo date('h:i:s a',$future_time) . "<br>";


?>