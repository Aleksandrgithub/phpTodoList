<?php
namespace Database;

include '../Database/connection.php';

use Database\Connection as Connection;
use Model\Task\Task as Task;
use PDO;

class Transaction
{
	private $tableName = "todo";
	private $conn;

	public function __construct(){
		$database = new Connection();
		$this->conn = $database->getConnection();
	}

	public function readAll()
	{
		$query = "SELECT id, description FROM " . $this->tableName . " WHERE status = 1";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$todo = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$task = Transaction::read($row['id']);
			array_push($todo, $task->getTask());
		}
		return $todo;
	}

	public function read($id): Task
	{
		$query = "SELECT id, description, status FROM " . $this->tableName . " WHERE id = :id";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id', $id);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$task = new Task($row['id'], $row['description'], $row['status']);
		return $task;
	}


	public function getRowCount($stmt)
	{
		$rowCount = $stmt->rowCount();
		return $rowCount;
	}

	public function readCompleted()
	{
		$query = "SELECT id, description FROM " . $this->tableName . " WHERE status = 0";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$todo = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$task = Transaction::read($row['id']);
			array_push($todo, $task->getTask());
		}
		return $todo;
	}

	public function create($task)
	{
		$query = "INSERT INTO " . $this->tableName . " SET description=:description";
		$stmt = $this->conn->prepare($query);
		$description = $task->getDescription();
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

	public function update($task)
	{
		$query = "UPDATE " . $this->tableName . " SET status = :status WHERE id = :id";
		$stmt = $this->conn->prepare($query);
		$status = $task->getStatus();
		$id = $task->getId();
		$stmt->bindParam(':status', $status);
		$stmt->bindParam(':id', $id);
		if ($stmt->execute()) {
			return true;
		}
		return false;
	}

	public function checkTaskStatus($id)
	{
		$query = "SELECT status FROM " . $this->tableName . " WHERE id = :id";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id', $id);
		if ($stmt->execute()) {
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			if ((!empty($result)) && ($result['status'] != 0)) {
				return true;
			}
			return false;
		}
		return false;
	}

	public function checkTaskExist($id) {
		$query = "SELECT EXISTS(SELECT 1 FROM " . $this->tableName . " WHERE id =:id LIMIT 1)";
		$stmt = $this->conn->prepare($query);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_NUM);
		if (intval($result[0]) != 0) {
			return true;
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
		$todo = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$task = Transaction::read($row['id']);
			array_push($todo, $task->getTask());
		}
		return $todo;
	}
}
