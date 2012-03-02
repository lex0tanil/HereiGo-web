<?php
session_start();


/* ----------------------------------------
	Checkings
---------------------------------------- */

if (!isset($_SESSION['id_membre'])) {
	header('location: /login/');
	exit;
}

$id_membre = $_SESSION['id_membre'];
$protection = true;


/* ----------------------------------------
	Classes
---------------------------------------- */

require_once '../classes/DBConnect.php';
$db = new DBConnect();
$erreur = $db->connect();
if ($erreur !== true) {
	include 'maintenance.php';
	exit();
}

require_once '../classes/Membre.php';
$membre = new Membre($db);

require_once '../classes/Question.php';
$question = new Question($db);

require_once '../classes/Recommendation.php';
$recommendation = new Recommendation($db);

require_once '../classes/Statistics.php';
$statistics = new Statistics($db);

require_once '../classes/Theme.php';
$theme = new Theme($db);

require_once '../classes/Tool.php';


/* ----------------------------------------
	Includes according to the device (mobile/default)
---------------------------------------- */

include '../inc/isMobile.php';

if(!isset($_SESSION['device']) AND empty($_SESSION['device'])) {
	isMobile();
}


if($_SESSION['device']==1) {
	include 'mobile_functions.php';
	include 'mobile_index.php';
} else {
	include 'default_functions.php';
	include 'default_index.php';	
}

?>