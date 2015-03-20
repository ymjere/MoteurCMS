<?php

	include('init.php');

	$posSlah = strripos ($_SERVER['REQUEST_URI'], "/");
	$posSlah++;
	$pageVoulue = substr($_SERVER['REQUEST_URI'], $posSlah);
	
	// afficher la liste des pages dans un menu
	$pageList = array();
	$pageList = $page->getPagesList();
	$idPageVoulue = 0;
	
	if($pageVoulue=="login" || $pageVoulue =="admin"){
		$view=new View("view/login.html");
		echo $view->render($_POST);
	}
	else{
		if(sizeof($pageList) > 0){
				foreach ($pageList as $key => $value) {
					if($pageList[$key]['url'] == $pageVoulue){
						$idPageVoulue = $pageList[$key]['id'];
						$type = $pageList[$key]['typeTemplate'];
						break;
					}
				}
				if($idPageVoulue === 0){
					header("HTTP/1.1 404 Not Found");
					echo file_get_contents("website/404.html");
				}else{
					$results = array();
					$generatePage = $page->getPage($idPageVoulue);
					$title = $generatePage['title'];
					//recuperation du format json et conversion en tableau
					$result = json_decode($generatePage['content']);
					foreach($result as $key => $value){
						$results[$key] = $value;
					}
					switch ($type) {
						case 1:
							$view=new View("template/article.html");
							echo $view->render(array(
									'title' => $title,
									'content' => $results['content'],
									'imgLink' => $results['img'],
									'header' => file_get_contents("includes/header.html"),
									'footer' => file_get_contents("includes/footer.html"),
								));
							break;
						case 2:
							$view=new View("template/list.html");
							echo $view->render(array(
									'title' => $title,
									'header' => file_get_contents("includes/header.html"),
									'footer' => file_get_contents("includes/footer.html"),
								));
							file_put_contents('website/' . $title . '.html', $contentData);
							break;
						case 3:
							$view=new View("template/link.html");
							echo $view->render(array(
									'title' => $title,
									'link' => $results['link'],
									'header' => file_get_contents("includes/header.html"),
									'footer' => file_get_contents("includes/footer.html"),
								));
							file_put_contents('website/' . $title . '.html', $contentData);
							break;
					}
				}
		}	
	}
?>