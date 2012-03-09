<?php

class Gps extends ConnectedItem {
	
	public function getGpsData($route_id) {
		if (!is_numeric($route_id)) return '-1';
		
		$req = $this->db->query("SELECT * FROM hig_gps WHERE route_id=$route_id");
		
		$returnObject = new stdClass();
		$returnObject->error = true;
		
		if ($req->success && $req->nbResult == 1) {
			$data = mysql_fetch_array($req->result);
			
			$returnObject->error = false;
			$returnObject->gps_id = $data['gps_id'];
			$returnObject->route_id = $data['route_id'];
            $returnObject->gps_lat = $data['gps_lat'];
            $returnObject->gps_long = $data['gps_long'];
			$returnObject->gps_alt = $data['gps_alt'];
			$returnObject->gps_speed = $data['gps_speed'];
			$returnObject->gps_dt = $data['gps_dt'];
		}
		return $returnObject;
	}
	
	public function addGpsPosition($route_id, $lat, $long, $alt, $speed) {
	
	}

	public function deleteGpsPosition($gps_id) {
		
	}
	
	public function updateGpsPosition($gps_id, $route_id, $lat, $long, $alt, $speed) {
	
	}
	
	public function calculateNbGpsPositions($route_id) {
	
	}
	
	public function deleteGpsPositions($route_id) {
		// use deletationPosition
	}
	
}
?>