<?php 
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
require("model/utilisateur.php");
class TestUtilisateur extends TestCase
{

    //test pour verifier la connexion
   public function testverifConnexion()
    {
        $user = new utilisateur();
        $this->assertEquals(true, $user->verifConnexion('pomme', '1234'));
        $this->assertEquals(false, $user->verifConnexion('try','tips'));
        $this->assertEquals(true, $user->verifConnexion('cool', 'cool'));    
    }

    //test pour récuperé l'id de l'utilisateur

    public function testgetIdUtilisateur()
    {
        $user = new utilisateur();
        $this->assertEquals(1, (int)$user->getIdUtilisateur('pomme')['id']);
        $this->assertEquals(4, (int)$user->getIdUtilisateur('cool')['id']);
        $this->assertEquals(2, (int)$user->getIdUtilisateur('poire')['id']);
        $this->assertNotEquals(3, (int)$user->getIdUtilisateur('poire')['id'], "erreur pour poire");
   
    }

     //test pour récuperé tout les utilisateurs

    // public function testgetUtilisateur()
    // {
    //     $user = new utilisateur();
    //     $this->assertEquals(true, $user->getAll(), "erreur sur getAll");
    
    // }
    
}

?>