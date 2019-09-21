<?php
require_once 'database.php';

class UserReferral {

	protected static $tablename = 'referals';
	public $id;
	public $userId;
	public $refCode;

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

	public static function findByRefCode($code='') {
		global $database;
		$sql = "SELECT * FROM ". self::$tablename ." WHERE refCode = '{$refCode}' LIMIT 1 ";
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

		$sql = "INSERT INTO ". self::$tablename ." (userId, refCode) ";
		$sql .= "VALUES('";
		$sql .= $database->escape($this->userId) ."', '";
		$sql .= $database->escape($this->refCode) ."' )";

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
		$sql .= "userId =  '";
		$sql .= $database->escape($this->userId) ."', refCode = '";
		$sql .= $database->escape($this->refCode) ."' WHERE id = ";
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
