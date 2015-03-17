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
		elseif($_POST['mode'] == 'generatePage' && isset($_POST['page'])){
			generatePage($page, $_POST['page']);
			$page->setCreated($_POST['page']);
		}
	}
	
	$view=new View("view/pagesManage.html");
		echo $view->render(array(
			'navigation' => file_get_contents("view/nav.html")
		));
		
	function generatePage($page, $id){
		$generatePage = $page->getPage($id);
		$file = $generatePage['title'].".php";
		
		$content = "test";
		
		file_put_contents($file, $content);
	}
?>