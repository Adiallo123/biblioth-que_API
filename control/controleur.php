<?php
use Firebase\JWT\JWT;
require_once('./vendor/autoload.php');

class controleur {
	
	public function erreur404() {
		(new vue)->erreur404();
	}

	public function verification() {
		$corpsRequete = file_get_contents('php://input');

		if($json = json_decode($corpsRequete,true))
		{
			if(isset($json["login"]) && isset($json["mdp"]))
			{
				$verif = (new utilisateur)->verifConnexion($json["login"], $json["mdp"]);

				if($verif)
				{
					$idUtilisateur = (new utilisateur)->getIdUtilisateur($json["login"]);

					$secretKey  = 'bGS6lzFqvvSQ8ALbOxatm7/Vk7mLQyzqaS34Q4oR1ew=';
					$tokenId    = base64_encode(random_bytes(16));
					$issuedAt   = new DateTimeImmutable();
					$expire     = $issuedAt->modify('+60 minutes')->getTimestamp();      // Add 60 seconds
					$serverName = "your.domain.name";
					//$username   = "username";
					$username   = "username";                                                 // Retrieved from filtered POST data


					/*
					// Create the token as an array
					$data = [
						'iat'  => $issuedAt->getTimestamp(),    // Issued at: time when the token was generated
						'jti'  => $tokenId,                     // Json Token Id: an unique identifier for the token
						'iss'  => $serverName,                  // Issuer
						'nbf'  => $issuedAt->getTimestamp(),    // Not before
						'exp'  => $expire,                      // Expire
						'data' => [                             // Data related to the signer user
							'userName' => $json["login"],			// Username
							'idUtilisateur' => $idUtilisateur   // Id de l'utilisateur        
						]
					];
					*/
					
					$infosUser = $json["login"] . ":" . $idUtilisateur['id'];
					//$infosUser = $json["login"];

					
					// Create the token as an array
					$data = [
						'iat'  => $issuedAt->getTimestamp(),    // Issued at: time when the token was generated
						'jti'  => $tokenId,                     // Json Token Id: an unique identifier for the token
						'iss'  => $serverName,                  // Issuer
						'nbf'  => $issuedAt->getTimestamp(),    // Not before
						'exp'  => $expire,                      // Expire
						'data' => [ 'user' => $infosUser]
					];
					


					// Encode the array to a JWT string.
					$JWT = JWT::encode(
						$data,      // Data to be encoded in the JWT
						$secretKey, // The signing key
						'HS512'     // Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
					);

					echo $JWT;
				}
				else
				{
					echo "false";
				}
			}
		}
	}
	
	
	
	public function supprimerPersonne() {
		if(isset($_GET["id"])) {
			$laPersonne = (new utilisateur)->getPersonne($_GET["id"]);
			if(count($laPersonne) > 0) {
				$supprimer = (new personne)->supprimerPersonne($_GET["id"]);
				
				if($supprimer === true) {
					http_response_code(200);
			
					$json = '{ "code":200, "message": "La personne a été suprimée." }';
					(new vue)->afficherJSON($json);
				}
				else {
					http_response_code(400);
			
					$json = '{ "code":400, "message": "Impossible de supprimer cette personne." }';
					(new vue)->afficherJSON($json);
				}
			}
			else {
				(new vue)->erreur404();
			}
		}
		else {
			http_response_code(400);
			
			$json = '{ "code":400, "message": "Données manquantes." }';
			(new vue)->afficherJSON($json);
		}
	}
}