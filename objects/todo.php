<?php
class Task {

	private $conn;
	private $tableName = "todo";
	private $id;
	private $description;
	private $status;

	public function __construct($db){
		$this->conn = $db;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function setDescription($description)
	{
		$this->description = $description;
	}

	public function setStatus($status)
	{
		$this->status = $status;
	}

	public function read(){
		$query = "SELECT id, description FROM " . $this->tableName . " WHERE status = 1";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	public function readCompleted(){
		$query = "SELECT id, description FROM " . $this->tableName . " WHERE status = 0";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	public function create(){
		$query = "INSERT INTO " . $this->tableName . " SET description=:description";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":description", $this->description);
		if ($stmt->execute()) {
			$insertId = $this->conn->lastInsertId();
			return $insertId;
		}
		return false;
	}

	public function update(){
		$query = "UPDATE " . $this->tableName . " SET status = :status WHERE id = :id";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':status', $this->status);
		$stmt->bindParam(':id', $this->id);
		if ($stmt->execute()) {
			return true;
		}
		return false;
	}

	public function markTaskCompleted(){
		$query = "SELECT status FROM " . $this->tableName . " WHERE id = :id";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id', $this->id);
		if ($stmt->execute()) {
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			if((!empty($result)) && ($result['status'] != 0)) {
				Todo::update();
				return true;
			}
			return false;
		}
		return false;
	}

	public function delete(){
		$query = "DELETE FROM " . $this->tableName . " WHERE id = :id";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":id", $this->id);
		if ($stmt->execute()) {
			return true;
		}
		return false;
	}

	public function readPaging($fromRecordNum, $recordsPerPage){
		$query = "SELECT id, description FROM " . $this->tableName . " WHERE status = 1 LIMIT :fromRecordNum, :recordsPerPage";
		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(":fromRecordNum", $fromRecordNum, PDO::PARAM_INT);
		$stmt->bindParam(":recordsPerPage", $recordsPerPage, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}
}
