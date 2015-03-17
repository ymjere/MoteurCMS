<?php
	session_start();
	
	include('init.php');

	if(isset($_POST['mode'])){
		if($_POST['mode'] == 'createPage' && isset($_POST['title']) && isset($_POST['imgLink']) && isset($_POST['content']) ){
			$page->CreatePage($_POST['title'],"",$_POST['content']);
		}
		elseif($_POST['mode'] == 'edit' && isset($_POST['newPassword']) && isset($_POST['id']) ){
			$user->ModifUser($_POST['id'],$_POST['newPassword']);
		}
		elseif($_POST['mode'] == 'delete' && isset($_POST['id']) ){
			$user->SupprUser($_POST['id']);
		}		
	}
	
	$view=new View("view/pagesManage.html");
		echo $view->render(array(
			'navigation' => file_get_contents("view/nav.html")
		));
?>