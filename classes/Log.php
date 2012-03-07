<?php

class Log extends ConnectedItem {

    public function getInfos($log_id) {
		if (!is_numeric($log_id)) return '-1';
		
		$req = $this->db->query("SELECT * FROM hig_log WHERE log_id=$log_id");
		
		$returnObject = new stdClass();
		$returnObject->error = true;
		
		if ($req->success && $req->nbResult == 1) {
			$data = mysql_fetch_array($req->result);
			
			$returnObject->error = false;
			$returnObject->log_id = $data['route_id'];
			$returnObject->user_id = $data['user_id'];
            $returnObject->log_ip = stripslashes($data['log_ip']);
            $returnObject->log_mac = stripslashes($data['log_mac']);
			$returnObject->log_action = stripslashes($data['log_action']);
			$returnObject->log_device = stripslashes($data['log_device']);
			$returnObject->log_target = stripslashes($data['log_target']);
            $returnObject->log_browser = stripslashes($data['log_browser']);
            $returnObject->log_referer = stripslashes($data['log_referer']);
            $returnObject->log_importance = $data['log_importance'];
           	$returnObject->log_dt = $data['log_dt'];
		}
		return $returnObject;
	}
	
	public function addLogItem($user_id, $ip, $mac, $action, $device, $target, $browser, $referer, $importance) {
	
	}
	
	public function deleteLogItem($log_id) {
		
	}
	
	public function updateLogItem($log_id, $user_id, $ip, $mac, $action, $device, $target, $browser, $referer, $importance) {
	
	}
}
?>