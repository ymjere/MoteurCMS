<?php
	session_start();
	
	include('init.php');
	
	if(isset($_POST['mode'])){
		if($_POST['mode'] == 'createPage' && isset($_POST['title'])){
			$data = array();
			foreach($_POST as $key => $donnée) {
				if(!($key == 'title' || $key ==  'template' || $key ==  'mode' || $key ==  'url')){
					$data[$key] = $donnée;
				}
			}
			if(isset($_FILES['imgLink'])) RecupFile($_FILES['imgLink']);
			foreach($_FILES as $key => $donnée) {
				$data['img'] = './img/' . $donnée['name'];
			}
			$page->CreatePage($_POST['title'],json_encode($data), $_POST['template'], $_POST['url']);
			generateList($page);
		}
		elseif($_POST['mode'] == 'edit' && isset($_POST['newPassword']) && isset($_POST['id']) ){
			$user->ModifUser($_POST['id'],$_POST['newPassword']);
			generateList($page);
		}
		elseif($_POST['mode'] == 'delete' && isset($_POST['id']) ){
			$user->SupprUser($_POST['id']);
			generateList($page);
		}	
		elseif($_POST['mode'] == 'selectDefaultPage' && isset($_POST['defaultPage'])){
			$page->setDefaultPage($_POST['defaultPage']);
		}
		
	}else generateList($page);
		
	function generateList($page){
		$view=new View("view/pagesManage.html");
		$detailView=new View("view/pageRow.html");
		$pages = $detailView->renderList($page->getPagesList());
		echo $view->render(array(
			'navigation' => file_get_contents("view/nav.html"),
			'pages'=> $pages
		));
	}
		
	//Récupération de l'image uploadé
	function RecupFile($file){
		$dossier = 'img/';
		$fichier = basename($file['name']);
		$taille_maxi = 1000000; //1Mo
		$taille = filesize($file['tmp_name']);
		$extensions = array('.png', '.gif', '.jpg', '.jpeg');
		$extension = strrchr($file['name'], '.'); 
		//Début des vérifications de sécurité...
		if(!in_array($extension, $extensions)){ //Si l'extension n'est pas dans le tableau
			$erreur = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg, txt ou doc...';
		}
		if($taille>$taille_maxi){
			 $erreur = 'Le fichier est trop gros...';
		}
		if(!isset($erreur)){ //S'il n'y a pas d'erreur, on upload
			 // On formate le nom du fichier ici...
			 $fichier = strtr($fichier, 
				  'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
				  'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
			 $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
			 if(move_uploaded_file($file['tmp_name'], $dossier . $fichier)){ //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
				  echo 'Upload effectué avec succès !';
			 }
			 else{ //Sinon (la fonction renvoie FALSE).
				  echo 'Echec de l\'upload !';
			 }
		}
		else{
			 echo $erreur;
		}
	}

?>