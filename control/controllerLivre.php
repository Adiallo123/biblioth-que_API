<?php
use Firebase\JWT\JWT;
require_once('./vendor/autoload.php');

class controllerLivre {
	
	public function erreur404() {
		(new vue)->erreur404();
	}

	public function recupererLivres()
	{
		$lesLivres = (new Livre)->getAll();

		$lesLivres_JSON = json_encode($lesLivres);

		echo $lesLivres_JSON;
	}

	public function ajouterEvaluation()
	{
		$corpsRequete = file_get_contents('php://input');
		if($json = json_decode($corpsRequete,true))
		{
			
			if(isset($json["commentaire"]) && isset($json["note"]) && isset($json["idUtilisateur"]) && isset($json["idLivre"]))
			{
				//var_dump($json);
				$isExecute = (new Livre)->ajouterEvaluation($json["idUtilisateur"], $json["idLivre"], $json["note"], $json["commentaire"]);
				
				var_dump($isExecute);

				if($isExecute)
				{
					echo "true";
				}
				
			}
		}	
		
	}

	public function getEvaluations()
	{
		
		if(isset($_GET["idUtilisateur"]))
		{
			
			$lesEvaluations = (new Livre)->getEvaluations($_GET["idUtilisateur"]);

			$lesEvaluationsJSON = json_encode($lesEvaluations);

			echo $lesEvaluationsJSON;
		}
		
		
	}
	
}