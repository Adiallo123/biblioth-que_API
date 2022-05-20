<?php
session_start();



error_reporting(E_ALL);
ini_set("display_errors", 1);

// Test de connexion à la base
$config = parse_ini_file("config.ini");
try {
	$pdo = new \PDO("mysql:host=".$config["host"].";dbname=".$config["database"].";charset=utf8", $config["user"], $config["password"]);
} catch(Exception $e) {
	echo "<h1>Erreur de connexion à la base de données :</h1>";
	echo $e->getMessage();
	exit;
	echo "cocou";
}

// Chargement des fichiers MVC
//require("control/controleur.php");
require("control/controleur.php");
require("control/controllerLivre.php");
require("view/vue.php");
require("model/utilisateur.php");
require("model/livre.php");

// Routes
if(isset($_GET["action"])) {
	switch($_GET["action"]) {
		case "utilisateur":
			switch($_SERVER["REQUEST_METHOD"]) {
				case "GET":
					
					break;
				case "POST":
					(new controleur)->verification();
					break;
				case "PUT":

					break;
				case "DELETE":
					
					break;
			}
			break;

		case "livre":
			switch($_SERVER["REQUEST_METHOD"]) {
				case "GET":
					(new controllerLivre)->recupererLivres();
					break;
				case "POST":

					break;
				case "PUT":
					
					break;
				case "DELETE":
					
					break;
			}
			break;
		case "evaluation":
			switch($_SERVER["REQUEST_METHOD"]) {
				case "GET":
					(new controllerLivre)->getEvaluations();
					break;
				case "POST":
					(new controllerLivre)->ajouterEvaluation();
					break;
				case "PUT":
					
					break;
				case "DELETE":
					
					break;
			}
			break;
		// Route par défaut : erreur 404
		default:
			(new controleur)->erreur404();
			break;
	}
}
else {
	// Pas d'action précisée = afficher l'accueil
	$json = '{ "code":200, "message": "Bienvenue dans l\'API !" }';
	(new vue)->afficherJSON($json);
}