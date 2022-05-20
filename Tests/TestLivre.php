<?php 

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require("model/livre.php");

class TestLivre extends TestCase
{

    public function testCreateEvaluation()
    {
        $l = new Livre();
        $addEvaluation = $l->ajouterEvaluation(1,1,5,"try1");
        $this->assertEquals(false,$addEvaluation);

        $addEvaluation2 = $l->ajouterEvaluation(4,2,3,'try2');
        $this->assertEquals(true,$addEvaluation2);
    }

   
}

?>