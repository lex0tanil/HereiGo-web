<?php
require_once 'Tool.php';

class Member extends ConnectedItem {
		
	public function getInfos($id_membre) {
		if (!is_numeric($id_membre)) return 'Error with parameters.';
		$req = $this->db->query("SELECT * FROM member WHERE id_membre=$id_membre");
		
		$returnObject = new stdClass();
		$returnObject->erreur = true;
		
		if ($req->success && $req->nbResult == 1) {
			$donn = mysql_fetch_array($req->result);
			
			$returnObject->error = false;
		}
		return $returnObject;
	}
	
	public function logIn($email, $pass) {
	}
			
	public function logOut() {
		session_unset();
	}
		
}
?>