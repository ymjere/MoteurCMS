<?php
class User
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

	public function login($login, $password)
	{
		$req=$this->bdd->prepare("SELECT id, login, password FROM users WHERE login=:login AND password=:pass LIMIT 1");
		$req->execute(array(
			"login" =>  $login,
			"pass" =>  $password
		));
		$reponse = $req->fetch();

		if(sizeof($reponse)!=0){
			return $reponse;
		}

		return false;

	}

	public function getUsersList($login){
		$req=$this->bdd->prepare("SELECT * FROM users WHERE login!=:login");
		$req->execute(array(
			"login" =>  $login
		));
		$rps=$req->fetchall();
		return $rps;
	}
	
	public function ModifUser($id,$pwd){
		$req=$this->bdd->prepare("UPDATE users SET password = :pwd WHERE id=:id");
		$req->execute(array(
			"id" =>  $id,
			"pwd" => $pwd
		));
	}
	
	public function SupprUser($id){
		$req=$this->bdd->prepare("DELETE FROM users WHERE id=:id");
		$req->execute(array(
			"id" =>  $id
		));
	}
	
	public function CreatUser($login,$pwd){
		$req=$this->bdd->prepare("INSERT INTO users (`id`, `login`, `password`) VALUES (NULL,:login,:pwd)");
		$req->execute(array(
			"login" => $login,
			"pwd" => $pwd
		));
	}
}
?>