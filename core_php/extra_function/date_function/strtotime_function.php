<?php

date_default_timezone_set('asia/calcutta');

echo date("d-m-y",strtotime("+ 5 days"))."<br>";// add week in date by strtotime      
echo date('h:i:s A',strtotime("+ 5 hours"))."<br>";

?>