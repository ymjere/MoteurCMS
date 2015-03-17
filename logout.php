<?php
	session_start();
	session_destroy();
	
	include('View.php');
	
	$view=new View("view/login.html");
	echo $view->render("");
?>