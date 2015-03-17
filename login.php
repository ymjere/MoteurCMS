<?php  
	session_start();
	
	include('init.php');
	
	if($_POST){
		$_SESSION['user']=$user->login($_POST['login'], $_POST['password']);
		if($_SESSION['user']){
			$view=new View("view/home.html");
			echo $view->render(array(
				'session' => $_SESSION,
				'navigation' => file_get_contents("view/nav.html")
			));
		}
		else{
			$view=new View("view/login.html");
			echo $view->render($_POST);
		}
	}
	else{
		$view=new View("view/login.html");
		echo $view->render("");
	}
?>