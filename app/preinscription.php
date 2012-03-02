<?php
session_start();

include '../inc/isMobile.php';

if(!isset($_SESSION['device']) AND empty($_SESSION['device'])) {
	isMobile();
}

if($_SESSION['device']==1) {
	include 'mobile_preinscription.php';
} else {
	include 'default_preinscription.php';	
}

?>