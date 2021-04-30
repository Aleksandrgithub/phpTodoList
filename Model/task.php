<?php
namespace Model\Task;

class Task {
	private $description;
	private $status;
	private $id;

	public function __construct($id = null, $description = "description", $status = Status::TO_DO){
		$this->description = $description;
		$this->status = $status;
		$this->id = $id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function setDescription($description)
	{
		$this->description = $description;
	}

	public function setStatusCompleted($status)
	{
		$this->status = $status;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function getTask()
	{
		$task=array(
			"id" => $this->id,
			"description" => $this->description,
			"status" => $this->status,
		);
		return $task;
	}

}

class Status {
	CONST COMPLETED = 0;
	CONST TO_DO = 1;
}
