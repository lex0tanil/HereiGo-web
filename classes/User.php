<?php

class User {

    public function getInfos($user_id) {
		if (!is_numeric($user_id)) return '-1';
		
		$req = $this->db->query("SELECT * FROM users WHERE user_id=$user_id");
		
		$returnObject = new stdClass();
		$returnObject->error = true;
		
		if ($req->success && $req->nbResult == 1) {
			$data = mysql_fetch_array($req->result);
			
			$returnObject->error = false;
			$returnObject->user_id = $data['id_membre'];
			$returnObject->user_username = stripslashes($data['user_username']);
                        $returnObject->user_facebook_id = $data['user_facebook_id'];
                        $returnObject->user_twitter_id = $data['user_twitter_id'];
			$returnObject->user_email = stripslashes($data['user_email']);
			$returnObject->user_password = stripslashes($data['user_password']);
			$returnObject->user_location = stripslashes($data['user_location']);
			$returnObject->user_temp_key = stripslashes($data['user_temp_key']);
                        $returnObject->user_dt = $data['user_dt'];
                        $returnObject->user_dt_last_login = $data['user_dt_last_login'];
		}
		return $returnObject;
	}
	
	public function logIn($email, $pass, $autoconnect) {
	}

        public function logOut($user_id) {
            session_unset();
            if (isset($_COOKIE['autoconnect'])) {
                setcookie('autoconnect','',0,'/','',0);
            }
	}
	
	public function verifyId($user_id) {
            
	}

	public function isUsernameAlreadyUsed($user_username) {

	}
	
	public function isEmailAlreadyUsed($email) {

	}

	public function isTwitterIdAlreadyUsed($username) {

	}

	public function isFacebookIdAlreadyUsed($username) {

	}
	
	public function getId($user_username) {

	}
	
	public function getIdByUsername($user_username) {

	}
	
	public function getUsernameByEmail($email) {

        }
		
	public function getNewPassword($email) {
            
	}
	
	public function changeProfileData($user_id, $data) {
            switch($data) {
                case 'location':
                    break;
                case 'bio':
                    break;
                case 'birthday':
                    break;
            }

	}
	
	public function changePassword($user_id, $old_password, $new_password) {
            
	}
	
	public function changeEmail($user_id, $new_email) {
            
	}
	

	public function validNewEmail($user_id, $temp_key) {
            
	}

        public function getNbRoutes($user_id) {

        }

        public function getNbMedals($user_id) {
            
        }
	
        public function getNbFollowings($user_id) {

        }

        public function getFollowings($user_id){

        }

        public function getFollowers($user_id) {
            
        }

        public function getNbFollowers($user_id) {

        }
	
        public function isFollowing($user_id_src, $user_id_dest) {

        }
        
        public function followUser($user_id_src, $user_id_dest) {

        }

        public function unfollowUser($user_id_src, $user_id_dest) {

        }
	
	public function deleteUser($user_id) {
            
	}
}
?>