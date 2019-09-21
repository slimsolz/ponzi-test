<?php
require_once 'config.php';


class MySQLDatabase {

	private $connection;
	private $lastQuery;
	private $magic_quotes;
	private $real_escape_string;

	function __construct() {

		$this->openConnection();
		$this->magic_quotes = get_magic_quotes_gpc();
    $this->real_escape_string = function_exists("mysql_real_escape_string");

	}

	public function openConnection() {
		$this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);
		if (mysqli_connect_errno()) {
			die("Connection to database failed " . mysqli_connect_error() . "(".
				mysqli_connect_errno() .")");
		}
	}

	public function closeConnection() {
		if (isset($this->connection)) {
			mysqli_close($this->connection);
			unset($this->connection);
		}
	}

	public function query($sql) {
		$this->lastQuery = $sql;
		$result = mysqli_query($this->connection, $sql);
		$this->confirmQuery($result);
		return $result;
	}

	public function escape($value) {
		if ($this->real_escape_string) {
			if ($this->magic_quotes) {
				$value = stripslashes($value);
			}
			$value = mysql_real_escape_string($value);
		} else {
			if (!$this->magic_quotes) {
			$value = addslashes($value);
				}
		}
		return $value;
	}

	public function fetchArray($result) {
		return mysqli_fetch_array($result);
	}

	public function numRows($result) {
		return mysqli_num_rows($result);
	}

	public function insertId() {
		return mysqli_insert_id($this->connection);
	}

	public function affectedRows() {
		return mysqli_affected_rows($this->connection);
	}

	private function confirmQuery($result) {
		if (!$result) {
			die("Database query failed ". $this->lastQuery . mysqli_error($this->connection));
		}
	}
}

$database = new MySQLDatabase();
?>
