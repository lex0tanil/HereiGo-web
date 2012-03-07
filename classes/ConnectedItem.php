<?php

abstract class ConnectedItem {

	protected $db;
	
	public function __construct(DBConnect $db) {
		$this->db = $db;
	}

}

?>