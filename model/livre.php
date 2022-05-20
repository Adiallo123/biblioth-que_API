<?php

class Livre {
	// Objet PDO servant à la connexion à la base
	private $pdo;

	// Connexion à la base de données
	public function __construct() {
		$config = parse_ini_file("config.ini");
		
		try {
			$this->pdo = new PDO("mysql:host=".$config["host"].";dbname=".$config["database"].";charset=utf8", $config["user"], $config["password"]);
		} catch(Exception $e) {
			echo $e->getMessage();
		}
	}
	
	//recupere tous les livres
	public function getAll() {
		$sql = "SELECT * FROM livre";
		
		$req = $this->pdo->prepare($sql);
		$req->execute();
		
		return $req->fetchAll(PDO::FETCH_ASSOC);
	}
	
	// Recupere les 
	public function getLivre($id) {
		$sql = "SELECT * FROM livre WHERE id_utilisateur = :id";
		
		$req = $this->pdo->prepare($sql);
		$req->bindParam(':id', $id, PDO::PARAM_STR);
		$req->execute();
		
		return $req->fetch(PDO::FETCH_ASSOC);
	}
	
	public function ajouterEvaluation($idutilisateur, $idlivre, $note, $commentaire) {

		$sql1 = "SELECT COUNT(*) AS nbEvalUserForThisBook FROM evaluer WHERE id_utilisateur = :idUtilisateur AND id_livre = :idLivre";

		$req = $this->pdo->prepare($sql1);
		$req->bindParam(':idUtilisateur', $idutilisateur, PDO::PARAM_INT);
		$req->bindParam(':idLivre', $idlivre, PDO::PARAM_INT);
		$req->execute();

		$data = $req->fetch();


		if($data['nbEvalUserForThisBook'] < 1)
		{
			$sql2 = "INSERT INTO evaluer (id_utilisateur, id_livre, note, commentaire, `date`) VALUES (:idutilisateur, :idlivre, :note, :commentaire, now())";
		
			$req = $this->pdo->prepare($sql2);
			$req->bindParam(':idutilisateur', $idutilisateur, PDO::PARAM_INT);
			$req->bindParam(':idlivre', $idlivre, PDO::PARAM_INT);
			$req->bindParam(':note', $note, PDO::PARAM_INT);
			$req->bindParam(':commentaire', $commentaire, PDO::PARAM_STR);
			
			$req->execute();
			
			return true;
		}
		else
		{
			return false;
		}


		
	}

	public function getEvaluations($id) {
		$sql = "SELECT img,note,commentaire,`date` FROM evaluer INNER JOIN livre ON evaluer.id_livre = livre.id WHERE evaluer.id_utilisateur = :id";
		$req = $this->pdo->prepare($sql);
		$req->bindParam(':id', $id, PDO::PARAM_INT);
		$req->execute();
		return $req->fetchAll(PDO::FETCH_ASSOC);
	}

	
}