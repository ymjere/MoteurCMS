<?php
	session_start();
	
	include('View.php');	

	if($_POST){
		if(isset($_POST['header'])){
			file_put_contents("includes/header.html",$_POST['header']);
		}
		if(isset($_POST['footer'])){
			file_put_contents("includes/footer.html",$_POST['footer']);
		}		
		$view=new View("view/hfManage.html");
					echo $view->render(array(
						'session' => $_SESSION,
						'navigation' => file_get_contents("view/nav.html"),
						'header' => file_get_contents("includes/header.html"),
						'footer' => file_get_contents("includes/footer.html"),
					));
	}
	else{
		$view=new View("view/hfManage.html");
					echo $view->render(array(
						'session' => $_SESSION,
						'navigation' => file_get_contents("view/nav.html"),
						'header' => file_get_contents("includes/header.html"),
						'footer' => file_get_contents("includes/footer.html"),
					));
	}
?>