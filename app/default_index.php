<?php
/* ----------------------------------------
	Protection which prevents people to load the page without index.php
---------------------------------------- */

if (!$protection) {
	header('location: /login/');
	exit;
}


/* ----------------------------------------
	Others
---------------------------------------- */

$infosMembre = $membre->getInfos($id_membre);
$mode = $_GET['mode'];

?>