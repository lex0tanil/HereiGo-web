<?php

abstract class ConnectedItem {

	protected $db;
	public $log;
	
	public function __construct(DBConnect $db) {
		$this->db = $db;
	}

}

?>