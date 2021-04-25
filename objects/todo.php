<?php
class Todo {

	private $conn;
	private $tableName = "todo";
	public $id;
	public $description;
	public $status;

	public function __construct($db){
		$this->conn = $db;
	}

	function read(){
		$query = "SELECT id, description FROM " . $this->tableName . " WHERE status = 1";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function readCompleted(){
		$query = "SELECT id, description FROM " . $this->tableName . " WHERE status = 0";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function create(){
		$query = "INSERT INTO " . $this->tableName . " SET description=:description";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":description", $this->description);
		if ($stmt->execute()) {
			return true;
		}
		return false;
	}

	function update(){
		$query = "UPDATE " . $this->tableName . " SET status = :status WHERE id = :id";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':status', $this->status);
		$stmt->bindParam(':id', $this->id);
		if ($stmt->execute()) {
			return true;
		}
		return false;
	}

	function delete(){
		$query = "DELETE FROM " . $this->tableName . " WHERE id = :id";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":id", $this->id);
		if ($stmt->execute()) {
			return true;
		}
		return false;
	}

	function readPaging($fromRecordNum, $recordsPerPage){
		$query = "SELECT id, description FROM " . $this->tableName . " WHERE status = 1 LIMIT :fromRecordNum, :recordsPerPage";
		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(":fromRecordNum", $fromRecordNum, PDO::PARAM_INT);
		$stmt->bindParam(":recordsPerPage", $recordsPerPage, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}
}
