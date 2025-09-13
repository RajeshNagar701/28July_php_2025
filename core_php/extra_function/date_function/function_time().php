<?php
date_default_timezone_set('asia/calcutta');

// time() print unix time-stamp 1, jan 1970
echo time()."<br>";


$hours=time()+(4*60*60);
echo date('h:i:s a',$hours) . "<br>";


$days=time()+(10*24*60*60);
echo date('d/m/y',$days) . "<br>";


?>