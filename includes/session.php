<?php

class Session{

	private $loggedIn = false;
	public $userId;
	public $user;

	function __construct(){
		session_start();
		$this->checkLogin();
	}

	public function isLoggedIn() {
		return $this->loggedIn;
	}

	public function login($user){
		if ($user) {
			$this->userId = $_SESSION['userId'] = $user->id;
			$this->user = $_SESSION['user'] = $user->referral_code;
			$this->loggedIn = true;
		}
	}

	public function logout(){
		unset($_SESSION['userId']);
		unset($_SESSION['user']);
		unset($this->userId);
		unset($this->user);
		$this->loggedIn = false;
	}

	private function checkLogin(){
		if (isset($_SESSION['userId']) && isset($_SESSION['user'])) {
			$this->userId = $_SESSION['userId'];
			$this->user = $_SESSION['user'];
			$this->loggedIn = true;
		} else {
			unset($this->userId);
			unset($this->user);
			$this->loggedIn = false;
		}
	}

}

$session = new Session();
?>
