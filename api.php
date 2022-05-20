<?php
$corpsRequete = file_get_contents('php://input');
var_dump($corpsRequete);
$o = json_decode($corpsRequete);
echo $o->nom;