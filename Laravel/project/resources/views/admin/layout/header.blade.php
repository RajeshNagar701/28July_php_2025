
<?php
	function active($currect_page){
	  $url_array =  explode('/', $_SERVER['REQUEST_URI']) ; // current page url
	  $url = end($url_array);  // tours 
	  if($currect_page == $url){
		  echo 'active'; //class name in css 
	  } 
	}
	?>
