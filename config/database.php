<?php
namespace Database;

use PDO;
use PDOException;

class Connection
{
	private $host = "localhost";
	private $dbName = "test_task";
	private $username = "root";
	private $password = "";
	private $conn;

	public function getConnection(){
		$this->conn = null;
		try {
			$this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbName, $this->username, $this->password);
		} catch(PDOException $exception){
			echo "Connection error: " . $exception->getMessage();
		}
		return $this->conn;
	}
}

class Transaction
{
	private $tableName = "todo";
	private $conn;

	public function __construct(){
		$database = new Connection();
		$this->conn = $database->getConnection();
	}

	public function read()
	{
		$query = "SELECT id, description FROM " . $this->tableName . " WHERE status = 1";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	public function readCompleted()
	{
		$query = "SELECT id, description FROM " . $this->tableName . " WHERE status = 0";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	public function create($description)
	{
		$query = "INSERT INTO " . $this->tableName . " SET description=:description";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':description', $description);
		if ($stmt->execute()) {
			return true;
		}
		return false;
	}

	public function getLastInsertId()
	{
		if($this->conn->lastInsertId()) {
			$insertId = $this->conn->lastInsertId();
			return $insertId;
		}
		return false;
	}

	public function update($status, $id)
	{
		$query = "UPDATE " . $this->tableName . " SET status = :status WHERE id = :id";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':status', $status);
		$stmt->bindParam(':id', $id);
		if ($stmt->execute()) {
			return true;
		}
		return false;
	}

	public function markTaskCompleted($status, $id)
	{
		$query = "SELECT status FROM " . $this->tableName . " WHERE id = :id";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id', $id);
		if ($stmt->execute()) {
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			if ((!empty($result)) && ($result['status'] != 0)) {
				DbTransactions::update($status, $id);
				return true;
			}
			return false;
		}
		return false;
	}

	public function delete($id)
	{
		$query = "DELETE FROM " . $this->tableName . " WHERE id = :id";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":id", $id);
		if ($stmt->execute()) {
			return true;
		}
		return false;
	}

	public function readPaging($fromRecordNum, $recordsPerPage)
	{
		$query = "SELECT id, description FROM " . $this->tableName . " WHERE status = 1 LIMIT :fromRecordNum, :recordsPerPage";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":fromRecordNum", $fromRecordNum, PDO::PARAM_INT);
		$stmt->bindParam(":recordsPerPage", $recordsPerPage, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}
}
