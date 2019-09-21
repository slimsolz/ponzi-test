<?php
require_once 'database.php';

class User {

	protected static $tablename = 'users';
	public $id;
	public $email;
	public $name;
	public $password;
	public $referral_code;
	public $referral;

	public static function findAll() {
		$sql = "SELECT * FROM ". self::$tablename ;
		return self::findBySql($sql);
	}

	public static function findById($id=0) {
		global $database;
		$sql = "SELECT * FROM ". self::$tablename ." WHERE id = {$id} LIMIT 1 ";
		$resultArray = self::findBySql($sql);
		return !empty($resultArray) ? array_shift($resultArray) : false ;
	}

	public static function getTotalByReferralCode($referral='') {
		global $database;
		$sql = "SELECT * FROM ". self::$tablename ." WHERE referral = '{$referral}'";
		$resultArray = $database->query($sql);
		$total = $database->numRows($resultArray);
		return $total;
	}

	public static function findByRefCode($referral_code='') {
		global $database;
		$sql = "SELECT * FROM ". self::$tablename ." WHERE referral_code = '{$referral_code}' LIMIT 1 ";
		$resultArray = self::findBySql($sql);
		return !empty($resultArray) ? array_shift($resultArray) : false ;
	}

 	public static function findBySql($sql='') {
		global $database;
		$result = $database->query($sql);
		$objectArray = array();
		while ($row = $database->fetchArray($result)) {
			$objectArray[] = self::instantiate($row);
		}

		return $objectArray;
	}

	public static function authenticate($email='', $password='') {
		global $database;
		$email = $database->escape($email);
		$password = $database->escape($password);

		$sql = "SELECT * FROM ". self::$tablename ;
		$sql .= " WHERE email = '{$email}' ";
		$sql .= "AND password = '{$password}' ";
		$sql .= "LIMIT 1";

		$resultArray = self::findBySql($sql);
		return !empty($resultArray) ? array_shift($resultArray) : false ;
	}

	private static function instantiate($record) {
		$object = new self;

		foreach ($record as $attribute => $value) {
			if ($object->hasAttribute($attribute)) {
				$object->$attribute = $value;
			}
		}

		return $object;
	}

	private function hasAttribute($attribute) {
		$objectVars = get_object_vars($this);

		return array_key_exists($attribute, $objectVars);
	}

	public function save() {
		return (isset($this->id)) ? $this->update() : $this->create();
	}

	public function create() {
		global $database;

		$sql = "INSERT INTO ". self::$tablename ." (email, name, password, referral_code, referral) ";
		$sql .= "VALUES('";
		$sql .= $database->escape($this->email) ."', '";
		$sql .= $database->escape(ucfirst($this->name)) ."', '";
		$sql .= $database->escape($this->password) ."', '";
		$sql .= $database->escape($this->referral_code) ."', '";
		$sql .= $database->escape($this->referral) ."' )";

		if ($database->query($sql)) {
			$this->id = $database->insertId();
			return true;
		} else {
			return false;
		}
	}

	public function update() {
		global $database;

		$sql = "UPDATE ". self::$tablename ." SET ";
		$sql .= "email =  '";
		$sql .= $database->escape($this->email) ."', name = '";
		$sql .= $database->escape(ucfirst($this->name)) ."', password = '";
		$sql .= $database->escape($this->password) ."', referral_code = '";
		$sql .= $database->escape($this->referral_code) ."', referral = '";
		$sql .= $database->escape($this->referral) ."' WHERE id = ";
		$sql .= $database->escape($this->id);

		$database->query($sql);

		return ($database->affectedRows() == 1) ? true : false;
	}

	public function delete() {
	 	global $database;

	 	$sql = "DELETE FROM ". self::$tablename ." WHERE ";
	 	$sql .= "id = ". $database->escape($this->id);
	 	$sql .= " LIMIT 1";

	 	$database->query($sql);
	 	return ($database->affectedRows() == 1) ? true : false;
	}
}

?>
