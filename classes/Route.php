<?php

class Route extends ConnectedItem {

    public function getInfos($route_id) {
		if (!is_numeric($route_id)) return '-1';
		
		$req = $this->db->query("SELECT * FROM hig_routes WHERE route_id=$route_id");
		
		$returnObject = new stdClass();
		$returnObject->error = true;
		
		if ($req->success && $req->nbResult == 1) {
			$data = mysql_fetch_array($req->result);
			
			$returnObject->error = false;
			$returnObject->route_id = $data['route_id'];
			$returnObject->user_id = $data['user_id'];
            		$returnObject->route_title = stripslashes($data['user_facebook_id']);
           		$returnObject->route_nb_points = $data['route_nb_points'];
			$returnObject->route_length = $data['route_length'];
			$returnObject->route_elevation = $data['route_elevation'];
			$returnObject->route_elevation_max = $data['route_elevation_max'];
			$returnObject->route_elevation_min = $data['route_elevation_min'];
          		$returnObject->route_dt = $data['route_dt'];
		}
		return $returnObject;
	}
	
	public function addRoute($user_id, $title) {
	
	}
			
	public function deleteRoute($route_id) {
            
	}
	
	public function updateRoute($route_id, $user_id, $title, $nb_points, $length, $elevation, $elevation_max, $elevation_min) {
	
	}
}
?>