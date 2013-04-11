<?php
require_once('fonctions.php');
session(true);

header('Content-Type: application/json');
echo json_encode($_SESSION);

?>