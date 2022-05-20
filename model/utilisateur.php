<?php

class utilisateur {
	// Objet PDO servant à la connexion à la base
	private $pdo;

	// Connexion à la base de données
	public function __construct() {
		$config = parse_ini_file("config.ini");
		
		try {
			$this->pdo = new \PDO("mysql:host=".$config["host"].";dbname=".$config["database"].";charset=utf8", $config["user"], $config["password"]);
		} catch(Exception $e) {
			echo $e->getMessage();
		}
	}
	
	public function getAll() {
		$sql = "SELECT * FROM utilisateur";
		
		$req = $this->pdo->prepare($sql);
		$req->execute();
		
		return $req->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function verifConnexion($login, $mdp) {
		$sql = "SELECT count(*) AS userFind FROM utilisateur WHERE login = :login and mdp = :mdp";
		$salt = "xamarin";
        $mdp = $mdp.$salt;

		$hash = sha1($mdp);

		$req = $this->pdo->prepare($sql);
		$req->bindParam(':login', $login,PDO::PARAM_STR);
        $req->bindParam(':mdp', $hash,PDO::PARAM_STR);
		$req->execute();

        $resultat = $req->fetch(PDO::FETCH_ASSOC);
        if($resultat["userFind"] == 1)
        {
            return true;
        }
        else
        {
            return false;
        }


		
	}

	public function getIdUtilisateur($login)
	{
		$sql = "SELECT id FROM utilisateur WHERE login = :login";
		$req = $this->pdo->prepare($sql);
		$req->bindParam(':login', $login,PDO::PARAM_STR);
		$req->execute();

		return $req->fetch();
	}
	

	public function supprimerUtilisateur($id) {
		$sql = "DELETE FROM utilisateur WHERE id = :id";
		
		$req = $this->pdo->prepare($sql);
		$req->bindParam(':id', $id, PDO::PARAM_STR);
		return $req->execute();
	}


}