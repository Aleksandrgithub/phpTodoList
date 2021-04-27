<?php
class Task {
	private $id;
	private $description;
	private $status;

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
}
