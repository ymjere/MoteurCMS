<?php
	session_start();
	
	include('init.php');

	if(isset($_POST['mode'])){
		if($_POST['mode'] == 'edit' && isset($_POST['newPassword']) && isset($_POST['id']) ){
			$user->ModifUser($_POST['id'],$_POST['newPassword']);
		}
		elseif($_POST['mode'] == 'delete' && isset($_POST['id']) ){
			$user->SupprUser($_POST['id']);
		}		
	}
	
	
	if(isset($_POST['login']) && isset($_POST['password'])){
		$user->CreatUser($_POST['login'],$_POST['password']);
		
		$view=new View("view/usersManage.html");
					$detailView=new View("view/userRow.html");
					echo $view->render(array(
						'navigation' => file_get_contents("view/nav.html"),
						'users'=> $detailView->renderList($user->getUsersList($_SESSION['user']['login']))
					));
	}
	else{
		$view=new View("view/usersManage.html");
					$detailView=new View("view/userRow.html");
					echo $view->render(array(
						'navigation' => file_get_contents("view/nav.html"),
						'users'=> $detailView->renderList($user->getUsersList($_SESSION['user']['login']))
					));
	}
?>