<?php
require_once 'ConnectedItem.php';

class DBConnect {
	
	private $db_host = '';
	private $db_login = '';
	private $db_pass = '';
	private $db_base = '';
	
	public $link;
	
	public function connect() {
		ob_start();
		$this->link = mysql_connect($this->db_host, $this->db_login, $this->db_pass, true);
		$erreur = ob_get_contents();
        ob_end_clean();
		if ($erreur != '' || $this->link === false) return 'mysql_error: "'.mysql_error().'" | erreur: "'.$erreur.'"';
		
		return mysql_select_db($this->db_base, $this->link);
	}
	
	public function query($query, $type='read') {
		$returnObject = new stdClass();
		$returnObject->result = mysql_query($query, $this->link);
		
		if ($returnObject->result == false) {
			$returnObject->success = false;
			$returnObject->error = mysql_error($this->link);
			$returnObject->errno = mysql_errno($this->link);
		} else {
			$returnObject->success = true;
			$returnObject->error = '';
			if ($type == 'write') {
				$returnObject->nbResult = mysql_affected_rows($this->link);
			} else {
				$returnObject->nbResult = mysql_num_rows($returnObject->result);
			}
		}
		return $returnObject;
	}
	
	public function disconnect() {
		return mysql_close($this->link);
	}
	
	public function insertedID() {
		return mysql_insert_id($this->link);
	}
}
?>
