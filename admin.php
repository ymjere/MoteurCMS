<?php
	session_start();
	
	include('init.php');

	if(isset($_SESSION['user'])){
		if($_GET){
			switch ($_GET['page']) {
				case 'hfManage':
					$view=new View("view/hfManage.html");
					echo $view->render(array(
						'session' => $_SESSION,
						'navigation' => file_get_contents("view/nav.html"),
						'header' => file_get_contents("includes/header.html"),
						'footer' => file_get_contents("includes/footer.html"),
					));
					break;
				case 'usersManage':
					$view=new View("view/usersManage.html");
					$detailView=new View("view/userRow.html");
					echo $view->render(array(
						'navigation' => file_get_contents("view/nav.html"),
						'users'=> $detailView->renderList($user->getUsersList($_SESSION['user']['login']))
					));
					break;
				case 'pagesManage':
					$view=new View("view/pagesManage.html");
					$detailView=new View("view/pageRow.html");
					$pages = $detailView->renderList($page->getPagesList());
					$detailView=new View("view/pageSelect.html");
					$selectPages = $detailView->renderList($page->getPagesList());
					echo $view->render(array(
						'navigation' => file_get_contents("view/nav.html"),
						'pages'=> $pages,
						'selectPages'=> $selectPages
					));
					break;
				default :
					$view=new View("view/login.html");
					echo $view->render($_POST);
			}
		}
		else{
			$view=new View("view/home.html");
			echo $view->render(array(
				'session' => $_SESSION,
				'navigation' => file_get_contents("view/nav.html")
			));
		}
	}
	else{
		$page = $page->getDefaultPage();
		$view=new View("website/".$page['title'].".html");
		echo $view->render("");
	}
?>