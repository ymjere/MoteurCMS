<?php
class Page
{
	private $host='localhost';
	private $bdd;

	public function __construct($dbName, $dbLogin, $dbPass)
	{

		$this->bdd = new PDO('mysql:host='.$this->host.';dbname='.$dbName, $dbLogin, $dbPass,
			array(
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO:: FETCH_ASSOC,
				PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
			)
		);

	}

	public function getPagesList(){
		$req=$this->bdd->prepare("SELECT * FROM pages");
		$req->execute();
		$rps=$req->fetchall();
		return $rps;
	}
	
	public function setCreated($id){
        $req=$this->bdd->prepare("UPDATE pages SET created = 1 WHERE id=:id");
        $req->execute(array(
            'id' =>  $id,
        ));
    }

	
	public function getPage($id){
        $req=$this->bdd->prepare("SELECT * FROM pages WHERE id=:id");
        $req->execute(array(
            'id' =>  $id,
        ));
        $rp=$req->fetch();
        return $rp;
    }

	
	public function ModifPage($id,$pwd){
		$req=$this->bdd->prepare("UPDATE users SET password = :pwd WHERE id=:id");
		$req->execute(array(
			'id' =>  $id,
			'pwd' => $pwd
		));
	}
	
	public function SupprUser($id){
		$req=$this->bdd->prepare("DELETE FROM users WHERE id=:id");
		$req->execute(array(
			'id' =>  $id
		));
	}
	
	public function CreatePage($title,$imgLink,$content){
		$req=$this->bdd->prepare("INSERT INTO pages (`id`, `title`, `imgLink`,`content`) VALUES (NULL,:title,:imgLink,:content)");
		$req->execute(array(
			'title' => $title,
			'imgLink' => $imgLink,
			'content' => $content,
		));
	}
}
?>