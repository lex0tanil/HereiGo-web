<?php

class Feed extends ConnectedItem {

    public function getInfos($feed_id) {
		if (!is_numeric($feed_id)) return '-1';
		
		$req = $this->db->query("SELECT * FROM hig_feed WHERE feed_id=$feed_id");
		
		$returnObject = new stdClass();
		$returnObject->error = true;
		
		if ($req->success && $req->nbResult == 1) {
			$data = mysql_fetch_array($req->result);
			
			$returnObject->error = false;
			$returnObject->feed_id = $data['route_id'];
			$returnObject->user_id = $data['user_id'];
            $returnObject->feed_action = stripslashes($data['feed_action']);
            $returnObject->feed_content = stripslashes($data['feed_content']);
           	$returnObject->feed_dt = $data['log_dt'];
		}
		return $returnObject;
	}
	
	public function addFeedItem($user_id, $action, $content) {
	
	}
	
	public function deleteFeedItem($feed_id) {
		
	}
	
	public function updateFeedItem($feed_id, $user_id, $action, $content) {
		
	}
}
?>